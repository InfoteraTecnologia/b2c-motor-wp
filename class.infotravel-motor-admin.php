<?php

class Infotravel_Admin {
    const NONCE = 'infotravel-update-key';
    private static $initiated = false;
    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }

        if ( isset( $_POST['action'] ) && $_POST['action'] == 'enter-key' ) {
            self::enter_api_key();
        }
    }

    public static function init_hooks() {
        // A página de estatísticas autônomas foi removida em 3.0 para uma página de configuração e estatísticas totalmente completa.
        // Redirecione todos os links que possam ter sido marcados ou no histórico do navegador.
        if ( isset( $_GET['page'] ) && 'infotravel-stats-display' == $_GET['page'] ) {
            wp_safe_redirect( esc_url_raw( self::get_page_url( 'stats' ) ), 301 );
            die;
        }
        self::$initiated = true;

        add_action( 'admin_init', array( 'Infotravel_Admin', 'admin_init' ) );
        add_action( 'admin_menu', array( 'Infotravel_Admin', 'admin_menu' ), 5 ); # Priority 5, so it's called before Jetpack's admin_menu.
        add_action( 'admin_enqueue_scripts', array( 'Infotravel_Admin', 'load_resources' ) );

        add_filter( 'plugin_action_links_'.plugin_basename( plugin_dir_path( __FILE__ ) . 'infotravel-motor.php'), array( 'Infotravel_Admin', 'admin_plugin_settings_link' ) );

        add_action( 'wp_ajax_infotravel_saveConfigHospedagem', array('Infotravel_Admin', 'saveConfigHospedagem') );
        add_action( 'wp_ajax_infotravel_saveConfigPacote', array('Infotravel_Admin', 'saveConfigPacote') );
    }

    public static function admin_init() {
        load_plugin_textdomain( 'infotravel-motor' );
    }

    public static function admin_menu() {
        if ( class_exists( 'Jetpack' ) )
            add_action( 'jetpack_admin_menu', array( 'Infotravel_Admin', 'load_menu' ) );
        else
            self::load_menu();
    }

    public static function admin_head() {
        if ( !current_user_can( 'manage_options' ) )
            return;
    }

    public static function admin_plugin_settings_link( $links ) {
        $settings_link = '<a href="'.esc_url( self::get_page_url() ).'">'.__('Configurações', 'infotravel-motor').'</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public static function load_menu() {
        if ( class_exists( 'Jetpack' ) )
            $hook = add_submenu_page( 'jetpack', __( 'Infotravel' , 'infotravel-motor'), __( 'Infotravel' , 'infotravel-motor'), 'manage_options', 'infotravel-config', array( 'Infotravel_Admin', 'display_page' ) );
        else
            $hook = add_options_page( __('Infotravel', 'infotravel-motor'), __('Infotravel', 'infotravel-motor'), 'manage_options', 'infotravel-config', array( 'Infotravel_Admin', 'display_page' ) );
    }

    public static function load_resources() {
        global $hook_suffix;

        if ( in_array( $hook_suffix, apply_filters( 'infotravel_admin_page_hook_suffixes', array(
            'index.php', # dashboard
            'settings_page_infotravel-config',
            'jetpack_page_infotravel-config',
            'plugins.php',
        ) ) ) ) {
            wp_register_style( 'infotravel-admin.css', plugin_dir_url( __FILE__ ) . '_inc/css/infotravel-admin.css', array(), INFOTRAVEL_VERSION );
            wp_enqueue_style( 'infotravel-admin.css');

            wp_register_script( 'infotravel-admin.js', plugin_dir_url( __FILE__ ) . '_inc/js/infotravel-admin.js', array('jquery'), INFOTRAVEL_VERSION );
            wp_enqueue_script( 'infotravel-admin.js' );

            $inline_js = array(
                'strings' => array(
                    'Remove this URL' => __( 'Remove this URL' , 'infotravel-motor'),
                    'Removing...'     => __( 'Removing...' , 'infotravel-motor'),
                    'URL removed'     => __( 'URL removed' , 'infotravel-motor'),
                    '(undo)'          => __( '(undo)' , 'infotravel-motor'),
                    'Re-adding...'    => __( 'Re-adding...' , 'infotravel-motor'),
                )
            );

            wp_localize_script( 'infotravel-admin.js', 'WPInfotravel', $inline_js );
        }
    }

    public static function display_page() {
        if ( ( isset( $_GET['view'] ) && $_GET['view'] == 'start' ) )
            self::display_start_page();
        elseif ( isset( $_GET['view'] ) && $_GET['view'] == 'stats' )
            self::display_stats_page();
        else
            self::display_configuration_page();
    }

    public static function display_start_page() {
        Infotravel::view( 'start' );
    }

    public static function display_stats_page() {
        Infotravel::view( 'stats' );
    }

    public static function display_configuration_page() {
        Infotravel::view( 'config' );
    }

    public static function get_page_url( $page = 'config' ) {
        $args = array( 'page' => 'infotravel-config' );
        if ( $page == 'stats' )
            $args = array( 'page' => 'infotravel-config', 'view' => 'stats' );
        elseif ( $page == 'delete_key' )
            $args = array( 'page' => 'infotravel-config', 'view' => 'start', 'action' => 'save', '_wpnonce' => wp_create_nonce( self::NONCE ) );

        $url = add_query_arg( $args, class_exists( 'Jetpack' ) ? admin_url( 'admin.php' ) : admin_url( 'options-general.php' ) );

        return $url;
    }

    public static function saveConfigHospedagem(){

        $hospedagemExibirHospedagem = $_POST["hospedagemExibirHospedagem"];
        $url_dominio_hospedagem = $_POST["url_dominio_hospedagem"];
        $infotravel_chave_hospedagem = $_POST["infotravel_chave_hospedagem"];
        $hospedagemExibirTopoRodape = $_POST["hospedagemExibirTopoRodape"];

        update_option('hospedagem_exibir', $hospedagemExibirHospedagem);
        update_option('hospedagem_dominio', $url_dominio_hospedagem);
        update_option('hospedagem_chave', $infotravel_chave_hospedagem);
        update_option('hospedagem_exibir_tr', $hospedagemExibirTopoRodape);

        return true;
    }

    public static function saveConfigPacote(){

        $pacoteExibirPacote = $_POST["pacoteExibirPacote"];
        $url_dominio_pacote = $_POST["url_dominio_pacote"];
        $infotravel_chave_pacote = $_POST["infotravel_chave_pacote"];
        $pacoteExibirTopoRodape = $_POST["pacoteExibirTopoRodape"];

        update_option('pacote_exibir', $pacoteExibirPacote);
        update_option('pacote_dominio', $url_dominio_pacote);
        update_option('pacote_chave', $infotravel_chave_pacote);
        update_option('pacote_exibir_tr', $pacoteExibirTopoRodape);

        return true;
    }

}



























