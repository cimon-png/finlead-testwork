<?php

get_header();

$cities = get_posts(array('post_type' => 'cities', 'numberposts' => -1));

function get_types_options() {
    
    $types = get_terms(array(
        'taxonomy' => 'immovable_type',  // Таксономия
        'hide_empty' =>  true,   // Показывать все термины, даже если нет записей
    ));

    if (!empty($types) && !is_wp_error($types)) {
        foreach ($types as $type) {
            echo '<option value="' . $type->term_id . '">' . $type->name . '</option>';
        }
    }
}
?>

<div class="container">
    <div class="row pt-5">
        <!-- Сайдбар с городами -->
        <div class="col-md-3">
            <h2>Города</h2>
            <ul class="list-group">
                <?php foreach ($cities as $city): ?>
                    <li class="list-group-item">
                        <a href="<?php echo get_permalink($city->ID); ?>" class="btn btn-primary">
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url($city->ID)); ?>" alt="<?php echo esc_attr($city->post_title); ?>" class="img-fluid" />
                            <div>
                                <h4><?php echo esc_html($city->post_title); ?></h4>
                                
                            </div> 
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- Основной контент с недвижимостью -->
        <div class="col-md-9">
            <h2>Вся недвижимость</h2>
            <div class="row card-row">
                <?php
                $immovables = get_posts(array('post_type' => 'immovables', 'numberposts' => -1));
                foreach ($immovables as $immovable): ?>
                    <div class="col-md-4 mb-4 col-sm-12 d-flex align-items-stretch">
                        <div class="card h-100 w-100">
                            <?php if (has_post_thumbnail($immovable->ID)) { ?>
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url($immovable->ID)); ?>" class="card-img-top" style="height:150px;" alt="<?php the_title(); ?>">
                            <?php } else {
                                
                                echo '<img src="' . get_stylesheet_directory_uri()  . '/images/default-image.png"  class="card-img-top" style="height:150px;" alt="Резервное изображение">';
                            } ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo esc_html($immovable->post_title); ?></h5>
                                <p class="card-text">
                                    Цена: <?php echo esc_html(get_field('price', $immovable->ID)); ?><br>
                                    Адрес: <?php echo esc_html(get_field('address', $immovable->ID)); ?><br>
                                    Площадь: <?php echo esc_html(get_field('square', $immovable->ID)); ?> м²
                                </p>
                                
                                <a href="<?php echo get_permalink($immovable->ID); ?>" class="btn mt-auto btn-primary">Подробнее</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <h2 class="text-center pt-5">Добавление недвижимости</h2>
    
    <div class="row">
        <form id="immovables-form" class="d-flex flex-column m-auto">
            
            <input type="text" class="p-2 m-2" id="title" name="title" placeholder="Заголовок" required>
            <input type="text" class="p-2 m-2"id="price" name="price" placeholder="Цена"required>
            <input type="text" class="p-2 m-2"id="address" name="address" placeholder="Адрес"required>
            <input type="text" class="p-2 m-2"id="square" name="square" placeholder="Площадь"required> 
            <input type="text" class="p-2 m-2"id="live-square" name="live-square" placeholder="Жилая площадь"required>
            <input type="text" class="p-2 m-2"id="floor" name="square" placeholder="Этаж"required>
            <select id="city_id" class="p-2 m-2"name="city_id"required>
                <option value="">Выберите город</option>
                <?php
                foreach ($cities as $city) {
                    echo '<option value="' . $city->ID . '">' . $city->post_title . '</option>';
                }
                ?>
            </select>
            <select class="p-2 m-2" id="type"required>
                <option value="">Выберите тип недвижимости</option>
                <?php
                    get_types_options();
                ?>
            </select>
            <input type="hidden" id="nonce" value="<?php echo wp_create_nonce('add_immovable_nonce'); ?>">
            <button class="btn btn-primary p-2 m-2" type="submit">Добавить недвижимость</button>
            <div id="form-response"></div>
        </form>
        
    </div>
</div>

<?php
get_footer();