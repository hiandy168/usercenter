<?php

class CoLinkPager extends CLinkPager
{
	public function init()
	{
            parent::init();
            		
	}
        
        protected function createPageButtons()
	{
            if(($pageCount=$this->getPageCount())<=1)
                    return array();

            list($beginPage,$endPage)=$this->getPageRange();
            $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
            $buttons=array();

            // first page
            $buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);


            // internal pages
            for($i=$beginPage;$i<=$endPage;++$i)
                    $buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);


            // last page
            $buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

            return $buttons;
	}	
}
