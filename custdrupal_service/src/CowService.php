<?php

namespace Drupal\custdrupal_service;

use Drupal\Core\Session\AccountProxy;

/**
 * CowService is a simple exampe of a Drupal 8 service.
 */
class CowService {

  private $currentUser;
  private $sounds = ["looO", 'mooO'];

  /**
   * Part of the DependencyInjection magic happening here.
   */
  public function __construct(AccountProxy $currentUser) {
    $this->currentUser = $currentUser;
  }

  /**
   * Returns a a Drupal user as an owner.
   */
  public function whoIsYourOwner() {
    return $this->currentUser->getDisplayName();
  }

  /**
   * Returns a cow sound.
   */
  public function saySomething() {
    return $this->sounds[array_rand($this->sounds)];
  }

  

}
