<?php echo $this->renderpartial('/common/header1', $config); ?>

<div class="div-main">

    <div class="user-jf-nav clearfix user-tips-navc">
        <ul>
            <li  id="allmessage">
                <a href="javascript:;" >
                    <p><?php echo count($all_list)?></p>
                    <p>全部消息</p>
                </a>
            </li>
            <li id="nomessage" class="selected">
                <a href="javascript:;"  >
                    <p><?php echo count($list)?></p>
                    <p>未读消息</p>
                </a>
            </li>
        </ul>
    </div>


    <div class="user-jf-list" id="all">
        <ul>
            <?php if(!empty($all_list) && is_array($all_list)){ foreach ($all_list as $key=>$val){?>

            <li <?php if(Message::model()->message_read($val->pid,$this->member['id'],$val->id)){?>style="background: #ccc" <?php }?> >
                <a href="javascript:;" onclick="read(<?php echo $val->id?>,'<?php echo $val->url?>')">
                <div class="user-jf-listdiv user-jf-listdivc1">
	    	    	  <span>
	    	    	  	<i><?php echo date('Y-m-d H:i:s',$val->datetime) ?></i>
	    	    	  	<p><?php echo $val->title?></p>
	    	    	  </span>
                    <em><?php echo $val->result?></em>
                </div>
                    </a>
            </li>
            <?php }}else{ ?>
                <div class="nodata-div">
                    <span><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/nodata-img-info.png"/></span>
                    <p>暂时没有消息</p>
                </div>
            <?php }?>
        </ul>

    </div>

    <div class="user-jf-list" id="no" style="display: none">
        <ul>

            <?php if(!empty($list)){ foreach ($list as $key=>$val){?>
                <li>
                    <a href="javascript:;" onclick="read(<?php echo $val->id?>,'<?php echo $val->url?>')">
                        <div class="user-jf-listdiv user-jf-listdivc1">
	    	    	  <span>
	    	    	  	<i><?php echo date('Y-m-d H:i:s',$val->datetime) ?></i>
	    	    	  	<p><?php echo $val->title?></p>
	    	    	  </span>
                            <em><?php echo $val->result?></em>
                        </div>
                    </a>
                </li>
            <?php }}else{ ?>
                <div class="nodata-div">
                    <span><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/nodata-img-info.png"/></span>

                    <p>暂时没有未读消息</p>
                </div>
            <?php }?>
        </ul>

    </div>


</div>



</body>
</html>
<script>

    $("#allmessage").click(function(){
        $("#all").show();
        $("#no").hide();
        $(this).removeClass("selected");
        $("#nomessage").addClass("selected");
    })
    $("#nomessage").click(function(){
        $("#no").show();
        $("#all").hide();
        $(this).removeClass("selected");
        $("#allmessage").addClass("selected");
    })
    function read(id,url){
        $.ajax({
            type: "get",
            url: "<?php echo $this->createUrl('/h5/member/message');?>",
            data:{
                "id": id,
            },
            success: function(msg){
                 // alert(msg);
                location.href= url;
            }


        });
        //alert(url);



    }

</script>
