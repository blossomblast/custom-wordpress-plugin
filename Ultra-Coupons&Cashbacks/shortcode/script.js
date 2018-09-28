//alert("script");
jQuery(document).ready(function()
 {
	 //alert('hai');
	  
		jQuery(".copy_class").on("click",function()
		{
			alert('copy class');
			merchant_id=jQuery(this).attr('merchant_id');
			coupon_id=jQuery(this).attr('coupon_id');
			//ajaxurl=jQuery(this).attr('ajax_url');
			//alert('coupon id'+coupon_id);
			var data={
				action:'confirmation_form',
				merchant_id:merchant_id,
				coupon_id:coupon_id
				};
				jQuery.ajax({
					type:"POST",
					 url: myAjax.ajaxurl,
					 data:data,
					 cache:false,
					 error:function(data)
					 {
						 alert("error");
						 console.log(data);
					 },
					 success:function(data)
					 {
						 //alert(data);
						 console.log(data);
						
						 /* jQuery("#myModal_"+coupon_id).html(data);
						  jQuery("#myModal_"+coupon_id).modal(); */
						  jQuery("body").append('<div id="myModal_'+coupon_id+'" class="modal fade" role="dialog"></div>');
						   jQuery("#myModal_"+coupon_id).html(data);
						  jQuery("#myModal_"+coupon_id).modal();
					 }
				});
		});
		
		
		jQuery(".image_coupon").on("click",function()
		{
			merchant_id=jQuery(this).attr('merchant_id');
			coupon_id=jQuery(this).attr('coupon_id');
			
			var data={
				action:'confirmation_image_modal',
				merchant_id:merchant_id,
				coupon_id:coupon_id
				};
				jQuery.ajax({
					type:"POST",
					 url: myAjax.ajaxurl,
					 data:data,
					 cache:false,
					 error:function(data)
					 {
						 alert("error");
						 console.log(data);
					 },
					 success:function(data)
					 {
						 //alert(data);
						 console.log(data);
						
						 jQuery("#myModal").html(data);
						 jQuery("#myModal").modal();
					 }
				});
		});
		
		
	});
	
	
	//copy code from input box
	
	
	function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("copy");
  jQuery("#copied").show();
  alert("Copied the text: " + copyText.value);
}

//my hide function
function myhideFunction() {
	var redirection=jQuery("#hide_code").val();
 new Clipboard('#hide_code_click');
  window.location.href=redirection;
}
