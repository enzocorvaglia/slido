<?php
class slido{

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