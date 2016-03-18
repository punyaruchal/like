<?php

/**
 * @file
 * Contains \Drupal\like\Controller\LikeController.
 */

namespace Drupal\like\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class LikeController.
 *
 * @package Drupal\like\Controller
 */
class LikeController extends ControllerBase {
  /**
   * Like.
   *
   * @return string
   *   Return Hello string.
   */
  public function like($entity, $id) {

    $user = $this->currentUser();
    $entity_arr = explode(':', $entity);
    $entity_type = $entity_arr[0];
    $object = $this->entityManager()->getStorage($entity_type)->load($id);
    if ($object) {
      try {
        $session_id = like_do_like($user, $object);
      } catch (\LogicException $e) {
        // Fail silently and return the updated link.
      }
    }


    return $this->response($entity, $id, $session_id);
  }

  /**
   * Unlike.
   *
   * @return string
   *   Return Hello string.
   */
  public function unlike($entity, $id) {

    $user = $this->currentUser();
    $entity_arr = explode(':', $entity);
    $entity_type = $entity_arr[0];
    $object = $this->entityManager()->getStorage($entity_type)->load($id);
    if ($object) {
      try {
        $session_id = like_do_unlike($user, $object);
      } catch (\LogicException $e) {
        // Fail silently and return the updated link.
      }
    }


    return $this->response($entity, $id, $session_id);
  }

  public function response($target, $id, $session_id) {
    $account = $this->currentUser();
    if ($account->isAnonymous() && !like_get_cookie()) {
      like_set_cookie($session_id);
    }

    $response = new AjaxResponse();

    $link = like_get_link($target, $id);


    $link_id = '#' . $link['#attributes']['id'];

    // Create a new JQuery Replace command to update the link display.
    $replace = new ReplaceCommand($link_id, drupal_render($link));
    $response->addCommand($replace);

    return $response;

  }

}
