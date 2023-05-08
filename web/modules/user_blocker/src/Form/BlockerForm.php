<?php

namespace Drupal\user_blocker\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

/**
 * Provides a User blocker form.
 */
class BlockerForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_blocker_blocker';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // $form['message'] = [
    //   '#type' => 'textarea',
    //   '#title' => $this->t('Message'),
    //   '#required' => TRUE,
    // ];

    // $form['actions'] = [
    //   '#type' => 'actions',
    // ];
    // $form['actions']['submit'] = [
    //   '#type' => 'submit',
    //   '#value' => $this->t('Send'),
    // ];

    // return $form;

    $form['username'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'user',
      '#title' => $this->t('Username'),
      '#description' => $this->t('Enter the username of the user you want to block.'),
      '#maxlength' => 64,
      '#size' => 20,
      '#weight' => '0',
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;

  }

  

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // $this->messenger()->addStatus($this->t('The message has been sent.'));
    // $form_state->setRedirect('<front>');


    $id = $form_state->getValue('username');
    $user = User::load($id);
    $user->block();
    $user->save();
    $this->messenger()->addMessage($this->t('User %username has been blocked.', ['%username' => $user->getAccountName()]));
    
  }
  /**
  * {@inheritdoc}
  */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $id = $form_state->getValue('username');

    $user_to_block = User::load($id);
    
    $current_user = \Drupal::currentUser();
    if ($id == $current_user->id()) {
      $form_state->setError(
        $form['username'],
        $this->t('You cannot block your own account.')
      );
    }
    if ($id == 1 ) {
      $form_state->setError(
        $form['username'],
        $this->t('You cannot block user 1 account.')
        
      );
      
    }

    if ($id == NULL) {
      $form_state->setError(
        $form['username'],
        $this->t('You cannot block non existing account.')
        
      );
    }
  }
}
