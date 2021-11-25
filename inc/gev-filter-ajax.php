<?php

// Include scripts and styles
if(!function_exists('gev_insert_script')){
    add_action( 'wp_enqueue_scripts', 'gev_insert_script' );
    function gev_insert_script(){
        // Chart js
        wp_enqueue_script( 'gev_chart_js', 'https://cdn.jsdelivr.net/npm/chart.js', array());

        // Google Chart
        wp_enqueue_script( 'gev_gchart_js', 'https://www.gstatic.com/charts/loader.js', array());

        // if(!is_home()) return;
        wp_enqueue_style( 'gev_charts_css', get_stylesheet_directory_uri() . '/assets/css/gev-charts.css');
        wp_register_script('gev_charts_js', get_stylesheet_directory_uri() . '/assets/js/gev-charts.js', array('jquery'), '1.0', true);
        wp_enqueue_script( 'gev_jspdf_js', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js', array('jquery'), '1.3.3');
        wp_enqueue_script('gev_charts_js');
        wp_localize_script( 'gev_charts_js', 'gev_vars', ['ajaxurl' => admin_url('admin-ajax.php'), 'childUrl' => get_stylesheet_directory_uri()] );
    }
}


// Function filter ajax content
if(!function_exists('gev_filter_test')){
    add_action( 'wp_ajax_nopriv_gev_ajax_filtercountry', 'gev_filter_test');
    add_action( 'wp_ajax_gev_ajax_filtercountry', 'gev_filter_test');

    function gev_filter_test(){
        $country = intval($_POST['countryId']);
        $sector = intval($_POST['sectorId']);
        $subsector = intval($_POST['subsectorId']);

        $tax_query = array('relation' => 'AND');

        /**
         * Conditional items for query
         */

        // Country
        if ($country){
            $tax_query[] =  array(
                    'taxonomy' => 'gev_country',
                    'field' => 'term_id',
                    'terms' => $country
            );
        }

        // Sector
        if ($sector){
            $tax_query[] =  array(
                    'taxonomy' => 'gev_sector',
                    'field' => 'term_id',
                    'terms' => $sector
                );
        }

        // Subsector
        if ($subsector){
            $tax_query[] =  array(
                    'taxonomy' => 'gev_subsector',
                    'field' => 'term_id',
                    'terms' => $subsector
                );
        }
        
        // Init array results
        $items_found = [];

        $args = array(
            'post_type' => 'gev_graphics',
            'posts_per_page' => -1,
            'tax_query' => $tax_query
        );

        // Get post from request
        $items = get_posts($args);

        // Colors default
        $colorsDefault = ['#22D0A4', '#246ED3', '#FAD441'];

        $arrTestTerms = [];

        foreach ($items as $item) {

            $arrTestTerms[] = $item->ID;
            // Array associtative
            $colors = get_field('colores', $item->ID);

            // Array only hex color
            $colorsN = [];

            foreach ($colors as $color) {
                if(strlen($color) > 0){
                    $colorsN[] = $color;
                }
            }

            $settings = [];

            if($colorsN){
                $settings = [
                    'type' => get_field('tipo_de_grafica', $item->ID),
                    'colors' => $colorsN
                ];
            } else {
                $settings = [
                    'type' => get_field('tipo_de_grafica', $item->ID),
                    'colors' => $colorsDefault
                ];
            }

            $items_found[] = [
                'title' => $item->post_title,
                'urlgs' => get_field('url_google_sheets', $item->ID),
                'itemId' => $item->ID,
                'termCountry' => get_the_terms($item->ID, 'gev_country'),
                'termSector' => get_the_terms($item->ID, 'gev_sector'),
                'termSubsector' => get_the_terms($item->ID, 'gev_subsector'),
                'sheet' => get_field('nombre_de_la_hoja', $item->ID),
                'termMes' => get_the_terms($item->ID, 'gev_mes'),
                'termAno' => get_the_terms($item->ID, 'gev_ano'),
                'settings' => $settings,
            ];
        }

        $my_terms_sector = wp_get_object_terms( $arrTestTerms, 'gev_sector' );
        $my_terms_subsector = wp_get_object_terms( $arrTestTerms, 'gev_subsector' );

        $result = [
            'response' => $items_found,
            'term_list_sector' => $my_terms_sector,
            'term_list_subsector' => $my_terms_subsector
        ];

        // Send data ajax
        wp_send_json($result);
        // echo json_encode($result);

        die();
    }
}
