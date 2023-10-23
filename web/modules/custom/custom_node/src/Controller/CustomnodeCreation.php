<?php 
    namespace Drupal\custom_node\Controller;
    use Drupal\Core\Controller\ControllerBase;
    use Drupal\node\Entity\Node;
    Class CustomnodeCreation extends ControllerBase{
        public function content(){
            $node = Node::create(['type' => 'article']);
            $node -> set('title','new node');
            $node -> set('uid',1);
            $node -> status = 1;
            $node -> save();
            return [
                $this->messenger()->addMessage($this->t('Form Submitted Successfully'), 'status',TRUE)
            ];
        }
    }
?>