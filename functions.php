


<?php

function register_my_menu() {
    register_nav_menu('primary', __('Primary Menu'));
}
add_action('after_setup_theme', 'register_my_menu');



// Encolar estilos y scripts de Bootstrap
function enqueue_bootstrap_styles_scripts() {
    // Encolar el CSS de Bootstrap con integridad y crossorigin
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(), // Dependencias
        '5.3.3', // Versión
        'all' // Media
    );

    // Encolar el JavaScript de Bootstrap con integridad y crossorigin
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(), // Dependencias
        '5.3.3', // Versión
        true // Cargar en el pie de página
    );

    // Encolar tu hoja de estilos compilada desde Sass
    wp_enqueue_style(
        'custom-style',
        get_template_directory_uri() . '/style.css',
        array('bootstrap-css'), // Dependencias
        '1.0', // Versión
        'all' // Media
    );
}

// Gancho para encolar los estilos y scripts en el frontend
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_styles_scripts');

// Encolar Normalize.css
function add_normalize_CSS() {
   wp_enqueue_style('normalize-styles', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css');
}
add_action('wp_enqueue_scripts', 'add_normalize_CSS');

// Registrar una nueva sidebar simplemente llamada 'Sidebar'
function add_widget_support() {
    register_sidebar(array(
        'name'          => 'Sidebar',
        'id'            => 'sidebar',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
}
// Gancho para la inicialización del widget
add_action('widgets_init', 'add_widget_support');

// Registrar un nuevo menú de navegación
function add_main_nav() {
    register_nav_menu('header-menu', __('Header Menu'));
}
// Gancho para la inicialización de los menús de navegación
add_action('init', 'add_main_nav');


// Función de devolución de llamada para el metabox
function custom_metabox_callback($post) {
    // Recuperar el valor actual del metabox
    $meta_value = get_post_meta($post->ID, '_custom_meta_key', true);
    ?>
    <label for="custom_meta_field">Custom Field:</label>
    <input type="text" id="custom_meta_field" name="custom_meta_field" value="<?php echo esc_attr($meta_value); ?>" />
    <?php
}

// Agregar el metabox
function add_custom_metabox() {
    add_meta_box(
        'custom-metabox',
        'Custom Metabox Title',
        'custom_metabox_callback',
        'post', // Tipo de pantalla donde mostrar el metabox (puedes cambiarlo a 'page' u otros según tus necesidades)
        'normal', // Posición del metabox (normal, side, advanced)
        'default' // Prioridad del metabox
    );
}
add_action('add_meta_boxes', 'add_custom_metabox');

// Guardar los datos del metabox
function save_custom_metabox_data($post_id) {
    // Verificar permisos del usuario y campos nonce
    if (!current_user_can('edit_post', $post_id) || !isset($_POST['custom_metabox_nonce'])) {
        return;
    }

    // Sanitizar y guardar los datos del metabox
    $meta_value = isset($_POST['custom_meta_field']) ? sanitize_text_field($_POST['custom_meta_field']) : '';
    update_post_meta($post_id, '_custom_meta_key', $meta_value);
}
add_action('save_post', 'save_custom_metabox_data');


?>
