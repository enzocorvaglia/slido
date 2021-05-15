<?php

// all'interno di un plugin è conveniente inizializzare lo shortcode solo dopo che 
// wordpress si è caricato completamente.

add_action('init', 'slido_init');

function slido_init(){
	add_shortcode( 'slido', 'slido_func' );
}

function slido_func( $atts ) {

	


	$a = shortcode_atts( array(
		'template' => 'default',
		'colonne' => '1',
		'righe' => '1',
		'altezza' => '100px', 
		'edizione' => '',
		'tipo' => '', 
		'tassonomia' => '',
		'termine' => '',	
		'limite'  => 50,
		'image_size'  => 'thumbnail',	
		'object_fit' => 'contain',
		'seamless' => '1',
		'slido_id' => '0',
		'slido_speed' => '400',
		'slido_fade' => 'false'

	), $atts );	

	$template = $a['template'];	
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
	$seamless = $a['seamless'];	
	$slido_id = $a['slido_id'];	
	$slido_speed = $a['slido_speed'];	
	$slido_fade = $a['slido_fade'];	
	
	
	switch ($template) {
		case 'logo':
			$tipo = 'grid_slide';
			$tassonomia = 'fma_loghi_edizione';
			$termine = $a['edizione'];
			break;
		case 'logo_2':
			$tipo = 'grid_slide';
			$tassonomia = 'fma_loghi_edizione';
			$termine = $a['edizione'];
			break;			
		case 'rai':
			$tipo = array('archivio_news', 'archivio_video');
			$tassonomia = 'special';
			$termine = 'slido';
			$image_size  = 'thumbnail';	 		
			break;
	}	

	
		$gruppo = 1;
		$post_corrente = 1;		
	
/***************************************************************************************/	
		ob_start();
/***************************************************************************************/

		?>
		<style>
			.logo-post-image img {
				height: <?php echo $altezza?>;
				object-fit: contain;
			}
			.logo-post-image a{
				display: flex;
				justify-content: center;
			}
			.over-the-slide {
				position: absolute;
				top: 158px;
				right: 16px;
				text-transform: uppercase;
			}	
			.over-the-slide span {
				background: #d73135;
				color: white;
				padding: 7px;
			}	
			.slido-body-rai{
				position: relative;
			}
			.slido-body{
				display:none;
				overflow: hidden;
			}
		</style>
		<?php	

	
	
	
		//echo 'colonne = '.$colonne.', righe = '.$righe.', altezza = '.$altezza;
		//echo '<style> .slido-flex-box{height:'.$altezza.'} </style>';
		//echo '<style> .slido-flex-box img{height:'.$altezza.'} </style>';
	
		if(is_array($tipo)){
			$lista_post_type = implode("-", $tipo);			
		}else{
			$lista_post_type = $tipo;
		}
		//la sequente variabile sarà utilizzata come classe identificativa di un certo tipo di elemento
		$identificativo = $lista_post_type.'-'.$tassonomia.'-'.$termine;
		//echo '<style> .'.$identificativo.' img{object-fit:'.$object_fit.'} </style>';	
	
		if ($colonne == 1) { echo '<style> .slido-columns-1{padding:5px; width:99%} </style>'; }
		if ($colonne == 2) { echo '<style> .slido-columns-2{padding:1%; width:48%} </style>'; }
		if ($colonne == 3) { echo '<style> .slido-columns-3{padding:1%; width:31%} </style>'; }	
		if ($colonne == 4) { echo '<style> .slido-columns-4{padding:0.5%; width:24%} </style>'; }
		if ($colonne == 5) { echo '<style> .slido-columns-5{padding:0.5%; width:19%} </style>'; }
		if ($colonne == 6) { echo '<style> .slido-columns-6{padding:0.3%; width:16%} </style>'; }		

		$fetched_posts = [];
		$posts_for_slide = $colonne*$righe; //massimo nunero di posts che vengono visualizzati ad ogni slide			
	
		// The Query
			$query = new WP_Query(  array ( 
									//'post_type' => array( $tipo, "archivio_video"), 
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
			//$fetched_posts 				visualizzazione  con interruzione
			//$fetched_posts_normalized 	visalizzazione continua
			$posts_to_show = $seamless == "1" ? $fetched_posts_normalized : $fetched_posts;			
			?>
			<div class="slido-body slido-body-<?php echo $template; ?>">
				<div class="slido-container_<?php echo $slido_id ?>">
					<?php		


					global $post; 
					foreach ($posts_to_show as $ID) {
						  $post = get_post( $ID, OBJECT );
						  setup_postdata( $post );	

						 //modulo: se è uguale a uno è un multiplo del numero di elementi del gruppo
						$modulus = $post_corrente % $posts_for_slide;
						if ( $modulus == 1){
							
							echo ' <div class="gruppo_' .$gruppo. ' slido-flex-container "> ';	
						}
						echo '<div class="slido-columns-'.$colonne.' slido-flex-box '.$identificativo.' template-'.$template.'">';	
						//echo 'IN '.$post_corrente.' % '.$posts_for_slide.' = '.$modulus;
						$myslido = new slido();
						$funcname = 'template_'.$template;
						$myslido->$funcname();

						echo '</div> <!-- slido-columns-{} -->';
						$post_corrente++;

						//aggiunge, quando necessario, la chiusura del DIV ( class = "gruppo_N slido-flex-container" ), utilizzato come slide, contenente il gruppo di posts da visualizzare
						$modulus = $post_corrente % $posts_for_slide;
						//echo 'OUT '.$post_corrente.' % '.$posts_for_slide.' = '.$modulus;
						if ($modulus == 1 ){
							echo '</div> <!-- gruppo'.$gruppo.' -->	';	
							$gruppo++;
						}				
					}
					wp_reset_postdata();
					?>
					</div><!-- slido-container -->	

					<?php if($template == "rai"){?>
					<div class="over-the-slide">
						<span>Scelti per voi</span>
					</div><!-- over-the-slide -->
					<?php }?>				
	

			</div><!-- slido-body-{} -->
			
		<?php	
		}else{
			echo '<div class = "no-slido-post"> Nessun elemento trovato per SLIDO </div>';
		}

			
	/********************************
	slider inizio
	***********************************/
	?>
	<script>
	jQuery(document).ready(function(){
		jQuery('.slido-container_<?php echo $slido_id ?>').slick({
			pauseOnFocus: false,	
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 3000,			
			infinite: true,
			arrows: false,
			dots: true,
			fade: <?php echo $slido_fade ?>,
			speed: <?php echo $slido_speed ?>,

		});
	jQuery( ".slido-flex-box" ).show();	
	jQuery( ".slido-body" ).show();	
	jQuery(".slido-flex-box").hover(function(){jQuery(".slido-title_2").css("opacity", "1");} , function(){jQuery(".slido-title_2").css("opacity", "0");});
	});
	</script> 	
	<?php
/********************************
slider FINE
***********************************/
			
	
		/****************************************************************************/	
		$result = ob_get_contents(); // get everything in to $result variable
		ob_end_clean(); 
	
		return $result;

}



//add_action( 'generate_after_footer_widgets','lancia_slido' );   

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
		jQuery( ".slido-body" ).show();	
		jQuery(".slido-flex-box").hover(function(){jQuery(".slido-title_2").css("opacity", "1");} , function(){jQuery(".slido-title_2").css("opacity", "0");});
		});
		</script> 	
		<?php
	/********************************
	slider FINE
	***********************************/		
}



