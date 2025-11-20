<?php

class Infotravel_Admin
{
    const NONCE = 'infotravel-update-key';
    private static $initiated = false;

    public static function init()
    {
        if (!self::$initiated) {
            self::init_hooks();
        }

        if (isset($_POST['action']) && $_POST['action'] == 'enter-key') {
            self::enter_api_key();
        }
    }

    public static function init_hooks()
    {
        // A página de estatísticas autônomas foi removida em 3.0 para uma página de configuração e estatísticas totalmente completa.
        // Redirecione todos os links que possam ter sido marcados ou no histórico do navegador.
        if (isset($_GET['page']) && 'infotravel-stats-display' == $_GET['page']) {
            wp_safe_redirect(esc_url_raw(self::get_page_url('stats')), 301);
            die;
        }
        self::$initiated = true;

        add_action('admin_init', array('Infotravel_Admin', 'admin_init'));
        add_action('admin_menu', array('Infotravel_Admin', 'admin_menu'), 5); # Priority 5, so it's called before Jetpack's admin_menu.
        add_action('admin_enqueue_scripts', array('Infotravel_Admin', 'load_resources'));

        add_filter('plugin_action_links_' . plugin_basename(plugin_dir_path(__FILE__) . 'infotravel-motor.php'), array('Infotravel_Admin', 'admin_plugin_settings_link'));

        add_action('wp_ajax_infotravel_saveConfig', array('Infotravel_Admin', 'saveConfig'));
    }

    public static function admin_init()
    {
        load_plugin_textdomain('infotravel-motor');

        // Handle form submission
        if (isset($_POST['action']) && $_POST['action'] === 'infotravel_saveConfig') {
            self::saveConfig();
        }
    }

    public static function admin_menu()
    {
        if (class_exists('Jetpack'))
            add_action('jetpack_admin_menu', array('Infotravel_Admin', 'load_menu'));
        else
            self::load_menu();
    }

    public static function admin_head()
    {
        if (!current_user_can('manage_options'))
            return;
    }

    public static function admin_plugin_settings_link($links)
    {
        $settings_link = '<a href="' . esc_url(self::get_page_url()) . '">' . __('Configurações', 'infotravel-motor') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public static function load_menu()
    {
        if (class_exists('Jetpack'))
            $hook = add_submenu_page('jetpack', __('Infotravel', 'infotravel-motor'), __('Infotravel', 'infotravel-motor'), 'manage_options', 'infotravel-config', array('Infotravel_Admin', 'display_page'));
        else
            $hook = add_options_page(__('Infotravel', 'infotravel-motor'), __('Infotravel', 'infotravel-motor'), 'manage_options', 'infotravel-config', array('Infotravel_Admin', 'display_page'));
    }

    public static function load_resources()
    {
        global $hook_suffix;

        if (in_array($hook_suffix, apply_filters('infotravel_admin_page_hook_suffixes', array(
            'index.php', # dashboard
            'settings_page_infotravel-config',
            'jetpack_page_infotravel-config',
            'plugins.php',
        )))) {
            wp_register_style('infotravel-admin.css', plugin_dir_url(__FILE__) . '_inc/css/infotravel-admin.css', array(), INFOTRAVEL_VERSION);
            wp_enqueue_style('infotravel-admin.css');

            wp_register_script('infotravel-admin.js', plugin_dir_url(__FILE__) . '_inc/js/infotravel-admin.js', array('jquery'), INFOTRAVEL_VERSION);
            wp_enqueue_script('infotravel-admin.js');

            $inline_js = array(
                'strings' => array(
                    'Remove this URL' => __('Remove this URL', 'infotravel-motor'),
                    'Removing...' => __('Removing...', 'infotravel-motor'),
                    'URL removed' => __('URL removed', 'infotravel-motor'),
                    '(undo)' => __('(undo)', 'infotravel-motor'),
                    'Re-adding...' => __('Re-adding...', 'infotravel-motor'),
                )
            );

            wp_localize_script('infotravel-admin.js', 'WPInfotravel', $inline_js);
        }
    }

    public static function display_page()
    {
        if ((isset($_GET['view']) && $_GET['view'] == 'start'))
            self::display_start_page();
        elseif (isset($_GET['view']) && $_GET['view'] == 'stats')
            self::display_stats_page();
        else
            self::display_configuration_page();
    }

    public static function display_start_page()
    {
        Infotravel::view('start');
    }

    public static function display_stats_page()
    {
        Infotravel::view('stats');
    }

    public static function display_configuration_page()
    {
        Infotravel::view('config');
    }

    public static function get_page_url($page = 'config')
    {
        $args = array('page' => 'infotravel-config');
        if ($page == 'stats')
            $args = array('page' => 'infotravel-config', 'view' => 'stats');
        elseif ($page == 'delete_key')
            $args = array('page' => 'infotravel-config', 'view' => 'start', 'action' => 'save', '_wpnonce' => wp_create_nonce(self::NONCE));

        $url = add_query_arg($args, class_exists('Jetpack') ? admin_url('admin.php') : admin_url('options-general.php'));

        return $url;
    }

    public static function saveConfig()
    {
        // Verify nonce for security
        if (!wp_verify_nonce($_POST['_wpnonce'], 'infotravel_saveConfig')) {
            wp_die('Security check failed');
        }

        // Check if user has permission
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        // Save basic configuration
        update_option('b2c_dominio', sanitize_text_field($_POST["dominio"]));
        update_option('b2c_chave', sanitize_text_field($_POST["chave"]));
        update_option('b2c_empresa', sanitize_text_field($_POST["empresa"]));
        update_option('b2c_engine_base_url', sanitize_text_field($_POST["engine_base_url"]));
        update_option('b2c_base_url_api', sanitize_text_field($_POST["base_url_api"]));
        update_option('b2c_white_label', isset($_POST["white_label"]) ? '1' : '0');
        update_option('b2c_iframe', isset($_POST["iframe"]) ? '1' : '0');
        update_option('b2c_target', isset($_POST["target"]) ? '1' : '0');

        // Save dependency loading options
        update_option('b2c_load_css', isset($_POST["load_css"]) ? '1' : '0');
        update_option('b2c_load_tabs', isset($_POST["load_tabs"]) ? '1' : '0');

        // Save motor activation options
        update_option('b2c_enable_hotel', isset($_POST["enable_hotel"]) ? '1' : '0');
        update_option('b2c_enable_service', isset($_POST["enable_service"]) ? '1' : '0');
        update_option('b2c_enable_flight', isset($_POST["enable_flight"]) ? '1' : '0');
        update_option('b2c_enable_dynamic_package', isset($_POST["enable_dynamic_package"]) ? '1' : '0');
        update_option('b2c_enable_flight_package', isset($_POST["enable_flight_package"]) ? '1' : '0');
        update_option('b2c_enable_hotel_package', isset($_POST["enable_hotel_package"]) ? '1' : '0');
        update_option('b2c_enable_bus_hotel_package', isset($_POST["enable_bus_hotel_package"]) ? '1' : '0');
        update_option('b2c_enable_bus_services_package', isset($_POST["enable_bus_services_package"]) ? '1' : '0');

        // If this is an AJAX request, return JSON response
        if (wp_doing_ajax()) {
            wp_send_json_success('Configuration saved successfully');
        } else {
            // For regular form submission, redirect with success message
            wp_redirect(add_query_arg('updated', 'true', self::get_page_url()));
            exit;
        }
    }
}
