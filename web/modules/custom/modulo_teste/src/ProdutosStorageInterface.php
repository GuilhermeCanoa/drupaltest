<?php

namespace Drupal\modulo_teste;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\modulo_teste\Entity\ProdutosInterface;

/**
 * Defines the storage handler class for Produtos entities.
 *
 * This extends the base storage class, adding required special handling for
 * Produtos entities.
 *
 * @ingroup modulo_teste
 */
interface ProdutosStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Produtos revision IDs for a specific Produtos.
   *
   * @param \Drupal\modulo_teste\Entity\ProdutosInterface $entity
   *   The Produtos entity.
   *
   * @return int[]
   *   Produtos revision IDs (in ascending order).
   */
  public function revisionIds(ProdutosInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Produtos author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Produtos revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\modulo_teste\Entity\ProdutosInterface $entity
   *   The Produtos entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ProdutosInterface $entity);

  /**
   * Unsets the language for all Produtos with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
