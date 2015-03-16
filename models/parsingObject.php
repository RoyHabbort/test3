<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of parsingObject
 *
 * @author Иноходец
 */
class parsingObject {
    
    private $_data = string;
    private $_tags = string;
    
    //при создании объекта, сразу считываем данные html со страницы
    function __construct($url){
        $this->_data = file_get_contents($url);
    }
    
    //возвращаем текущие данные
    public function getData(){
        return $this->_data;
    }
    
    //извлекаем из html кода все теги
    private function _extracte_tags($html){
        preg_match_all('/<([a-z0-9\-]+)(.*?)>?/is', $html, $allTags);
        
        if(empty($allTags)){
            return null;
        }
        
        $allTags = $allTags[1];
        return $allTags;
    }
    
    public function getAllTags(){
        
        //извлекаем из кода страницы все теги
        $allTags = $this->_extracte_tags($this->_data);
        
        //если тегов не найдено, возвращаем null
        if(empty($allTags)){
            return null;
        }
        
        //Перебираем все теги формируя результирующий массив
        //содержащий название тега, и кол-во его вхождений
        $result = array();
        foreach($allTags as $key => $value){
            if(!$result[$value]){
                $result[$value] = array(
                    'name' => $value,
                    'count' => 1
                );
            }else{
                $result[$value]['count']++;
            }
        }
        
        return $result;
       
    }
    
    
}
