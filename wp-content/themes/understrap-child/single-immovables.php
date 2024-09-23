<?php
// Template Name: Шаблон недвижимость
// Template Post Type: immovable

get_header();
?>



    <div class="immovable-content ">
        
        <div class="container mt-5">
        <div class="row">
            
            <div class="col-md-6 ">
            
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('full', ['class' => 'img-fluid rounded', 'alt' => get_the_title()]); ?>
                <?php else : ?>
                    <img src="<?php echo get_stylesheet_directory_uri()  ?>/images/default-image.png" alt="Нет изображения" class="img-fluid rounded">
                <?php endif; ?>
                
                
            </div>

            
            <div class="col-md-6">
                <h2><?php the_title();?></h2>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Тип</th>
                            <?php

                            $terms = get_the_terms($post, 'immovable_type');

                            if ($terms && !is_wp_error($terms)) {
                                foreach ($terms as $term) {
                                    echo '<td>' . esc_html($term->name) . '</td>'; 
                                }
                                
                            }
                            ?>
                            
                            
                        </tr>
                        <tr>
                            <th scope="row">Площадь объекта</th>
                            <td><?php the_field('square');?> м²</td>
                        </tr>
                        <tr>
                            <th scope="row">Жилая площадь</th>
                            <td><?php the_field('live-square');?> м²</td>
                        </tr>
                        <tr>
                            <th scope="row">Стоимость</th>
                            <td><?php the_field('price');?></td>
                        </tr>
                        <tr>
                            <th scope="row">Этаж</th>
                            <td><?php the_field('floor');?></td>
                        </tr>
                        <tr>
                            <th scope="row">Адрес</th>
                            <td><?php the_field('address');?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

<?php
get_footer();
?>