<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of heretic
 *
 * @author Рой
 */
class heretic {
    
    public static $_path = array();
    public static $_config = array();
    public static $_script = array();
    public static $_link = array();
    public static $_kernel = array();
    public static $_widget = array();
    public static $active_page;



    /*
     * 08-2014
     * Подключение модулей
     * Roy
     */
    
    public static function connect($path, $condition){
    
        $dir = $path;
        if(is_dir($dir)) {

            $files = scandir($dir);

            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'
            foreach ($files as $key => $value) {
                if (substr_count($value, $condition)) include_once $dir . $value;
            }
        }
        
    }
    
    public static function connectDir($dir, $array, $condition){
        
        if(is_dir($dir)) {
            
            foreach ($array as $key => $value) {
                include_once $dir . $value . $condition;
            }
            
        }
        
    }
    
    /*------------------------------------------------------------------------*/
    
    
    /*
     * 08-2014
     * Вызов виджета
     * Roy
     */
    
    public static function Widget($name, $arguments = array(), $method = 'index'){

            $file = heretic::$_path['widget'] . $name . '/' . $name . 'Widget.php';
            $class = $name . 'Widget'; 
            if (!is_readable($file)){
                return false;
            }else{
                
                if(!in_array($class, heretic::$_widget)){
                    include $file;
                    heretic::$_widget[] = $class;
                }
                $widget = new $class;
                $widget->$method($arguments);
                return true;
            }
      }
      
      /*----------------------------------------------------------------------*/
      
      
      /*
       * 08-2014
       * Не помню что за функция
       * Roy
       */
      
      public static function cout($params){
          if(!empty($params)) return $params;
            else return NULL;
      }
      
      /*----------------------------------------------------------------------*/
      
      /*
       * 08-2014
       * Работа с подсказками
       * roy
       */
      
      public static function setFlash($name, $value){
          $_SESSION[$name] = $value;
      }
      
      public static function getFlash($name){
          if (!empty($_SESSION[$name])) {
              $return = $_SESSION[$name];
              heretic::destroyFlash($name);
              return $return;
          } else return NULL;
      }
      
      public static function destroyFlash($name){
          if (!empty($_SESSION[$name])) unset($_SESSION[$name]);
      }
    
      /*----------------------------------------------------------------------*/
      
    
    /*
     * 10-2014
     * Организация редиректа с подсказками
     * roy
     */  
      
    public static function redirect($action, $address, $text){
        heretic::setFlash ($action, $text);
        $location = $address;
        header( "Location: {$location}", true, 303 );
    }
    
    
    /*
     * 14-10-2014
     * Структурированный вывод массивов
     * roy
     */
    
    
    public static function hvar_dump($array){
        echo "<pre>";
        var_dump($array);
        echo "</pre>";
    }
      
      
}
