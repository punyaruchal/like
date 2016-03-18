<?php

/**
 * @file
 * Contains \Drupal\like\Plugin\views\field\TargetEntityTitleViewsField.
 */

namespace Drupal\like\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Random;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("target_entity_title_views_field")
 */
 class TargetEntityTitleViewsField extends FieldPluginBase {
/**
 * {@inheritdoc}
 */
 public function usesGroupBy() {
   return FALSE;
 }

/**
 * {@inheritdoc}
 */
 public function query() {
   // do nothing -- to override the parent query.
	
 }

/**
 * {@inheritdoc}
 */
 protected function defineOptions() {
   $options = parent::defineOptions();

   $options['hide_alter_empty'] = array('default' => FALSE);
   return $options;
 }

/**
 * {@inheritdoc}
 */
 public function buildOptionsForm(&$form, FormStateInterface $form_state) {
   parent::buildOptionsForm($form, $form_state);
 }

/**
 * {@inheritdoc}
 */
 public function render(ResultRow $values) {
    // Return a random text, here you can include your custom logic.
    // Include any namespace required to call the method required to generte the
    // output desired
		if(empty($values->_entity)){
			return;
		}
		$entity = $values->_entity;
		$entity_target_type = $entity->getTargetEntityType();
		$entity_target_id = $entity->getTargetEntityId();
		
		$target_entity = \Drupal::entityManager()->getStorage($entity_target_type)->load($entity_target_id);
    $link = $target_entity->toLink();
    return render($link->toRenderable());
 }


}
