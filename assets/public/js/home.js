$(document).ready(function(){
   
        var tr=document.getElementsByTagName('tr'); 
        for(var i=0,j=0;i<tr.length;i++) { 
            j++; 
            tr[i].className=j%2==0?'':'tr2'; 
        } 
  
    $('#verify_image').click(
            function(){
            $('#verify_image').attr('src',Siteurl+'/member/verify_image?'+ Math.random());
            $('#capt_login_admin').focus();
            return false;
            }
    );

     $('#refresh').click(
            function(){
               top.location.reload();
               return false;
            }
    );
    
});


function checkall(obj,itemName){
        var aa = document.getElementsByName(itemName);
        for (var i=0; i<aa.length; i++){
         aa[i].checked = obj.checked;
        }
        
        var all = document.getElementsByName('idAll');
         for (var i=0; i<all.length; i++){
         all[i].checked = obj.checked;
        }
        
} 

function checkall2(obj,itemName){
        var aa = document.getElementsByName(itemName);
        for (var i=0; i<aa.length; i++){
         aa[i].checked = obj.checked;
        }  
} 




function changeLeft(tid,obj){
	var new_url = admin_url+'/'+$(obj).attr('ref');
        set_center(new_url);
	getleft_menu(tid,obj);
	$(".nav_m li").removeClass('active');
	$(obj).addClass('active');
}

//左边菜单点击
function set_position(obj){
    var $position ='您当前的位置：';
    $position += "<span>"+$(obj).parent().parent().find('span').eq(1).html()+"</span> > ";
    $position += "<span>"+$(obj).find('span').eq(0).html()+"</span>";
    $('#position .position_title').html($position);
}

//顶部菜单
function set_position_main(obj,ref){
    var $position ='您当前的位置：';
    $position += "<span>"+$(obj).find('span').eq(0).html()+"</span> > ";
    $position += "<span>"+$('#left_nav').find('li[ref='+ref+']').html()+"</span>";
    $('#position .position_title').html($position);
}

   
function AddFavorite(sURL, sTitle)
{
    try
    {
        window.external.addFavorite(sURL, sTitle);
    }
    catch (e)
    {
        try
        {
            window.sidebar.addPanel(sTitle, sURL, "");
        }
        catch (e)
        {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}


function SetHome(obj,vrl){
        try{
                obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl='http://www.9open.net');
        }
        catch(e){
                if(window.netscape) {
                        try {
                                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                        }
                        catch (e) {
                                alert("请先开启firefox设为主页功能！\n在浏览器地址栏输入“about:config”后回车\n将signed.applets.codebase_principal_support的值设置为'true',双击改变。");
                        }
                        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                        prefs.setCharPref('browser.startup.homepage',vrl);
                 }
        }
}




function getleft_menu(type,obj){
        $.ajax({
            type: "post",
            url: admin_url+"/main/ajax_menu",
            data:{type:type},
            dataType:'html',
            beforeSend: function(XMLHttpRequest){},
            success: function(data, textStatus){
                $('#left_nav').html(data);
                set_position_main(obj,$(obj).attr('ref'));
                //var new_url = admin_url+$('#left_nav ul li:eq(0)').attr('ref')
                //var default_url =admin_url+'notice';
                //if( (parent.document.getElementById("center").src != new_url && new_url == default_url ) ||   new_url != parent.document.getElementById("center").src ){
                //    set_center(new_url);
                //}
            },
//            complete: function(XMLHttpRequest, textStatus){},
            error: function(){}
        });
        
}
function set_center(url){
    document.getElementById("center").src=url;
}

function del(url,id){ 
 if(confirm("确定要删除数据吗？")){
     submit_id(url,id);
 }
}

    
    

function submit_id(url,id){
        $.ajax({
            type: "post",
            url: url+'?'+ Math.random(),
            data:{id:id},
            dataType:'json',
            beforeSend: function(){
                   parent.ship_mess('loading.......',3000,0,820);
            },
            success: function(data){
               if(data.state){
                   parent.ship_mess_big(data.mess,3000,0,820);
                   document.location.reload(); 
               }else{
                   parent.ship_mess_big(data.mess,3000,0,820);
               }
            },
            error: function(){
                  parent.ship_mess_big('error',3000,0,820);
            }
        });
        
}

function submit_bat(url){
        var id_obj = $('#ListFrm').find("input[name='id[]']:checked");
        var id=new Array();
        id_obj.each(function(i,obj){
            id.push($(obj).val());
        });
         var id_str=id.join(",");
        $.ajax({
            type: "post",
            url: url+'?'+ Math.random(),
            data:{id:id_str},
            dataType:'json',
            beforeSend: function(){
                  parent.ship_mess('loading.......',3000,0,820);
            },
           success: function(data){
               if(data.state){
                   parent.ship_mess_big(data.mess,3000,0,820);
                   document.location.reload(); 
               }else{
                   parent.ship_mess_big(data.mess,3000,0,820);
               }
            },
            error: function(){
                  parent.ship_mess_big('error',3000,0,820);
            }
        });
        
}




function submitorder(url){
        var order_obj = $('#ListFrm').find("input[name='order[]']");
        var id=new Array();
        var order=new Array();
        order_obj.each(function(i,obj){
            order.push($(obj).val());
            id.push($(obj).attr('ref'));
        });
         var id_str=id.join(",");
         var order_str=order.join(",");
//        alert(id_str);alert(order_str);
        $.ajax({
            type: "post",
            url: url+'?'+ Math.random(),
            data:{id:id_str,order:order_str},
            dataType:'json',
            beforeSend: function(){
                   parent.ship_mess('loading.......',3000,0,820);
            },
            success: function(data){
               if(data.state){
                   parent.ship_mess(data.mess,3000,0,820);
                   document.location.reload(); 
               }else{
                   parent.ship_mess(data.mess,3000,0,820);
               }
            },
            error: function(){
                  parent.ship_mess('error',3000,0,820);
            }
        });
        
}

function upload_file(obj,name){
	var editor = KindEditor.editor({
		fileManagerJson:admin_url+"/files/file_manager",
		uploadJson:admin_url+'/files/upload',
		allowFileManager : true
	});
	editor.loadPlugin('insertfile', function() {
		editor.plugin.fileDialog({
			fileUrl : KindEditor('#'+obj).val(),
			clickFn : function(url,title) {
				if($.trim(title)==url){
					title='';
				}
				newurl = url.substr(url.indexOf("data"));
				$('#'+obj).val(newurl);
				if(name!=''){
					$('#'+name).val(title);
				}
				editor.hideDialog();
			}
		});
	});
}

function upload_pic(obj,name){
	var editor = KindEditor.editor({
		fileManagerJson:admin_url+"/files/file_manager",
		uploadJson:admin_url+'/files/upload',
		allowFileManager : true,
                formatUploadUrl :false
	});
	editor.loadPlugin('image', function() {
		editor.plugin.imageDialog({
			imageUrl : KindEditor('#'+obj).val(),
				clickFn : function(url) {
                                    $('#'+obj).attr('src',url);
                                    url = url.substr(url.indexOf("data"));
                                    $('#'+name).val(url);
                                    editor.hideDialog();
				}
			});
	});
}

function upload_pic_bat(){
	var editor = KindEditor.editor({
		fileManagerJson:admin_url+"/files/file_manager",
		uploadJson:admin_url+'/files/upload?id='+id+'&token='+token+'&lang='+lang,
		allowFileManager : true,
                formatUploadUrl :false
	});
        editor.loadPlugin('multiimage', function() {
            editor.plugin.multiImageDialog({
                clickFn: function(urlList) {
                    var div = $('#pics ul');
                    $.each(urlList, function(i, data) {
                        div.append('<li><input type=\'hidden\' value=\"'+data.url+'\" name=\'newpic['+i+'][pics]\'><div class=\'img\'><img src=\"'+site_url+'/'+data.url+'\" id=\"img1\" ></div><div class=\"del\">没有提交</div> <div class=\"order\"><span>排序：</span><input type=\'text\' value=\"99\" name=\'newpic['+i+'][order]\'></div><div class=\"text\"><span>描述：</span><textarea  name=\'newpic['+i+'][title]\' ></textarea></div></li>');
                    });
                    editor.hideDialog();
                }
            });
        });             
}




function ship_mess($mess){
    var time = arguments[1]?arguments[1]:3000  ;//默认3秒
    var top  = arguments[2]?arguments[2]:0  ;
    var left = arguments[3]?arguments[3]:0  ;
    $("#ship_mess").remove();
    //8B0000 B22222  A52A2A
    $(document.body).append('<div id="ship_mess" style="color:#ffffff;font-weight:bold;font-size:12px;border-bottom-left-radius:8px;border-bottom-right-radius: 8px;background:#8B0000;padding:9px 50px 8px 50px;z-index:9999;position:fixed;left:'+left+'px;top:'+top+'px;">'+$mess+'</div>');
    $("#ship_mess").fadeOut(parseInt(time)); 
}     


function ship_mess_big($mess){
    var time = arguments[1]?arguments[1]:3000  ;//默认3秒
    var top  = arguments[2]?arguments[2]:40  ;
    var left = arguments[3]?arguments[3]:50  ;
    $("#ship_mess").remove();
    //8B0000 B22222  A52A2A
       //8B0000 B22222  A52A2A
    $(document.body).append('<div id="ship_mess" style="display:none;color:#ffffff;font-weight:bold;font-size:12px;border-radius:8px;background:#8B0000;padding:15px 50px 14px 50px;z-index:9999;position:fixed;left:'+left+'%;top:'+top+'%;">'+$mess+'</div>');
    var width = $("#ship_mess").width(); 
    wdith =width+parseInt(100);
    $("#ship_mess").css('margin-left','-'+wdith/2+'px');
    $("#ship_mess").css('display','block');
    $("#ship_mess").fadeOut(parseInt(time)); 
}     

function openwindow(url,name,iWidth,iHeight){
var url;                                 //转向网页的地址;
var name;                           //网页名称，可为空;
var iWidth = arguments[2]?arguments[2]:'510';                           //弹出窗口的宽度;
var iHeight= arguments[3]?arguments[3]:'600';                          //弹出窗口的高度;
var iTop = (window.screen.availHeight-30-iHeight)/2;       //获得窗口的垂直位置;
var iLeft = (window.screen.availWidth-10-iWidth)/2;           //获得窗口的水平位置;
window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=yes,resizeable=no,location=no,status=no');
}

function showimg($url){
        if($url.indexOf("http") ==0){
            return $url;
        }else{
            return site_url+'/'+$url;
        }
}


$(document).ready(function(){
    $('#verify_image').click(
            function(){
            $('#verify_image').attr('src','/member/verify_image?'+ Math.random());
            $('#verify').focus();
            return false;
            }
    );
    $('#comment_verify_image').click(
            function(){
            $('#comment_verify_image').attr('src',baseurl +'/comment/verify_image?'+ Math.random());
            $('#comment_verify').focus();
            return false;
            }
    );
});



    


$(".tabs li").click(function() {
    var thisparent = $(this).parent('ul').parent('.tabs');
    thisparent.find('li').removeClass('active');
    $(this).addClass('active');
    thisparent.find('.tabscon').hide();
    thisparent.find('.tabscon:eq(' + thisparent.find('li').index(this) + ')').show();
});
	

$('.gaoguan').delegate('a.reduceGg','click',function(){    $(this).parents('.ggdiv').remove();})


$("#addGg").click(function () {
    var html =  '<div class="ggdiv fl "  style="position:relative;margin:0 0 10px 0">';
        html +=            '<div>';
        html +=               '<input class="ggxm" type="text" name="company_leaders[name][]" placeholder="请填写姓名"></input>';
        html +=               '<input class="ggxm" type="text" name="company_leaders[position][]" placeholder="请填写姓名"></input>';
        html +=               '<span class="commom" style="position:absolute;top:0px;left:370px;">';
        html +=               ' <a class="reduceGg">(点击 -进行删除))</a>';
        html +=             ' </span>';
        html +=         '</div>';
        html +=         '<div>';
        html +=         '<textarea class=""   name="company_leaders[remark][]" id="" placeholder="过往经历，如：教育背景、曾就职信息等"></textarea>';
        html +=         '</div><div class="cl"></div> ';
        html +=     '</div>';
    $(".ggdiv:last").after(html);
    return false;
});
    
    

$("#go-top").bind("click",function() {
        $("html, body").animate({
                scrollTop: 0
        },300);
});
	
$(".input").hover(function() {
        if ($(this).hasClass("focus")) {
                return;
        }
        $(this).addClass("inputH");
        $(this).stop().css("border-color", "#D4D4D4").animate({
                "borderColor": "#0099CC"
        },
        200,
        function() {
                $(this).css("borderColor", "#0099CC");
        });
},function() {
        if ($(this).hasClass("focus")) {
                return;
        }
        $(this).removeClass("inputH");
        $(this).stop().animate({
                "borderColor": "#D4D4D4"
        },
        200,
        function() {
                $(this).css("borderColor", "");
        });
});



