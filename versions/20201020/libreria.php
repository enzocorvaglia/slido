
<?php

//reference: https://philipnewcomer.net/2012/11/get-the-attachment-id-from-an-image-url-in-wordpress/

function slido_get_attachment_id_from_url( $attachment_url = '' ) {
 
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


// ottiene la lista dei termini assegnati al post corrente - ATTUALMENTE NON UTILIZZATO
function slido_add_custom_tax_terms() {
	$taxonomies = array( 
	  'tema_news',
	  'tema_video',
	);
	foreach ( $taxonomies as $id ) {
		$term_list = get_the_term_list( get_the_ID(), $id, '', ', ' );
			if ($term_list){
				return  $term_list;
			}
		}
  	}
// dovrebbe ritornare il numero della rivista se il post possiede il termine - ATTUALMENTE NON UTILIZZATO
function slido_add_custom_tax_terms_rivista() {
		//$term_list è una lista di tutti i termini della tassonomia
		//assegnati al post corrente separati da spazio e virgola (come 
		//specificato dagli ultimi due argomenti). Nello specifico caso comunque 
		//la lista dovrebbe essere composta sempre da un solo elemento.
		$term_list = get_the_term_list( get_the_ID(), 'rivista', '', ', ' );
		if ($term_list){
			if (strpos($term_list, 'no-rivista') === false) {
				return  $term_list;
			}
		}
}
