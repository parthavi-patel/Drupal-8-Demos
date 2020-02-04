<?php
/**
 * @file
 * Contains \Drupal\ajaxform\Form\AjaxForm.
 */
namespace Drupal\ajaxform\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

class AjaxForm extends FormBase {

   /**
    * {@inheritdoc}
   */
    public function getFormId() {
        return 'ajax_form';
    }

    /**
     * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['message'] = [
            '#type' => 'markup',
            '#markup' => '<div id="after_submit_message"></div>'
        ];

        $form['#prefix'] = '<div id="ajax_form_block">';
        $form['#suffix'] = '</div>';

        $form['candidate_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Candidate Name:'),
            '#required' => TRUE,
        );
        $form['candidate_mail'] = array(
            '#type' => 'email',
            '#title' => t('Email ID:'),
            '#required' => TRUE,
        );
        $form['candidate_number'] = array (
            '#type' => 'tel',
            '#title' => t('Mobile no'),
        );
        $form['candidate_dob'] = array (
            '#type' => 'date',
            '#title' => t('DOB'),
            '#required' => TRUE,
        );
        $form['candidate_gender'] = array (
            '#type' => 'select',
            '#title' => ('Gender'),
            '#options' => array(
                'Female' => t('Female'),
                'male' => t('Male'),
            ),
        );
        $form['candidate_confirmation'] = array (
            '#type' => 'radios',
            '#title' => ('Are you above 18 years old?'),
            '#options' => array(
                'Yes' =>t('Yes'),
                'No' =>t('No')
            ),
        );
        $form['candidate_copy'] = array(
            '#type' => 'checkbox',
            '#title' => t('Send me a copy of the application.'),
        );
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Submit'),
            '#ajax' => [
                'callback' => [$this, 'callToAjax'],
                'wrapper' => 'ajax_form_block',
                'effect' => 'fade',
            ],
        );

        //echo "<pre>"; print_r($form); die;
        return $form;

    }

    /**
     * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        return parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
    */
    public function callToAjax(array &$form, FormStateInterface $form_state) {

        \Drupal::messenger()->addMessage($this->t('Form Submitted Successfully'), 'status', TRUE);

        $message = [
          '#theme' => 'status_messages',
          '#message_list' => drupal_get_messages(),
        ];

        $messages = \Drupal::service('renderer')->render($message);
        
        $response = new AjaxResponse();
        $response->addCommand(new HtmlCommand('#after_submit_message', $messages));

        $form_state->setRebuild();

        return $response;

    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        //echo "<pre>"; print_r($form_state); die;
        $candidate_name = $form_state->getValue('candidate_name');
        $candidate_mail = $form_state->getValue('candidate_mail');
        $candidate_number = $form_state->getValue('candidate_number');
        $candidate_dob = $form_state->getValue('candidate_dob');
        $candidate_gender = $form_state->getValue('candidate_gender');
        $candidate_confirmation = $form_state->getValue('candidate_confirmation');
        $candidate_copy = $form_state->getValue('candidate_copy');

        $connection = \Drupal::database();
        
        $query = $connection->insert('candidate_form_data')
                ->fields([
                    'candidate_name' => $candidate_name,
                    'candidate_mail' => $candidate_mail,
                    'candidate_number' => $candidate_number,
                    'candidate_dob' => $candidate_dob,
                    'candidate_gender' => $candidate_gender,
                    'candidate_confirmation' => $candidate_confirmation,
                    'candidate_copy' => $candidate_copy,
                ])
                ->execute();

    }
}

    
