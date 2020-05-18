<?php
declare(strict_types=1);
use Phalcon\Assets\Asset\Css;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $css1 = new Css('css/style.css');
        $this->assets->addAsset($css1);
        return $this->view;
    }

}

