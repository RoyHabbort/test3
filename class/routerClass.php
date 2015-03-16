<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of routerClass
 *
 * @author Рой
 */
class routerClass {
    
    private $controller = '';
    private $action = '';
    private $arguments = '';
    private $file = '';
    
    public function delegate(){
    
        $this->getController();

        $controller = $this->controller ;
        $action = $this->action;
        $arguments = $this->arguments;
        if (is_readable($this->file) == false) {
            $this->executeRoute();
            return true;
            errorClass::getPageError('404');
            die();
        }
        
        include_once $this->file;
        $class = $this->controller . 'Controller';
        
        //исключение. Заглушка для  контроллера page, pagelist
        if(($controller == 'page')&&($this->action == 'pagelist')){
            errorClass::getPageError('404');
            die();
        }
        
        $controller = new $class();
        
        if (is_callable(array($controller, $this->action)) == false) {
            errorClass::getPageError('404');
            die();
        }
        $controller->$action($arguments);
    
    }
    
    private function getController(){
        
//        $route = $_SERVER["REQUEST_URI"];
//        echo $route;
         
        $route = (empty($_GET['route'])) ? '' : $_GET['route'];
        if (empty($route)) { $route = 'index'; }
        
        
        $route = trim($route, '/\\');
        $parts = explode('/', $route);
        
        $this->controller = $parts[0];
        array_shift($parts);
        if (!empty($parts)){
            $this->action = $parts[0];
            array_shift($parts);
            if(!empty($parts)) $this->getArguments($parts);
        }
        
        if(empty($this->controller)) $this->controller = 'index';
        if(empty($this->action)) $this->action = 'index';
        if($this->controller == 'index') $this->controller = heretic::$_config['default_controller'];
        
        $this->file = heretic::$_path['controllers'].$this->controller . 'Controller.php';
        
    }
    
    
    
    
    private function getArguments($parts){
        
        
        if(is_array($parts)){
            foreach ($parts as $key => $value) {
                $this->arguments[] = mysql_real_escape_string($value);
            }
        }else{
            $this->arguments = mysql_real_escape_string($parts);
        }
        
    }
    
    
    private function executeRoute(){
        
        $action = $this->controller;
        $arguments = $this->arguments;
        if($this->action == 'index') $this->action = '';
        if(empty($arguments)) $arguments = array(); 
        array_unshift($arguments, $this->action); 
        
        $file = heretic::$_path['controllers'].'pageController.php';

        include_once $file;
        
        $controller = new pageController;
        
        if (is_callable(array($controller, $this->action)) == false) {
            
            errorClass::getPageError(404);
            
        }else{
            $controller->$action($arguments);
        }
        
        
    }
    
    
}
