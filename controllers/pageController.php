<?php



/*
 * 15-02-2015
 * Контроллер страниц
 * Roy
 */

class pageController extends controllerClass{
    
    //главная страница
    public function index(){
        $this->render('index');
    }
    
    //страница парсинга
    public function parser(){
        
        //если поле url осталось пустым, возвращаем ошибку
        if(empty($_POST['url'])){
            heretic::redirect('error', '/', 'Ошибка! Некоректный URL адрес.');
        }
        
        $url = $_POST['url'];
        $url = (string) $url;
        $url = strip_tags($url);
        
        $parser = new parser();
        $parsingObject = $parser->connectUrl($url);
        
        //если при инициализации парсера, вернулся пустой объект, возвращаем ошибку
        if(!$parsingObject){
            heretic::redirect('error', '/', 'Ошибка! Некоректный URL адрес.');
        }
        
        //извлекаем все теги
        $result = $parsingObject->getAllTags();
        
        $this->render('parser', array('result' => $result, 'url' => $url));
        
    }
    
    
}