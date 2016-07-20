<?php

/**
 * @file
 * content-types.php
 */

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