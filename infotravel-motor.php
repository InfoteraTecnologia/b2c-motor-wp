<?php

    /**
     * @package Infotravel Motor
     * @author Infotera Tecnologia <suporte@infotera.com.br>
     * @license GPLv3
     * @copyright 2018 by Infotera Tecnologia
     */

    /*
     *  Plugin Name: Infotravel - Motor de Busca JS
     *  Plugin URI: https://github.com/InfoteraTecnologia/b2c-motor-wp
     *  Description: Plugin para inserção dos motores de busca do infotravel.
     *  Version: 2.2
     *  Author: INFOTERA TECNOLOGIA
     *  Author URI: http://infotera.com.br/
     *  License:

     * Text Domain: infotravel-motor
     *
     * @author INFOTERA TECNOLOGIA
     * @version 2.2
    */

    // Certifique-se de não expor nenhuma informação se for chamado diretamente
    if (!function_exists('add_action')) {
        echo 'Olá! Eu sou apenas um plugin, não há muito que eu possa fazer quando chamado diretamente.';
        exit;
    }

    define('INFOTRAVEL_VERSION', '2.2');
    define('INFOTRAVEL__MINIMUM_WP_VERSION', '3.7');
    define('INFOTRAVEL__PLUGIN_DIR', plugin_dir_path(__FILE__));
    define('INFOTRAVEL__PLUGIN_URL', plugins_url('', __FILE__));

    register_activation_hook(__FILE__, array('Infotravel', 'plugin_activation'));
    register_deactivation_hook(__FILE__, array('Infotravel', 'plugin_deactivation'));

    require_once(INFOTRAVEL__PLUGIN_DIR . 'class.infotravel-motor.php');

    add_action('init', array('Infotravel', 'init'));

    if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
        require_once(INFOTRAVEL__PLUGIN_DIR . 'class.infotravel-motor-admin.php');
        add_action('init', array('Infotravel_Admin', 'init'));
    }


    //eol