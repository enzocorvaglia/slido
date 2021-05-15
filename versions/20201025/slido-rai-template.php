<?php
/**
 * Template tipo RAI for SLIDO
 * 	
 * from @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



function slido_post_image() {
	
	$myslido = new slido();
	
	if (has_post_thumbnail()) {
		$immagine_catturata = get_the_post_thumbnail_url();
	} else {
		$immagine_catturata = $myslido->catch_that_image();
	}	

	$image_id = $myslido->get_attachment_id_from_url( $immagine_catturata );

	$thumb_array = wp_get_attachment_image_src($image_id, 'full');	
	
	if( $thumb_array[1]<560){
		$thumb_url = $immagine_catturata;
	}else{
		$thumb_url = $thumb_array[0];
	}

	$title1_inside = get_the_title();

	$content = get_the_content();
	$stripped_content = strip_tags($content);

	$trimmed_content = $myslido->tokenTruncate($stripped_content, 110);

	$title2_inside = $trimmed_content.' ...';	
	
	$url_destinazione = get_post_meta( get_the_ID(), 'url_destinazione_logo', true );	

echo sprintf(
		'
		
			<div class="rai-style-post-image">
					<a href="%2$s" class="rai-feat-img-container">
						<img src="%1$s">
					</a>

					<a href="%2$s" class="container-titolo">
						<div class="accavallo">
							%5$s
						</div>	
						<div class = "slido-flex-center">
							<div class = "slido-rai-title"> %3$s </div>
						</div>
					</a>
			</div>
		
		',
		$thumb_url,
		esc_url( get_permalink()),
		$title1_inside, //slido_add_custom_tax_terms(),
		"",//$title2_inside  //slido_add_custom_tax_terms_rivista() 
		"Scelti per voi",
		$url_destinazione
	);	
}
?>

