<?php
class WhatsApp_Btn
{
    public function init()
    {
        // Carga archivos necesarios
        $this->load_dependencies();

        // Agrega el enlace de WhatsApp al front-end
        add_action('wp_footer', array($this, 'insert_whatsapp_link'));

        // Registra las opciones del plugin
        add_action('admin_menu', array($this, 'register_options_page'));

        // Registra las opciones del plugin
        add_action('admin_init', array($this, 'register_settings'));
    }

    private function load_dependencies()
    {
        // Carga la clase de administración
        require_once plugin_dir_path(__FILE__) . 'class-whatsapp-btn-admin.php';
    }

    public function insert_whatsapp_link()
    {
        // Aquí puedes poner las opciones predeterminadas en caso de que no se hayan configurado
        $phone_number = get_option('whatsapp_btn_phone_number', '123456789');
        $message = urlencode(get_option('whatsapp_btn_message', '¡Hola! Me gustaría obtener más información.'));
        $background_color = get_option('whatsapp_btn_background_color', '#25D366');
        $text_color = get_option('whatsapp_btn_text_color', '#FFFFFF');
        $position = get_option('whatsapp_btn_position', 'bottom-right');
        $width = get_option('whatsapp_btn_width', '50px');
        $height = get_option('whatsapp_btn_height', '50px');
        $border_radius = get_option('whatsapp_btn_border_radius', '50%');
        //$padding = get_option('whatsapp_btn_padding', '10px');
        $svg_color = get_option('whatsapp_btn_svg_color', '#FFFFFF');
        $box_shadow = get_option('whatsapp_btn_box_shadow', '0 4px 6px rgba(0,0,0,0.1)');
        $content = wp_kses_post(get_option('whatsapp_btn_content', ''));
        if (empty($content)) {
            $content = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 60%; fill: ' . $svg_color . ';"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>';
        }

        echo '
    <a href="https://wa.me/' . $phone_number . '?text=' . $message . '" target="_blank" id="whatsapp-btn-link" style="position: fixed;display: flex;align-items: center;justify-content:center;  box-shadow: ' . $box_shadow . ';center; z-index: 1000; background-color: ' . $background_color . '; color: ' . $text_color . '; width: ' . $width . '; height: ' . $height . '; border-radius: ' . $border_radius . ';' . $this->get_position_css($position) . '">
    ' . $content . '
</a>
';
    }

    private function get_position_css($position)
    {
        switch ($position) {
            case 'bottom-right':
                return 'bottom: 20px; right: 20px;';
            case 'bottom-left':
                return 'bottom: 20px; left: 20px;';
            default:
                return 'bottom: 20px; right: 20px;';
        }
    }

    public function register_options_page()
    {


        add_menu_page(
            __('WhatsApp Btn', 'whatsapp-btn'), // Título de la página
            __('WhatsApp Btn', 'whatsapp-btn'), // Título del menú
            'manage_options', // Capacidad
            'whatsapp-btn', // Slug
            array($this, 'options_page_callback'), // Función de devolución de llamada
            'dashicons-whatsapp', // Icono
            80 // Posición
        );

        add_submenu_page(
            'whatsapp-btn',
            __('Configuración', 'whatsapp-btn'),
            __('Configuración', 'whatsapp-btn'),
            'manage_options',
            'whatsapp-btn',
            array($this, 'options_page_callback')
        );

        add_submenu_page(
            'whatsapp-btn',
            __('Información', 'whatsapp-btn'),
            __('Información', 'whatsapp-btn'),
            'manage_options',
            'whatsapp-btn-info',
            array($this, 'info_page_callback')
        );
    }

    public function options_page_callback()
    {
        $admin = new WhatsApp_Btn_Admin();
        $admin->display_options_page();
    }

    public function info_page_callback()
    {
        $admin = new WhatsApp_Btn_Admin();
        $admin->display_info_page();
    }

    public function register_settings()
    {
        register_setting('whatsapp_btn_options', 'whatsapp_btn_options', array($this, 'sanitize_options'));

        register_setting('whatsapp_btn_options', 'whatsapp_btn_phone_number');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_message');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_background_color');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_text_color');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_position');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_width');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_height');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_border_radius');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_padding');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_svg_color');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_box_shadow');
        register_setting('whatsapp_btn_options', 'whatsapp_btn_content');
        register_setting('whatsapp_btn', 'whatsapp_btn_link_color');
    }
}
