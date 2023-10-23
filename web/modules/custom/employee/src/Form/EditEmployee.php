<?php 
    namespace Drupal\employee\Form;
    use Drupal\Core\Form\FormBase;
    use Drupal\Core\Form\FormStateInterface;
    use Drupal\Code\Database\Database;

    class EditEmployee extends Formbase{
        /**
         * {@inheritdoc}
         */
        public function getFormId(){
            return "edit_employee";
        }
        /**
         * {@inheritDoc}
         */
        public function buildForm(array $form, FormStateInterface $form_state){
            $id = \Drupal:: routeMatch()->getParameter('id');
            $query = \Drupal::database();
            $data = $query-> select('employees','e')
                    ->fields('e',['id','name','gender','about_employee'])
                    ->condition('e.id',$id,'=')
                    ->execute()->fetchAll(\PDO::FETCH_OBJ);
            $genderOptions = array(
                'Male' => 'Male',
                'Female' => 'Female',
                'Other' => 'Other'
            );
            $form['name'] = array(
                '#type' => 'textfield',
                '#title' => t('Name'),
                '#default_value' => $data[0]->name,
                '#required' => true,
                '#attributes' => array(
                    'placeholder' => 'Enter Name'
                )
            );

            $form['gender'] = array(
                '#type' => 'select',
                '#title' => 'Gender',
                '#options' => $genderOptions,
                '#default_value' => $data[0]->gender,
                '#required' => true
            );
            $form['about_employee'] = array(
                '#type' => 'textarea',
                '#title' => 'About Employee',
                '#default_value' => $data[0]->about_employee,
                '#required' => true,
                '#attributes' => array(
                    'placeholder' => 'About Employee'
                ),
              
            );
            $form['update']= array(
                '#type' => 'submit',
                '#value' => 'Update',
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
            $id =\Drupal::routeMatch()->getParameter('id');

            $postData = $form_state->getValues();
            unset($postData['update'],$postData['form_build_id'], $postData['form_token'],$postData['form_id'], $postData['op']);
            // echo "<pre>";
            // print_r($postData);
            // echo "</pre>";
            // exit;

            $query = \Drupal::database();
            $query->update('employees')->fields($postData)
                  ->condition('id',$id)
                  ->execute();
            $response = new \Symfony\Component\HttpFoundation\RedirectResponse('../employee-list');
            $response->send();
            $this->messenger()->addMessage($this->t('Form data update Successfully'), 'status',TRUE);
        }
    }   
?>