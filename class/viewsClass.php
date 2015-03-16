<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of viewsClass
 *
 * @author Рой
 */
class viewsClass {
    
    function __construct() {
        if ((heretic::$_config['debug']) && errorClass::getCountError()) {
            echo "<strong>Текущая ошибка:</strong>" . errorClass::getError();
        }
    }
    
    
    /*
     * 09-2014
     * Функция рендеренга страницы
     * roy
     */

    public function renderPage($page, $arguments = '') {
     

        /***********WORK PLACE****************/
        
        if (is_readable($page) == false) {
            errorClass::getPageError('404');
        }else{
            include $page;
        }
        
        
    }
    
    public function partialRenderPage($page, $arguments = '') {
        if (is_readable($page) == false) {
            errorClass::getPageError('404');
        }else{
            include $page;
        }
        
    }
    
    /*
     * 15-10-2014
     * Функция вставки дополнительного шаблона
     * roy
     */
    
    public function innerPage($page, $arguments = ''){
        
        $path = heretic::$_path['views'] . $page . '.php';
        $this->partialRenderPage($path, $arguments);
        
    }
    
    
    
    /*
     * 09-2014
     * Конвертация даты
     * Рой
     */
    
    public function converteDate($date, $type = 'date'){

        switch ($type) {
            case 'onlyDate': $result = $this->onlyDate($date); break;
            case 'news': $result = $this->dateDotted($date); break;
            case 'dateTime': $result = $this->dateTime($date); break;
            case 'date': $result = $this->dateDasher($date); break;
            default: $result = $this->dateDasher($date); break;
        }
        
        return $result;
        
    }
    
    /*Только дата*/
    private function onlydate($date){
        $array = explode(' ', $date);
        return $array[0];
    }
    
    /*Дата со временем*/
    private function dateTime($date){
        
        $array = explode(' ', $date);
        
        $result = $this->dateDasher($array[0]);
        
        $time = $array[1];
        $time = substr($time, 0, 5);
        $result = $result . ' в ' . $time;
        
        return $result;
    }
    
    /*Дата через тире*/
    private function dateDasher($date){
        
        $array = explode(' ', $date);
        $date = $array[0];

        $date_split = explode('-', $date);

        $year = $date_split[0];
        $month = $date_split[1];
        $day = $date_split[2];

        switch ($month) {
            case '01': $month = 'января'; break;
            case '02': $month = 'февраля'; break;
            case '03': $month = 'марта'; break;
            case '04': $month = 'апреля'; break;
            case '05': $month = 'мая'; break;
            case '06': $month = 'июня'; break;
            case '07': $month = 'июля'; break;
            case '08': $month = 'августа'; break;
            case '09': $month = 'сентября'; break;
            case '10': $month = 'октября'; break;
            case '11': $month = 'ноября'; break;
            case '12': $month = 'декабря'; break;
            default: $month = 'января'; break;
        }

        $result = $day . ' ' . $month . ' ' . $year;
        
        return $result;
    }
    
    /*дата через точку*/
    private function dateDotted($date){
        
        $array = explode(' ', $date);
        $date = $array[0];


        $date_split = explode('-', $date);

        $year = $date_split[0];
        $month = $date_split[1];
        $day = $date_split[2];
        $result = $day . '.' . $month . '.' . $year; 
        
        return $result;
        
    }
    
    /*-------------------------------------------------------*/
    
    
    /*
     * 09-2014
     * Множественная форма числа
     * Roy
     */
    
    public function smarty_modifier_string_declination($numeric, $many="объявлений", $one="объявление", $two="объявления"){
        
        $numeric = (int) abs($numeric);
        if (($numeric % 100 == 1) || ($numeric % 100 > 20) && ($numeric % 10 == 1)){
            return $one;
        }
        elseif (($numeric % 100 == 2) || ($numeric % 100 > 20) && ($numeric % 10 == 2)){
            return $two;
        }
        elseif (($numeric % 100 == 3) || ($numeric % 100 > 20) && ($numeric % 10 == 3)){
            return $two;
        }
        elseif (($numeric % 100 == 4) || ($numeric % 100 > 20) && ($numeric % 10 == 4)){
            return $two;
        }
        else {
            return $many;
        }
    }
    
    /*------------------------------------------------------------------------*/
    
    
    /*
     * 09-2014
     * Красивый вывод цены и суммы
     * Roy
     */
    
    public function smarty_modifier_sum_convert($string, $format="int"){
	
	if ($format == "int") {
		return intval($string);
	}
	if ($format == "float") {
		$string = str_replace(",",".",$string);
		return floatval($string);
	}
	if ($format == "digit") {
		return number_format($string, 0, "," ," ");
	}
	if ($format == "summa") {
        return number_format($string,0,","," ")." <span class='rur'>руб.</span>";
	}
        if ($format == "float_summa") {
        return number_format($string,2,","," ")." <span class='rur'>руб.</span>";
        }
    }
    
    /*------------------------------------------------------------------------*/
    
    /*
     * 09-2014
     * Красивая обрезка текста до кол-ва символов, без разрыва слов
     * Roy
     */
    
    public static function previewText($text = '', $length = 500){
        $text = strip_tags($text);
        return self::cropText($text, $length); 
      }
      
      public static function cropText($string, $length){
        $result = implode(array_slice(explode('<br>',wordwrap($string,$length,'<br>',false)),0,1));
        if($result!=$string) {
            if ($result[mb_strlen($result) - 1] == '.' || $result[mb_strlen($result) - 1] == ',') $result = substr($result, 0, strlen($result)-1);
            $result .= '...';
        }    
        return $result;
      }
    
     /*-----------------------------------------------------------------------*/
    
}
