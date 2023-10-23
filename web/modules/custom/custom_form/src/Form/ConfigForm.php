<?php 
    namespace Drupal\custom_form\Form;

    use Drupal\Core\Form\ConfigFormBase;
    use Drupal\Core\Form\FormStateInterface;

    class ConfigForm extends ConfigFormBase{
    
        /**
         * Setting Variable.
         */
        Const CONFIGNAME = "custom_form.settings";

        /**
         * {@inheritdoc}
         */
        public function getFormId() {
            return "custom_form_settings";
        }

        /**
         * {@inheritdoc}
         */
        protected function getEditableConfigNames(){
            return [
                static::CONFIGNAME,
            ];
        }

        public function buildForm(array $form, FormStateInterface $form_state) {
            $config = \Drupal::config('custom_form.settings');
            $publish_node = $config->get('options');
            $config = $this->config(static::CONFIGNAME);
            $form['options'] = array(
                '#type' => 'checkbox',
                '#title'=> $this->t('choose option'),
            );
            $form['options']['#default_value'] = $publish_node;

            return Parent::buildForm($form, $form_state);
        }
        /**
         * {@inheritDoc}
         */

         public function submitForm(array &$form, FormStateInterface $form_state) {
            $config = $this->config(static::CONFIGNAME);
            $config->set("options", $form_state->getValue('options'));
            $config->save();
         }
    }
?>