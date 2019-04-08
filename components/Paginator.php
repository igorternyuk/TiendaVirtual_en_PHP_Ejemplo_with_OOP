<?php

/**
 * Description of Paginator
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Paginator {
    
   private $maxPagesToShow = 4;
   private $keyOfGet = 'page-';
   private $currentPage = 1;
   private $itemsTotal;
   private $itemsPerPage;
   private $pageTotal;
   
   public function __construct($currentPage, $itemsTotal, $itemsPerPage, $keyOfGet) {
       $this->itemsPerPage = $itemsPerPage;
       $this->itemsTotal = $itemsTotal;
       $this->pageTotal = $this->getPageTotal();
       $this->keyOfGet = $keyOfGet;
       $this->setCurrentPage($currentPage);
   }
   
   private function getPageTotal(){
       return ceil($this->itemsTotal / $this->itemsPerPage);
   }
   
   private function setCurrentPage($currentPage = 1){
       if($currentPage > 0){
           if($currentPage > $this->pageTotal){
               $currentPage = $this->pageTotal;
           }
       } else {
           $currentPage = 1;
       }
       $this->currentPage = $currentPage;
   }
   
   public function getHtml(){
       $links = null;
       $limits = $this->limits();
       $html = '<ul class="pagination" >';
       for($page = $limits['start']; $page <= $limits['end']; ++$page){
           if($page == $this->currentPage){
               $links .= "<li class='active'><a href='#'>" . $page . "</a></li>";
           } else {
               $links .= $this->generateReferenceHtml($page);
           }
       }
       
       //Utils::debug($limits['start']);
       //Creates references for the first and last pages
       if(!is_null($links)){
           if($this->currentPage > 1){
               $links = $this->generateReferenceHtml($this->currentPage - 1, "&lt") . $links;
               $links = $this->generateReferenceHtml(1, "<<") . $links;
           }
           
           if($this->currentPage < $this->pageTotal){
               $links .= $this->generateReferenceHtml($this->currentPage + 1, "&gt"); 
               $links .= $this->generateReferenceHtml($this->pageTotal, ">>"); 
           }
       }
       $html .= $links . "</ul>";
       return $html;
   }
   
   private function limits(){
       $start = $this->currentPage - ceil($this->maxPagesToShow / 2);
       
       $start = $start <= 0 ? 1 : $start;
       //Utils::debug($start);
       if($start + $this->maxPagesToShow <= $this->pageTotal){
           $end = $start + $this->maxPagesToShow - 1;
       } else {
           $end = $this->pageTotal;
           $start = $end - $this->maxPagesToShow;
           if($start <= 0){
               $start = 1;
           }
       }
       //echo "start = ".$start." end = ".$end;
       //Utils::debug(['start' => $start, 'end' => $end,'pageTotal' => $this->pageTotal]);
       return ['start' => $start, 'end' => $end];
   }
   
   private function generateReferenceHtml($page, $label = null){
       if(!$label){
           $label = $page;
       }
       $currentURI = filter_input(INPUT_SERVER, 'REQUEST_URI');       
       $currentURI = rtrim($currentURI, '/').'/';       
       $currentURI = preg_replace("~page-[0-9]+/~", '', $currentURI);
       $newUrl = $currentURI . $this->keyOfGet . $page;
       return "<li><a href='" . $newUrl. "'>" . $label . "</a></li>";
   }

}
