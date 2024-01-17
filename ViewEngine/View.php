<?php

namespace ViewEngine;

use Core\MvcContext;
use Core\MvcContextInterface;

class View implements ViewInterface
{


    const VIEW_FOLDER = 'views/';
    const VIEW_EXTENSION = '.php';

     private $mvcContext;


    public function __construct(MvcContextInterface $mvcContext)
    {
        $this->mvcContext = $mvcContext;
    }


    public function render($model = null, $viewName = null)
    {


       if ($viewName !=null){



           if (strstr($viewName,'.')){
               include self::VIEW_FOLDER . $viewName;

           }

           else{

               include self::VIEW_FOLDER . $viewName . self::VIEW_EXTENSION;
           }

       }
       else{

          $folder = strtolower(str_replace('Controller', '',$this->mvcContext->getControllerName()));

           $file = strtolower($this->mvcContext->getActionName());

           include self::VIEW_FOLDER . $folder . DIRECTORY_SEPARATOR . $file . self::VIEW_EXTENSION;
       }
    }
}