<?php

/**
 * @file
 * Contains \Drupal\like\Entity\Like.
 */

namespace Drupal\like\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Session;
use Drupal\like\LikeInterface;
use Drupal\user\UserInterface;


/**
 * Defines the Like entity.
 *
 * @ingroup like
 *
 * @ContentEntityType(
 *   id = "like",
 *   label = @Translation("Like"),
 *   handlers = {
 *     "list_builder" = "Drupal\like\LikeListBuilder",
 *     "views_data" = "Drupal\like\Entity\LikeViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\like\Form\LikeForm",
 *       "add" = "Drupal\like\Form\LikeForm",
 *       "edit" = "Drupal\like\Form\LikeForm",
 *       "delete" = "Drupal\like\Form\LikeDeleteForm",
 *     },
 *   },
 *   base_table = "likes",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *   },
 *   field_ui_base_route = "like.settings"
 * )
 */
class Like extends ContentEntityBase implements LikeInterface {
  use EntityChangedTrait;


  /**
   * {@inheritdoc}
   */
  public function __construct(array $values, $entity_type, $bundle = FALSE, $translations = array()) {
    if (isset($values['target_entity_id'])) {
      $values['target_entity'] = $values['target_entity_id'];
    }
    parent::__construct($values, $entity_type, $bundle, $translations);
  }

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public function getTargetEntityId() {
    return $this->get('target_entity_id')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTargetEntityId($target_entity_id) {
    $this->set('target_entity_id', $target_entity_id)->value;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getTargetEntityType() {
    return $this->get('target_entity_type')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTargetEntityType($target_entity_type) {
    $this->set('target_entity_type', $target_entity_type);

    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public function getTargetEntity() {

    return $this->entityManager()
      ->getStorage($this->getEntityType())
      ->load($this->getTargetEntityId());
  }


  /**
   * {@inheritdoc}
   */
  public function getUserIp() {
    return $this->get('user_ip')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setUserIp($ip) {
    $this->set('user_ip');
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getSessionId() {
    return $this->get('session_id')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setSessionId($id) {
    $this->set('session_id', $id);
    return $this;
  }


  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Like entity.'))
      ->setReadOnly(TRUE);
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Like entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User ID'))
      ->setDescription(t('The user ID liked the content'))
      ->setSettings([
        'target_type' => 'user',
        'default_value' => 0,
      ]);


    $fields['target_entity_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Target Entity Type'))
      ->setDescription(t('The target of entity type.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ));

    $fields['target_entity_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Target Entity ID'))
      ->setRequired(TRUE)
      ->setDescription(t('The Target Entity ID.'));

    $fields['target_entity'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Target Entity'))
      ->setDescription(t('The Target entity user liked.'))
      ->setComputed(TRUE);


    $fields['session_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Session ID'))
      ->setDescription(t('The User session ID'));

    $fields['user_ip'] = BaseFieldDefinition::create('string')
      ->setLabel(t('user_ip'))
      ->setDescription(t('The User IP Address'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    return $fields;
  }


}
