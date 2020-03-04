<?php
/**
 * @file
 * Contains \Drupal\jobform\Form\JobForm.
 */
namespace Drupal\jobform\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class JobForm extends FormBase {

   /**
    * {@inheritdoc}
   */
    public function getFormId() {
        return 'job_form';
    }

    /**
     * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['job_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Candidate Name:'),
            '#required' => TRUE,
        );
        $form['job_mail'] = array(
            '#type' => 'email',
            '#title' => t('Email ID:'),
            '#required' => TRUE,
        );
        $form['job_number'] = array (
            '#type' => 'tel',
            '#title' => t('Mobile no'),
        );
        $form['job_dob'] = array (
            '#type' => 'date',
            '#title' => t('DOB'),
            '#required' => TRUE,
        );
        $form['job_gender'] = array (
            '#type' => 'select',
            '#title' => ('Gender'),
            '#options' => array(
                'Female' => t('Female'),
                'male' => t('Male'),
            ),
        );
        $form['job_confirmation'] = array (
            '#type' => 'radios',
            '#title' => ('Are you above 18 years old?'),
            '#options' => array(
                'Yes' =>t('Yes'),
                'No' =>t('No')
            ),
        );
        $form['job_copy'] = array(
            '#type' => 'checkbox',
            '#title' => t('Send me a copy of the application.'),
        );
        //$form['#theme'] = "manage-jobform";
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
        if (strlen($form_state->getValue('job_number')) < 10) {
            $form_state->setErrorByName('job_number', $this->t('Mobile number is too short.'));
        }
    }

    /**
     * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        //echo "<pre>"; print_r($form_state); die;
        $job_name = $form_state->getValue('job_name');
        $job_mail = $form_state->getValue('job_mail');
        $job_number = $form_state->getValue('job_number');
        $job_dob = $form_state->getValue('job_dob');
        $job_gender = $form_state->getValue('job_gender');
        $job_confirmation = $form_state->getValue('job_confirmation');
        $job_copy = $form_state->getValue('job_copy');

        $connection = \Drupal::database();
        
        $query = $connection->insert('job_form_data')
                ->fields([
                    'job_name' => $job_name,
                    'job_mail' => $job_mail,
                    'job_number' => $job_number,
                    'job_dob' => $job_dob,
                    'job_gender' => $job_gender,
                    'job_confirmation' => $job_confirmation,
                    'job_copy' => $job_copy,
                ])
                ->execute();
    }
}

    
