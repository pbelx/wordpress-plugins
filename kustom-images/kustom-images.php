<?php
/*
Plugin Name: Kustom Images  Below Posts
Description: Display different images below posts by category, set via plugin settings.
Version: 1.3
Author: bxmedia
*/

add_action('admin_menu', 'cci_add_admin_menu');
add_action('admin_init', 'cci_settings_init');

function cci_add_admin_menu() {
    add_options_page(
        'Category Images',
        'Category Images',
        'manage_options',
        'custom_category_images',
        'cci_options_page'
    );
}

function cci_settings_init() {
    register_setting('cciSettings', 'cci_category_images');

    add_settings_section(
        'cci_section',
        __('Assign images to categories:', 'cci'),
        null,
        'cciSettings'
    );

    $categories = get_categories(array('hide_empty' => false));
    foreach ($categories as $cat) {
        add_settings_field(
            'cci_' . $cat->slug,
            $cat->name,
            'cci_image_field_render',
            'cciSettings',
            'cci_section',
            ['slug' => $cat->slug]
        );
    }
}

function cci_image_field_render($args) {
    $options = get_option('cci_category_images');
    $slug = $args['slug'];
    $value = $options[$slug] ?? '';
    ?>
    <input type="text" name="cci_category_images[<?php echo esc_attr($slug); ?>]" id="cci_<?php echo esc_attr($slug); ?>" value="<?php echo esc_url($value); ?>" style="width:60%" />
    <button class="button cci-upload-button" data-target="cci_<?php echo esc_attr($slug); ?>">Select Image</button>
    <?php
}

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_media();
    wp_enqueue_script('cci-admin', plugin_dir_url(__FILE__) . 'admin.js', ['jquery'], null, true);
});

function cci_options_page() {
    ?>
    <div class="wrap">
        <h1>Custom Category Images</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('cciSettings');
            do_settings_sections('cciSettings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Frontend content filter
add_filter('the_content', function ($content) {
    if (!is_single()) return $content;

    $category_images = get_option('cci_category_images');
    if (!$category_images) return $content;

    foreach ($category_images as $slug => $image_url) {
        if (has_category($slug)) {
            $image_html = '<div class="custom-category-image" style="margin-top:20px;"><img src="' . esc_url($image_url) . '" alt="' . esc_attr($slug) . ' image"></div>';
            return $content . $image_html;
        }
    }
    return $content;
});
