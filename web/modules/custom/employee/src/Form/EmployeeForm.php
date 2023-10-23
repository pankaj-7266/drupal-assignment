<?php 
    namespace Drupal\employee\Form;
    use Drupal\Core\Form\FormBase;
    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Code\Database\Database;

    class EmployeeForm extends Formbase{
        /**
         * {@inheritdoc}
         */
        public function getFormId(){
            return "create_employee";
        }
        /**
         * {@inheritDoc}
         */
        public function buildForm(array $form, FormStateInterface $form_state){
            $genderOptions = array(
                'Male' => 'Male',
                'Female' => 'Female',
                'Other' => 'Other'
            );
            $form['name'] = array(
                '#type' => 'textfield',
                '#title' => t('Name'),
                '#default-value' => '',
                '#required' => true,
                '#attributes' => array(
                    'placeholder' => 'Enter Name'
                )
            );

            $form['gender'] = array(
                '#type' => 'select',
                '#title' => 'Gender',
                '#options' => $genderOptions,
                '#required' => true
            );
            $form['about_employee'] = array(
                '#type' => 'textarea',
                '#title' => 'About Employee',
                '#default_value' => '',
                '#required' => true,
                '#attributes' => array(
                    'placeholder' => 'About Employee'
                )
            );
            $form['save']= array(
                '#type' => 'submit',
                '#value' => 'Save Employee',
                '#button_type' => 'primary'
            );
            return $form;
        }
        /** 
         * {@inheritDoc}
         */
        public function validateForm(array &$form, FormStateInterface $form_state){
            $name = $form_state->getValue('name');
            if(trim($name) == ''){
                $form_state -> setErrorByName('name',$this->t('this field is required'));
            }
            else if($form_state->getValue('gender') == '0'){
                $form_state->setErrorByName('gender',$this-> t('this option field is required'));
            }
            else if($form_state->getValue('about_employee')== ''){
                $form_state->setErrorByname('about_employee',$this->t('about field is required'));
            }
        }
        /**
         * {@inheritdoc}
         */
        public function submitForm(array & $form, FormStateInterface $form_state){
            $postData = $form_state->getValues();
            unset($postData['save'],$postData['form_build_id'], $postData['form_token'],$postData['form_id'], $postData['op']);
            // echo "<pre>";
            // print_r($postData);
            // echo "</pre>";
            // exit;

            $query = \Drupal::database();
            $query->insert('employees')->fields($postData)->execute();

            $this->messenger()->addMessage($this->t('Form Submitted Successfully'), 'status',TRUE);
        }
    }
?>