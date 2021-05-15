<?php
/**
 * Featured image for SLIDO
 * 	
 * from @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function slido_post_image() {


	if (has_post_thumbnail()) {
		$immagine_catturata = get_the_post_thumbnail_url();
	} else {
		// la funzione catch_that_image() è dichiarata in functions.php
		$immagine_catturata = catch_that_image();
	}	
	
	$image_id = slido_get_attachment_id_from_url( $immagine_catturata );
	$thumb_array = wp_get_attachment_image_src($image_id, 'thumbnail');	
	
	if( $thumb_array[1]<560){
		$thumb_url = $immagine_catturata;
	}else{
		$thumb_url = $thumb_array[0];
	}

	$title1_inside = get_the_title();

	$content = get_the_content();
	$stripped_content = strip_tags($content);
	//la funzione di seguito chiamata è situata	in function.php
	//la fonte del codice è https://stackoverflow.com/questions/79960/how-to-truncate-a-string-in-php-to-the-word-closest-to-a-certain-number-of-chara	
	$trimmed_content = tokenTruncate($stripped_content, 110);
	//$trimmed_content = wp_trim_words( $content, 18 );

	$title2_inside = $trimmed_content.' ...';	
	
	$url_destinazione = get_post_meta( get_the_ID(), 'url_destinazione_logo', true );	
	
	echo sprintf(
		'
<div class="slido-flex-box">								
	<a href="%6$s">									
		<div class="slido-box">		

		
			<div class="slido-post-image">
				<a href="%2$s" class="fixed-ratio-container">
					<img src="%1$s">
					<div class="slido-title_3">
						%5$s
					</div>			
				</a>

				<div class="slido-title_1">
					<a href="%2$s"> %3$s </a>
				</div>

				<div class="slido-title_2">
					<a href="%2$s"> %4$s </a>
				</div>				
			</div>
		
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
