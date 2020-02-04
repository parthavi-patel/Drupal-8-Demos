<?php 

namespace Drupal\custdrupal_service\controller;

use Drupal\custdrupal_service\CowService;


class VegetablerController {

	public function vegetablepage() {
		$cowservice = new CowService();
		$value = $cowservice->whoIsYourOwner();
	}

}