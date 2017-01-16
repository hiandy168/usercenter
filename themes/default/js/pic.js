// JavaScript Document
$(function(){
    
    $("a").bind('focus',function(){
       if(this.blur){ //���֧�� this.blur                        
          this.blur();
       };        
    });
    
    $('#slideshow').cycle({
        fx:     'scrollHorz',
        speed:       500,
        timeout:     4000,
        pager:      '#num',
        next:   '.banner .next',
        prev:   '.banner .prev ',
        pagerEvent: 'click',
		pauseOnPagerHover: true,
		before: function() { 
            $('.caption').html(this.title);
        }
    });
    
    // ����
	var nav = $('#SI_Nav');
	nav.on('mousemove', '.list',
	function() {
		var item = $(this);
		var list = item.find('dl');
		list.width(item.outerWidth());
		item.addClass('hover');
	});
	nav.on('mouseleave', '.list',
	function() {
		var item = $(this);
		item.removeClass('hover');
	});
	
	// ����
	// ���hover
	var body = $('body');
	var hoverClz = 'hover';
	var itemClz = '.mod-a .item';
	body.on('mouseover', itemClz,function() {
		$(this).addClass(hoverClz);
                $(this).find('.ft').show();
	});
	body.on('mouseout', itemClz,function() {
		$(this).removeClass(hoverClz);
                 $(this).find('.ft').hide();
	});


	var $navSliderBox = $("#nav-slider-wrap ol");
	var isFirst = true;
	$("#nav-slider-prev").click(function() {
		if (isFirst) {
			return;
		}
		$navSliderBox.animate({
			left: 0
		});
		isFirst = true;
	})
	$("#nav-slider-next").click(function() {
		if (!isFirst) {
			return;
		}
		$navSliderBox.animate({
			left: -792
		});
		isFirst = false;
	})
    
});

    
