<?php

// Include scripts and styles
if(!function_exists('gev_insert_script')){
    add_action( 'wp_enqueue_scripts', 'gev_insert_script' );
    function gev_insert_script(){
        // if(!is_home()) return;
        wp_enqueue_style( 'gev_charts_css', get_stylesheet_directory_uri() . '/assets/css/gev-charts.css');
        wp_register_script('gev_charts_js', get_stylesheet_directory_uri() . '/assets/js/gev-charts.js', array('jquery'), '1.0', true);
        wp_enqueue_script('gev_charts_js');
        wp_localize_script( 'gev_charts_js', 'gev_vars', ['ajaxurl' => admin_url('admin-ajax.php'), 'childUrl' => get_stylesheet_directory_uri()] );

    }
}


// Function filter ajax content
if(!function_exists('gev_filter_test')){
    add_action( 'wp_ajax_nopriv_gev_ajax_filtercountry', 'gev_filter_test');
    add_action( 'wp_ajax_gev_ajax_filtercountry', 'gev_filter_test');

    function gev_filter_test(){
        $country = $_POST['countryId'];
        $sector = $_POST['sectorId'];
        $subsector = $_POST['subsectorId'];
        $mes = $_POST['mesId'];
        $ano = $_POST['anoId'];

        $tax_query = array('relation' => 'AND');

        /**
         * Conditional items for query
         */

        // Sector
        if (strlen($sector) > 1){
            $tax_query[] =  array(
                    'taxonomy' => 'gev_sector',
                    'field' => 'term_id',
                    'terms' => $sector
                );
        }

        // Country
        if (strlen($country) > 1){
            $tax_query[] =  array(
                    'taxonomy' => 'gev_country',
                    'field' => 'term_id',
                    'terms' => $country
                );
        }

        // Subsector
        if (strlen($subsector) > 1){
            $tax_query[] =  array(
                    'taxonomy' => 'gev_subsector',
                    'field' => 'term_id',
                    'terms' => $subsector
                );
        }

        // Mes
        if (strlen($mes) > 1){
            $tax_query[] =  array(
                    'taxonomy' => 'gev_mes',
                    'field' => 'term_id',
                    'terms' => $mes
                );
        }

        // Año
        if (strlen($ano) > 1){
            $tax_query[] =  array(
                    'taxonomy' => 'gev_ano',
                    'field' => 'term_id',
                    'terms' => $ano
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

        foreach ($items as $item) {
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
                'settings' => [
                    'type' => get_field('tipo_de_grafica', $item->ID),
                    'colors' => ["rgb(34, 208, 164)", "rgb(36, 110, 211)", "rgb(34, 208, 164)", "rgb(255, 87, 51)", "rgb(255, 87, 51)"]
                ]
            ];
        }

        // Send data ajax
        wp_send_json($items_found);

        die();
    }
}
