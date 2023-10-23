<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Provides a custom form.
 */
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
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];
    $form['about'] = [
      '#type' => 'textarea',
      '#title' => 'About',
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
    $config = \Drupal::config('custom_form.settings');
    $publish_node = $config->get('options');
    $name = $form_state->getValue('name');
    $about = $form_state->getValue('about');
    $node = Node::create([
      'type' => 'formcontent',
      'title' => $name,
      'field_name' => $name,
      'field_about' => $about,
    ]);
    if ($publish_node == 1) {
      $node->setPublished();
      $this->messenger()->addMessage($this->t('published node created'), 'status', TRUE);
    }
    else {
      $node->setUnpublished();
      $this->messenger()->addMessage($this->t('unpublished node created'), 'warning', TRUE);
    }
    $node->save();
    // $form_state->setRedirect('entity.node.canonical', ['node' => $node->id()]);
  }

}
