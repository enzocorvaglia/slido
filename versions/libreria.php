
<?php

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
