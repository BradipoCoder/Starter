<?php

/**
 * @file
 * template.php
 */

/**
 * Implements hook_preprocess_html()
 * Google fonts and Google Analitycs
 */
function starter_preprocess_html(&$variables) {
  $fonts = array(
    0 => 'http://fonts.googleapis.com/css?family=Montserrat:400,700',
    1 => 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,300,400,600',
  );

  foreach ($fonts as $key => $css) {
    drupal_add_css($css, array('type' => 'external'));
  }

  //$ga = _starter_get_ga_script();
  //drupal_add_js($ga, array('type' => 'inline', 'scope' => 'header', 'weight' => 5));
}

// ** PREPROCESS NODE **
// ---------------------

/**
 * Implements hook_preprocess_node()
 */
function starter_preprocess_node(&$vars){
  $node = $vars['node'];
  switch ($node->type) {
    case 'page':
      _starter_preprocess_node_page($vars);
      break;
    
    default:
      # code...
      break;
  }
}

function _starter_preprocess_node_page(&$vars){
  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'col-sm-6';
    $vars['classes_array'][] = 'col-md-4';
  }
}

// ** ADMIN **
// -----------

/**
 * Implements hook_form_FORM_ID_alter(&$form, &$form_state, $form_id)
 * Node editing and some permission
 */
function starter_form_node_form_alter(&$form, $form_state){
  global $user;

  $form['nodehierarchy']['#title'] = 'Genitore';
  if (isset($form['nodehierarchy']['nodehierarchy_menu_links'][0]['#title'])){
    $form['nodehierarchy']['nodehierarchy_menu_links'][0]['#title'] = 'Genitore';
  }

  if ($user->uid == 1){
    // Administrator
  } else {
    // Authenticated user
    $form['options']['promote']['#access'] = false;
    $form['options']['sticky']['#access'] = false;
    $form['revision_information']['#access'] = false;
  }
}

// ** GA **
// --------

function _starter_get_ga_script(){
  $ga = "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  
  ga('create', 'UA-54988180-1', 'auto');
  ga('send', 'pageview');";
  return $ga;
}