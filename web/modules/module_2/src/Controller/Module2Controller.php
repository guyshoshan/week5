<?php

namespace Drupal\module_2\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Module 2 routes.
 */
class Module2Controller extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
