<?php

/**
 * @file
 * Contains produtos.page.inc.
 *
 * Page callback for Produtos entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Produtos templates.
 *
 * Default template: produtos.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_produtos(array &$variables) {
  // Fetch Produtos Entity Object.
  $produtos = $variables['elements']['#produtos'];
  echo "oieee";
  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
