<?php

if(!function_exists('gev_formacion_posts_func')){

    // Enqueue Styles
    if(!function_exists('gev_form_assets')){
        function gev_form_assets(){
            wp_enqueue_style( 'gev-form-css', get_stylesheet_directory_uri() . '/assets/css/gev-form.css');
            wp_enqueue_script( 'gev-form-js', get_stylesheet_directory_uri() . '/assets/js/gev-form.js', array('jquery'), '1.0');
        }

        add_action( 'wp_enqueue_scripts', 'gev_form_assets');
    }

    // Shortcode formacion
    add_shortcode('gev_formacion_posts', 'gev_formacion_posts_func');
    function gev_formacion_posts_func(){

        function args_query($category){
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'category_name' => $category
            );

            return $args;
        }

        $query_podcast = new WP_Query(args_query('podcast'));
        $query_videos = new WP_Query(args_query('videos'));
        $query_presentaciones = new WP_Query(args_query('presentaciones'));

        ob_start();
        ?>

        <!-- LOOP PODCAST -->
        <?php if($query_podcast->have_posts()): ?>
            <div class="gev-form-cont gev-form-cont__podcast" id="gev-podcasts">
                <div class="gev-form-cont__heading">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/iconos_formacion_icon_74_videos.svg" alt="" class="gev-form-cont__heading__icon">
                    <h2 class="gev-form-cont__heading__title">Podcast</h2>
                </div>

                <div class="gev-form-cont__articles">
                    <?php while($query_podcast->have_posts()): $query_podcast->the_post();?>
                        <article class="gev-form-cont__article">
                            <?php the_content(); ?>
                        </article>
                    <?php endwhile; ?>
                </div>

                <a href="#" class="gev-form-cont__articles__showMore" data-items="gev-podcasts">
                    <span class="gev-form-cont__articles__showMore__text">Ver más</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
        <?php endif; wp_reset_query();?>

        <!-- LOOP VIDEOS -->
        <?php if($query_videos->have_posts()): ?>
            <div class="gev-form-cont gev-form-cont__video"  id="gev-videos">
                <!-- MODAL WINDOW -->
                <div class="gev-modal-video">
                    <div class="gev-modal-video__wrapper">
                        <h4 class="gev-modal-video__title">Lorem ipsum dolor sit amet.</h4>
                        <iframe width="1280" height="753" src="https://www.youtube.com/embed/S8QI1HXnhO4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="gev-form-cont__heading">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/iconos_formacion_icon_74_videos.svg" alt="" class="gev-form-cont__heading__icon">
                    <h2 class="gev-form-cont__heading__title">Videos</h2>
                </div>

                <div class="gev-form-cont__articles">
                    <?php while($query_videos->have_posts()): $query_videos->the_post();?>
                        <article class="gev-form-cont__article">
                            <figure class="gev-form-cont__video__fig">
                                <?php if(get_the_post_thumbnail()): ?>
                                    <?php the_post_thumbnail( 'full', array('class' => 'gev-form-cont__video__cover') ); ?>
                                <?php else: ?>
                                    <img class="gev-form-cont__video__cover" src="https://via.placeholder.com/1920x1080" alt="">
                                <?php endif; ?>
                                <figcaption class="gev-form-cont__video__cap" data-title="<?php the_title(); ?>">
                                    <?php the_content(); ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/icon-play-form.svg" alt="" class="gev-form-cont__video__play">
                                </figcaption>
                            </figure>
                            <h4 class="gev-form-cont__article__title">
                                <?php the_title(); ?>
                            </h4>
                        </article>
                    <?php endwhile; ?>
                </div>

                <a href="#" class="gev-form-cont__articles__showMore" data-items="gev-videos">
                    <span class="gev-form-cont__articles__showMore__text">Ver más</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
        <?php endif; wp_reset_query();?>

        <!-- LOOP PRESENTACIONES -->
        <?php if($query_presentaciones->have_posts()): ?>
            <div class="gev-form-cont gev-form-cont__presentation"  id="gev-presentations">
                <div class="gev-form-cont__heading">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/iconos_formacion_icon_75_presentaciones.svg" alt="" class="gev-form-cont__heading__icon">
                    <h2 class="gev-form-cont__heading__title">Presentaciones</h2>
                </div>

                <div class="gev-form-cont__articles">
                    <?php while($query_presentaciones->have_posts()): $query_presentaciones->the_post()?>
                        
                        <article class="gev-form-cont__article">
                            <figure class="gev-form-cont__presentation__fig">
                                <?php if(get_the_post_thumbnail()): ?>
                                    <?php the_post_thumbnail( 'full', array('class' => 'gev-form-cont__presentation__cover') ); ?>
                                <?php else: ?>
                                    <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                                <?php endif; ?>

                                <a href="<?php the_field('documento') ?>" download class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                                    <button type="button" class="gev-form-cont__presentation__btnDownload">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                </a>
                            </figure>
                            <h4 class="gev-form-cont__article__title">
                                <?php the_title(); ?>
                            </h4>
                        </article>
                    <?php endwhile; ?>
                </div>

                <a href="#" class="gev-form-cont__articles__showMore" data-items="gev-presentations">
                    <span class="gev-form-cont__articles__showMore__text">Ver más</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
            </div>
        <?php endif; ?>

        <?php
        return ob_get_clean();
    }
}