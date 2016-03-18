<?php

/**
 * @file
 * Contains Drupal\like\Form\ConfigForm.
 */

namespace Drupal\like\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 *
 * @package Drupal\like\Form
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'like.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('like.config');
    $form['target_entities'] = [
      '#type' => 'select',
      '#title' => t('Target entities'),
      '#required' => TRUE,
      '#description' => t('This is allow user like or unlike the entity content. '),
      '#default_value' => $config->get('target_entities'),
      '#options' => $this->getTargetEntities(),
      '#multiple' => TRUE,
      '#size' => 15,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('like.config')
      ->set('target_entities', $form_state->getValue('target_entities'))
      ->save();
  }

  /**
   * Return list of entity type and bundles options
   */

  public function getTargetEntities() {

    $entities = array(
      'node',
      'user',
      'taxonomy_term',
      'comment'
    );

    $options = array();


    foreach ($entities as $type) {
      $options[$type] = array();
      $bundles = \Drupal::entityManager()->getBundleInfo($type);
      if (!empty($bundles)) {
        $op = array();
        foreach ($bundles as $k => $v) {
          $op[$type . ':' . $k] = isset($v['label']) ? $v['label'] : '';
        }
      }
      $options[$type] = $op;

    }
    return $options;


  }

}
