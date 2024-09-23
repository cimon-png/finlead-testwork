<?php
/*
Plugin Name: ajax form plugin
Description: Форма добавления недвижимости с использованием AJAX
Version: 1.0
Author: Cimon4c
*/




// wp_localize_script('real-estate-ajax', 'ajaxurl', array('url' => admin_url('admin-ajax.php')));
// wp_localize_script('my-script-handle', 'ajaxurl', admin_url('admin-ajax.php'));
class PluginAssets{
    public function __construct(){
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts(){
        wp_enqueue_script('ajax-form', plugin_dir_url(__FILE__) . 'js/ajax-form.js', array('jquery'), null, true);
        
        wp_localize_script('ajax-form', 'ajaxurl', array(
            'url' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('add_immovable_nonce')
        ));
    }
}

new PluginAssets();

class AddImmovablesAjax{

    public function __construct(){
        add_action('wp_ajax_add_real_estate', [$this,'add_real_estate']);
        add_action('wp_ajax_nopriv_add_real_estate', [$this,'add_real_estate']);
    }

    public function add_real_estate(){
        // Проверка nonce
        check_ajax_referer('add_immovable_nonce', 'nonce');

        // Получаем данные из POST-запроса
        $title = sanitize_text_field($_POST['title']);
        $price = sanitize_text_field($_POST['price']);
        $address = sanitize_text_field($_POST['address']);
        $square = sanitize_text_field($_POST['square']);
        $floor = sanitize_text_field($_POST['floor']);
        $liveSquare = sanitize_text_field($_POST['live_square']);
        $city_id = intval($_POST['city']);
        $type_id = intval($_POST['type']);

        // Вставка нового поста
        $new_post_id = wp_insert_post(array(
            'post_title' => $title,
            'post_type' => 'immovables',
            'post_status' => 'publish'
        ));

        // Проверка на наличие ошибок при добавлении поста
        if (is_wp_error($new_post_id)) {
            error_log('Ошибка при добавлении поста: ' . $new_post_id->get_error_message());
            wp_send_json_error(array('message' => 'Ошибка при добавлении недвижимости.'));
        }

        // Сохраняем мета-данные
        if ($new_post_id) {
            update_post_meta($new_post_id, '_city_id', $city_id);
            update_post_meta($new_post_id, 'price', sanitize_text_field($_POST['price']));
            update_post_meta($new_post_id, 'address', sanitize_text_field($_POST['address']));
            update_post_meta($new_post_id, 'square', sanitize_text_field($_POST['square']));
            update_post_meta($new_post_id, 'live-square', sanitize_text_field($_POST['live_square']));
            update_post_meta($new_post_id, 'floor', sanitize_text_field($_POST['floor']));
            if ($type_id) {
                wp_set_post_terms($new_post_id, [$type_id], 'immovable_type');
            }

            $post_url = get_permalink($new_post_id);

            
            
            // Возвращаем данные нового поста
            wp_send_json_success(array(
                'message' => 'Недвижимость добавлена.',
                'title' => sanitize_text_field($_POST['title']),
                'price' => sanitize_text_field($_POST['price']),
                'address' => sanitize_text_field($_POST['address']),
                'square' => sanitize_text_field($_POST['square']),
                'url' => $post_url 
            ));
        } else {
            wp_send_json_error(array('message' => 'Ошибка при добавлении недвижимости.'));
        }
    }

}

$addImmovablesAjax = new AddImmovablesAjax();