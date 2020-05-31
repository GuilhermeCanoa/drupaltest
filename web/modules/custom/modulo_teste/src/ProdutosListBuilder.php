<?php

namespace Drupal\modulo_teste;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Produtos entities.
 *
 * @ingroup modulo_teste
 */
class ProdutosListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Produtos ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\modulo_teste\Entity\Produtos $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.produtos.edit_form',
      ['produtos' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
