<?php

namespace Drupal\modulo_teste;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Produtos entity.
 *
 * @see \Drupal\modulo_teste\Entity\Produtos.
 */
class ProdutosAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\modulo_teste\Entity\ProdutosInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished produtos entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published produtos entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit produtos entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete produtos entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add produtos entities');
  }


}
