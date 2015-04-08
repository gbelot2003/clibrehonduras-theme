<?php

/**
 * Implements template_preprocess_html().
 */
function clibre_preprocess_html(&$variables) {

	// Add conditional CSS for IE. To use uncomment below and add IE css file
	//drupal_add_css(path_to_theme() . '/css/ie.css', ['weight' => CSS_THEME, 'browsers' => ['!IE' => FALSE], 'preprocess' => FALSE]);
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


/**
 * Implement function block_render to enable automaticly languages swich
 */
function block_render($module, $block_id) {
	$block = block_load($module, $block_id);
	$block_content = _block_render_blocks([$block]);
	$build = _block_get_renderable_array($block_content);
	$block_rendered = drupal_render($build);
	return $block_rendered;
}

/**
 * [clibre_form_alter description]
 * @param  [type] &$form       [description]
 * @param  [type] &$form_state [description]
 * @param  [type] $form_id     [description]
 * @return [type]              [description]
 */
function clibre_form_alter(&$form, &$form_state, $form_id){
	//$form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Buscar';}";
	if ($form_id == 'search_block_form')
	{
		$form['search_block_form']['#attributes']['placeholder'] = t('Buscar');
		$form['search_block_form']['#attributes']['size'] = 25;
		$form['search_block_form']['#attributes']['title'] = t('Ingresa el texto que deseas buscar');
		$form['actions']['#attributes']['class'][] = 'element-invisible';
		$form['actions']['submit']['#attributes']['class'][] = '';
		$form['actions']['submit']['#attributes']['class'][] = 'alert';

		//unset($form['actions']['submit']);
		//$form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/search.png');
	}
}
