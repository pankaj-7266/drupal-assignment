<?php
     namespace Drupal\custom_form\Controller;
     use Drupal\Core\Controller\ControllerBase;

     class FormController extends ControllerBase{
      public function createNode(){
          $form = \Drupal::formBuilder()->getForm('Drupal\custom_form\Form\CustomForm');
               return $form;  
      }
     }
?>