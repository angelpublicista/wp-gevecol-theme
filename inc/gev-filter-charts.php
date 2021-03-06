<?php

if(!function_exists('grid_gev_charts_func')){
    add_shortcode( 'grid_gev_charts', 'grid_gev_charts_func' );
    function grid_gev_charts_func(){

		echo '<form class="gev-filters-bar" id="gev-filters-bar">';

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
		echo '<select name="sectorFilter" class="gev-disabled" id="sectorFilter" disabled><option value="" selected disabled>Sector</option>';
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
		echo '<select name="subsectorFilter" id="subsectorFilter" disabled><option value="" disabled selected>Subsector</option>';
		echo '</select>';
		echo '</div>';
		endif;

		echo '</div>'; //End gev-container

		echo '</form>'; //End gev-filters-bar

		ob_start();
		?>

		<div class="gev-container" id="gev-cont-graphics">
			<div class="gev-loader">
				<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/spin-1s-200px.gif" alt="">
			</div>
			<div class="gev-charts-section" id="gev-charts-section">
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

								// Array associtative
								$colors = get_field('colores');

								// Array only hex color
								$colorsN = [];

								// Colors default
								$colorsDefault = ['#246ED3', '#27ABEF', '#22D0A4', '#00E8B1', '#FAD441', '#868B8D', '#FF9F40', '#002F8D', '#0489B4', '#17B4B7', '#8DF4DC', '#DAF4F7', '#CFD1D2', '#CFD1D2'];

								foreach ($colors as $color) {
									if(strlen($color) > 0){
										$colorsN[] = $color;
									}
								}

								if($colorsN){
									$settings = [
										'type' => get_field('tipo_de_grafica'),
										'colors' => $colorsN
									];
								} else {
									$settings = [
										'type' => get_field('tipo_de_grafica'),
										'colors' => $colorsDefault
									];
								}
								

								$jsonSettings = json_encode($settings);

								
							?>
							<div class="gev-col" style="margin-top: 80px;">
								<div class="gev-row gev-meta-chart">
									<div class="gev-col">
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
									</div>

									<div class="gev-col">
										<?php $meta =  $paises . " / " . $sectores . " / " . $subsectores; ?>
										<a href="#" class="gev-download-report gev-single-report" data-report="chart-<?php echo $post_id ?>" data-name="<?php the_title(); ?> " data-meta="<?php echo $meta?>">
											<span class="gev-download-report__text">Descargar gráfica</span>
											<i class="fas fa-arrow-down"></i>
										</a>
									</div>
								</div>
								<div class="gev-chart-container">
									<canvas 
										class="gev-charts" 
										id="chart-<?php echo $post_id ?>" 
										data-url="<?php the_field('url_google_sheets'); ?>"
										data-sheet="<?php the_field('nombre_de_la_hoja'); ?>"
										data-settings= '<?php echo $jsonSettings; ?>'
									></canvas>
								</div>
								<hr style="margin: 30px 0">
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