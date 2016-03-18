<?php

/**
 * @file
 * Contains like\like.views.inc..
 * Provide a custom views field data that isn't tied to any other module. */

/**
 * Implements hook_views_data().
 */
function like_views_data() {

  $data['like']['table']['group'] = t('Like');
  $data['like']['table']['join'] = array(
    // #global is a special flag which allows a table to appear all the time.
    '#global' => array(),
  );


  $data['like']['target_entity_title_views_field'] = array(
    'title' => t('Target Entity Title'),
    'help' => t('Providing target entity title that user has liked.'),
    'field' => array(
      'id' => 'target_entity_title_views_field',
    ),
  );

  $data['like']['target_entity_view_views_field'] = array(
    'title' => t('Target Entity View'),
    'help' => t('Providing target entity view.'),
    'field' => array(
      'id' => 'target_entity_view_views_field',
    ),
  );
  return $data;
}
