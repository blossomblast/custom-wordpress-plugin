
//coupon script
jQuery(document).ready(function()
{
  jQuery("#coupon_form").validate(
  {
	  rules:
	  {  
	     /*  coupon_heading:
		  {
			  required:true 
		  },			  
     	  merchant:
		   {
			required:true  
		   },
		   category:
		   {
			   required:true
		   },
		   subcategory:
		   {
			   required:"#subcategory:visible"
		   },
		   subcategory_2:
		   {
			   required:"#subcategory_2:visible"
		   },
            coupon_type:
		   {
			   required:true
		   },
		   coupon_code:
		   {
			   required:"#coupon_code:visible"
		   },
		   deal_button:
		   {
			   required:"#deal_button:visible"
		   },
		   coupon_link:
		   {
			   required:"#coupon_link:visible"
		   },
		    coupon_expiration:
		   {
			   required:"#coupon_expire_id:visible"
		   }, 
		   coupon_end:
		   {
			   required:"#coupon_end:visible"
		   },
		   hide_coupon:
		   {
			   required:"#coupon_hide_id:visible"
		   },
		    image_coupon_type:
		   {
			   required:"#image_coupon_id:visible"
		   }, 
		   coupon_image:
		   {
			   required:"#coupon_image:visible"
		   },
		   iframe_image:
		   {
			   required:"#iframe_image:visible"
		   } */		   
		  
	  },
	  messages:
	  {
		/* image_coupon_type:
		   {
			   required:function()
			   {
				   jQuery("#uploaded_profile_image").html("<font color='red'>Please Choose your image coupon format</font>	");
				   setTimeout(function()
				   {
					   jQuery("#uploaded_profile_image").html('');
				   },3000);
			   }
			    
		   },
		    coupon_expiration:
		   {
			   required:function()
			   {
				   jQuery("#expire_err").html("<font color='red'>Choose wheather Coupon Expiration date should display ?</font>	");
				    setTimeout(function()
				   {
					   jQuery("#expire_err").html('');
				   },3000);
			   }
		   },
         	hide_coupon:
		   {
			   required:function()
			   {
			    jQuery("#uploaded_profile_image").html("<font color='red'>Choose wheather Coupon Code should display ?</font>	");
				    setTimeout(function()
				   {
					   jQuery("#uploaded_profile_image").html('');
				   },3000);
			   }
		   }	 */
	  },
	  submitHandler:function()
	  {
		  alert('coupon form'); 
		 coupon_heading=jQuery("#coupon_heading").val();
         merchant=jQuery("#merchant").val();
         category=jQuery("#category").val();
		 subcategory=jQuery("#subcategory").val();
		 subcategory_2=jQuery("#subcategory_2").val();
		 coupon_type=jQuery("#coupon_type").val();
		 coupon_code=jQuery("#coupon_code").val();
		 deal_button=jQuery("#deal_button").val();
		 coupon_link=jQuery("#coupon_link").val();
		 discount=jQuery("#discount").val();
		 description=jQuery("#description").val();
		 expiration=jQuery("input[name='coupon_expiration']:checked").val();
		 coupon_start=jQuery("#coupon_start").val();
		 coupon_end=jQuery("#coupon_end").val();
		 hide_coupon=jQuery("input[name='hide_coupon']:checked").val();
		 image_coupon_type=jQuery("input[name='image_coupon_type']:checked").val();
		 coupon_image=jQuery("#profile_image_id").val();
		 iframe_image=jQuery("#iframe_image").val();
		 result=coupon_image.split('logo/');
		 filename=result[1];
		 
		 coupon_id=jQuery("#coupon_id").val();
		// alert(coupon_id)
		// alert('image coupon type, image  deal value '+image_coupon_type+"  "+filename+" "+deal_button);
		
		 var data={
			 action:'insert_coupon_details',
			 coupon_heading:coupon_heading,
			 merchant_id:merchant,
			 category_id:category,
			 subcategory_id:subcategory,
			 subcategory_2_id:subcategory_2,
			 coupon_type_id:coupon_type,
			 coupon_code:coupon_code,
			 deal_button:deal_button,
			 coupon_link:coupon_link,
			 discount:discount,
			 description:description,
			 expiration_id:expiration,
			 coupon_start:coupon_start,
			 coupon_end:coupon_end,
			 hide_coupon_id:hide_coupon,
			 image_coupon_type_id:image_coupon_type,
			 coupon_image:filename,
			 iframe_image:iframe_image,
             coupon_id:coupon_id			 
		 };
		 console.log('data in console ='+data);
		  jQuery.ajax({
			 type:"POST",
			 url:the_ajax_script.ajaxurl,
			 data:data,
			 cache:false,
			 error:function(data)
			 {
				 alert('error');
				 console.log(data);
			 },
			 success:function(data)
			 {
				// alert(data);
				 console.log(data);
				 
				 result=data.split('|');
				 console.log('result '+result);
				 if(result[0]=='inserted')
				 {
		      //	alert('inserted');
					window.location.href=result[1];
				 }
				 else if(data=='exist')
				 {
					jQuery("#coupon_form_response").html('<font color="red">This Link From The Merchant is exist.</font>'); 
					setTimeout(function()
					{
						jQuery("#coupon_form_response").html('');
					},3000);
				 }
				 else
				 {
					// alert('else part');
					 jQuery("#coupon_form_response").html(data); 
				 }
			 }
			 
		 }); 
       		
		  
	  }
  });


//category on change

jQuery(document).on('change',"#category",function()
{
	//alert('category on change');
	val=jQuery("#category").val();
	//alert(val);
	 var data={
		action:'category_on_change',
		category_id:val
	 };
	 jQuery.post(the_ajax_script.ajaxurl, data, function(response) {	
         		
				//alert('response  '+response);
				result=response.split('|');
				console.log(response);
				
				if(result[1]=='empty')
						jQuery("#sub1_id").hide();
			      else
				  {
					  jQuery("#sub1_id").show();
					  	jQuery("#subcategory").html(result[1]);
				  }
			
			 
		});  
	 
});

//Sub category on change

jQuery(document).on('change',"#subcategory",function()
{
	//alert('category on change');
	val=jQuery("#category").val();
	sub_val=jQuery("#subcategory").val();
	//alert(val);
	 var data={
		action:'subcategory_on_change',
		category_id:val,
		subcat_id:sub_val
	 };
	 jQuery.post(the_ajax_script.ajaxurl, data, function(response) {	
         		
				//alert('response  '+response);
				result=response.split('|');
				console.log(response);
				
				if(result[1]=='empty')
						jQuery("#sub2_id").hide();
			      else
				  {
					  jQuery("#sub2_id").show();
					  	jQuery("#subcategory_2").html(result[1]);
				  }
			
			 
		});  
	 
});


//image on change
 jQuery(document).on('change',"#coupon_image",function()
	{	
	//alert('onchangbe');
	var upload_photo = jQuery(this)[0].files;
	//alert(upload_photo);
	console.log(upload_photo);
	var error='';
	var name = upload_photo[0].name;
   var size=upload_photo[0].size;

       var formdata=new FormData();
				var extension = name.split('.').pop().toLowerCase();
				//alert(extension);
				if ( jQuery.inArray( extension , ['gif','png','jpg','jpeg'] ) == -1 )
				{
					error += 'Unsupported format ' + extension + "  "+"only jpg,png files are accepted";
				
					  jQuery("#file_response").html('<font color="red">'+error+'</font>');
					setTimeout(function()
					{
						  jQuery("#file_response").html('');
					},3000);
		
					jQuery(this).closest('form').find("#merchant_logo_upload").val('');
				
				}
				else if(size >2e+6 )
					{
					
					jQuery("#file_response").html('<font color="red">File size should be lessthan 2mb</font>');
					setTimeout(function()
					{
						jQuery("#file_response").html('');
					},3000);
		
					jQuery(this).closest('form').find("#merchant_logo_upload").val('');
					}
					else{
						
					formdata.append("upload_photo[]",upload_photo[0]);
					// alert('proceed');
					 
					formdata.append("action",'merchant_logo_upload'); 
					 
				 	 jQuery.ajax({
          type:'POST',
		     url: the_ajax_script.ajaxurl,
          data:formdata,
		  contentType:false,
		  processData:false,
        cache:false,
          success: function(value) {
			 // alert('sucess : '+value);
			 
			 jQuery("#profile_image_id").val(value);
				jQuery("#uploaded_profile_image").html('<div class="col-md-4"><img src="'+value+'" class="img-responsive img-thumbnail" style="max-height: 200px; max-width: 200px;"></div>'); 
			 
			 
			 
            jQuery(this).html(value);
          }
        });
		  
					}
				
					 
		
		
	});
  
  //based on coupon type show details
  jQuery("#coupon_type").on('change',function()
  {
	  type=jQuery("#coupon_type").val();
	 // alert('type change  '+type);
	  if(type==1)
	  {
		  jQuery("#coupon_code_id").show();
		   jQuery("#discount_id").show();
		  jQuery("#description_id").show();
		  jQuery("#coupon_expire_id").show();
		  jQuery("#coupon_start_id").show();
		  jQuery("#coupon_end_id").show();
		  jQuery("#coupon_hide_id").show();
		   jQuery("#image_coupon_id").hide();
		  jQuery("#iframe_image_id").hide();
		  jQuery("#image_id").hide();
		  
	  }
	  else if(type==2)
	  { 
         jQuery("#coupon_code_id").hide();
		 jQuery("#link_id").show(); 
		  jQuery("#deal_button_id").show();
		  jQuery("#discount_id").show();
		  jQuery("#description_id").show();
		  jQuery("#coupon_expire_id").show();
		  jQuery("#coupon_start_id").show();
		  jQuery("#coupon_end_id").show();
		  jQuery("#coupon_hide_id").hide();
		  jQuery("#image_coupon_id").hide();
		  jQuery("#iframe_image_id").hide();
		  jQuery("#image_id").hide();
		  

	  }
	  else if(type==3)
	  {
		  jQuery("#image_coupon_id").show(); 
		   jQuery("#coupon_code_id").hide();
		   jQuery("#deal_button_id").hide();
		    jQuery("#discount_id").hide();
		  jQuery("#description_id").hide();
		  jQuery("#coupon_expire_id").hide();
		  jQuery("#coupon_start_id").hide();
		  jQuery("#coupon_end_id").hide();
		  jQuery("#coupon_hide_id").hide();
		  jQuery("#link_id").hide(); 
		 
	  }
	  else
	  {
		  jQuery("#coupon_form_response").html('<font color="red">Error !! While loading Details</font>');
	  }
		  
  });
  
  //delete coupon details
  jQuery(".coupondelete").click(function(){
	 // alert('coupon delete');
		id=jQuery(this).attr('alt');	
        // alert(id);		
		 var data = {
				action: 'coupon_delete',
				'coupon_id':id
			};
		jQuery.post(the_ajax_script.ajaxurl, data, function(response) {	
         		//console.log(response);
			//	alert('response  '+response);
		        result=response.split('|');
				//alert(result);
			     if(result[0]=='ok')
					 window.location.href=result[1];
		
       }); 
  });

});