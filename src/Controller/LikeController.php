<?php

/**
 * @file
 * Contains \Drupal\like\Controller\LikeController.
 */

namespace Drupal\like\Controller;

use Drupal\Core\Access\CsrfTokenGenerator;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class LikeController.
 *
 * @package Drupal\like\Controller
 */
class LikeController extends ControllerBase {

  protected $csrfGenerator;

  public function __construct(CsrfTokenGenerator $token_generator = NULL) {
    $this->csrfGenerator = $token_generator;
  }

  /**
   * Like.
   *
   * @return string
   *   Return Hello string.
   */
  public function like($entity, $id, $html_id, $token = '') {

    if (empty($token)) {
      $token = isset($_GET['token']) ? $_GET['token'] : '';
    }
    $user = $this->currentUser();
    $entity_arr = explode(':', $entity);
    $entity_type = $entity_arr[0];
    $object = $this->entityManager()->getStorage($entity_type)->load($id);
    if ($object) {
      try {
        $session_id = like_do_like($user, $object, $token);
      } catch (\LogicException $e) {
        // Fail silently and return the updated link.
      }
    }


    return $this->response($entity, $id, $session_id, $html_id);
  }

  /**
   * Unlike.
   *
   * @return string
   *   Return Hello string.
   */
  public function unlike($entity, $id, $html_id, $token = '') {

    if (empty($token)) {
      $token = isset($_GET['token']) ? $_GET['token'] : '';
    }
    
    $user = $this->currentUser();
    $entity_arr = explode(':', $entity);
    $entity_type = $entity_arr[0];
    $object = $this->entityManager()->getStorage($entity_type)->load($id);
    if ($object) {
      try {
        $session_id = like_do_unlike($user, $object, $token);
      } catch (\LogicException $e) {
        // Fail silently and return the updated link.
      }
    }


    return $this->response($entity, $id, $session_id, $html_id);
  }

  public function response($target, $id, $session_id, $html_id) {
    $account = $this->currentUser();
    if ($account->isAnonymous() && !like_get_cookie()) {
      like_set_cookie($session_id);
    }

    $response = new AjaxResponse();

    $link = like_get_link($target, $id);


    $link_id = '#' . $html_id;
    $token = \Drupal::csrfToken()->get();
    $link['#url']->setRouteParameter('token', $token);

    // Create a new JQuery Replace command to update the link display.
    $replace = new ReplaceCommand($link_id, drupal_render($link));
    $response->addCommand($replace);

    return $response;

  }

}
