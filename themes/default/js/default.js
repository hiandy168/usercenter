// JavaScript Document
$(function()
{
	$('.search_txt').focus(function()
	{
		if($(this).val()==this.defaultValue)
		{
			$(this).val('')	
		}
	//defaultvalue:初始的Value值		
		
	}).blur(function()
	{
		if($(this).val()=='')
		{
		$(this).val(this.defaultValue)
		}
	})	
})
