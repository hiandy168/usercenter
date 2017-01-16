<?php

/**
 * CLinkPager class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.web.widgets.pagers
 * @since 1.0
 */
class JumpLinkPager extends CLinkPager {

    public function init() {
        parent::init();
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run() {
        $this->registerClientScript();
        $buttons = $this->createPageButtons();
	    if (empty($buttons))
            return;
        echo $this->header;
        $thispage = isset($_GET['page'])?intval($_GET['page']):1;
        if($thispage>$this->getPageCount() ){
            $thispage = $this->getPageCount();
        }else if($thispage<=0){
            $thispage = 1;
        }
		$frist_button = '<li class="page_frist"> 共'.$this->getItemCount().'条记录';
		$buttons[] ='<li class="page_extend">输入页数 <input name="page" format="*N" size="3" id="jumppage"><input type="button" name="go" value="跳转"  data-url="'.$this->getPages()->createPageUrl($this->getController(),'99998').'" onclick="var jump_page=$(\'#jumppage\').val(); var url =$(this).attr(\'data-url\').replace(\'99999\',jump_page);window.location =url;">&nbsp;(第'.$thispage.'/'.$this->getPageCount().'页)当前'.$this->getPageSize().'条/页</li>';
		$buttons =array_merge(array($frist_button),$buttons);
        echo CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
        echo $this->footer;
    }



}
