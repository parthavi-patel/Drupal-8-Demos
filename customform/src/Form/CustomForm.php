<?php
/**
 * @file
 * Contains \Drupal\customform\Form\CustomForm.
 */
namespace Drupal\customform\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomForm extends FormBase {

   /**
    * {@inheritdoc}
   */
    public function getFormId() {
        return 'custom_form';
    }

    /**
     * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
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
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#button_type' => 'primary',
        );

        //echo "<pre>"; print_r($form); die;
        return $form;

    }

    /**
     * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if (strlen($form_state->getValue('candidate_number')) < 10) {
            $form_state->setErrorByName('candidate_number', $this->t('Mobile number is too short.'));
        }
    }

    /**
     * {@inheritdoc}
    */
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

    
