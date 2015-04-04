<?php

/**
 * Implements template_preprocess_html().
 */
function clibre_preprocess_html(&$variables) {

	// Add conditional CSS for IE. To use uncomment below and add IE css file
	drupal_add_css(path_to_theme() . '/css/ie.css', ['weight' => CSS_THEME, 'browsers' => ['!IE' => FALSE], 'preprocess' => FALSE]);
}

/**
 * Implement hook_process_html
 * @param $variables
 */
function clibre_process_html(&$variables){
	$variables['styles'] = preg_replace('/\.css\?[^"]+/','.css', $variables['styles']);
}


/**
 * [clibre_block_list_alter description]
 * @param  [type] &$blocks [description]
 */
function clibre_block_list_alter(&$blocks) {
	if (drupal_is_front_page()) {
		foreach ($blocks as $key => $block) {
			if ($block->module == 'system' && $block->delta == 'main') {
				unset($blocks[$key]);
			}
		}
		drupal_set_page_content();
	}
}



/**
 * Implements template_preprocess_page.
 */
function clibre_preprocess_page(&$variables) {

	/**
	 * Setting grid form main page
	 */
	if (drupal_is_front_page()) {
		$variables['main_grid'] = 'large-12';
		unset($variables['sidebar_first_grid']);
		unset($variables['sidebar_sec_grid']);
	}

	/**
	 * Remove anoin default taxonomy listing
	 */
	if(arg(0) == "taxonomy" && arg(1) == "term") {
		$variables['page']['content']['system_main']['nodes'] = null;
		unset($variables['page']['content']['system_main']['no_content']);
		unset($variables['page']['content']['system_main']['pager']);
	}
}

/**
 * Implements template_preprocess_node.
 */
function clibre_preprocess_node(&$variables) {
}
