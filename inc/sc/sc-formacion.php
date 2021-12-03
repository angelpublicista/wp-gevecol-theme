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
        ob_start();
        ?>
        <div class="gev-form-cont gev-form-cont__podcast" id="gev-podcasts">
            <div class="gev-form-cont__heading">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/iconos_formacion_icon_74_videos.svg" alt="" class="gev-form-cont__heading__icon">
                <h2 class="gev-form-cont__heading__title">Podcast</h2>
            </div>

            <div class="gev-form-cont__articles">
                <article class="gev-form-cont__article">
                    <iframe id='audio_79072421' frameborder='0' allowfullscreen='' scrolling='no' height='200' style='border:1px solid #EEE; box-sizing:border-box; width:100%;' src="https://www.ivoox.com/player_ej_79072421_4_1.html?c1=ff6600"></iframe>
                </article>
                <article class="gev-form-cont__article">
                    <iframe id='audio_79072421' frameborder='0' allowfullscreen='' scrolling='no' height='200' style='border:1px solid #EEE; box-sizing:border-box; width:100%;' src="https://www.ivoox.com/player_ej_79072421_4_1.html?c1=ff6600"></iframe>
                </article>

                <article class="gev-form-cont__article">
                    <iframe id='audio_79072421' frameborder='0' allowfullscreen='' scrolling='no' height='200' style='border:1px solid #EEE; box-sizing:border-box; width:100%;' src="https://www.ivoox.com/player_ej_79072421_4_1.html?c1=ff6600"></iframe>
                </article>

                <article class="gev-form-cont__article">
                    <iframe id='audio_79072421' frameborder='0' allowfullscreen='' scrolling='no' height='200' style='border:1px solid #EEE; box-sizing:border-box; width:100%;' src="https://www.ivoox.com/player_ej_79072421_4_1.html?c1=ff6600"></iframe>
                </article>

                <article class="gev-form-cont__article">
                    <iframe id='audio_79072421' frameborder='0' allowfullscreen='' scrolling='no' height='200' style='border:1px solid #EEE; box-sizing:border-box; width:100%;' src="https://www.ivoox.com/player_ej_79072421_4_1.html?c1=ff6600"></iframe>
                </article>

                <article class="gev-form-cont__article">
                    <iframe id='audio_79072421' frameborder='0' allowfullscreen='' scrolling='no' height='200' style='border:1px solid #EEE; box-sizing:border-box; width:100%;' src="https://www.ivoox.com/player_ej_79072421_4_1.html?c1=ff6600"></iframe>
                </article>

                <article class="gev-form-cont__article">
                    <iframe id='audio_79072421' frameborder='0' allowfullscreen='' scrolling='no' height='200' style='border:1px solid #EEE; box-sizing:border-box; width:100%;' src="https://www.ivoox.com/player_ej_79072421_4_1.html?c1=ff6600"></iframe>
                </article>

                <article class="gev-form-cont__article">
                    <iframe id='audio_79072421' frameborder='0' allowfullscreen='' scrolling='no' height='200' style='border:1px solid #EEE; box-sizing:border-box; width:100%;' src="https://www.ivoox.com/player_ej_79072421_4_1.html?c1=ff6600"></iframe>
                </article>
            </div>

            <a href="#" class="gev-form-cont__articles__showMore" data-items="gev-podcasts">
                <span class="gev-form-cont__articles__showMore__text">Ver más</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>


        <div class="gev-form-cont gev-form-cont__video"  id="gev-videos">
            <div class="gev-form-cont__heading">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/iconos_formacion_icon_74_videos.svg" alt="" class="gev-form-cont__heading__icon">
                <h2 class="gev-form-cont__heading__title">Videos</h2>
            </div>

            <div class="gev-form-cont__articles">
                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__video__fig">
                        <img class="gev-form-cont__video__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <figcaption class="gev-form-cont__video__cap">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/icon-play-form.svg" alt="" class="gev-form-cont__video__play">
                        </figcaption>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__video__fig">
                        <img class="gev-form-cont__video__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <figcaption class="gev-form-cont__video__cap">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/icon-play-form.svg" alt="" class="gev-form-cont__video__play">
                        </figcaption>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__video__fig">
                        <img class="gev-form-cont__video__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <figcaption class="gev-form-cont__video__cap">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/icon-play-form.svg" alt="" class="gev-form-cont__video__play">
                        </figcaption>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__video__fig">
                        <img class="gev-form-cont__video__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <figcaption class="gev-form-cont__video__cap">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/icon-play-form.svg" alt="" class="gev-form-cont__video__play">
                        </figcaption>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>
            </div>

            <a href="#" class="gev-form-cont__articles__showMore" data-items="gev-videos">
                <span class="gev-form-cont__articles__showMore__text">Ver más</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>

        <div class="gev-form-cont gev-form-cont__presentation"  id="gev-presentations">
            <div class="gev-form-cont__heading">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/formacion/iconos_formacion_icon_75_presentaciones.svg" alt="" class="gev-form-cont__heading__icon">
                <h2 class="gev-form-cont__heading__title">Presentaciones</h2>
            </div>

            <div class="gev-form-cont__articles">
                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>

                <article class="gev-form-cont__article">
                    <figure class="gev-form-cont__presentation__fig">
                        <img class="gev-form-cont__presentation__cover" src="https://via.placeholder.com/1920x1080" alt="">
                        <a href="#" class="gev-form-cont__presentation__cap gev-form-cont__presentation__download">
                            <button href="#" class="gev-form-cont__presentation__btnDownload">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </a>
                    </figure>
                    <h4 class="gev-form-cont__article__title">
                        Lorem ipsum dolor sit amet.
                    </h4>
                </article>
            </div>

            <a href="#" class="gev-form-cont__articles__showMore" data-items="gev-presentations">
                <span class="gev-form-cont__articles__showMore__text">Ver más</span>
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>

        <?php
        return ob_get_clean();
    }
}