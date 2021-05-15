<?php

/*Company car drive*/
/*


	/**
	 * Post Type: loghi.
	 */




function slido_func( $atts ) {
	
//include "slido-featured-image.php";
//include "slido-style.php";	
	
include "slido-rai-template.php";
?> <style> <?php	
include "slido-rai-style.css";	
?> </style> <?php	
	
include "libreria.php";	
	


	
		$a = shortcode_atts( array(
			'colonne' => '3',
			'righe' => '1',
			'altezza' => '',
			'edizione' => '',
			'tipo' => 'archivio_news',
			'tassonomia' => 'special',
			'termine' => 'slido',
			
		), $atts );	
		$colonne = $a['colonne'];
		$righe = $a['righe'];
		$altezza = $a['altezza'];
		$edizione = $a['edizione'];
		$tipo = $a['tipo'];
		$tassonomia = $a['tassonomia'];
		$termine = $a['termine'];	
	
		$gruppo = 1;
		$post_corrente = 1;		
	
/***************************************************************************************/	
		ob_start();
/***************************************************************************************/
		//echo 'colonne = '.$colonne.', righe = '.$righe.', altezza = '.$altezza;
		//echo '<style> .slido-flex-box{height:'.$altezza.'} </style>';
		//echo '<style> .slido-flex-box img{height:'.$altezza.'} </style>';
		
		if ($colonne == 1) { echo '<style> .slido-flex-box{padding:5px; width:99%} </style>'; }
		if ($colonne == 2) { echo '<style> .slido-flex-box{padding:1%; width:48%} </style>'; }
		if ($colonne == 3) { echo '<style> .slido-flex-box{padding:1%; width:31%} </style>'; }	
		if ($colonne == 4) { echo '<style> .slido-flex-box{padding:0.5%; width:24%} </style>'; }
		if ($colonne == 5) { echo '<style> .slido-flex-box{padding:0.5%; width:19%} </style>'; }
		if ($colonne == 6) { echo '<style> .slido-flex-box{padding:0.3%; width:16%} </style>'; }		
	
			?>

		<div class="slido-body">
			
		<div class="slido-container">
		<?php			
		// The Query
			$query = new WP_Query(  array ( 
									'post_type' => $tipo, 
									'posts_per_page' => '-1',
									'orderby' => 'title', 
									'order' => 'ASC',
									'tax_query' => array(
										array(
											'taxonomy' => $tassonomia,
											'field' => 'slug',
											'terms' => $termine,
										)
									)
							) );
			// The Loop


			$posts_amount = $query->found_posts;
			$posts_for_screen = $colonne*$righe;		

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post(); 
						

						//modulo: se è uguale a uno è un multiplo del numero di elementi del gruppo
						if ($post_corrente % ($posts_for_screen) == 1){
							echo ' <div class="gruppo_' .$gruppo. ' slido-flex-container "> ';	
						}
							$fetched_
							slido_post_image();

						$post_corrente++;
						//nel caso si tratti dell'ultimo logo, ovvero post_corrente uguale a totale loghi	
						//non si aggiunge il div di chiusura del gruppo 
						if ($post_corrente % ($posts_for_screen) == 1 || $post_corrente > $posts_amount){
							echo '</div> <!-- gruppo'.$gruppo.' -->	';	
							$gruppo++;
						}							
				}

			} else {
				// no posts found
			}
			/* Restore original Post Data */
			wp_reset_postdata();	
		?>
	
		</div><!-- slido-container -->	
</div>
		<?php


	
/****************************************************************************/	
		$result = ob_get_contents(); // get everything in to $result variable
		ob_end_clean(); 
	
		return $result;

}
add_shortcode( 'slido', 'slido_func' );


add_action( 'generate_after_footer_widgets','lancia_slido' );   

function lancia_slido() {  
	
	/********************************
	slider inizio
	***********************************/
		?>
		<script>
		jQuery(document).ready(function(){
			jQuery('.slido-container').slick({
				pauseOnFocus: false,	
				slidesToShow: 1,
				slidesToScroll: 1,
				autoplay: true,
				autoplaySpeed: 3000,			
				infinite: true,
				arrows: false,
				dots: true,
				fade: false,
				speed: 600,

			});
		jQuery( ".slido-flex-box" ).show();	
		jQuery(".slido-flex-box").hover(function(){jQuery(".slido-title_2").css("opacity", "1");} , function(){jQuery(".slido-title_2").css("opacity", "0");});
		});
		</script> 	
		<?php
	/********************************
	slider FINE
	***********************************/		
}



