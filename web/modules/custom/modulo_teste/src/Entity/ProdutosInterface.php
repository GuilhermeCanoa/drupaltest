<?php

namespace Drupal\modulo_teste\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Produtos entities.
 *
 * @ingroup modulo_teste
 */
interface ProdutosInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Produtos name.
   *
   * @return string
   *   Name of the Produtos.
   */
  public function getName();

  /**
   * Sets the Produtos name.
   *
   * @param string $name
   *   The Produtos name.
   *
   * @return \Drupal\modulo_teste\Entity\ProdutosInterface
   *   The called Produtos entity.
   */
  public function setName($name);

  /**
   * Gets the Produtos creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Produtos.
   */
  public function getCreatedTime();

  /**
   * Sets the Produtos creation timestamp.
   *
   * @param int $timestamp
   *   The Produtos creation timestamp.
   *
   * @return \Drupal\modulo_teste\Entity\ProdutosInterface
   *   The called Produtos entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Produtos revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Produtos revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\modulo_teste\Entity\ProdutosInterface
   *   The called Produtos entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Produtos revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Produtos revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\modulo_teste\Entity\ProdutosInterface
   *   The called Produtos entity.
   */
  public function setRevisionUserId($uid);

}
