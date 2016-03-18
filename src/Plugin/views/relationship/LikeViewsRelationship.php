<?php
/**
 * @file
 * Contains \Drupal\like\Plugin\views\relationship\FlagViewsRelationship.
 */

namespace Drupal\like\Plugin\views\relationship;

use Drupal\user\RoleInterface;
use Drupal\views\Plugin\views\relationship\RelationshipPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a views relationship to select liked content by a user.
 *
 * @ViewsRelationship("like_relationship")
 */
class LikeViewsRelationship extends RelationshipPluginBase {

  /**
   * {@inheritdoc}
   */
  public function defineOptions() {
    $options = parent::defineOptions();
    $options['like'] = ['default' => NULL];
    $options['required'] = ['default' => 1];
    $options['user_scope'] = ['default' => 'current'];
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
  public function query() {

    if ($this->options['user_scope'] == 'current') {
      $this->definition['extra'][] = [
        'field' => 'user_id',
        'value' => '***CURRENT_USER***',
        'numeric' => TRUE,
      ];
      $roles = user_roles(FALSE, "like_like");
      if (isset($roles[RoleInterface::ANONYMOUS_ID])) {
        // Disable page caching for anonymous users.
        \Drupal::service('page_cache_kill_switch')->trigger();

        // Add in the SID from Session API for anonymous users.
        $this->definition['extra'][] = [
          'field' => 'session_id',
          'value' => '***FLAG_CURRENT_USER_SID***',
          'numeric' => TRUE,
        ];
      }
    }

    parent::query();
  }
}
