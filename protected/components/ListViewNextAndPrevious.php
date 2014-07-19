<?php
Yii::import('web.widgets.pagers.CLinkPager');
class ListViewNextAndPrevious extends CLinkPager{
    /**
 * Creates the page buttons.
 * @return array a list of page buttons (in HTML code).
 */

protected function createPageButtons()
{
    if(($pageCount=$this->getPageCount())<=1)
        return array();

    list($beginPage,$endPage)=$this->getPageRange();
    $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
    $buttons=array();

    // first page
    $buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,$currentPage<=0,false);

    // prev page
    if(($page=$currentPage-1)<0)
        $page=0;
    $buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);

    /* 
             * !!! change has been made here !!!
             */
    $buttons[]='<li>Page '.$this->getCurrentPage(false).' of '.$this->getPageCount().'</li>';

    // next page
    if(($page=$currentPage+1)>=$pageCount-1)
        $page=$pageCount-1;
    $buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

    // last page
    $buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$currentPage>=$pageCount-1,false);

    return $buttons;
}
}
?>