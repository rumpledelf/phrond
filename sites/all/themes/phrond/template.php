<?php

/**
 * @file
 * The primary PHP file for this theme.
 */

function phrond_block_view_alter(&$data, $block) {
  if ($block->delta == 'term_header-term_header_minor') {
    if (isset($_GET['state'])) {
      $term = taxonomy_term_load($_GET['state']);
      if ($term) {
        $data['content']['#markup'] = str_replace('</h2>',' in '.$term->name.'</h2>',$data['content']['#markup']);
        $data['content']['#markup'] = str_replace('Australia',$term->description,$data['content']['#markup']);
      }
    }
  }
}

function phrond_form_alter(&$form, &$form_state, $form_id){
  if ($form_id == "views_exposed_form") {
    $form['search']['#attributes'] = array('placeholder' => t('Keywords'));
    // taxonomy term id is arg(2)
    $term = taxonomy_term_load(arg(2));
    $vid = $term->vid;
    if (($vid == 4) || ($term->tid == 16)) {
      // get all children of current term
      $terms = taxonomy_get_tree($vid, $term->tid, 1);
      if ($terms) {
        unset($form['category']['#options']);
        $form['category']['#options']['All'] = t('- Subcategory -');
        foreach ($terms as $subterm) {
          $form['category']['#options'][$subterm->tid] = $subterm->name;
        }
      }
      else {
        unset($form['category']);
        unset($form['#info']['filter-field_category_tid']);
      }
    }
    if ($vid == 3) {
      unset($form['type']);
      unset($form['#info']['filter-field_type_tid']);
    }
    if ($vid == 2) {
      unset($form['state']);
      unset($form['#info']['filter-field_state_tid']);
    }
  }
}

function phrond_page_alter(&$page) {
  // this is for the state listing pages
  if (arg(1) == 'term') {
    $term = taxonomy_term_load(arg(2));
    if ($term->vid == 2) {
      if (isset($page['content']['system_main']['view'])) {
        $page['content']['system_main']['view']['#markup'] = str_replace("statetoken=","state=".arg(2),$page['content']['system_main']['view']['#markup']);
      }
    }
  }
}

function phrond_preprocess_page(&$variables) {
  if (arg(0) == 'taxonomy' && arg(1) == 'term' && is_numeric(arg(2))) {
    $variables['theme_hook_suggestions'][] = 'page__taxonomy_term';
  }
}

function phrond_preprocess_html(&$variables) {
  if (arg(0) == 'taxonomy' && arg(1) == 'term') {
    $term = taxonomy_term_load(arg(2));
    $variables['classes_array'][] = 'vocabulary-' . strtolower($term->vocabulary_machine_name);
  }
}
