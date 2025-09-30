<?php
/**
Класс для навигации по нескольким страницам
*/
class PageNavigator
{
    // Имя страницы, содержащий навигатор
    private $pagename;
    // Общее число страниц для вывода
    private $totalpages;
    // Число записей на одной странице
    private $recordsperpage;
    // Максимальное число ссылок на другие страницы
    private $maxpagesshown;
    // Начало нумерации ссылок в блоке
    private $currentstartpage;
    // Конец нумерации ссылок в блоке
    private $currentendpage;
    // Номер текущей страницы
    private $currentpage;
    // HTML-код для неактивных ссылок "следующая" и "предыдущая"
    private $spannextinactive;
    private $spanpreviousinactive;
    // HTML-код для неактивных ссылок "первая" и "последняя"
    private $firstinactivespan;
    private $lastinactivespan;
    // для формирования строки запроса, должен соответствовать $_GET['offset'] на вызывающей странице
    private $firstparamname = "offset";
    // дополнительные параметры, использовать как пару "&имя=значение" для получения
    private $params;
    // CSS-классы для оформления постраничного навигатора
    private $inactivespanname = "inactive";
    private $pagedisplaydivname = "totalpagesdisplay";
    private $divwrappername = "navigator";  
    // Текстовые элементы навигации
    private $strfirst = "|&lt;";
    private $strnext = "Next";
    private $strprevious = "Prev";
    private $strlast = "&gt;|";
    // Для сообщений об ошибках
    private $errorstring; 
    
    public function __construct($pagename, $totalrecords, $recordsperpage, $recordoffset, $maxpagesshown = 4, $params = ""){
        $this->pagename = $pagename;
        $this->recordsperpage = $recordsperpage;  
        $this->maxpagesshown = $maxpagesshown;
        // уже url-кодировано
        $this->params = $params;
        
        // проверить, что recordoffset кратно recordsperpage
        $this->checkRecordOffset($recordoffset, $recordsperpage) or
          die($this->errorstring);
    }
    
    // $recordoffset - где навигатор должен позиционироваться
    // число выводимых записей на странице постоянно
    // смещение должно быть кратно этой величине
    private function checkRecordOffset($recordoffset, $recordsperpage)
    {
        $bln = true;
        if($recordoffset%$recordsperpage != 0){
          $this->errorstring = "Ошибка — не кратно числу записей на странице.";
          $bln = false;  
        }
        return $bln;
    }  
}
