<?php 
namespace Drupal\node_unpublished\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
Class NodeUnpublish extends ControllerBase{
	public function content(){
		$node = Node::load(18);
		$node->status = 0;
        $node->save();
        return [];
	}
} 
