<?php

class Infotravel {
    private static $initiated = false;
    public static function init() {
        if ( ! self::$initiated ) {
            self::init_hooks();
        }
    }

    /**
     * Inicializa WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;

        add_action( 'wp_ajax_infotravel_hotel_autocomplete', array('Infotravel', 'hotel_autocomplete') );
        add_action( 'wp_ajax_nopriv_infotravel_hotel_autocomplete', array('Infotravel', 'hotel_autocomplete') );
        add_action( 'wp_ajax_infotravel_b2c_hospedagem', array('Infotravel', 'get_url_b2c') );
        add_action( 'wp_ajax_nopriv_infotravel_b2c_hospedagem', array('Infotravel', 'get_url_b2c') );

        add_action( 'wp_ajax_infotravel_pacote_autocomplete', array('Infotravel', 'pacote_autocomplete') );
        add_action( 'wp_ajax_nopriv_infotravel_pacote_autocomplete', array('Infotravel', 'pacote_autocomplete') );
        add_action( 'wp_ajax_infotravel_b2c_pacote', array('Infotravel', 'get_url_b2c_pacote') );
        add_action( 'wp_ajax_nopriv_infotravel_b2c_pacote', array('Infotravel', 'get_url_b2c_pacote') );
        
        add_action( 'wp_ajax_infotravel_pacote_dinamico_autocomplete', array('Infotravel', 'pacote_dinamico_autocomplete') );
        add_action( 'wp_ajax_nopriv_infotravel_pacote_dinamico_autocomplete', array('Infotravel', 'pacote_dinamico_autocomplete') );
        add_action( 'wp_ajax_infotravel_b2c_pacote_dinamico', array('Infotravel', 'get_url_b2c_pacote_dinamico') );
        add_action( 'wp_ajax_nopriv_infotravel_b2c_pacote_dinamico', array('Infotravel', 'get_url_b2c_pacote_dinamico') );

        add_shortcode( 'infotravel_motor_hotel', array( 'Infotravel', 'motor_hotel' ) );
        add_shortcode( 'infotravel_motor_pacote', array( 'Infotravel', 'motor_pacote' ) );
        add_shortcode( 'infotravel_motor_pacote_dinamico', array( 'Infotravel', 'motor_pacote_dinamico' ) );
    }

    public static function motor_hotel(){

        wp_register_style( 'jquery-ui.min.css', plugin_dir_url( __FILE__ ) . 'views/template/css/jquery-ui.min.css', array(), INFOTRAVEL_VERSION );
        wp_register_style( 'font-awesome.min.css', plugin_dir_url( __FILE__ ) . 'views/template/css/font-awesome.min.css', array(), INFOTRAVEL_VERSION );
        wp_register_style( 'infotravel-motor.css', plugin_dir_url( __FILE__ ) . 'views/template/css/infotravel-motor.css', array(), INFOTRAVEL_VERSION );
        wp_enqueue_style('jquery-ui.min.css');
        wp_enqueue_style('font-awesome.min.css');
        wp_enqueue_style('infotravel-motor.css');


        if(get_option('hospedagem_exibir') == "true"){
            $file = INFOTRAVEL__PLUGIN_DIR . 'views/template/hotel.php';

            include ($file);
        }

        wp_register_script( 'jquery-ui.min.js', plugin_dir_url( __FILE__ ) . 'views/template/js/jquery-ui.min.js', array('jquery'), INFOTRAVEL_VERSION );
        wp_register_script( 'jquery.autocomplete.js', plugin_dir_url( __FILE__ ) . 'views/template/js/jquery.autocomplete.js', array('jquery', 'jquery-ui.min.js'), INFOTRAVEL_VERSION );
        wp_enqueue_script('jquery-ui.min.js');
        wp_enqueue_script('jquery.autocomplete.js');

        if(get_option('hospedagem_exibir') == "true"){
            wp_register_script( 'infotravel-motor-hotel.js', plugin_dir_url( __FILE__ ) . 'views/template/js/infotravel-motor-hotel.js', array('jquery', 'jquery-ui.min.js', 'jquery.autocomplete.js'), INFOTRAVEL_VERSION );
            wp_enqueue_script('infotravel-motor-hotel.js');

            $html = '<script>'
                . 'jQuery(document).ready(function(){'
                . 'motorDeBuscaHotel.init();'
                . '});'
                . '</script>';
            echo $html;
        }
    }


    public static function motor_pacote(){

        $file = INFOTRAVEL__PLUGIN_DIR . 'views/template/pacote.php';
		
        wp_register_style( 'jquery-ui.min.css', plugin_dir_url( __FILE__ ) . 'views/template/css/jquery-ui.min.css', array(), INFOTRAVEL_VERSION );
        wp_register_style( 'font-awesome.min.css', plugin_dir_url( __FILE__ ) . 'views/template/css/font-awesome.min.css', array(), INFOTRAVEL_VERSION );
        wp_register_style( 'infotravel-motor.css', plugin_dir_url( __FILE__ ) . 'views/template/css/infotravel-motor.css', array(), INFOTRAVEL_VERSION );
        wp_enqueue_style('jquery-ui.min.css');
        wp_enqueue_style('font-awesome.min.css');
        wp_enqueue_style('infotravel-motor.css');
		
        if(get_option('pacote_exibir') == "true"){
            include ($file);
        }
		
		 wp_register_script( 'jquery-ui.min.js', plugin_dir_url( __FILE__ ) . 'views/template/js/jquery-ui.min.js', array('jquery'), INFOTRAVEL_VERSION );
        wp_register_script( 'jquery.autocomplete.js', plugin_dir_url( __FILE__ ) . 'views/template/js/jquery.autocomplete.js', array('jquery', 'jquery-ui.min.js'), INFOTRAVEL_VERSION );
        wp_enqueue_script('jquery-ui.min.js');
        wp_enqueue_script('jquery.autocomplete.js');

        wp_register_script( 'infotravel-motor-pacote.js', plugin_dir_url( __FILE__ ) . 'views/template/js/infotravel-motor-pacote.js', array('jquery', 'jquery-ui.min.js', 'jquery.autocomplete.js'), INFOTRAVEL_VERSION );
        wp_enqueue_script('infotravel-motor-pacote.js');

        $html = '<script>'
            . 'jQuery(document).ready(function(){'
            . 'motorDeBuscaPacote.init();'
            . '});'
            . '</script>';
        
        echo $html;
    }
    
    public static function motor_pacote_dinamico(){
        
        $file = INFOTRAVEL__PLUGIN_DIR . 'views/template/pacote_dinamico.php';
		
        wp_register_style( 'jquery-ui.min.css', plugin_dir_url( __FILE__ ) . 'views/template/css/jquery-ui.min.css', array(), INFOTRAVEL_VERSION );
        wp_register_style( 'font-awesome.min.css', plugin_dir_url( __FILE__ ) . 'views/template/css/font-awesome.min.css', array(), INFOTRAVEL_VERSION );
        wp_register_style( 'infotravel-motor.css', plugin_dir_url( __FILE__ ) . 'views/template/css/infotravel-motor.css', array(), INFOTRAVEL_VERSION );
        wp_enqueue_style('jquery-ui.min.css');
        wp_enqueue_style('font-awesome.min.css');
        wp_enqueue_style('infotravel-motor.css');
		
        if(get_option('pacote_dinamico_exibir') == "true"){
            include ($file);
        }
		
        wp_register_script( 'jquery-ui.min.js', plugin_dir_url( __FILE__ ) . 'views/template/js/jquery-ui.min.js', array('jquery'), INFOTRAVEL_VERSION );
        wp_register_script( 'jquery.autocomplete.js', plugin_dir_url( __FILE__ ) . 'views/template/js/jquery.autocomplete.js', array('jquery', 'jquery-ui.min.js'), INFOTRAVEL_VERSION );
        wp_enqueue_script('jquery-ui.min.js');
        wp_enqueue_script('jquery.autocomplete.js');

        wp_register_script( 'infotravel-motor-pacote-dinamico.js', plugin_dir_url( __FILE__ ) . 'views/template/js/infotravel-motor-pacote-dinamico.js', array('jquery', 'jquery-ui.min.js', 'jquery.autocomplete.js'), INFOTRAVEL_VERSION );
        wp_enqueue_script('infotravel-motor-pacote-dinamico.js');
        
        $html = '<script>'
            . 'jQuery(document).ready(function(){'
            . 'motorDeBuscaPacoteDinamico.init();'
            . '});'
            . '</script>';
        
        echo $html;
    }

    public static function hotel_autocomplete (){

        $url = get_option("hospedagem_dominio");
        $chave = get_option("hospedagem_chave");
        
        if($_POST['valor']){
            $valor = '&nmDestino=' . $_POST['valor'];
        }
        
        $response = wp_remote_get( $url . '/infotravel/ws/v1/motor/hospedagem/'. $chave .'?stConfig=S' . $valor );
        echo $response['body'];
        die();

    }

    public static function pacote_autocomplete (){
        $url = get_option("pacote_dominio");
        $chave = get_option("pacote_chave");
        $param = '';

        if($_POST['param']){
            $param = $_POST['param'];
        }
        
        $response = wp_remote_get( $url . '/infotravel/ws/v1/motor/pacote-aereo/'. $chave .'?stConfig=S' . $param );

        echo $response['body'];
        die();
    }

    public static function pacote_dinamico_autocomplete (){
        $url = get_option("pacote_dinamico_dominio");
        $chave = get_option("pacote_dinamico_chave");
        $param = '';

        if($_POST['param']){
            $param = $_POST['param'];
        }
        
        $response = wp_remote_get( $url . '/infotravel/ws/v1/motor/pacote-dinamico/'. $chave .'?stConfig=S' . $_POST['param'] );
        
        echo $response['body'];
        die();
    }
    
    
    private static function bail_on_activation( $message, $deactivate = true ) {
        ?>
        <!doctype html>
        <html>
        <head>
            <meta charset="<?php bloginfo( 'charset' ); ?>">
            <style>
                * {
                    text-align: center;
                    margin: 0;
                    padding: 0;
                    font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
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
        if ( $deactivate ) {
            $plugins = get_option( 'active_plugins' );
            $infotravel = plugin_basename( INFOTRAVEL__PLUGIN_DIR . 'infotravel-motor.php' );
            $update  = false;
            foreach ( $plugins as $i => $plugin ) {
                if ( $plugin === $infotravel ) {
                    $plugins[$i] = false;
                    $update = true;
                }
            }
            if ( $update ) {
                update_option( 'active_plugins', array_filter( $plugins ) );
            }
        }
        exit;
    }

    /**
     * Chamado por activate_{ plugin_basename( __FILES__ ) } por register_activation_hook()
     * @static
     */
    public static function plugin_activation() {
        if ( version_compare( $GLOBALS['wp_version'], INFOTRAVEL__MINIMUM_WP_VERSION, '<' ) ) {
            load_plugin_textdomain( 'infotravel-motor' );

            $message = '<strong>'.sprintf(esc_html__( 'Infotravel Plugin %s requer WordPress %s ou mais.' , 'infotravel-motor'), INFOTRAVEL_VERSION, INFOTRAVEL__MINIMUM_WP_VERSION ).'</strong> '.sprintf(__('Por favor <a href="%1$s" target="">atualize seu WordPress</a> para uma versão mais nova.', 'infotravel-motor'), 'https://codex.wordpress.org/Upgrading_WordPress');

            Infotravel::bail_on_activation( $message );
        }

        update_option('hospedagem_exibir', 'true');
        update_option('hospedagem_dominio', '');
        update_option('hospedagem_chave', '');
        update_option('hospedagem_exibir_tr', 'true');

        update_option('pacote_exibir', 'true');
        update_option('pacote_dominio', '');
        update_option('pacote_chave', '');
        update_option('pacote_exibir_tr', 'true');
        
        update_option('pacote_dinamico_exibir', 'true');
        update_option('pacote_dinamico_dominio', '');
        update_option('pacote_dinamico_chave', '');
        update_option('pacote_dinamico_exibir_tr', 'true');
    }

    /**
     * Remove todas as opções de conexões
     * @static
     */
    public static function plugin_deactivation( ) {
        delete_option('hospedagem_exibir');
        delete_option('hospedagem_dominio');
        delete_option('hospedagem_chave');
        delete_option('hospedagem_exibir_tr');

        delete_option('pacote_exibir');
        delete_option('pacote_dominio');
        delete_option('pacote_chave');
        delete_option('pacote_exibir_tr');

        delete_option('pacote_dinamico_exibir');
        delete_option('pacote_dinamico_dominio');
        delete_option('pacote_dinamico_chave');
        delete_option('pacote_dinamico_exibir_tr');
        
        return 'deactivated';
    }

    public static function view( $name, array $args = array() ) {

        load_plugin_textdomain( 'infotravel-motor' );

        $file = INFOTRAVEL__PLUGIN_DIR . 'views/admin/'. $name . '.php';

        include( $file );
    }

    public static function get_url_b2c(){
        echo get_option("hospedagem_dominio") . '/b2c/hotel';
        die();
    }

    public static function get_url_b2c_pacote(){
        echo get_option("pacote_dominio") . '/b2c/pacote-aereo';
        die();
    }

    public static function get_url_b2c_pacote_dinamico(){
        echo get_option("pacote_dinamico_dominio") . '/b2c/pacote-dinamico';
        die();
    }
}
