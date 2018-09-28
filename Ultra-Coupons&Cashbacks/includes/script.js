jQuery(document).ready(function()
{
  jQuery(".store_save").on('click',function()
  {
	 //alert('store save');
	  name=jQuery("#merchant_name").val();
	  desc=jQuery("#merchant_desc").val();
	  logo=jQuery("#profile_image_id").val();
	   merchant_id=jQuery("#merchant_id").val();
	  
	   result=logo.split('logo/');
		 logo=result[1];
	   
	  if(name=='')
		  jQuery("#merchant_name").focus();
	  else
	  {
	  var data = {
       action: 'insert_stores',
	    merchant_id:merchant_id,
         merchant_name:name,
		 desc :desc,
		 logo :logo
       };
     
	//alert(logo);
	   jQuery.ajax(
	   {
		  type:"POST",
          url:the_ajax_script.ajaxurl,
          data:data,
        cache:false,
       error:function(data)
	   {
		   alert("error");
		   console.log(data);
	   },
       success:function(data)
	   {
		  
		 // alert(data);
		   //console.log(data);
		
			if(data=="exist")
			{
				jQuery("#merchant_response").html('<font color="red">Entered Merchant name is already exist. Use New Name</font>');
				setTimeout(function()
				{
					jQuery("#merchant_response").html('');
				},3000);
			}
			else
			{
				//alert('else part');
				window.location.href=data;
			}
	   }	   
	  });   
	  }
  });
  
  
  jQuery("#merchant_logo").on('change',function()
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
		
					jQuery(this).closest('form').find("#merchant_logo").val('');
				
				}
				else if(size >2e+6 )
					{
					
					jQuery("#file_response").html('<font color="red">File size should be lessthan 2mb</font>');
					setTimeout(function()
					{
						jQuery("#file_response").html('');
					},3000);
		
					jQuery(this).closest('form').find("#merchant_logo").val('');
					}
					else{
						
					formdata.append("upload_photo[]",upload_photo[0]);
					 //alert('proceed');
					 
					formdata.append("action",'merchant_logo_upload'); 
					 
					 jQuery.ajax({
          type:'POST',
		     url: the_ajax_script.ajaxurl,
          data:formdata,
		  contentType:false,
		  processData:false,
        cache:false,
          success: function(value) {
			//  alert('sucess : '+value);
			 
			 jQuery("#profile_image_id").val(value);
				jQuery("#uploaded_profile_image").html('<div class="col-md-4"><img src="'+value+'" class="img-responsive img-thumbnail" style="max-height: 100px; max-width: 100px;"></div>'); 
			 
			 
			 
            jQuery(this).html(value);
          }
        });
		 
					}
				
					 
		
		
	});
  
  

  
  
	jQuery(".merchantdelete").click(function(){
		id=jQuery(this).attr('alt');	
          //alert(id);		
		var data = {
				action: 'dynamic_merchant_delete',
				'merchant_id':id
			};
		jQuery.post(the_ajax_script.ajaxurl, data, function(response) {	
         		
				//alert('response  '+response);
			 if(response=="ok"){
				jQuery("#merchant_"+id).remove();
				
			} 
		});  
		
  }); 
    //if initial check box clicked then check all the check boxes
	jQuery(".checkbox_all").click(function()
	{
			
		 jQuery('.check_box').attr('checked', this.checked);
		 jQuery('.checkbox_all').attr('checked', this.checked);
	
	});
	//if all the checkboxes checked then check check_all checkbox
	
	 jQuery(".check_box").click(function(){
 
        if(jQuery(".check_box").length == jQuery(".check_box:checked").length) {
            jQuery(".checkbox_all").attr("checked", "checked");
        } else {
            jQuery(".checkbox_all").removeAttr("checked");
        }
 
    });
  
  
  //bulk actionn
   jQuery("#apply").on('click',function()
   {
	   
	 action_name=jQuery("#bulck_select").val();
	 
	 check=false;
	   if(jQuery(".checkbox_all").prop('checked')==true)
		  check=true;
	     else
		 {
			jQuery(".checkbox_all").attr('checked','checked')
			jQuery(".check_box").attr('checked','checked')
		 }
		 
	 
	   var data = {
				action: 'dynamic_bulk_action',
				name:action_name
			};
		jQuery.post(the_ajax_script.ajaxurl, data, function(response) {	
         		
				//alert('response  '+response);
				 
			   if(response=="ok"){
				jQuery("#table_items tbody tr").remove();
			   }
				else
				{
					jQuery("#bulk_res").html('<font color="red">'+response+'</font>');
					setTimeout(function()
					{
					jQuery("#bulk_res").html('');	
					},3000);
				}
		});    
	  
   });
   //filter option 
   
  jQuery("#filter").on('click',function()
  {
	 
	  action_name=jQuery("#bulck_filter").val();
	  //alert(name);
	    var data = {
				action: 'dynamic_bulk_filter',
				name:action_name
			};
		jQuery.post(the_ajax_script.ajaxurl, data, function(response) {	
         		
				//alert('response  '+response);
				 //console.log(response);
			   if(response)
				{
					jQuery("#bulk_res").html('<font color="red">'+response+'</font>');
					setTimeout(function()
					{
					jQuery("#bulk_res").html('');	
					},3000);
				}
		});    
	  
	  
	  
	  
  });
  
  //add category details
 
  jQuery(".category_save").on('click',function()
  {
	  
	//alert('category save');
	  category_id=jQuery("#category_id").val();
	 // alert(category_id);
	  category=jQuery("#category").val();
	  category_desc=jQuery("#description").val();
	  
	  sub=jQuery('input[name=sub_cat]:checked').val();
	    // alert(sub);
	 
	  if(category==''||category==null)
		  jQuery("#category").focus();
	  else if(!sub)
	  {
		 jQuery("#sub").show();
	  }
	  else
	  {
		
			 jQuery("#sub").remove();  

	  var data = {
       action: 'insert_category',
	   category_id:category_id,
	    category:category,  
		 desc :category_desc,
		 sub:sub
       };
     
	//alert(data);
	    jQuery.ajax(
	   {
		  type:"POST",
          url:the_ajax_script.ajaxurl,
          data:data,
        cache:false,
       error:function(data)
	   {
		    alert("error");
		   console.log(data);
	   },
       success:function(data)
	   {
		  
		//  alert(data);
		 // console.log(data);
		 // t=jQuery.trim(data);
		 // alert('after rim '+t);
		   console.log(data);
		   
	
               var result=data.split('|');
		
			  var sub_cat=data.split('_divide_');
			  console.log('cat_block  = '+sub_cat[0]);
				console.log('sub1_cat  '+sub_cat[1]);
		      if(result[0]=='inserted')
			    {    
			        
                    jQuery("#response").html('<font color="red">Your Data Saved</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},5000); 
					
					window.location.href=result[1];
					
		        }
				else if(data=='exist')
				{
					alert('exist blog');
					 jQuery("#response").html('<font color="red">'+category+ ' is Exist. please add some other category.</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},3000); 
					
					
				}
				
			   if(sub_cat[1])
				{
					
					jQuery("#response").html('<font color="red">Your Data Saved</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},3000); 
					
				//	jQuery("#category_block_id").html(sub_cat[0]);
					//jQuery("#category_block_id").append(sub_cat[1]);
					jQuery("#cat_head").html(sub_cat[0]);
					jQuery("#cat_block").html(sub_cat[1]);
					
					//jQuery("#sub1_head").html(sub_cat[0]);
					//jQuery("#sub1_id").html(sub_cat[1]);
				} 
			    	
				
			  } 
	   	   
	  });    
	  }  
	    
  });
  
 //sub category1 save sub_category1_save
 jQuery(document).on('click',".sub_category1_save",function()
 {
	 //alert('subcat');
	  category=jQuery("#sub1_category").val();
	  category_desc=jQuery("#sub1_description").val();
	  last_cat_id=jQuery("#cat_id").val();
	  sub=jQuery('input[name=sub1_cat]:checked').val();
	     
	 
	  if(category==''||category==null)
		  jQuery("#sub1_category").focus();
	  else if(!sub)
	  {
		 jQuery("#sub").show();
	  }
	  else
	  {
		   jQuery("#sub").remove();  

		 // alert('proceed');
		  //console.log('Proceed');
		   var data = {
       action: 'insert_sub1_category',
	    category:category,  
		 desc :category_desc,
		 last_cat_id:last_cat_id,
		 sub:sub
       };
     
	//alert(data);
	   jQuery.ajax(
	   {
		  type:"POST",
          url:the_ajax_script.ajaxurl,
          data:data,
        cache:false,
       error:function(data)
	   {
		    alert("error");
		   console.log(data);
	   },
       success:function(data)
	   {
		  
	//  alert(data);
		 // console.log(data);	  
		      var result=data.split('|');			 
			 // console.log('result  '+result);		  
			  var sub_cat=data.split('-divide-');
			  console.log('sub cat '+sub_cat);
		      if(result[0]=='inserted')
			    {    
					//window.location.href=result[1];	
					jQuery("#response").html('<font color="red">Your Data Saved</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},3000);
		        }
				else if(data=='exist')
				{				
					jQuery("#response").html('<font color="red">'+category+ ' is Exist. please add some other category.</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},3000);
					
				}
				
			 if(sub_cat[1])
				{
					//subcategory link 
					// alert('sub 2 category path');
					  var data={
						 action:'sub_cat2_form',
						 category_id:sub_cat[1],
						 sub1_id:sub_cat[2],
						 category:sub_cat[3]
					 };	 
					  jQuery.ajax({
						  
					type:"POST",
					  url:the_ajax_script.ajaxurl,
					  data:data,
					cache:false,
				   error:function(data)
				   {
						alert("error");
					   console.log(data);
				   },
				   success:function(data)
				   {
					  // alert(data);
					   //console.log(data);
					   
					   
					   result=data.split('-divide-');
					  console.log('result  '+result);
					  // console.log('result 0 = '+result[0]);
					   // console.log('result 1 = '+result[1]);
					   jQuery("#sub_head").html(result[0]);
					  jQuery("#sub_head").append(result[1]);
					   //jQuery("#sub2_id").html(result[1]);
				   }
					  });
	 
				}

	   }
	   });
		
			
	  }  
	 
	 
 });
  
 

  
jQuery(document).on('click',"#add_more_sub_cat",function()
 {
	// alert('add_sub_cat');
      
	 last1_id=jQuery(this).attr('data-id');  
      edit_id=jQuery(this).attr('edit_id');
	  cat_name=jQuery(this).attr('cat_name');
	  cat1_edit=jQuery(this).attr('cat1_edit');
	   // alert('cat_name '+cat_name);
		//alert('cat id'+last1_id);
	var data={
		 action:'add_more_sub1_category',
		  category_id:last1_id,
		  edit_id:edit_id,
		  cat_name:cat_name,
		  cat1_edit:cat1_edit
	};
	  jQuery.ajax(
	   {
		  type:"POST",
          url:the_ajax_script.ajaxurl,
          data:data,
        cache:false,
       error:function(data)
	   {
		   alert("error");
		   console.log(data);
	   },
       success:function(data)
	   {
		  
		 // alert(data);
		   console.log(data);
		   result=data.split('-divide-');
		  // alert(result[0]);
		   console.log('result '+result);
		   
		    if(result[0]=='start')
			{
				 jQuery("#cat_head").html(result[1]);
				 jQuery("#cat_block").html(result[3]);
			}
			else
			{
				//alert('else part');
				 // jQuery("#sub1_id").addClass('show');
				  jQuery("#cat_block").html(result[1]);
		  
	      } 
		   
	   }		  
	   }); 
	 
	
});
  
  //pass more sub cat data to controller
  
  jQuery(document).on('click',".sub_more_category1_save",function()
 {
	// alert('subcat');
	  category=jQuery("#sub1_category").val();
	  category_desc=jQuery("#sub1_description").val();
	  last_cat_id=jQuery("#cat_id").val();
	  sub=jQuery('input[name=sub1_cat]:checked').val();	
	   cat1_edit_val=jQuery("#cat1_edit_id").val();
	   if(cat1_edit_val=='cat1_edit')
		   cat1_edit_val='cat1_edit';
	  if(category==''||category==null)
		  jQuery("#sub1_category").focus();
	  else if(!sub)
	  {
		 jQuery("#sub").show();
	  }
	  else
	  {
		   jQuery("#sub").remove();  

		 // alert('proceed');
		  //console.log('Proceed');
		  
		  
		   var data = {
       action: 'insert_more_sub1_category',
	    category:category,  
		 desc :category_desc,
		 last_cat_id:last_cat_id,
		 sub:sub
       };
     
	//alert(data);
	   jQuery.ajax(
	   {
		  type:"POST",
          url:the_ajax_script.ajaxurl,
          data:data,
        cache:false,
       error:function(data)
	   {
		    alert("error");
		   console.log(data);
	   },
       success:function(data)
	    {
		  
		 // alert(data);
		 console.log(data);
		  
		  var result=data.split('|');	  
			  var sub_cat=data.split('-divide-');
		      if(result[0]=='inserted')
			    {    
					//window.location.href=result[1];	
					
					jQuery("#response").html('<font color="red">Your Data Saved</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},3000);
		        }
				else if(data=='exist')
				{
					jQuery("#response").html('<font color="red">'+category+ ' is Exist. please add some other category.</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},3000);
				}
			 if(sub_cat[1])
			 {
				 
				     var data={
						 action:'sub_cat2_form',
						 category_id:sub_cat[1],
						 sub1_id:sub_cat[2],
						 category:sub_cat[3],
						 cat1_edit:cat1_edit_val
						 
					 };
					 
					  jQuery.ajax({
						  
					type:"POST",
					  url:the_ajax_script.ajaxurl,
					  data:data,
					cache:false,
				   error:function(data)
				   {
						alert("error");
					   console.log(data);
				   },
				   success:function(data)
				   {
					 // alert(data);
					   //console.log(data);
					   
					   
					   result=data.split('-divide-');
					  console.log('result  '+result);
					  // console.log('result 0 = '+result[0]);
					   // console.log('result 1 = '+result[1]);
					   jQuery("#sub_head").html(result[0]);
					    jQuery("#sub_head").append(result[1]);
					   //jQuery("#sub2_id").html(result[1]);
				   }
					  });			 
				   
				}
		   
	    }
	   });
		
			
	  }  
	 
	 
 });
  
  
  
  //collect data for initail sub2 category
  jQuery(document).on('click',".sub2_cat_save_data",function()
  {
	 // alert('sub2_cat_save_data');
	  
	var cat_id=jQuery("#cat_id").val();
	var sub1_id=jQuery("#sub1_cat_id").val();
	 var sub1_name=jQuery("#sub1_name").val();
	var sub2_name=jQuery("#sub2_category").val();
	var sub2_desc=jQuery("#sub2_description").val();
	// form_data=jQuery("#form_data").serialize();
	// alert('from '+form_data);
	 
	   if(sub2_name==''||sub2_name==null)
		  jQuery("#sub2_category").focus();
	  else
	  {
		//alert('proceed');
		var data={
			  action:'insert_sub_cat2',
			   cat_id:cat_id,
			   sub1_id:sub1_id,
			   sub1_name:sub1_name,
			   sub2_name:sub2_name,
			   sub2_desc:sub2_desc
			   
		  };
		 // alert(data);
		   console.log('data '+data);
	  jQuery.ajax(
	    {
		  type:"POST",
          url:the_ajax_script.ajaxurl,
          data:data,
        cache:false,
       error:function(data)
	    {
		    alert("error");
		   console.log(data);
	   },
       success:function(data)
	    {
		 // console.log(data);
		  
		   var result=data.split('|');	  
		      if(result[0]=='inserted')
			    {    
					//window.location.href=result[1];	
					jQuery("#response1").html('<font color="red">Your Data Saved</font>');
					setTimeout(function()
					{
						jQuery("#response1").html('');
					},3000);
		        }
				else if(data=='exist')
				{
					jQuery("#response1").html('<font color="red">'+sub2_name+ ' is Exist. please add some other category.</font>');
					setTimeout(function()
					{
						jQuery("#response1").html('');
					},3000);
				}
		  
		}
	   });
		
	  }
	  
  });
  
  jQuery(document).on('click',"#add_more_sub2_cat",function()
  {
	 // alert('add more sub2 category');
	  cat_id=jQuery(this).attr('data-id');
	  last_sub1_id=jQuery(this).attr('data-sub1-id');
	  sub1_name=jQuery(this).attr('data-subname');
	    append=jQuery("#append").val();
		cat1_edit_val=jQuery(this).attr('cat1_edit');
		//alert(append);
	    var data={
			action:'sub_cat2_form',
			category_id:cat_id,
			sub1_id:last_sub1_id,
			 category:sub1_name,
			 
		};
	  
	      jQuery.ajax({
						  
					type:"POST",
					  url:the_ajax_script.ajaxurl,
					  data:data,
					cache:false,
				   error:function(data)
				   {
						alert("error");
					   console.log(data);
				   },
				   success:function(data)
				   {
					 // alert(data);
					  // console.log(data);
					   
					   
					   result=data.split('-divide-');
					  console.log('result  '+result);
					   console.log('result 0 = '+result[0]);
					    console.log('result 1 = '+result[1]);
					  
					 
					  if(append=='append')
					  {
						 // alert('insert');
					   jQuery("#sub_head").html(result[0]);
					   jQuery("#sub_head").append(result[1]); 
					  
					  //jQuery("#sub2_id").html(result[1]);
					   jQuery("#add_more_sub2_cat").hide();
					  }
					  else
					  {
						  // alert('edit');
						jQuery("#sub_head").html(result[0]);
	                       jQuery("#sub_head").append(result[1]); 
				      }
				   }
					  });			
	  
  });
   //cancel buuton
  jQuery(document).on('click',"#sub_cancel_btn",function()
  {
	  //alert('cancel btn');
	  url=jQuery(this).attr('data-id');
	  window.location.href=url;
	    
  });
  //sub2 cancel button
  jQuery(document).on('click',"#sub2_cancel_btn",function()
  {
	  
	    jQuery("#sub_head").html('');
	    jQuery("#sub2_id").html('');
		
  });
  
  //delete category details
  jQuery(".categorydelete").click(function(){
	  //alert('category delete');
		id=jQuery(this).attr('alt');	
        // alert(id);		
		 var data = {
				action: 'category_delete',
				'category_id':id
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
  
  //update subcategory1 info
  jQuery(document).on('click',".sub_category1_update",function()
 {
	// alert('subcat update');
	  category=jQuery("#category").val();
	  category_desc=jQuery("#description").val();
	  last_cat_id=jQuery("#last_cat_id").val();
	  sub=jQuery('input[name=sub_cat]:checked').val();
	   sub_1_id=jQuery("#sub1_id").val();  
	 // alert(sub_1_id);
	
	  if(category==''||category==null)
		  jQuery("#category").focus();
	  else if(!sub)
	  {
		 jQuery("#sub").show();
	  }
	  else
	  {
		   jQuery("#sub").remove();  
		 // alert('proceed');
		 
		   var data = {
       action: 'insert_sub1_category',
	    category:category,  
		 desc :category_desc,
		 last_cat_id:last_cat_id,
		 subcat_1_id:sub_1_id,
		 sub:sub
       };
     
	
	   jQuery.ajax(
	   {
		  type:"POST",
          url:the_ajax_script.ajaxurl,
          data:data,
        cache:false,
       error:function(data)
	   {
		    alert("error");
		   console.log(data);
	   },
       success:function(data)
	   {  
	 // alert(data);
		//  console.log(data);	  
		      var result=data.split('|');			 
			 // console.log('result  '+result);		  
			  var sub_cat=data.split('-divide-');
			  console.log('sub cat '+sub_cat);
		      if(result[0]=='inserted')
			    {    
					//window.location.href=result[1];	
					jQuery("#response").html('<font color="red">Your Data Saved</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},3000);
		        }
				else if(data=='exist')
				{				
					jQuery("#response").html('<font color="red">'+category+ ' is Exist. please add some other category.</font>');
					setTimeout(function()
					{
						jQuery("#response").html('');
					},3000);
					
				}
				
			 if(sub_cat[1])
				{
					//subcategory link 
					 //alert('sub 2 category path');
					 console.log('sub cat val '+sub_cat);
					 var data={
						 action:'sub_cat2_form',
						 category_id:sub_cat[1],
						 sub1_id:sub_cat[2],
						 category:sub_cat[3]
					 };
					 
					 
					  jQuery.ajax({
						  
					type:"POST",
					  url:the_ajax_script.ajaxurl,
					  data:data,
					cache:false,
				   error:function(data)
				   {
						alert("error");
					   console.log(data);
				   },
				   success:function(data)
				   {
					 // alert(data);
					 //  console.log('updtae appenmd '+data);
					   
					   
					   result=data.split('-divide-');
					  console.log('result  '+result);
					   console.log('result 0 = '+result[0]);
					    console.log('result 1 = '+result[1]);
					   jQuery("#sub_head").html(result[0]);
					    jQuery("#sub_head").append(result[1]);
					   //jQuery("#sub2_id").html(result[1]);
				   }
					  });
					 
					 
					 
					 
					 
					 
					 
				}
		  
		   
	   }
	   });
		
			
	  }  
	 
	 
 });
  
 //load subcat2 while edit subcat 1 detals
  jQuery(document).on('click',"#add_sub2_cat_by_sub1",function()
  {
	 // alert('add more sub2 category');
	  cat_id=jQuery(this).attr('data-id');
	  last_sub1_id=jQuery(this).attr('data-sub1-id');
	  sub1_name=jQuery(this).attr('data-subname');
	  
	  append='append';
	 // alert(append);
	    var data={
			action:'sub_cat2_form',
			category_id:cat_id,
			sub1_id:last_sub1_id,
			 category:sub1_name,
			 append:append
		};
	  
	      jQuery.ajax({
						  
					type:"POST",
					  url:the_ajax_script.ajaxurl,
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
					 //  console.log(data);
					   
					   
					   result=data.split('-divide-');
					  console.log('result  '+result);
					   console.log('result 0 = '+result[0]);
					    console.log('result 1 = '+result[1]);
						
						
						
						 jQuery("#sub_head").html(result[0]);
					      jQuery("#sub_head").append(result[1]);	
                     
					  
					   
				   }
					  });			
	  
  });
  
  
   //delete sub1 category details
  jQuery(".sub1_delete").click(function(){
		id=jQuery(this).attr('sub1_id');	
         // alert(id);		
		 var data = {
				action: 'subcat1_delete',
				'category_id':id
			};
		jQuery.post(the_ajax_script.ajaxurl, data, function(response) {	
         		
			//	alert('response  '+response);
			  result=response.split('|');
			     if(result[0]=='ok')
					 window.location.href=result[1];
		});  
		 
  }); 
  //update sub category 2 details
  jQuery(document).on('click',".sub_category2_update",function()
  {
	  cat_id=jQuery("#cat_id").val();
	  sub1_id=jQuery("#sub1_id").val();
	  category=jQuery("#category").val();
	   desc=jQuery("#description").val();
	   sub2_id=jQuery("#sub2_id").val();
	   var data={
		   'action':'insert_sub_cat2',
		    'cat_id':cat_id,
			'sub1_id':sub1_id,
			'sub2_name':category,
			'sub2_desc':desc,
			'sub2_id':sub2_id
			
	   };
	   
	  
	   jQuery.ajax({
		   type:'POST',
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
			  // console.log(data);
			   result=data.split('|');
			   if(result[0]=='updated')
				   window.location.href=result[1];
			   else if(data=='exist')
			   {
				   jQuery("#response").html('<font color="red">'+category +'is Exist please use some other name</font>');
				   setTimeout(function()
				   {
					   jQuery("#response").html('');  
				   },3000);
			   }
			   else
			   {
				  // alert('updation failed');
				   jQuery("#response").html('<font color="red">Updation failed. Please Try Again</font>');
				   setTimeout(function()
				   {
					   jQuery("#response").html('');  
				   },3000);
			   }
			   
		   }
	   });
  });
  
  //delete category 2 details
  jQuery(".cat2_delete").click(function(){
		id=jQuery(this).attr('cat_id');	
          //alert(id);		
		 var data = {
				action: 'subcategory_2_delete',
				'category_id':id
			};
		jQuery.post(the_ajax_script.ajaxurl, data, function(response) {	
         		
				//alert('response  '+response);
			  result=response.split('|');
			     if(result[0]=='ok')
					 window.location.href=result[1];
		});  
		 
  }); 
});