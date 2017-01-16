<?php echo $this->renderpartial('/common/header_new', $config); ?>
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/index_application_new.css">
<script src="<?php echo $this->_theme_url; ?>js/echarts/dist/echarts.js"></script>
<?php echo $this->renderpartial('/common/header_app',array ('project_list'=>$project_list,'view'=> $view,'config'=>$config)); ?>
    
	<!-- 页头结束 -->
    <section id="main-cont" class="clearfix">
        <!-- 左侧内容数据 -->
        <?php 
            $tab = $config['tab'];
            switch ($tab){
                case 'user':
                    echo $this->renderpartial('/common/main-con-user',array('config'=>$config,'user'=>$user));
                    break;
                case 'behavior':
                    echo $this->renderpartial('/common/main-con-behavior',array('config'=>$config,'behavior'=>$behavior));
                    break;
                case 'points':
                    echo $this->renderpartial('/common/main-con-points',array('config'=>$config,'point'=>$point));
                    break;
                default:
                    echo $this->renderpartial('/common/main-con-visit',array('config'=>$config,'visit'=>$visit));   
                break;
            }
        ?>
        <!-- 左侧内容数据end -->
        <!--右侧内容区-->
        <?php echo $this->renderpartial('/common/main-con-right');?>
        <!--右侧内容区end-->
    </section>
    





    </div>
</div></div></div></div>

<?php echo $this->renderpartial('/common/footer', $config); ?>
