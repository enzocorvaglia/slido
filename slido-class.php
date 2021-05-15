<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class slido{

	public function template_default(){
		echo "Scegli un template fra quelli disponibili!";
	}

	
	public function template_logo() {


		$url_destinazione = get_field('url_destinazione_logo');
		$logo_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 

		echo sprintf(
			'
				<div class="logo-post-image">
						<a href="%1$s" class="logo-img-container">
							<img src="%2$s">
						</a>
				</div>
			',

			$url_destinazione,
			$logo_img_url
		);	
	}	
	

	
	public function template_logo_2() {


		$url_destinazione = get_field('url_destinazione_logo');
		$logo_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 

		echo sprintf(
			'
				<div class="logo-post-image">
						<a href="%1$s" >
							<img src="%2$s">
						</a>
				</div>
			',

			$url_destinazione,
			$logo_img_url
		);	
	}	
	
	
	public function template_rai() {


		if (has_post_thumbnail()) {
			$immagine_catturata = get_the_post_thumbnail_url();
		} else {
			$immagine_catturata = $this->catch_that_image();
		}	

		$image_id = $this->get_attachment_id_from_url( $immagine_catturata );

		$thumb_array = wp_get_attachment_image_src($image_id, 'full');	

		if( $thumb_array[1]<560){
			$thumb_url = $immagine_catturata;
		}else{
			$thumb_url = $thumb_array[0];
		}

		$title1_inside = get_the_title();

		$content = get_the_content();
		$stripped_content = strip_tags($content);

		$trimmed_content = $this->tokenTruncate($stripped_content, 110);

		$title2_inside = $trimmed_content.' ...';	

		$url_destinazione = get_post_meta( get_the_ID(), 'url_destinazione_logo', true );	

	echo sprintf(
			'

				<div class="rai-style-post-image">
						<a href="%2$s" class="rai-feat-img-container">
							<img src="%1$s">
						</a>

						<a href="%2$s" class="container-titolo">
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

	public function get_attachment_id_from_url( $attachment_url = '' ) {

		global $wpdb;
		$attachment_id = false;

		// If there is no url, return.
		if ( '' == $attachment_url )
			return;

		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();

		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
		if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

			// Remove the upload path base directory from the attachment URL
			$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

		}

		return $attachment_id;
	}

	

// se la featured image non è stata settata si utilizza la prima immagine disponibile nel testo del post. Codice tratto dal sito
// https://css-tricks.com/snippets/wordpress/get-the-first-image-from-a-post/

	public function catch_that_image() {
	  global $post, $posts;
	  $first_img = '';
	  ob_start();
	  ob_end_clean();
	  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);


// è stata aggiuntO if (isset ...ecc) per evitare la produzione dell'errore php Undefined offset: 0 nella visualizzazione di alcune pagine.
// LA COSA SAREBBE DA APPROFONDIRE. EVENTUALMENTE CERCARE UN'ALTRA VERSIONE DI QUESTO SNIPPET.

	if(isset($matches[1][0])){
		$first_img = $matches[1][0];
	}
	  if(empty($first_img)) {
		$first_img = get_site_url()."/wp-content/uploads/2019/02/default-image.jpg";
	  }

	  return $first_img;
	}	

	
// La seguente funzione viene utilizzata per troncare il testo ad un certo numero di caratteri ma evitando il troncamento dell'ultima parola.
// La fonte del codice è https://stackoverflow.com/questions/79960/how-to-truncate-a-string-in-php-to-the-word-closest-to-a-certain-number-of-chara	

	public function tokenTruncate($string, $your_desired_width) {
	  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
	  $parts_count = count($parts);

	  $length = 0;
	  $last_part = 0;
	  for (; $last_part < $parts_count; ++$last_part) {
		$length += strlen($parts[$last_part]);
		if ($length > $your_desired_width) { break; }
	  }

	  return implode(array_slice($parts, 0, $last_part));
	}	
	
	
}