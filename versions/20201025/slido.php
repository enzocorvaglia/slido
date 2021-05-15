<?php

/*Company car drive*/
/*


	/**
	 * Post Type: loghi.
	 */




function slido_func( $atts ) {

?> <style> <?php	
include "slido-rai-style.css";	
?> </style> <?php	


	$a = shortcode_atts( array(
			'colonne' => '1',
			'righe' => '1',
			'altezza' => '',
			'edizione' => '',
			'tipo' => 'grid_slide', 
			'tassonomia' => 'fma_loghi_edizione',
			'termine' => '2020-03-milano',	
			'limite'  => 15,
			'image_size'  => 'thumbnail',	
			'object_fit' => 'contain'
			
		), $atts );	
		$colonne = $a['colonne'];
		$righe = $a['righe'];
		$altezza = $a['altezza'];
		$edizione = $a['edizione'];
		$tipo = $a['tipo'];
		$tassonomia = $a['tassonomia'];
		$termine = $a['termine'];	
		$limite = $a['limite'];
		$image_size = $a['image_size'];	
		$object_fit = $a['object_fit'];
	
		$gruppo = 1;
		$post_corrente = 1;		
	
/***************************************************************************************/	
		ob_start();
/***************************************************************************************/
		//echo 'colonne = '.$colonne.', righe = '.$righe.', altezza = '.$altezza;
		//echo '<style> .slido-flex-box{height:'.$altezza.'} </style>';
		//echo '<style> .slido-flex-box img{height:'.$altezza.'} </style>';
		echo '<style> .slido-flex-box img{object-fit:'.$object_fit.'} </style>';	
	
		if ($colonne == 1) { echo '<style> .slido-columns-1{padding:5px; width:99%} </style>'; }
		if ($colonne == 2) { echo '<style> .slido-columns-2{padding:1%; width:48%} </style>'; }
		if ($colonne == 3) { echo '<style> .slido-columns-3{padding:1%; width:31%} </style>'; }	
		if ($colonne == 4) { echo '<style> .slido-columns-4{padding:0.5%; width:24%} </style>'; }
		if ($colonne == 5) { echo '<style> .slido-columns-5{padding:0.5%; width:19%} </style>'; }
		if ($colonne == 6) { echo '<style> .slido-columns-6{padding:0.3%; width:16%} </style>'; }		
	
	
		// The Query
			$query = new WP_Query(  array ( 
									'post_type' => $tipo, 
									'posts_per_page' => '-1',
									'orderby' => 'title', 
									'order' => 'ASC',
									'posts_per_page' => $limite, //forse consuma risorse perchè comunque cerca tutti i post ???
									'tax_query' => array(
										array(
											'taxonomy' => $tassonomia,
											'field' => 'slug',
											'terms' => $termine,
										)
									)
							) );
			// The Loop
	
			$fetched_posts = [];

			$posts_for_slide = $colonne*$righe; //massimo nunero di posts che vengono visualizzati ad ogni slide		

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post(); 
					$fetched_posts[] = get_the_ID();
				}

			} else {
				// no posts found
			}
			/* Restore original Post Data */
			wp_reset_postdata();	


		$posts_to_show = []; 
		$resto = 1;
		
		//duplichiamo i posts da visualizzare fino raggiungere un numero complessivo che faccia cadere 
		//la fine della sequenza con una slice completa.
		//Lo schema è che si duplica la lista base e si verifica se il numero_di_posts_da_visualizzare diviso il numero_di_posts_per_slide
		//produce un resto pari a zero. Se è pari a zero finisce il ciclo (...di duplicazioni) se è maggiore di zero si continua a duplicare.
		//In teoria il massimo di duplicati necessari è pari a numero_di_posts_per_slide moltiplicato per numero_di_posts_da_visualizzare.
		//Questa eventualità produrrà sicuramente un resto pari a zero nell'operazione di verifica.
		if (!empty($fetched_posts)){
			for( $i=1; $resto > 0 ; $i++ ){
				foreach ($fetched_posts as $value) {
					$fetched_posts_normalized[] = $value; //push
				}
				$resto = count($fetched_posts_normalized) % $posts_for_slide;
			}
			?>
			<div class="slido-body">
			<div class="slido-container">
			<?php		

				$posts_to_show = $fetched_posts;           		//visualizzazione  con interruzione
				$posts_to_show = $fetched_posts_normalized; 	//visalizzazione continua

				global $post; 
				foreach ($posts_to_show as $ID) {
					  $post = get_post( $ID, OBJECT );
					  setup_postdata( $post );	

					 //modulo: se è uguale a uno è un multiplo del numero di elementi del gruppo
					if ($post_corrente % ($posts_for_slide) == 1){
						echo ' <div class="gruppo_' .$gruppo. ' slido-flex-container "> ';	
					}
					echo '<div class="slido-columns-'.$colonne.' slido-flex-box">';	
						slido_post_image($image_size);
					echo '</div>';
					$post_corrente++;

					//aggiunge, quando necessario, la chiusura del DIV ( class = "gruppo_N slido-flex-container" ), utilizzato come slide, contenente il gruppo di posts da visualizzare
					if ($post_corrente % ($posts_for_slide) == 1 || $post_corrente > count($posts_to_show)){
						echo '</div> <!-- gruppo'.$gruppo.' -->	';	
						$gruppo++;
					}				
				}

			wp_reset_postdata();
			

		?>
	
				</div><!-- slido-container -->	
		</div>

		<?php	
		}else{
			echo '<div class = "no-slido-post"> Nessun elemento trovato per SLIDO </div>';
		}
			
	
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



