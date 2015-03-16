<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of parser
 * 
 * @author Иноходец
 */
class parser {

    public function connectUrl($url){
        //Проверяем адрес на валидность
        $url = $this->_parse_url_if_valid($url);
        
        if(!$url){
            return null;
        }
        //проверяем адрес на существование
        if(!$this->_access_url($url)){
            return null;
        }
        
        //создаём и возвращаем объект парсера
        $parsingObject = new parsingObject($url);
        
        return $parsingObject;
    }
    
    
    private function _parse_url_if_valid($url){
        
        // Массив с компонентами URL, сгенерированный функцией parse_url()
        $arUrl = parse_url($url);
        
        // Возвращаемое значение. По умолчанию будет считать наш URL некорректным.
        $ret = null;
        
        
        // Если не был указан протокол, или указанный протокол некорректен для url
        if (!array_key_exists("scheme", $arUrl) || !in_array($arUrl["scheme"], array("http", "https"))){
            $arUrl["scheme"] = "http";
        }
        
        // Если функция parse_url смогла определить host
        if (array_key_exists("host", $arUrl) && !empty($arUrl["host"])){
            // Собираем конечное значение url
            $ret = sprintf("%s://%s%s", $arUrl["scheme"], $arUrl["host"], $arUrl["path"]);
        }
        // Если значение хоста не определено (обычно так бывает, если не указан протокол),
        // Проверяем $arUrl["path"] на соответствие шаблона URL.
        else if (preg_match("/^\w+\.[\w\.]+(\/.*)?$/", $arUrl["path"])){
            // Собираем URL
            $ret = sprintf("%s://%s", $arUrl["scheme"], $arUrl["path"]);
        }
         
        // Если url валидный и передана строка параметров запроса
        if ($ret && empty($ret["query"])){
            $ret .= sprintf("?%s", $arUrl["query"]);
        }
        
        return $ret;
    }
    
    
    private function _access_url($url){
        
        if ($otvet=@get_headers($url)){
            $codeOtvet = substr($otvet[0], 9, 3);
            if($codeOtvet == 200){
                return true;
            }
        }
        
        return false;
        
    }
    
}
