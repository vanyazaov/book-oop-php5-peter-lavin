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
        $this->setTotalPages($totalrecords, $recordsperpage);
        $this->calculateCurrentPage($recordoffset, $recordsperpage);
        $this->createInactiveSpans();
        $this->calculateCurrentStartPage();
        $this->calculateCurrentEndPage();        
    }
    
    // Устанавливает класс неактивного элемента
    public function setInactiveSpanName($name){
        $this->inactivespanname = $name;
        // вызов функции для переименования span
        $this->createInactiveSpans();  
    }
    
    // Возвращает имя класса неактивного элемента
    public function getInactiveSpanName(){
        return $this->inactivespanname;
    }
    
    // Устанавливает класс для оформления общего количества страниц
    public function setPageDisplayDivName($name){
        $this->pagedisplaydivname = $name;    
    }
    
    // Возвращает класс для оформления общего количества страниц
    public function getPageDisplayDivName(){
        return $this->pagedisplaydivname;
    }
    
    // Устанавливает класс оформления навигатора
    public function setDivWrapperName($name){
        $this->divwrappername = $name;    
    }
    
    // Возвращает класс оформления навигатора
    public function getDivWrapperName(){
        return $this->divwrappername;
    }
    
    // Устанавливает параметр смещения
    public function setFirstParamName($name){
        $this->firstparamname = $name;    
    }
    
    // Возвращает параметр смещения
    public function getFirstParamName(){
        return $this->firstparamname;
    }
    
    // Вычисление номера конечной страницы
    private function calculateCurrentEndPage(){
        $this->currentendpage = $this->currentstartpage+$this->maxpagesshown;
        if($this->currentendpage > $this->totalpages)
        {
          $this->currentendpage = $this->totalpages;
        }
    }
    
    // Вычисление номера начальной страницы
    private function calculateCurrentStartPage(){
        $temp = floor($this->currentpage/$this->maxpagesshown);
        $this->currentstartpage = $temp * $this->maxpagesshown;
    }
    
    // HTML-код для вывода ссылок Next, First, Previous, Last
    private function createInactiveSpans(){
        $this->spannextinactive = "<span class=\"".
          "$this->inactivespanname\">$this->strnext</span>\n";
        $this->lastinactivespan = "<span class=\"".
          "$this->inactivespanname\">$this->strlast</span>\n";
        $this->spanpreviousinactive = "<span class=\"".
          "$this->inactivespanname\">$this->strprevious</span>\n";
        $this->firstinactivespan = "<span class=\"".
          "$this->inactivespanname\">$this->strfirst</span>\n";
    }
    
    // Вычисление номера текущей страницы
    private function calculateCurrentPage($recordoffset, $recordsperpage){
        $this->currentpage = $recordoffset/$recordsperpage;
    }
    
    // Вычисление общего количества страниц через округление с избытком
    private function setTotalPages($totalrecords, $recordsperpage){
        $this->totalpages = ceil($totalrecords/$recordsperpage);
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
