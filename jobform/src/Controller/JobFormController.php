<?php
/**
 * @file
 * Contains \Drupal\jobform\Controller\JobFormController.
 */

namespace Drupal\jobform\Controller;

use Drupal\Core\Controller\ControllerBase;

/*use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;*/

/**
 * Controller routines for jobform routes.
 */
class JobFormController extends ControllerBase {

  public function manageAction() {

        $form = \Drupal::formBuilder()->getForm('Drupal\jobform\Form\JobForm');        
        return array (
        	'#theme' => 'manage_jobform_display',
        	'#form_in_twig' => $form,
        );
    }
}
