<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'gev_insert_script' );

function gev_insert_script(){
	// if(!is_home()) return;
	wp_enqueue_style( 'gev_charts_css', get_stylesheet_directory_uri() . '/assets/css/gev-charts.css');
	wp_register_script('gev_charts_js', get_stylesheet_directory_uri() . '/assets/js/gev-charts.js', array('jquery'), '1.0', true);
	wp_enqueue_script('gev_charts_js');
	wp_localize_script( 'gev_charts_js', 'gev_vars', ['ajaxurl' => admin_url('admin-ajax.php'), 'childUrl' => get_stylesheet_directory_uri()] );

}


if(!function_exists('grid_gev_charts_func')){
    add_shortcode( 'grid_gev_charts', 'grid_gev_charts_func' );
    function grid_gev_charts_func(){

		echo '<div class="gev-filters-bar">';

		echo '<div class="gev-container gev-wrap-filters">';
		if($terms = get_terms(
			array(
				'taxonomy' => 'gev_country',
				'orderby' => 'name'
			)
		)):
		
		echo '<div class="gev-select-wrap">';
		echo '<div class="gev-arrow-cont"><img src="'.get_stylesheet_directory_uri().'/assets/img/arrow-down-select.svg"></div>';
		echo '<select name="countryFilter" id="countryFilter"><option value="" selected disabled>País</option>';
		echo '<option value="">Todos los países</option>';
		foreach($terms as $term):
			echo '<option value="'.$term->term_id.'">' . $term->name . '</option>';
		endforeach;
		echo '</select>';
		echo '</div>';
		endif;

		if($terms = get_terms(
			array(
				'taxonomy' => 'gev_sector',
				'orderby' => 'name'
			)
		)):
		
		echo '<div class="gev-select-wrap">';
		echo '<div class="gev-arrow-cont"><img src="'.get_stylesheet_directory_uri().'/assets/img/arrow-down-select.svg"></div>';
		echo '<select name="sectorFilter" id="sectorFilter"><option value="" selected disabled>Sector</option>';
		echo '<option value="">Todos los sectores</option>';
		foreach($terms as $term):
			echo '<option value="'.$term->term_id.'">' . $term->name . '</option>';
		endforeach;
		echo '</select>';
		echo '</div>';
		endif;

		if($terms = get_terms(
			array(
				'taxonomy' => 'gev_subsector',
				'orderby' => 'name'
			)
		)):
		
		echo '<div class="gev-select-wrap">';
		echo '<div class="gev-arrow-cont"><img src="'.get_stylesheet_directory_uri().'/assets/img/arrow-down-select.svg"></div>';
		echo '<select name="subsectorFilter" id="subsectorFilter"><option value="" disabled selected>Subsector</option>';
		echo '<option value="">Todos los subsectores</option>';
		foreach($terms as $term):
			echo '<option value="'.$term->term_id.'">' . $term->name . '</option>';
		endforeach;
		echo '</select>';
		echo '</div>';
		endif;

		if($terms = get_terms(
			array(
				'taxonomy' => 'gev_mes',
				'orderby' => 'name'
			)
		)):
		
		echo '<div class="gev-select-wrap">';
		echo '<div class="gev-arrow-cont"><img src="'.get_stylesheet_directory_uri().'/assets/img/arrow-down-select.svg"></div>';
		echo '<select name="mesFilter" id="mesFilter"><option value="" selected disabled>Mes</option>';
		echo '<option value="">Todos los meses</option>';
		foreach($terms as $term):
			echo '<option value="'.$term->term_id.'">' . $term->name . '</option>';
		endforeach;
		echo '</select>';
		echo '</div>';
		endif;

		if($terms = get_terms(
			array(
				'taxonomy' => 'gev_ano',
				'orderby' => 'name'
			)
		)):
		
		echo '<div class="gev-select-wrap">';
		echo '<div class="gev-arrow-cont"><img src="'.get_stylesheet_directory_uri().'/assets/img/arrow-down-select.svg"></div>';
		echo '<select name="anoFilter" id="anoFilter"><option value="" selected disabled>Año</option>';
		echo '<option value="">Todos los años</option>';
		foreach($terms as $term):
			echo '<option value="'.$term->term_id.'">' . $term->name . '</option>';
		endforeach;
		echo '</select>';
		echo '</div>';
		endif;

		$button = '<button id="gev-btn-filter">';
		$button .= 'Filtrar';
		$button .= '</button>';
		
		echo $button;

		echo '</div>'; //End gev-container

		echo '</div>'; //End gev-filters-bar

		ob_start();
		?>

		<div class="gev-container" id="gev-cont-graphics">
			<div class="gev-loader">
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/spin-1s-200px.gif" alt="">
			</div>
			<div class="gev-row">
				<?php 
					$args = array(
						'post_type' => 'gev_graphics',
						'posts_per_page' => -1
					);


					$query = new WP_Query($args);

					function implItems($terms, $separator){
						$nameTerms = [];

						if($terms){
							foreach ($terms as $term) {
								array_push($nameTerms, $term->name);
							}
	
							$implArr = implode($separator , $nameTerms );
	
							return $implArr;
						}
						
					}

					if($query->have_posts()){
						while($query->have_posts()){
							$query->the_post();
							?>
							<?php 
						$post_id = get_the_ID(); 
			
						$paises = implItems(get_the_terms($post->ID, 'gev_country'), ',');
						$sectores = implItems(get_the_terms($post->ID, 'gev_sector'), ',');
						$subsectores = implItems(get_the_terms($post->ID, 'gev_subsector'), ',');
						$meses = implItems(get_the_terms($post->ID, 'gev_mes'), ' - ');
						$anos = implItems(get_the_terms($post->ID, 'gev_ano'), ' - ');

						?>
						<div class="gev-col" style="margin-top: 80px;">
							<div class="gev-tax-filters">

								<span class="gev-tax-name"><?php echo $paises ?></span>
								<span class="gev-tax-separator">/</span>
								<span class="gev-tax-name"><?php echo $sectores ?></span>
								<span class="gev-tax-separator">/</span>
								<span class="gev-tax-name"><?php echo $subsectores ?></span>
							</div>

							<div class="gev-tax-date">
								<span class="gev-tax-name"><?php echo $meses ?></span>
								<span class="gev-tax-separator">/</span>
								<span class="gev-tax-name"><?php echo $anos ?></span>
							</div>

							

							<h4 class="gev-chart-title"><?php the_title(); ?></h4>

							<canvas 
								class="gev-charts" 
								id="chart-<?php echo $post_id ?>" 
								data-url="<?php the_field('url_google_sheets'); ?>"
								data-settings= "{}"
							></canvas>
						</div>
							<?php
						}
					}

					wp_reset_query();
				?>
			</div>
		</div>
		<?php
		return ob_get_clean();
    }

}


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

	$items = get_posts($args);

	foreach ($items as $item) {
		$items_found[] = [
			'title' => $item->post_title,
			'urlgs' => get_field('url_google_sheets', $item->ID),
			'itemId' => $item->ID,
			'termCountry' => get_the_terms($item->ID, 'gev_country'),
			'termSector' => get_the_terms($item->ID, 'gev_sector'),
			'termSubsector' => get_the_terms($item->ID, 'gev_subsector'),
			'termMes' => get_the_terms($item->ID, 'gev_mes'),
			'termAno' => get_the_terms($item->ID, 'gev_ano')
		];
	}

	// Send data ajax
	wp_send_json($items_found);

	die();
}