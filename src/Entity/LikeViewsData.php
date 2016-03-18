<?php

/**
 * @file
 * Contains \Drupal\like\Entity\Like.
 */

namespace Drupal\like\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Like entities.
 */
class LikeViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();
    

    return $data;
  }

}
