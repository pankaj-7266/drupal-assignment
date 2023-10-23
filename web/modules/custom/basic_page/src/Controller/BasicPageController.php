<?php
namespace Drupal\basic_page\Controller;

use Drupal\Core\Controller\ControllerBase;

class BasicPageController extends ControllerBase
{
    public function basicPage()
    {
        return [];
    }
    public function information(){
        return[
            '#title' => 'Information Page',
            '#theme' => 'information_page',
            '#data' => 'This is information Page'
        ];
    }
}
?>