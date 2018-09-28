<?php
               define ('COUPON_PLUGIN_URL', plugins_url() . '/Ultra-Coupons&Cashbacks');
            define ('COUPON_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins/Ultra-Coupons&Cashbacks');
				// Plugin path
			define( 'ULTRA_PROMOCODE_DIR', plugin_dir_path( __FILE__ ) );
		
		
            
			 add_action('init',  'include_media_coupon_css_js');
             add_shortcode('ultracoupon','get_coupon_display');
		add_filter('media_buttons_context', 'add_media_button');
				add_filter('media_upload_ultra_coupon',  'show_custom_coupon_page');
			
        
	
		function include_media_coupon_css_js()
		{
		     wp_register_script('bootstrapjs', plugins_url('assets/bootstrap/js/bootstrap.min.js', __FILE__), array('bootstrap'));
			    wp_register_style('bootstrapcss', plugins_url('assets/bootstrap/css/bootstrap.min.css', __FILE__));
				
				 wp_register_style('customcss', plugins_url('assets/css/custom.css', __FILE__));
		  if(is_admin())
			{
              wp_enqueue_script('bootstrapjs');
				wp_enqueue_style('bootstrapcss');
                wp_enqueue_style('customcss');
			}

		}
		function get_coupon_display($atts)
        {
		
			
            return ultrapromo_get_coupon_content($atts, "shortcode");
        }
		
function ultrapromo_get_coupon_content($atts, $action = "code")
   {
	   //print_r($atts);
	 //  echo "*********************  atts ".$atts;
    $coupon = ultrapromo_get_coupon($atts['name']);
	$exclude = (!empty($atts['exclude'])) ? array_map('trim', explode(',', $atts['exclude'])) : array();
	
    if(!empty($exclude) && in_array('rss', $exclude) && is_feed())
    {
        return;
    }
    
    if ($coupon)
    {
        if ($action == "shortcode")
        {
			echo "short code";
            ob_start();
        }
        ?>
    	<?php
			$random = rand();
        	$cdate = ($coupon->edate != '0000-00-00') ? new DateTime($coupon->edate) : '';
        ?>
		<style>
		  .row_block
          {
		   background-color:pink;
		    padding-top:20px;
              padding-left:20px;
              padding-bottom:20px;
			  border:1px solid black;
		  }
		</style>
		
    <div class="row coupon_box row_block">
	     <?php 
	/* 	print_r($exclude);
		   echo "<br> name : ".$coupon->name."<br>";
		   echo "des :  ".$coupon->description."<br>";
		  
		   
			echo "Coupon code : ".$coupon->codein."<br>";
			echo "Coupon link :  ".$coupon->link."<br>";
			echo "coupon message : ".$coupon->message."<br>";
			 echo "Expiration :  ";
			if(in_array('expiration', $exclude))
			{
				
				echo ($cdate instanceof DateTime) ?  $cdate->format("d-M-Y") : 'Never Expires';
			}
			echo "<br><br><br>"; */
		 ?>
		 <div class="col-md-3">
		 
		    <img src="<?php echo COUPON_PLUGIN_URL.'/images/products/img3.png'  ?>" width="60px" height="70px" class="img-responsive img-rounded" />
		 </div>
		 <div class="col-md-5">
		<?php if(!in_array('name', $exclude)):?>
			<span class="coupon_name"><h2 align="center"><?php echo stripslashes($coupon->name);?></h2></span>
		<?php endif;?>  
		    
		
		<?php if(!in_array('description', $exclude)):?>
			<div class="coupon_description"><p><?php echo stripslashes($coupon->description);?></p></div>
		<?php endif;?>
		<?php if(!in_array('expiration', $exclude)):?>
			<div class="coupon_date"><span>Expires: </span><span><?php echo ($cdate instanceof DateTime) ?  $cdate->format("m/d/Y") : 'Never Expires';?></span></div>
		<?php endif;?>
		
		
				<?php if(date('Y-m-d', current_time('timestamp', 0)) > $coupon->edate AND !empty($coupon->message)):?>
			<div class="coupon_message">
				<?php echo stripslashes($coupon->message);?>
			</div>
		<?php endif;?>
		
			</div>
			<div class="col-md-4">
			
			<?php
			if($coupon->codein)
			{
			?>
        <div id="coupon-container-<?php echo $coupon->id;?>-<?php echo $random;?>" class="coupon_container">
            <div unselectable="on" onselectstart="return false;" ondragstart="return false;"  id="coupon-<?php echo $coupon->id;?>-<?php echo $random;?>"  class="coupon" href="http://<?php echo str_replace('http://', '', $coupon->link);?>" target="_blank">
				<span><?php echo stripslashes($coupon->codein);?></span>
				<div class="hover-message">
					Click To Open/Copy
				</div>
			</div>
        </div> 
          <?php
			}
			$coupon->codein=0;
			?>		
		</br>
		
            <a class="btn btn-primary"  id="coupon-<?php echo $coupon->id;?>-<?php echo $random;?>"  class="coupon" href="http://<?php echo str_replace('http://', '', $coupon->link);?>" target="_blank">Get Deal</a>
    </div>
	</div>
    <?php

        if ($action == "shortcode")
        {
            $result = ob_get_contents();
            ob_end_clean();
            return $result;
        }
    }
	
}
		
		
		function ultrapromo_get_coupon($name)
{
    global $wpdb;
    $coupon_table = $wpdb->prefix . 'ultra_coupon';
    $sql = "SELECT * FROM $coupon_table WHERE name='%s'";
    $row = $wpdb->get_row($wpdb->prepare($sql, trim($name)));
	
    if ($row AND $row->sdate <= date('Y-m-d', current_time('timestamp', 0)) AND (!empty($row->message) OR ($row->edate == '0000-00-00' OR date('Y-m-d', current_time('timestamp', 0)) <= $row->edate ) ))
    {
        return $row;
    } else
    {
        return "";
    }
}
		
	function add_media_button($context)
		{
			$button = "<a href='" . esc_url( get_upload_iframe_src('ultra_coupon') ) . "' id='add_ultra_coupon' class='thickbox' title='Add A Coupon'><img src='" . esc_url( plugins_url('../images/coupon32.png', __FILE__) ) . "' alt='Add A Coupon' width='50px' height='25px' onclick='return false;' />Ultra Coupon</a>";		
			return $context.$button;
		}
		function show_custom_coupon_page()
		{
			
			global $wpdb;
			
			$table=$wpdb->prefix."coupon_type";
			$query="SELECT * FROM $table";
			$result=$wpdb->get_results($query);
   			$sql = "SELECT 
						* 
					FROM 
						".$wpdb->prefix."ultra_promocode 
					WHERE 
						coupon_end_date = '0000-00-00' OR coupon_end_date >= '".date('Y-m-d', current_time('timestamp', 0))."'";
    		
			$rows = $wpdb->get_results($sql);
			
 			//wp_admin_css( 'global', TRUE);
 			wp_admin_css( 'wp-admin', TRUE);
 			wp_admin_css( 'media', TRUE);
  			wp_admin_css( 'colors' , TRUE);
?>
		<script type="text/javascript">
		function changeCoupon()
		{
			//alert('change coupon');
			 var e = document.getElementById("coupon_type_id").value;
			// alert('coupon type id  '+e);
			  document.getElementById("coupons").innerHTML = "You selected: " + e;
			  document.form.check.value=e;
//alert(document.form.check.value)

document.form.submit();
		  
			  
			  
		}
		
		function coupon_nameFunction()
		{
			
			var e = document.getElementById("coupon_type_id").value;
			// alert('coupon type id  '+e);
			//  document.getElementById("coupons").innerHTML = "You selected: " + e;
			  document.form.check.value=e;
//alert(document.form.check.value)

document.form.submit();
			
			
			var e=document.getElementById("coupon_name_id").value;
			//alert('coupon id '+e);
			//document.getElementById("coupon_title").innerHTML="You selected "+e;
			document.form1.coupon.value=e;
			alert(document.form1.coupon.value);
			document.form1.submit();
			
		}
		
		
		function sub(){
			alert('sub');
document.form.check.value="yes"
alert(document.form.check.value);
document.form.submit();
}



		
	/* 	
		var changeCoupon=
		{
			change:function()
			{
				//alert('change');
				f = document.forms[0];
                 val=f.coupon_type.value;
                     alert('value '+val);	
               
			   
			   var e = document.getElementById("coupon_type_id");
               var strUser = e.options[e.selectedIndex].value;
			   
                  	   
			 
                  alert('val 1 by document '+strUser);				
			}
		}
		 */
		var addULTRAPromo={	
			insert : function() {
				//alert('insert function');
					f = document.forms[0];
					
					  var coupon_id = document.getElementById("coupon_id").value;
               
					
					
				if(coupon_id == '' || coupon_id == 'undefined')
				{
				return;
				}
					else
					{
			
			//alert(coupon_id);
			html='[upc';
			   
			  var exclude='';
  
  
                  var x = document.getElementById("product_heading").checked;
				  //alert(x);
				  if(x==true)
					  exclude +=document.getElementById("product_heading").value+",";
				   var x = document.getElementById("coupon_des").checked;
				  if(x==true)
					  exclude +=document.getElementById("coupon_des").value+",";
				  
				   var x = document.getElementById("discount").checked;
				  if(x==true)
					  exclude +=document.getElementById("discount").value+",";
				  
				   var x = document.getElementById("deal_expiration").checked;
				  if(x==true)
					  exclude +=document.getElementById("deal_expiration").value+",";
				  
				   var x = document.getElementById("expiration").checked;
				  if(x==true)
					  exclude +=document.getElementById("expiration").value+",";
				  
				   var x = document.getElementById("all_info").checked;
				  if(x==true)
				  {
					  exclude='';
					  exclude +=":"+coupon_id;
					  html +=  exclude;	
				  }
				  else
				  {
					//   alert(exclude);
					//console.log('checked value is '+exclude);
					var result=exclude.split(',');
					html +=":"+coupon_id+"_";
					  if(exclude.charAt(exclude.length - 1, 1) == ",")
							exclude = exclude.substring(0, exclude.length - 1);	
							
						html += ' exclude=' + exclude + '';	
					
					console.log('result  '+result);
				  }
				  
				
					/* if(exclude != '')
					{	
						
					}
					 	 */	
						 
					html += '] ';
					
					var win = window.dialogArguments || opener || parent || top;
					
					alert(html);
					win.send_to_editor(html);
			
					}
			}
		}
		
			
		</script>
		<style>
			label {
				color:#777;
			}
			
			form {
				padding:0 15px;
			}
			
			form div {
				margin:0 0 15px;
			}
			
			form div div {
				margin:7px 0 0;
			}
			
			body, html {
				overflow:hidden;
			}
			
			.button {
				margin-top:15px;
			}
		</style>
		
		
		<h3 class="media-title">Add A Coupon</h3>
		  <form action="" method="post" name="form">
		  
					
         <input type="hidden" name="check">					
			 
			     <input type="hidden" id="hidden-input" name="my-hidden-input">
				<span id="coupons"></span>
				
		  </form>
		  
		  <?php
		   $var=$_POST['check'];
		  ?>
		  
		
		<div>
				<label>Select Coupon Type</label>
				<div>
					<select class="input" name="coupon_type" onchange="changeCoupon()" id="coupon_type_id">
					
					
					 <option value="" disabled selected>Select Your Coupon Type</option>
						<?php
						
		  
						foreach($result as $r1)
						{
							echo "<option value='".$r1->type_id."'";
							
							   if(($var)&&$var==$r1->type_id )
								   echo "selected";
                        echo ">
								   ".ucfirst($r1->coupon)."
							     </option>";
						}
						?>
					</select>
				</div>
			</div>
		  
		  
		  
		  <form action="" method="POST" name="form1">
				
				  <input type="hidden" name="coupon">					
			 
			     <input type="hidden" id="hidden-input" name="my-hidden-input">
                   <div id="coupon_title"></div> 
			
			</form>
		  
		  
		  
		    
			<div>
				<label>Select Coupon To Add</label>
				<div>
					<select class="input" name="coupon_name" id="coupon_name_id" onchange="coupon_nameFunction()">
		               <option value="" disabled Selected>Choose your coupon </option>
		                <?php
						
			   $var=$_POST['check'];
			   $coupon_id=$_POST['coupon'];
		    if($var)
		      {
			
			    //echo "if part type id ".$var;
			  $table_name=$wpdb->prefix."ultra_promocode";
			  
			     $sql="SELECT * FROM $table_name
   			             WHERE 
			 coupon_end_date = '0000-00-00' OR coupon_end_date >= '".date('Y-m-d', current_time('timestamp', 0))."'  AND type_id=$var";
			   $result1=$wpdb->get_results($sql);
			  
			
			  foreach($result1 as $r1)
						{
							echo "<option value='".$r1->coupon_id."'";
							
							   if(($coupon_id)&&$coupon_id==$r1->coupon_id )
								   echo "selected";
                        echo ">
								   ".ucfirst($r1->coupon_title)."
							     </option>";
						}
         
			  }
			  else
			  {
				 // echo "   Else part ";
				  foreach($rows as $r1)
						{
							echo "<option value='".$r1->coupon_id."'";
							
							   if(($coupon_id)&&$coupon_id==$r1->coupon_id )
								   echo "selected";
                        echo ">
								   ".ucfirst($r1->coupon_title)."
							     </option>";
						}
         
				  
				  
			  }
				?>
				</select>
                    </div>
			</div>	
				
				
				<form name="coupon_form">
				
				
				
			<div>
				<label>Which Coupon Sections Would You Like To Exclude:</label>
				<div>
				
					<input type="checkbox"  id="product_heading" value="name" name="name" /> Coupon Name <br/>  
					<input type="checkbox" value="des" id="coupon_des" name="description"  /> Coupon Description <br/>
				
				
					  <?php
				
				$coupon_id=$_POST['coupon'];
	
				 echo "<input type='hidden' name='coupon_id'  id='coupon_id' value=$coupon_id />";
				if($coupon_id)
				{	
			$table_name=$wpdb->prefix."ultra_promocode";

			        $sql="SELECT * FROM  $table_name WHERE coupon_id=$coupon_id";
                     $result2=$wpdb->get_results($sql);
				
					 foreach($result2 as $r1)
					 {
					 }
					//print_r($r1);
						 if($r1->type_id==1 ||$r1->type_id==2)
						 {
							echo '<input type="checkbox"  id="discount" value="dt" name="discount" /> Discount<br/>
					<input type="checkbox"  value="de" id="deal_expiration" name="deal_expiration"  /> Coupon/Deal expiration <br/>
					<input type="checkbox" id="expiration" value="e" name="expiration" /> Coupon/Deal Expiration Date<br/>';
							  
						 }
				  
				}
				
					?>
					
					
					<input type="checkbox"  id="all_info" value="all" name="rss" /> Entire Coupon For RSS Feeds
					
				</div>
			</div>	
				
                 <div>
			<!-- <input type="button" class="button" id="go_button" onclick="addULTRACoupon.insert()" value="Insert Into Post" />   -->
				<input type="button" class="button" id="go_button" onclick="addULTRAPromo.insert()" value="Insert Into Post" />  
			</div>
				
					
					
				
			
		</form>	
	
<?php
		}
		  ?>