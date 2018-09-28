  //media buuton
  jQuery(document).ready(function()
  {
	 //alert('haiii');
	  
   jQuery(document).on('change',"#coupon_type",function()
	{
		alert('on change');
	}); 
	jQuery(document).on("click","#coupon_test",function()
	{
		alert('test change');
	});
	jQuery(document).on("click","#coupon_type_test",function()
	{
		alert('coupoj type test  change');
	});
	
  });
