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

            add_shortcode('infotravel_motor_hotel', array('Infotravel', 'motor_hotel'));
            add_shortcode('infotravel_motor_pacote_aereo', array('Infotravel', 'motor_pacote_aereo'));
            add_shortcode('infotravel_motor_pacote_dinamico', array('Infotravel', 'motor_pacote_dinamico'));
            add_shortcode('infotravel_motor_pacote_hotel', array('Infotravel', 'motor_pacote_hotel'));
            add_shortcode('infotravel_motor_pacote_rodo_hotel', array('Infotravel', 'motor_pacote_rodo_hotel'));
            add_shortcode('infotravel_motor_pacote_rodo_servico', array('Infotravel', 'motor_pacote_rodo_servico'));
        }

        private static function carregaJS($tipo, $jsFunction)
        {
            $chave = get_option("b2c_chave");
            $dominio = get_option("b2c_dominio");

            include INFOTRAVEL__PLUGIN_DIR . "views/template/$tipo.php";

            $html = "<script>"
                . "/* <![CDATA[ */"
                . "(function (d, s, id, ids) {"
                . "var js, jss, fjs = d.getElementsByTagName(s)[0];"
                . "if (d.getElementById(id))"
                . "return;"
                . "js = d.createElement(s);"
                . "js.id = id;"
                . "js.src = \"$dominio/motor/motorv2.js?v=" . INFOTRAVEL_VERSION . "\";"
                . "fjs.parentNode.insertBefore(js, fjs);"
                . "js2 = d.createElement(s);"
                . "js2.id = ids; "
                . "js2.text = \"document.addEventListener('DOMContentLoaded', function(event) {console.log('da');window.b2cMOTOR = new MotorBusca('$chave');});\";"
                . "fjs.parentNode.insertBefore(js2, fjs);"
                . "}"
                . "(document, 'script', 'js-b2c-motor', 'js-b2c-motor-init'))"
                . "/*]]>*/"
                . "</script>";

            $html .= "<script>"
                . "/* <![CDATA[ */"
                . "(function (d, s, id) {"
                . "var js, jss, fjs = d.getElementsByTagName(s)[0];"
                . "if (d.getElementById(id))"
                . "return;"
                . "js = d.createElement(s);"
                . "js.id = id;"
                . "js.text = \"document.addEventListener('DOMContentLoaded', function(event) { $jsFunction });\";"
                . "fjs.parentNode.insertBefore(js, fjs);"
                . "}"
                . "(document, 'script', 'js-$tipo'))"
                . "/*]]>*/"
                . "</script>";

            return $html;
        }

        public static function motor_hotel()
        {
            echo self::carregaJS("hospedagem", "window.b2cMOTOR.motorHotel('.pnlMotor.hotel');");
        }

        public static function motor_pacote_aereo()
        {
            echo self::carregaJS("pacote_aereo", "window.b2cMOTOR.motorPacoteAereo('.pnlMotor.pacoteAereo', null, true);");
        }

        public static function motor_pacote_hotel()
        {
            echo self::carregaJS("pacote_hotel", "window.b2cMOTOR.motorPacoteHotel('.pnlMotor.pacoteHotel', true);");
        }

        public static function motor_pacote_dinamico()
        {
            echo self::carregaJS("pacote_dinamico", "window.b2cMOTOR.motorPacoteDinamico('.pnlMotor.pacoteDinamico',null,true);");
        }

        public static function motor_pacote_rodo_hotel()
        {
            echo self::carregaJS("rodo_hotel", "window.b2cMOTOR.motorRodoHotel('.pnlMotor.rodoHotel');");
        }

        public static function motor_pacote_rodo_servico()
        {
            echo self::carregaJS("rodo_servico", "window.b2cMOTOR.motorRodoServico('.pnlMotor.rodoServico');");
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
