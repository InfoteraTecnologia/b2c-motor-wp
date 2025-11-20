<?php

class Infotravel
{
    private static $initiated = false;

    public static function init()
    {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    /**
     * Inicializa WordPress hooks
     */
    private static function init_hooks()
    {
        self::$initiated = true;

        // New unified motor shortcode
        add_shortcode('infotravel_motor_unified', array('Infotravel', 'motor_unified'));

        // Add hooks for loading dependencies
        add_action('wp_enqueue_scripts', array('Infotravel', 'maybe_load_dependencies'));
        add_action('wp_head', array('Infotravel', 'maybe_load_dependencies'));
    }

    /**
     * New unified motor shortcode that loads the complete motor structure
     */
    public static function motor_unified()
    {
        $chave = get_option("b2c_chave");
        $sgEmpresa = get_option("b2c_empresa");
        $dominio = get_option("b2c_dominio");
        $engineBaseUrl = get_option("b2c_engine_base_url", $dominio);
        $baseUrlApi = get_option("b2c_base_url_api", $dominio);
        $whiteLabel = get_option("b2c_white_label", '0') === '1';
        $iframe = get_option("b2c_iframe", '0') === '1';
        $target = get_option("b2c_target", '0') === '1';

        if (empty($chave) || empty($dominio) || empty($sgEmpresa)) {
            return 'Plugin Infotravel Motor não configurado.';
        }

        // Check if CSS loading is enabled
        $load_css = get_option('b2c_load_css', '1') === '1';
        $load_tabs = get_option('b2c_load_tabs', '1') === '1';

        $html = '';

        // Load CSS if enabled - using exact same path as motor.html
        if ($load_css) {
            $html .= '<link rel="stylesheet" href="' . esc_url($dominio) . '/motor/v1/motor.css" />';
        }

        // Load Font Awesome
        $html .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />';

        // Load required scripts
        $html .= '<script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>';
        $html .= '<script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>';

        // Include the motor HTML structure
        ob_start();
        include INFOTRAVEL__PLUGIN_DIR . 'views/template/motor_unified.php';
        $motor_html = ob_get_clean();

        $html .= $motor_html;

        // Load motor scripts
        $html .= '<script src="' . esc_url($dominio) . '/motor/v1/motor.js"></script>';
        $html .= '<script src="' . esc_url($dominio) . '/motor/v1/scripts.js"></script>';

        // Initialize the search engine
        $html .= '<script type="text/javascript">
            const searchEngine = SearchEngine({
                key: \'' . esc_js($chave) . '\',
                sgCompany: \'' . esc_js($sgEmpresa) . '\',
                b2cUrl: \'' . esc_url($dominio) . '\',
                engineBaseUrl: \'' . esc_url($engineBaseUrl) . '\',
                baseUrlApi: \'' . esc_url($baseUrlApi) . '\',
                whiteLabel: ' . ($whiteLabel ? 'true' : 'false') . ',
                iframe: ' . ($iframe ? 'true' : 'false') . ',
                target: ' . ($target ? 'true' : 'false') . '
            });

            // Initialize enabled motors
            ';

        // Check which motors are enabled and add initialization code
        if (get_option('b2c_enable_hotel', '1') === '1') {
            $html .= 'searchEngine.initHotelEngine({});';
        }

        if (get_option('b2c_enable_service', '1') === '1') {
            $html .= 'searchEngine.initServiceEngine({});';
        }

        if (get_option('b2c_enable_flight', '1') === '1') {
            $html .= 'searchEngine.initFlightEngine({});';
        }

        if (get_option('b2c_enable_dynamic_package', '1') === '1') {
            $html .= 'searchEngine.initDynamicPackageEngine({});';
        }

        if (get_option('b2c_enable_flight_package', '1') === '1') {
            $html .= 'searchEngine.initFlightPackageEngine({});';
        }

        if (get_option('b2c_enable_hotel_package', '1') === '1') {
            $html .= 'searchEngine.initHotelPackageEngine({});';
        }

        if (get_option('b2c_enable_bus_hotel_package', '1') === '1') {
            $html .= 'searchEngine.initBusHotelPackageEngine({});';
        }

        if (get_option('b2c_enable_bus_services_package', '1') === '1') {
            $html .= 'searchEngine.initBusServicesPackageEngine({});';
        }

        $html .= '
        </script>';

        return $html;
    }

    /**
     * Loads CSS dependencies if enabled
     */
    public static function maybe_load_dependencies()
    {
        // CSS is now loaded directly in the motor_unified() method
        // to match the exact structure of the original motor.html
    }

    private static function bail_on_activation($message, $deactivate = true)
    {
?>
        <!doctype html>
        <html>

        <head>
            <meta charset="<?php bloginfo('charset'); ?>">
            <style>
                * {
                    text-align: center;
                    margin: 0;
                    padding: 0;
                    font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
                }

                p {
                    margin-top: 1em;
                    font-size: 18px;
                }
            </style>

        <body>
            <p><?php echo $message; ?></p>
        </body>

        </html>
<?php
        if ($deactivate) {
            $plugins = get_option('active_plugins');
            $infotravel = plugin_basename(INFOTRAVEL__PLUGIN_DIR . 'infotravel-motor.php');
            $update = false;
            foreach ($plugins as $i => $plugin) {
                if ($plugin === $infotravel) {
                    $plugins[$i] = false;
                    $update = true;
                }
            }
            if ($update) {
                update_option('active_plugins', array_filter($plugins));
            }
        }
        exit;
    }

    /**
     * Chamado por activate_{ plugin_basename( __FILES__ ) } por register_activation_hook()
     * @static
     */
    public
    static function plugin_activation()
    {
        if (version_compare($GLOBALS['wp_version'], INFOTRAVEL__MINIMUM_WP_VERSION, '<')) {
            load_plugin_textdomain('infotravel-motor');

            $message = '<strong>' . sprintf(esc_html__('Infotravel Plugin %s requer WordPress %s ou mais.', 'infotravel-motor'), INFOTRAVEL_VERSION, INFOTRAVEL__MINIMUM_WP_VERSION) . '</strong> ' . sprintf(__('Por favor <a href="%1$s" target="">atualize seu WordPress</a> para uma versão mais nova.', 'infotravel-motor'), 'https://codex.wordpress.org/Upgrading_WordPress');

            Infotravel::bail_on_activation($message);
        }

        update_option('b2c_dominio', '');
        update_option('b2c_chave', '');
        update_option('b2c_empresa', '');
        update_option('b2c_engine_base_url', '');
        update_option('b2c_base_url_api', '');
        update_option('b2c_white_label', '0');
        update_option('b2c_iframe', '0');
        update_option('b2c_target', '0');

        // Set default dependency loading options
        update_option('b2c_load_css', '1');        // Enable CSS by default
        update_option('b2c_load_tabs', '1');       // Enable tabs by default

        // Set default motor activation options
        update_option('b2c_enable_hotel', '1');                    // Enable hotel by default
        update_option('b2c_enable_service', '1');                  // Enable service by default
        update_option('b2c_enable_flight', '1');                   // Enable flight by default
        update_option('b2c_enable_dynamic_package', '1');          // Enable dynamic package by default
        update_option('b2c_enable_flight_package', '1');           // Enable flight package by default
        update_option('b2c_enable_hotel_package', '1');            // Enable hotel package by default
        update_option('b2c_enable_bus_hotel_package', '1');        // Enable bus+hotel package by default
        update_option('b2c_enable_bus_services_package', '1');     // Enable bus+services package by default
    }

    /**
     * Remove todas as opções de conexões
     * @static
     */
    public
    static function plugin_deactivation()
    {
        delete_option('b2c_dominio');
        delete_option('b2c_chave');
        delete_option('b2c_empresa');
        delete_option('b2c_engine_base_url');
        delete_option('b2c_base_url_api');
        delete_option('b2c_white_label');
        delete_option('b2c_iframe');
        delete_option('b2c_target');

        // Clean up dependency options
        delete_option('b2c_load_css');
        delete_option('b2c_load_tabs');

        // Clean up motor activation options
        delete_option('b2c_enable_hotel');
        delete_option('b2c_enable_service');
        delete_option('b2c_enable_flight');
        delete_option('b2c_enable_dynamic_package');
        delete_option('b2c_enable_flight_package');
        delete_option('b2c_enable_hotel_package');
        delete_option('b2c_enable_bus_hotel_package');
        delete_option('b2c_enable_bus_services_package');

        return 'deactivated';
    }

    public
    static function view($name, array $args = array())
    {

        load_plugin_textdomain('infotravel-motor');

        $file = INFOTRAVEL__PLUGIN_DIR . '_inc/admin/' . $name . '.php';

        include($file);
    }
}
