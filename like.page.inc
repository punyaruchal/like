<?php

/**
 * @file
 * Contains like.page.inc..
 *
 * Page callback for Like entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Like templates.
 *
 * Default template: like.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_like(array &$variables) {
  // Fetch Like Entity Object.
  $like = $variables['elements']['#like'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
