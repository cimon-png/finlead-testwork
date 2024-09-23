<?php
// Template Name: Шаблон городда
// Template Post Type: cities

get_header(); 
// Информация о городе
$city_description = get_post_meta(get_the_ID(), '_city_description', true);
$city_image = get_post_meta(get_the_ID(), '_city_image', true);
?>

<div class="container">
    <div class="row pt-5">
        <div class="col-md-6">
            <?php echo '<img src="' . esc_url(get_the_post_thumbnail_url()) . '" alt="' . esc_attr(get_the_title()) . '" class="img-cities">'; ?>
        </div>
        <div class="col-md-6">
        <?php

            ?>
            <h1><?php the_title(); ?></h1>
            <?php
            

            if ($city_description) {
                echo '<p>' . esc_html($city_description) . '</p>';
            }?>
        </div>
    </div>
    
    <?php
    $immovables = new WP_Query(array(
        'post_type' => 'immovables',
        'posts_per_page' => 10,
        'meta_query' => array(
            array(
                'key' => '_city_id',
                'value' => get_the_ID(),
                'compare' => '='
            )
        )
    ));

    if ($immovables->have_posts()): ?>
        <h2 class="pt-5">Недвижимость в этом городе</h2>
        <div class="row">
            <?php while ($immovables->have_posts()): $immovables->the_post(); ?>
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="card h-100 w-100">
                        <?php if (has_post_thumbnail()) { ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" class="card-img-top" style="height:150px;" alt="<?php the_title(); ?>">
                        <?php } else {
                            
                            echo '<img src="' . get_stylesheet_directory_uri()  . '/images/default-image.png" style="height:150px;" alt="Резервное изображение">';
                        } ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p class="card-text">
                                Цена: <?php echo esc_html(get_field('price')); ?><br>
                                Адрес: <?php echo esc_html(get_field('address')); ?><br>
                                Площадь: <?php echo esc_html(get_field('square')); ?> м²
                            </p>
                            <a href="<?php the_permalink(); ?>" class="btn mt-auto btn-primary">Смотреть детали</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    else:
        echo '<p>Недвижимость в этом городе не найдена.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>