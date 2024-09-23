<?php

class ThemeAssets{

    public function __construct(){
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
    }

    public function enqueue_styles() {
        wp_enqueue_style('understrap-parent-style', get_template_directory_uri() . '/style.css'); //стили родительской темы

        wp_enqueue_style('understrap-child-style', get_stylesheet_directory_uri() . '/style.css', array('understrap-parent-style')); //стили дочерней темы

        wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    }

}

$themeAssets = new ThemeAssets();


class CustomImmovablesPostType{

    public function __construct(){

        add_action('init', array($this, 'registerImmovablesPost'));
        add_action('init', array($this, 'registerImmovablesTypeTaxonomy'));
        
    }

    //Кастомный тип поста Immovables
    public function registerImmovablesPost(){

        $labels = array(
            'name' => 'Недвижимость',
            'singular_name' => 'Недвижимость',
            'menu_name' => 'Недвижимость',
            'name_admin_bar' => 'Недвижимость',
            'add_new' => 'Добавить новую',
            'add_new_item' => 'Добавить новую недвижимость',
            'new_item' => 'Новая недвижимость',
            'edit_item' => 'Редактировать недвижимость',
            'view_item' => 'Просмотр недвижимости',
            'all_items' => 'Вся недвижимость',
            'search_items' => 'Поиск по недвижимости',
            'not_found' => 'Недвижимость не найдена',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-location-alt',
            'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
            'show_in_rest' => true,
        );

        register_post_type('immovables', $args);

    }

    //Кастомная таксономия immovable_type
    public function registerImmovablesTypeTaxonomy(){

        $labels = array(
            'name'              => __('Тип недвижимости'),
            'singular_name'     => __('Тип недвижимости'),
            'search_items'      => __('Поиск типа недвижимости'),
            'all_items'         => __('Все типы недвижимости'),
            'parent_item'       => __('Родительский тип недвижимости'),
            'parent_item_colon' => __('Родительский тип недвижимости'),
            'edit_item'         => __('Редактировать тип недвижимости'),
            'update_item'       => __('Обновить тип недвижимости'),
            'add_new_item'      => __('Добавить новый тип недвижимости'),
            'new_item_name'     => __('Новый тип недвижимости'),
            'menu_name'         => __('Тип недвижимости'),
        );

        $args = array(
            'labels' =>  $labels,
            'hierarchical' => true, 
            'show_ui'      => true, 
            'show_in_menu' => true, 
            'show_in_rest' => true, 
            'rewrite'      => array('slug' => 'immovable_type'),
        );

        register_taxonomy('immovable_type','immovables', $args);

    }

   

}

$customImmovablesPostType = new CustomImmovablesPostType();


class CustomCitiesPostType{

    public function __construct(){
        add_action('init', array($this, 'registerSitiesPost'));
    }

    //Кастомный тип поста sities
    public function registerSitiesPost(){

        $labels = array(
            'name' => 'Города',
            'singular_name' => 'Город',
            'menu_name' => 'Города',
            'name_admin_bar' => 'Города',
            'add_new' => 'Добавить новый',
            'add_new_item' => 'Добавить новый город',
            'new_item' => 'Новый город',
            'edit_item' => 'Редактировать город',
            'view_item' => 'Просмотр города',
            'all_items' => 'Все города',
            'search_items' => 'Поиск по городам',
            'not_found' => 'Город не найден',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-location-alt',
            'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
            'show_in_rest' => true,
        );

        register_post_type('cities', $args);
    }

}

$customCities = new CustomCitiesPostType();



//Связь недвижимости с городом через метабоксы
class MetaBoxLink {
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'city_meta_box'));
        add_action('add_meta_boxes', array($this, 'city_meta_box_info'));
        add_action('save_post', array($this, 'save_city_meta'));
        add_action('save_post', array($this, 'save_city_info'));
    }

    

    public function city_meta_box() {
        add_meta_box('city_select', 'Выбор города', array($this, 'city_meta_box_callback'), 'immovables');
    }

    public function city_meta_box_callback($post) {
        $cities = get_posts(array('post_type' => 'cities', 'numberposts' => -1));
        $selected_city = get_post_meta($post->ID, '_city_id', true);

        echo '<select name="city_id">';
        foreach ($cities as $city) {
            $selected = ($selected_city == $city->ID) ? 'selected' : '';
            echo '<option value="' . $city->ID . '" ' . $selected . '>' . $city->post_title . '</option>';
        }
        echo '</select>';
    }

    public function city_meta_box_info() {
        add_meta_box('city_info', 'Информация о городе', array($this, 'city_info_callback'), 'cities');
    }

    public function city_info_callback($post) {
        $city_description = get_post_meta($post->ID, '_city_description', true);
        $city_image = get_post_meta($post->ID, '_city_image', true);

        echo '<label for="city_description">Описание</label><br><br>';
        echo '<textarea style="width:100%;" id="city_description" name="city_description">' . esc_textarea($city_description) . '</textarea><br><br>';
    }

    public function save_city_meta($post_id) {
        if (isset($_POST['city_id'])) {
            update_post_meta($post_id, '_city_id', $_POST['city_id']);
        }
    }

    public function save_city_info($post_id) {
        if (isset($_POST['city_description'])) {
            update_post_meta($post_id, '_city_description', sanitize_textarea_field($_POST['city_description']));
        }
        if (isset($_POST['city_image'])) {
            update_post_meta($post_id, '_city_image', sanitize_text_field($_POST['city_image']));
        }
    }
}

$metaBoxLink = new MetaBoxLink();

?>