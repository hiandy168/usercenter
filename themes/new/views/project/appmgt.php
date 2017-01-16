<?php echo $this->renderpartial('/common/header_new', $config); ?>
<?php //echo $this->renderpartial('/common/right_menu',array('id'=>$config['pid'])); ?>
<?php //echo $this->renderpartial('/common/main-con-tab',array('pid'=>$config['pid'],'tab'=>$config['tab']));?>




	<!-- 页头结束 -->
    <section id="main-cont" class="clearfix">
        <!-- 左侧内容数据 -->
        <?php 
            $tab = $config['tab'];
            switch ($tab){
                case 'user':
                    echo $this->renderpartial('/common/main-con-user',array('config'=>$config,'user'=>$user,'project_list'=>$project_list,"view"=>$view,"pid"=>$pid,'activity'=>$activity));
                    break;
                case 'behavior':
                    echo $this->renderpartial('/common/main-con-behavior',array('config'=>$config,'behavior'=>$behavior,'project_list'=>$project_list,"view"=>$view,"pid"=>$pid));
                    break;
                case 'points':
                    echo $this->renderpartial('/common/main-con-points',array('config'=>$config,'point'=>$point,'project_list'=>$project_list,"view"=>$view,"pid"=>$pid));
                    break;
                default:
                    echo $this->renderpartial('/common/main-con-visit',array('config'=>$config,'visit'=>$visit,'project_list'=>$project_list,"view"=>$view,"pid"=>$pid,'activity'=>$activity));
                break;
            }
        ?>
        <!-- 左侧内容数据end -->
        <!--右侧内容区-->
        
        <!--右侧内容区end-->
    </section>
    





    </div>
</div></div></div></div>

<?php echo $this->renderpartial('/common/footer', $config); ?>
