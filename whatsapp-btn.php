<?php

/**
 * Plugin Name: Free Super Chat Guasa button
 * Description: Este plugin fue creado para insertar un enlace de WhatsApp en la página, permitiendo a los visitantes enviar mensajes directamente al número de teléfono configurado.
 * En la pestaña de configuración, puedes personalizar el mensaje, el color de fondo, el color del texto, el número de teléfono y la ubicación del enlace en la página.
 * El enlace de WhatsApp se mostrará en la esquina inferior derecha o izquierda de la página, según la configuración elegida.
 * Version: 1.0
 * Author: Asdrúbal Pérez
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('ABSPATH')) {
    exit; // Evita el acceso directo al archivo
}

// Carga la clase principal del plugin
require_once plugin_dir_path(__FILE__) . 'includes/class-whatsapp-btn.php';

// Inicializa el plugin
function whatsapp_btn()
{
    $mi_plugin_whatsapp = new WhatsApp_Btn();
    $mi_plugin_whatsapp->init();
}

function whatsapp_plugin_load_textdomain()
{
    load_plugin_textdomain('whatsapp-btn', false, basename(dirname(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'whatsapp_plugin_load_textdomain');
// Registra la función de inicio
add_action('plugins_loaded', 'whatsapp_btn');
