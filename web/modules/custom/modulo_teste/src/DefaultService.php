<?php

namespace Drupal\modulo_teste;

/**
 * Class DefaultService.
 */
class DefaultService implements ListarProdutos {

  /**
   * Constructs a new DefaultService object.
   */
  public function __construct() {
    echo "boa noite1";
  }

  public function getServiceData() {
    //Do something here to get any data.

    //$allProductsIds = \Drupal::entityQuery('produtos');
    $entities = \Drupal::entityTypeManager()->getStorage('produtos')->loadMultiple();

    $productList = [];
    foreach($entities as $product){
      $productList[] = $product->get("name")->value;
    }

    return $productList;
  }
  /**
   * Here you can pass your values as $array.
   */
  public function postServiceData($array) {
    //Do something here to post any data.
  }

}
