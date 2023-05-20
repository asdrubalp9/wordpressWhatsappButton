<?php
class WhatsApp_Btn_Admin
{
    public function display_options_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('No tienes suficientes permisos para acceder a esta página.'));
        }
?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <?php settings_errors('whatsapp_btn_options'); ?>
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('whatsapp_btn_options_save', 'whatsapp_btn_nonce');
                settings_fields('whatsapp_btn_options');
                do_settings_sections('whatsapp_btn_options');

                // Agregar un campo nonce

                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php echo __('Número de teléfono', 'whatsapp-btn') ?></th>
                        <td><input type="text" placeholder="<?php echo __('Ejemplo', 'whatsapp-btn') ?> 56..." name="whatsapp_btn_phone_number" value="<?php echo esc_attr(get_option('whatsapp_btn_phone_number')); ?>" /></td>

                        <th scope="row"><?php echo __('Mensaje inicial', 'whatsapp-btn') ?></th>
                        <td><input type="text" name="whatsapp_btn_message" value="<?php echo esc_attr(get_option('whatsapp_btn_message')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo __('Color de fondo', 'whatsapp-btn') ?></th>
                        <td><input type="color" name="whatsapp_btn_background_color" value="<?php echo esc_attr(get_option('whatsapp_btn_background_color')); ?>" /></td>

                        <th scope="row"><?php echo __('Color del texto', 'whatsapp-btn') ?></th>
                        <td><input type="color" name="whatsapp_btn_text_color" value="<?php echo esc_attr(get_option('whatsapp_btn_text_color')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo __('Ancho', 'whatsapp-btn') ?></th>
                        <td><input type="text" name="whatsapp_btn_width" value="<?php echo esc_attr(get_option('whatsapp_btn_width')); ?>" /></td>

                        <th scope="row"><?php echo __('Alto', 'whatsapp-btn') ?></th>
                        <td><input type="text" name="whatsapp_btn_height" value="<?php echo esc_attr(get_option('whatsapp_btn_height')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo __('Redondeado', 'whatsapp-btn') ?></th>
                        <td><input type="text" name="whatsapp_btn_border_radius" value="<?php echo esc_attr(get_option('whatsapp_btn_border_radius')); ?>" placeholder="50% para que sea circular" /></td>

                        <th scope="row"><?php echo __('Relleno interno', 'whatsapp-btn') ?></th>
                        <td><input type="text" name="whatsapp_btn_padding" value="<?php echo esc_attr(get_option('whatsapp_btn_padding')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo __('Color del icono predeterminado', 'whatsapp-btn') ?></th>
                        <td><input type="color" name="whatsapp_btn_svg_color" value="<?php echo esc_attr(get_option('whatsapp_btn_svg_color')); ?>" /></td>

                        <th scope="row"><?php echo __('Sombra', 'whatsapp-btn') ?></th>
                        <td><input type="text" name="whatsapp_btn_box_shadow" value="<?php echo esc_attr(get_option('whatsapp_btn_box_shadow')); ?>" placeholder="Ejemplo: 0 4px 6px rgba(0,0,0,0.1)" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo __('Posición', 'whatsapp-btn') ?></th>
                        <td>
                            <select name="whatsapp_btn_position">
                                <option value="bottom-right" <?php selected(get_option('whatsapp_btn_position'), 'bottom-right'); ?>>Esquina inferior derecha</option>
                                <option value="bottom-left" <?php selected(get_option('whatsapp_btn_position'), 'bottom-left'); ?>>Esquina inferior izquierda</option>
                            </select>
                        </td>
                        <th scope="row"><?php echo __('Contenido del botón de Guasa', 'whatsapp-btn') ?></th>
                        <td>
                            <textarea name="whatsapp_btn_content" placeholder="<?php echo __('Si no te gusta el icono actual de whatsapp, puedes colocar tu contenido aquí') ?> "><?php echo esc_textarea(wp_unslash(get_option('whatsapp_btn_content'))); ?></textarea>
                        </td>

                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo __('Color del enlace del botón de WhatsApp', 'whatsapp-btn') ?></th>
                        <td><input type="color" name="whatsapp_btn_link_color" value="<?php echo esc_attr(get_option('whatsapp_btn_link_color')); ?>" placeholder="Sí personalizaste tu botón, puedes asignarle un color" /></td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <div id="whatsapp-btn-preview-container">
                                <h3><?php echo __('Vista previa', 'whatsapp-btn') ?></h3>
                                <div id="whatsapp-btn-preview"></div>
                            </div>
                        </td>
                    </tr>

                    <?php submit_button(__('Guardar cambios', 'whatsapp-btn')); ?>
            </form>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const preview = document.getElementById('whatsapp-btn-preview');
                const bgColorInput = document.querySelector('input[name="whatsapp_btn_background_color"]');
                const textColorInput = document.querySelector('input[name="whatsapp_btn_text_color"]');
                const svgColorInput = document.querySelector('input[name="whatsapp_btn_svg_color"]');
                const widthInput = document.querySelector('input[name="whatsapp_btn_width"]');
                const heightInput = document.querySelector('input[name="whatsapp_btn_height"]');
                const borderRadiusInput = document.querySelector('input[name="whatsapp_btn_border_radius"]');
                const paddingInput = document.querySelector('input[name="whatsapp_btn_padding"]');
                const boxShadowInput = document.querySelector('input[name="whatsapp_btn_box_shadow"]');
                const contentInput = document.querySelector('textarea[name="whatsapp_btn_content"]');
                const linkColorInput = document.querySelector('input[name="whatsapp_btn_link_color"]');

                function updatePreview() {
                    const bgColor = bgColorInput.value;
                    const textColor = textColorInput.value;
                    const svgColor = svgColorInput.value;
                    const width = widthInput.value;
                    const height = heightInput.value;
                    const borderRadius = borderRadiusInput.value;
                    const padding = paddingInput.value;
                    const boxShadow = boxShadowInput.value;
                    const btnContent = contentInput.value;
                    const linkColor = linkColorInput.value;

                    preview.innerHTML = `
                    <a href="#" id="whatsapp-btn-link" style="display:flex;justify-content:center; align-items:center;background-color: ${bgColor}; color: ${linkColor}; width: ${width}; height: ${height}; border-radius: ${borderRadius}; padding: ${padding}; box-shadow: ${boxShadow};">
                        ${btnContent ? btnContent : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 60%; fill: '+svgColor+'"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>'}
                    </a>
                        `;
                }

                updatePreview();
                bgColorInput.addEventListener('input', updatePreview);
                textColorInput.addEventListener('input', updatePreview);
                svgColorInput.addEventListener('input', updatePreview);
                widthInput.addEventListener('input', updatePreview);
                heightInput.addEventListener('input', updatePreview);
                borderRadiusInput.addEventListener('input', updatePreview);
                paddingInput.addEventListener('input', updatePreview);
                boxShadowInput.addEventListener('input', updatePreview);
                contentInput.addEventListener('input', updatePreview);
                linkColorInput.addEventListener('input', updatePreview);
            });
        </script>
    <?php
    }

    public function sanitize_options($options)
    {
        // Verifica el nonce antes de guardar los cambios
        if (!isset($_POST['whatsapp_btn_nonce']) || !wp_verify_nonce($_POST['whatsapp_btn_nonce'], 'whatsapp_btn_options_save')) {
            add_settings_error('whatsapp_btn_options', 'whatsapp_btn_options_error', 'La solicitud no es válida. Por favor, intenta de nuevo.', 'error');
            return false;
        }

        // Limpia y valida cada opción
        $sanitized_options = array();

        if (isset($options['whatsapp_btn_phone_number'])) {
            $sanitized_options['whatsapp_btn_phone_number'] = sanitize_text_field($options['whatsapp_btn_phone_number']);
        }

        if (isset($options['whatsapp_btn_message'])) {
            $sanitized_options['whatsapp_btn_message'] = sanitize_textarea_field($options['whatsapp_btn_message']);
        }

        // Aquí limpiaremos y validaremos las demás opciones
        if (isset($options['whatsapp_btn_background_color'])) {
            $sanitized_options['whatsapp_btn_background_color'] = sanitize_text_field($options['whatsapp_btn_background_color']);
        }

        if (isset($options['whatsapp_btn_text_color'])) {
            $sanitized_options['whatsapp_btn_text_color'] = sanitize_text_field($options['whatsapp_btn_text_color']);
        }

        if (isset($options['whatsapp_btn_svg_color'])) {
            $sanitized_options['whatsapp_btn_svg_color'] = sanitize_text_field($options['whatsapp_btn_svg_color']);
        }

        if (isset($options['whatsapp_btn_width'])) {
            $sanitized_options['whatsapp_btn_width'] = sanitize_text_field($options['whatsapp_btn_width']);
        }

        if (isset($options['whatsapp_btn_height'])) {
            $sanitized_options['whatsapp_btn_height'] = sanitize_text_field($options['whatsapp_btn_height']);
        }

        if (isset($options['whatsapp_btn_border_radius'])) {
            $sanitized_options['whatsapp_btn_border_radius'] = sanitize_text_field($options['whatsapp_btn_border_radius']);
        }

        if (isset($options['whatsapp_btn_padding'])) {
            $sanitized_options['whatsapp_btn_padding'] = sanitize_text_field($options['whatsapp_btn_padding']);
        }

        if (isset($options['whatsapp_btn_box_shadow'])) {
            $sanitized_options['whatsapp_btn_box_shadow'] = sanitize_text_field($options['whatsapp_btn_box_shadow']);
        }

        if (isset($options['whatsapp_btn_position'])) {
            $sanitized_options['whatsapp_btn_position'] = sanitize_text_field($options['whatsapp_btn_position']);
        }

        if (isset($options['whatsapp_btn_content'])) {
            $sanitized_options['whatsapp_btn_content'] = sanitize_textarea_field($options['whatsapp_btn_content']);
        }

        if (isset($options['whatsapp_btn_link_color'])) {
            $sanitized_options['whatsapp_btn_link_color'] = sanitize_text_field($options['whatsapp_btn_link_color']);
        }

        // Agrega el mensaje de éxito
        add_settings_error('whatsapp_btn_options', 'whatsapp_btn_options_saved', 'Los cambios se han guardado correctamente.', 'success');

        return $sanitized_options;
    }


    public function display_info_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('No tienes suficientes permisos para acceder a esta página.'));
        }
    ?>
        <div class="wrap">
            <h1>Free Super Chat Guasa button </h1>
            <p><?php echo __('Este plugin fue creado para insertar un enlace de WhatsApp en la página, permitiendo a los visitantes enviar mensajes directamente al número de teléfono configurado.', 'whatsapp-btn'); ?> </p>
            <p><?php echo __('En la pestaña de configuración, puedes personalizar el mensaje, el color de fondo, el color del texto, el número de teléfono y la ubicación del enlace en la página.', 'whatsapp-btn'); ?> </p>
            <p><?php echo __('El enlace de WhatsApp se mostrará en la esquina inferior derecha o izquierda de la página, según la configuración elegida.', 'whatsapp-btn'); ?> </p>
            <p><?php echo __('Desarrollado por: Asdrúbal Pérez', 'whatsapp-btn'); ?> </p>
            <p><?php echo __('Versión: 1.0', 'whatsapp-btn'); ?> </p>
            <p><?php echo __('Cualquier comentario, requerimiento, sugerencia, desarrollo personalizado, puedes dirigirlo al correo asdrubaldev@gmail.com', 'whatsapp-btn'); ?> </p>
            <div style="display:flex; justify-content:start; gap:20px; items:center">
                <a href="https://www.buymeacoffee.com/Drup9" target="_blank" style="display: flex; justify-content: center; align-items: center;"><img src="<?php echo plugin_dir_url(__FILE__) . 'bmc_qr.png'; ?>" alt="Buy Me A Coffee" style="height: 160px !important;width: 160px !important;"></a>
                <a href="https://www.buymeacoffee.com/Drup9" target="_blank" style="display: flex; justify-content: center; align-items: center;"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" style="height: 60px !important;width: 217px !important;"></a>
            </div>
        </div>
<?php
    }
}
