<?php

/**
 * @file
 * Contains \Drupal\like\LikeInterface.
 */

namespace Drupal\like;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Like entities.
 *
 * @ingroup like
 */
interface LikeInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Like creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Like.
   */
  public function getCreatedTime();

  /**
   * Sets the Like creation timestamp.
   *
   * @param int $timestamp
   *   The Like creation timestamp.
   *
   * @return \Drupal\like\LikeInterface
   *   The called Like entity.
   */
  public function setCreatedTime($timestamp);


}
