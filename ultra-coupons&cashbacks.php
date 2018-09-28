<?php
/*
  Plugin Name: Ultra Coupons & Cashbacks
  Description: Plugin for  Coupons and Discounts
  Version: 1.0.0
  Author: jayanthi
  Author URI: http://www.webnox.in/jayanthi/
  Author Email: jayanthi@webnox.in
  Text Domain: My-Coupon
 License: GPLv2 or later
 */
  
 defined('ABSPATH')or die('Hey,you cant access this plugin');
 if(!class_exists('Ultra_Coupon'))
 {
	 class Ultra_Coupon
	 {
		  var $coupon_table;
		  var $db_version = '2.0';
		  
		  function __construct()
           {
            $this->contactDefine();
            register_activation_hook(__FILE__, array($this, 'create_coupon_table'), 21);
            add_action('init', array($this, 'include_coupon_css_js'));
            add_action('admin_menu', array($this, 'create_coupon_option_menu'), 12);
            add_action('admin_init', array($this, 'create_coupon_table'));
			
			
			 add_action( "wp_ajax_nopriv_$action", array ( $this, 'logged_out' ) );
             add_action( "wp_ajax_$action",        array ( $this, 'logged_in' ) );
           add_action('admin_init', array($this, 'create_category'));
			 
           /*  add_shortcode('ultracoupon', array($this, 'get_coupon_display'));
			add_filter('media_buttons_context', array($this, 'add_media_button'));
			add_filter('media_upload_ultra_coupon', array($this, 'show_custom_coupon_page'));
			 */
			//add_filter( 'handle_bulk_actions-edit-post', 'my_bulk_action_handler', 10, 3 );
			
        }
		
		function logged_out()
		{
			
		}
		function logged_in()
		{
			
		}
		function create_category()
		{
		
		
		}
		function contactDefine()
        {
            define ('COUPON_PLUGIN_URL', plugins_url() . '/Ultra-Coupons&Cashbacks');
            define ('COUPON_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins/Ultra-Coupons&Cashbacks');
				// Plugin path
			define( 'ULTRA_PROMOCODE_DIR', plugin_dir_path( __FILE__ ) );
        }

        function create_coupon_table()
        {
				
            global $wpdb;
            $COUPON_TABLE = $wpdb->prefix . 'ultra_coupon';
		
            if ($this->db_version != get_option('ultra_coupon_db_version'))
            {
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				 // coupon table
			
                $query = "CREATE TABLE {$COUPON_TABLE} (
                             id bigint(20) unsigned NOT NULL auto_increment,
                             name varchar(50) NOT NULL default '',
                             sdate date NOT NULL default '0000-00-00',
                             edate date NOT NULL default '0000-00-00',
                             codein varchar(50) NOT NULL default '',
                             description longtext NOT NULL ,
                             link longtext NOT NULL default '',
                             message varchar(255) NOT NULL default '',
                             PRIMARY KEY  (id),
                             KEY name (name)
                         );";
				
				dbDelta($query);
				
				
				 $COUPON_TABLE1 = $wpdb->prefix . 'coupon_merchants';
				
				 $query1 = "CREATE TABLE {$COUPON_TABLE1}(
                            merchant_id bigint(20) unsigned NOT NULL auto_increment,
                             name varchar(100) NOT NULL default '',
							 description varchar(100) NOT NULL default '', 
							 logo varchar(255) NOT NULL default '',
							 total_offers int(50) NOT NULL default '0',
                             created_at date  NOT NULL default '0000-00-00',                          
                             PRIMARY KEY  (merchant_id)
                            
                         );";
				
		
			     	dbDelta($query1);
				
				
				  $COUPON_TABLE2 = $wpdb->prefix . 'coupon_category';
				
				 $query2 = "CREATE TABLE {$COUPON_TABLE2}(
                            category_id bigint(20) unsigned NOT NULL auto_increment,
							 category varchar(255) NOT NULL,
							 description varchar(100) NOT NULL default '', 
							 total_offers int(50) NOT NULL default '0',
							 sub_category bigint(100) NOT NULL ,
                             created_at date  NOT NULL default '0000-00-00',                          
                             PRIMARY KEY  (category_id)
                            
                         );";
				
		
			     	dbDelta($query2);
				
				
				
				update_option('ultra_coupon_db_version', $this->db_version);
				  
			}
			
        }

		 function include_coupon_css_js()
        {							   
		 	wp_register_style('plugin', plugins_url('css/plugin.css', __FILE__));
			wp_register_style('calendar', plugins_url('css/jscal2.css', __FILE__));
            wp_register_script('plugin', plugins_url('sc/plugin.js', __FILE__), array('jquery'));
            wp_register_script('calendar', plugins_url('sc/jscal2.js', __FILE__));
            wp_register_script('calendar_en', plugins_url('sc/en.js', __FILE__));
		wp_register_style('shortcode', plugins_url('css/shortcode.css', __FILE__));
            wp_register_script('zeroclipboard', plugins_url('sc/zeroclipboard/ZeroClipboard.js', __FILE__), array('jquery'));
            wp_register_script('zeroclipboard_ready', plugins_url('sc/zeroclipboard_ready.js', __FILE__)); 
		// wp_register_style('shortcode', plugins_url('css/shortcode.css', __FILE__));
            // wp_register_script('zeroclipboard', plugins_url('sc/zeroclipboard/ZeroClipboard.js', __FILE__), array('jquery'));
            // wp_register_script('zeroclipboard_ready', plugins_url('sc/zeroclipboard_ready.js', __FILE__));
		
			
			
            wp_register_script('ultra_script', plugins_url('includes/script.js', __FILE__), array('jquery'));
			 wp_register_script('validation', plugins_url('assets/jquery/jquery.validate.min.js', __FILE__), array('jquery'));
			  wp_register_style('jquery_datatable_style', plugins_url('assets/css/jquery.dataTables.min.css', __FILE__));
			   wp_register_script('jquery_datatable', plugins_url('assets/jquery/jquery.dataTables.min.js', __FILE__), array('jquery'));
               
			   wp_register_script('bootstrapjs', plugins_url('assets/bootstrap/js/bootstrap.min.js', __FILE__), array('bootstrap'));
			    wp_register_style('bootstrapcss', plugins_url('assets/bootstrap/css/bootstrap.min.css', __FILE__));
				//wp_register_script('ajaxjquerymin', plugins_url('assets/jquery/jquery.min.js', __FILE__), array('jquery'));
				 wp_register_style('customcss', plugins_url('assets/css/custom.css', __FILE__));

				  wp_register_style('fontawesome', plugins_url('assets/bootstrap/css/font-awesome.min.css', __FILE__));
            wp_localize_script( 'plugin', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );	
			    wp_register_script('coupon_script', plugins_url('includes/coupon_script.js', __FILE__), array('jquery'));
				 wp_register_script('bootstrap_datepicker', plugins_url('assets/js/bootstrap-datepicker.js', __FILE__), array('jquery'));
				  wp_register_style('bootstrap_datepicker_css', plugins_url('assets/css/datepicker.css', __FILE__));
				  
				  
				/* wp_register_style('customer_plugin', plugins_url('css/plugin.css', __FILE__));
			
            wp_register_script('customer_plugin', plugins_url('sc/plugin.js', __FILE__), array('jquery'));  
			*/
			wp_localize_script( 'customer_plugin', 'the_code_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); 
			
				
		  
			
			if(is_admin())
			{
				//echo "<br>"."  %%%%%%%%%%%%%%  yes admin "."<br>";
				wp_enqueue_style('calendar');
				wp_enqueue_script('calendar');
				wp_enqueue_script('calendar_en');
				 wp_enqueue_style('plugin');
				wp_enqueue_script('ultra_script');
				wp_enqueue_script('validation');
				wp_enqueue_script('jquery_datatable');
				wp_enqueue_style('jquery_datatable_style');
				//wp_enqueue_script('bootstrapjs');
				//wp_enqueue_style('bootstrapcss');
				//wp_enqueue_script('ajaxjquerymin');
				//wp_enqueue_style('plugin_ajax');
                wp_enqueue_style('customcss');
                wp_enqueue_style('fontawesome');	
                wp_enqueue_script('coupon_script');	
               wp_enqueue_script('bootstrap_datepicker');	
                wp_enqueue_style('bootstrap_datepicker_css'); 
				
		   }
			else
			{
				//echo "<br>"."  %%%%%%%%%%%%%%  not admin  "."<br>";
				
				wp_enqueue_style('shortcode');
				//wp_enqueue_script('zeroclipboard');
			
				// $data = array(
					// 'swfPath' => plugins_url('sc/zeroclipboard/ZeroClipboard.swf', __FILE__)
				// );
			
				// wp_localize_script('zeroclipboard_ready', 'ZCData', $data);
				// wp_enqueue_script('zeroclipboard_ready');
			} 
		//	wp_enqueue_script('customer_plugin');
			 wp_enqueue_script('plugin');
        }

        function create_coupon_option_menu()
        {
            global $wpdb;
            $this->coupon_table = $wpdb->prefix . 'ultra_coupon';
			
			
	add_menu_page(__('Ultra Coupons', 'my-coupon'), __('Ultra Coupons', 'myplugin'), 'administrator', 'my-coupon', array($this, 'able_coupon_setting'),'dashicons-store',50);
            add_submenu_page('my-coupon', __('Ultra Coupons','myplugin'), __('Ultra Coupons','myplugin'), 'administrator', 'my-coupon', Array($this,'able_coupon_setting'));
            add_submenu_page('my-coupon', __('Ultra Coupons', 'myplugin'), __('Add New Coupon', 'myplugin'), 'administrator', 'add_coupon', array($this, 'add_coupon_new'));
				 
			
			  add_submenu_page('my-coupon', __('Ultra Coupons', 'myplugin'), __('Merchants', 'myplugin'), 'administrator', 'coupon-store', array($this, 'add_coupon_store'));
			  
			    add_submenu_page('my-coupon', __('Ultra Coupons', 'myplugin'), __('Categories', 'myplugin'), 'administrator', 'coupon-category', array($this, 'add_new_category'));
				
				
				 
				  
				   add_submenu_page('my-coupon', __('Ultra Coupons', 'myplugin'), __('Vendors', 'myplugin'), 'administrator', 'add_vendor', array($this, 'add_vendor_info'));
				
				add_submenu_page('my-coupon', __('Ultra Coupons', 'myplugin'), __('Settings', 'myplugin'), 'administrator', 'settings', array($this, 'settings'));
	 
        }
		function add_coupon_store()
		{
			//echo "add new coupon  store";
			 global $wpdb;
			 $name=$_GET['id'];
			 
			 if($name=='add')
			 {
				// $id=$_POST['merchantid'];
				
				 include(COUPON_PLUGIN_DIR . "/includes/add_coupon_store.php"); 
			 }
			  else  // if name is empty execute below file
			  { 
            include(COUPON_PLUGIN_DIR . "/includes/merchants.php");
			  }
			   
			
		}
		function add_new_category()
		{	
	    
		 global $wpdb;
		  $name=$_GET['id'];
			 
			 if($name=='add_cat')
			 {
				// $id=$_POST['merchantid'];
				
				 include(COUPON_PLUGIN_DIR . "/includes/add_categories.php"); 
			 }
			  else  // if name is empty execute below file
			  { 
			include(COUPON_PLUGIN_DIR . "/includes/categories.php");
		    }
		}
		
		function add_coupon_new()
		{
			 global $wpdb;
			 
			  $table_name = $wpdb->prefix . "coupon_type";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'" ) != $table_name)
		    {
		     $sql= "CREATE TABLE $table_name(
                            type_id bigint(20) unsigned NOT NULL auto_increment,
							 coupon varchar(255) NOT NULL,
							 total_offers int(50) NOT NULL default '0',
                             created_at date  NOT NULL default '0000-00-00',                          
                             PRIMARY KEY  (type_id)
                            
                         );";
		   require_once (ABSPATH. 'wp-admin/includes/upgrade.php' );
		    dbDelta($sql); 	
			$created_time=date('Y-m-d');
			$query="INSERT INTO $table_name(coupon,total_offers,created_at)VALUES('coupon','0','$created_time'),
			                                  ('deal','0','$created_time'),
											   ('image','0','$created_time')";
											   
			$wpdb->query($query);								   

        			
		}
		 $table_name1 = $wpdb->prefix . "ultra_promocode";
		  if($wpdb->get_var("SHOW TABLES LIKE '$table_name1'" ) != $table_name1)
		   {
		     $sql= "CREATE TABLE $table_name1(
                            coupon_id bigint(20) unsigned NOT NULL auto_increment,
							type_id smallint(11) NOT NULL,
							coupon_title varchar(200) NOT NULL,
							merchant_id bigint(20) NOT NULL,
							category_id bigint(20) NOT NULL,
							subcat1_id bigint(20) NOT NULL,
							subcat2_id bigint(20) NOT NULL,
							coupon_code varchar(200) NOT NULL,
							link varchar(255) NOT NULL,			
							discount varchar(100) NOT NULL,
							product_description varchar(200) NOT NULL,
							coupondeal_expiration varchar(100) NOT NULL,
						    coupon_start_date date  NOT NULL default '0000-00-00', 
                            coupon_end_date date  NOT NULL default '0000-00-00', 
                            hide_coupon smallint(10) NOT NULL,							
                            deal_button_text varchar(200) NOT NULL,
							image_coupon_type smallint(10) NOT NULL, 
                            coupon_image varchar(255) NOT NULL,
                             iframe_tag text NOT NULL,
                             short_code varchar(200) NOT NULL,							 
                             created_at date  NOT NULL default '0000-00-00',                          
                             PRIMARY KEY  (coupon_id)
                            
                         );";
		   require_once (ABSPATH. 'wp-admin/includes/upgrade.php' );
		    dbDelta($sql);     			
		}
			
       	 $table_name2 = $wpdb->prefix . "image_coupon_type";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name2'" ) != $table_name2)
		{
		     $sql= "CREATE TABLE $table_name2(
                            image_type_id bigint(20) unsigned NOT NULL auto_increment,
							 category varchar(255) NOT NULL,
							 total_offers int(50) NOT NULL default '0',
                             created_at date  NOT NULL default '0000-00-00',                          
                             PRIMARY KEY  (image_type_id)
                            
                         );";
		   require_once (ABSPATH. 'wp-admin/includes/upgrade.php' );
		    dbDelta($sql); 	
			
			$created_time=date('Y-m-d');
			
			$query="INSERT INTO $table_name2(category,total_offers,created_at)VALUES('custom_upload','0','$created_time'),('iframe_tag','0','$created_time')";									 
											   
			$wpdb->query($query);								   

        			
		} 
			 
			 
			 include(COUPON_PLUGIN_DIR . "/includes/add_new_coupon.php");
			
		}
		function add_vendor_info()
		{
			echo "add Vendor modules";
		}
		function settings()
		{
			echo "Plugin Setting page";
		}
		
        function able_coupon_setting()
        {
           // $this->save_coupon_data();
           // include(COUPON_PLUGIN_DIR . "/php/coupon_list.php");
		   
		   
		   global $wpdb;
			
			 $name=$_GET['id'];
			 
			 if($name=='add_coupon')
			 {
				
				 include(COUPON_PLUGIN_DIR . "/includes/add_new_coupon.php"); 
			 }
			 else
			 {
			include(COUPON_PLUGIN_DIR . "/includes/all_coupons.php");
			 }
		   
        }


        function get_coupon_display($atts)
        {
            return ultracoupon_get_coupon_content($atts, "shortcode");
        }
		function add_media_button($context)
		{
			$button = "<a href='" . esc_url( get_upload_iframe_src('ultra_coupon') ) . "' id='add_ultra_coupon' class='thickbox' title='Add A Coupon'><img src='" . esc_url( plugins_url('images/coupon32.png', __FILE__) ) . "' alt='Add A Coupon' width='50px' height='25px' onclick='return false;' />Ultra Coupon</a>";		
			return $context.$button;
		}

		function show_custom_coupon_page()
		{
			global $wpdb;
			
   			$sql = "SELECT 
						* 
					FROM 
						".$wpdb->prefix."ultra_coupon 
					WHERE 
						edate = '0000-00-00' OR edate >= '".date('Y-m-d', current_time('timestamp', 0))."'";
    		
			$rows = $wpdb->get_results($sql);
			
 			wp_admin_css( 'global', TRUE);
 			wp_admin_css( 'wp-admin', TRUE);
 			wp_admin_css( 'media', TRUE);
  			wp_admin_css( 'colors' , TRUE);
?>
		<script type="text/javascript">
			var addULTRACoupon = {
				insert : function() {
					f = document.forms[0];
					
					if(f.coupon_name.value == '' || f.coupon_name == 'undefined')
						return;
					
					html = '[ultracoupon name="'+ f.coupon_name.value +'"';
					
					var exclude = '';
					
					if(f.name.checked)
						exclude += "name,";
						
					if(f.expiration.checked)
						exclude += "expiration,";
						
					if(f.description.checked)
						exclude += "description,";
                    
					if(f.rss.checked)
						exclude += "rss,";
					
					if(exclude != '')
					{	
						if(exclude.charAt(exclude.length - 1, 1) == ",")
							exclude = exclude.substring(0, exclude.length - 1);	
							
						html += ' exclude="' + exclude + '"';	
					}
							
					html += '] ';
					
					var win = window.dialogArguments || opener || parent || top;
					
					//alert(html);
					win.send_to_editor(html);
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
		<form>
			<h3 class="media-title">Add A Coupon</h3>
			<div>
				<label>Select Coupon To Add</label>
				<div>
					<select class="input" name="coupon_name">
						<?php foreach($rows as $r):?>
							<option value="<?php echo stripslashes($r->name);?>"><?php echo stripslashes($r->name);?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>	
			<div>
				<label>Which Coupon Sections Would You Like To Exclude:</label>
				<div>
					<input type="checkbox" value="1" name="name" /> Coupon Name <br/>
					<input type="checkbox" value="1" name="description"  /> Coupon Description <br/>
					<input type="checkbox" value="1" name="expiration" /> Coupon Expiration Date<br/>
					<input type="checkbox" value="1" name="rss" /> Entire Coupon For RSS Feeds
				</div>
			</div>	
			<div>
				<input type="button" class="button" id="go_button" onclick="addULTRACoupon.insert()" value="Insert Into Post" />
			</div>
		</form>			
<?php
		}

		
	 }
	 
	
	 
	 
	 
	 new Ultra_Coupon();
 }
 
 
 
 add_action('wp_ajax_merchant_logo_upload','merchant_logo_upload');
 
 function merchant_logo_upload()
 {
	
	 $target_dir =COUPON_PLUGIN_DIR."/uploads/logo/";
$target_file = $target_dir . basename($_FILES["upload_photo"]["name"][0]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($_FILES["upload_photo"]["name"][0])
{  

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

       }
	   else {


 $updatedFileName='';

       if (file_exists($target_dir. $_FILES["upload_photo"]["name"][0])) 
      {
	   $name_array = $_FILES["upload_photo"]["name"][0];
			
			$file_path = $target_dir;
			
			$file_path = $file_path . basename( $name_array );
			
			$basename = substr($name_array, 0, strrpos($name_array, "."));
			
			$path = $name_array;
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			
			$randomnumber = mt_rand(100000, 999999);
			
			$fileName = $randomnumber . '-' . $basename . '.' . $ext;
	        $updatedFileName=$fileName;
	  
		move_uploaded_file( $_FILES["upload_photo"]['tmp_name'][0], $target_dir.$updatedFileName );

	    
      }
    else
      {
         $updatedFileName=$_FILES["upload_photo"]["name"][0];
         move_uploaded_file( $_FILES["upload_photo"]['tmp_name'][0], $target_dir.$_FILES["upload_photo"]["name"][0] );
 
		
      }
	//  $file_name=base_url().'images/company_logo/'.$updatedFileName;
	$file_name=COUPON_PLUGIN_URL.'/uploads/logo/'.$updatedFileName;
	  echo $file_name;
	  exit();
      }
	}
	 
	 
	 
	 
 }
 
 function ultracoupon_dynamic_coupon_delete_fun()
{
     global $wpdb;
    $COUPON_TABLE = $wpdb->prefix . 'ultra_coupon';
    $couponid = (int)$_POST["couponid"];
	$sql="DELETE FROM $COUPON_TABLE WHERE id=$couponid";
    $wpdb->get_results($sql);  
    echo "ok";
    exit(); 
}
// dynamic_coupon_delete
add_action('wp_ajax_dynamic_coupon_delete', 'ultracoupon_dynamic_coupon_delete_fun');


add_action('wp_ajax_insert_stores','inser_merchant_info');
//call the  function on any page/post wheneve we want particular  coupon to execute
function get_coupon_content($name, $exclude = '')
{
	$array = array();
	$array['name'] = $name;
	$array['exclude'] = $exclude;
	
	ultracoupon_get_coupon_content($array);
}

function ultracoupon_get_coupon_content($atts, $action = "code")
{
    $coupon = ultracoupon_get_coupon($atts['name']);
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
function ultracoupon_get_coupon($name)
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
function inser_merchant_info()
{
	global $wpdb;
	
	/*
	if ($_GET["page"] <> "coupon-store") return;
	             */
            if (isset($_POST["merchant_name"]))
            { 
		
				$table_name=$wpdb->prefix.'coupon_merchants';
				$_POST = stripslashes_deep($_POST);
				
                global $wpdb;
                $merchant_name = trim($_POST["merchant_name"]);
                    $t1=strtolower($merchant_name);
                $description= trim($_POST["desc"]);
                $merchant_logo_url =$_POST["logo"];
                 $created_time=date('Y-m-d');
                $datas = array("name" => $t1,
                               "description" => $description,
                               "logo" => $merchant_logo_url,
							   "created_at"=>$created_time
                  
				  );
	
					  $result=$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE name = %s",$t1));
					
			 
    			
					
					if ($_POST["merchant_id"] == "")
                    {
				if(!empty($result))
				{
					echo "exist";
				}
				else
				{
					
                     if( $wpdb->insert($table_name, $datas))
						{
							
						$url=admin_url().'admin.php?page=coupon-store';	
						echo $url;

						}
					else
					{
					echo "Store insertion failed ";
					$wpdb->show_errors();
					} 
			
				}
                   } 
				else
                  {
				
				if($result->merchant_id!=$_POST["merchant_id"])
				{
					echo "exist";
				}
				else
				{
                    $wpdb->update($table_name, $datas, array("merchant_id" => (int)$_POST["merchant_id"]));
					
					 $url=admin_url().'admin.php?page=coupon-store';	
						echo $url; 
						 
				}
                  
				}					
                
				exit();

            
		
	
   }
}

//delete merchant info from database
add_action('wp_ajax_dynamic_merchant_delete','merchant_info_delete');

function merchant_info_delete()
{
	global $wpdb;
    $COUPON_TABLE = $wpdb->prefix . 'coupon_merchants';
    $merchant_id = (int)$_POST["merchant_id"];
	$sql="DELETE FROM $COUPON_TABLE WHERE merchant_id=$merchant_id";
    $wpdb->get_results($sql);  
    echo "ok";
    exit(); 
	
	
	
}
//do bulck actions here
add_action('wp_ajax_dynamic_bulk_action','dynamic_bulk_action');
function dynamic_bulk_action()
{
	global $wpdb;
    $COUPON_TABLE = $wpdb->prefix . 'coupon_merchants';
      $action=$_POST['name'];
	  if($action=='trash')
	  {
	$sql="TRUNCATE TABLE $COUPON_TABLE";
    $wpdb->get_results($sql);  
    echo "ok";
    exit(); 
	  }
	  else if($action="export")
	  {
		  echo "didn't complete Export action";
		  exit();
	  
	  }
	  else
	  {
		  echo "Please choose any one of the drop down option";
		  exit();
	  }
	
}
//bulk filter 
add_action('wp_ajax_dynamic_bulk_filter','dynamic_bulk_filter');
function dynamic_bulk_filter()
{
	
	global $wpdb;
    $COUPON_TABLE = $wpdb->prefix . 'coupon_merchants';
      $action=$_POST['name'];
	  $month=date("F");
	  if($action=='all')
	  {
	  
    echo "Didn't do filter  the contents.";
    exit(); 
	  }
	  else if($action==$month)
	  {
		  echo "didn't do filter for the month of ".$month;
		  exit();
	  
	  }
	  else
	  {
		  echo "Please choose any one of the drop down option";
		  exit();
	  }
	
}
//insert category
add_action('wp_ajax_insert_category','insert_category'); 
function insert_category()
{
	global $wpdb;
	//echo "insert category";
      if (isset($_POST["category"]))
            { 
		
				$table_name=$wpdb->prefix.'coupon_category';
				$_POST = stripslashes_deep($_POST);
	
             
                $category =trim($_POST["category"]);
				  $t1=strtolower($category);
                $description= trim($_POST["desc"]);
                $sub=$_POST["sub"];
                 $created_time=date('Y-m-d');
                $datas = array(
				                "category" =>$t1,
                               "description" => $description,
							   "sub_category"=>$sub,
							   "created_at"=>$created_time,
							  
                               );
					
					
          $result=$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE category = %s", $t1));
	
                  if ($_POST["category_id"] == "")
                   {
					   
				if($result->category)
				{
					echo "exist";
				}
				else
				{
                  if( $wpdb->insert($table_name, $datas))
						{
							$lastid = $wpdb->insert_id;
							
							if($sub==1)
							{
								
								$pageurl=admin_url().'admin.php?page=coupon-category';
								$output='';
							//	$output='last inserted id is:  '.$lastid."<br>";
								$output .='
								 <h3> Add Sub Categories     Under   '.
                   								     $category.' </h3>
													 
							   <button type="button" class="btn btn-primary btn-sm" id="add_more_sub_cat" data-id="'.$lastid .'">Add Category
           </button>&nbsp;&nbsp;
		   <button id="sub_cancel_btn" class="btn btn-primary" data-id="'.$pageurl.'" edit_id="null">Close</button>
													 ';
													  
													 $output .='_divide_'.'
								
						       <form method="post" action="'.$pageurl.'" enctype="multipart/form-data" class="form-horizontal" role="form">
                      
                            
                                <input type="hidden" id="cat_id" value="'.$lastid.'" >							   
								
                                <div class="form-group">
                                    <label for="subname" class="col-md-3 control-label">Sub Category Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="sub1_category" id="sub1_category" placeholder="Sub Category Name">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="description" class="col-md-3 control-label">Sub Category Description</label>
                                    <div class="col-md-9">
                                        <textarea  class="form-control" name="sub1_description" id="sub1_description" placeholder="Description"> </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subcategory" class="col-md-3 control-label">Does this has Sub category</label>
                                    <div class="col-md-9">
                                        <input type="radio" class="form-control" name="sub1_cat" value="1">   YES
										</br>
										</br>
										<input type="radio" class="form-control" name="sub1_cat" value="0">   NO
                                    </div>
									 <span id="sub" style="display:none;
									                        color:red;
															text-align:center;" >
									    Choose whether It has sub category? 
									 </span>
                                </div>
                               
                                    
                              

                                <div class="form-group">
                                                                        
                                    <div class="col-md-offset-3 col-md-9">
								
                               
                                     
									   <input type="button" class="btn btn-primary sub_category1_save" value="Save" >
									   
									   
									   
                                    </div>
                                </div>
                                
                           
                                
                            </form>
							
							';
							echo $output;
														  
							}
							else 
							{
								
						$url=admin_url().'admin.php?page=coupon-category';	
						echo "inserted"."|".$url;
						
							}
						}
				   	
					else
					{
					echo "Store insertion failed ";
					$wpdb->show_errors();
					}
				}
					
                  } 
				  else 
                  {
					  
					  $categor_id=$_POST["category_id"];
					  $flag=0;
					
					 $sql="SELECT * FROM $table_name WHERE category='$t1'";
					 $result1=$wpdb->get_results($sql);
					
					  if(is_array($result1))
					  {
						  foreach($result1 as $r1)
						  {
						  if($r1->category_id!=$categor_id)
						  {
							  $flag=1;
							  break;
						  }
						  }
					  }
						  
					  
					  
			  if( $flag==1)
				{
					echo "exist";
				}
				else
				{
					  
					  if($sub==0)
					  {
						  $table1=$wpdb->prefix."sub_category_1";
						$sql="DELETE FROM $table1 WHERE category_id=$categor_id";
						    $wpdb->query($sql);   
						  $table2=$wpdb->prefix."sub_category_2";
						$sql="DELETE FROM $table2 WHERE category_id=$categor_id";   
						  $wpdb->query($sql);
					  }
				
					   $wpdb->update($table_name, $datas, array("category_id" => (int)$_POST["category_id"]));
					
					$url=admin_url().'admin.php?page=coupon-category';	
						echo "inserted"."|".$url; 
					
					
                  }
				  }
				exit();

            }
		 
	
	
	
}
//add sub category 1 
add_action('wp_ajax_insert_sub1_category','insert_sub1_category');
function insert_sub1_category()
{ 
     global $wpdb;
	
	
	  $table_name = $wpdb->prefix . "sub_category_1";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'" ) != $table_name)
		{
		     $sql= "CREATE TABLE $table_name(
                             subcat_1_id bigint(20) unsigned NOT NULL auto_increment,
							 category_id bigint(100) NOT NULL,
							 category varchar(255) NOT NULL,
							 description varchar(100) NOT NULL default '', 
							 total_offers int(50) NOT NULL default '0',
							 sub_category_2 bigint(100) NOT NULL ,
                             created_at date  NOT NULL default '0000-00-00',                          
                             PRIMARY KEY  (subcat_1_id)
                            
                         );";
		   require_once (ABSPATH. 'wp-admin/includes/upgrade.php' );
		    dbDelta($sql);
			
			
			       
				    $category = trim($_POST["category"]);
                $category_id=$_POST["last_cat_id"];
                $description= trim($_POST["desc"]);
                   $t1=strtolower($category); 
                 $created_time=date('Y-m-d');
				 $sub=$_POST["sub"];
                $datas = array("category_id"=>$category_id,	
                               "category"=>$t1,			
                               "description" => $description,                
							   "sub_category_2"=>$sub,
							   "created_at"=>$created_time
                               );
							   
					  $flag=0;
					
					 $sql="SELECT * FROM $table_name WHERE category='$t1' AND category_id=$category_id";
					 $result1=$wpdb->get_results($sql);
					   
					  if(is_array($result1))
					  {
						  if(empty($result1))
							  $flag=0;
						  else
							  $flag=1;
					  }
		 
				if($flag==1)
				{
					echo "exist";
				}
				else
				{
						   
					if( $wpdb->insert($table_name, $datas))
						{
							$lastid = $wpdb->insert_id;
							
					  if($sub==1)
						 {
					     echo "create"."-divide-".$category_id."-divide-".$last_id.'-divide-'.$category;
						 }							 
						  else
						  {
					  $url=admin_url().'admin.php?page=coupon-store';	
						echo "inserted"."|".$url;
						  }
							
						

						}
					else
					{
					echo "sub category -1 insertion failed ";
					$wpdb->show_errors();
					} 
				}
			    
			exit();
			  }
			 else
			 {
				
			  if($_POST["category"])
               { 
		
				
				$_POST = stripslashes_deep($_POST);
				
              
                $category = trim($_POST["category"]);
                $category_id=$_POST["last_cat_id"];
                $description= trim($_POST["desc"]);
                $t1=strtolower($category);
                 $created_time=date('Y-m-d');
				 $sub=$_POST["sub"];
               $datas = array("category_id"=>$category_id,	
                               "category"=>$t1,			
                               "description" => $description,                
							   "sub_category_2"=>$sub,
							   "created_at"=>$created_time
                               );
            	
					
                   $flag=0;
					
					 $sql="SELECT * FROM $table_name WHERE category='$t1' AND category_id=$category_id";
					 $result1=$wpdb->get_results($sql);
				
					//print_r($result1);
					  if(is_array($result1))
					  {
						  if(empty($reult1))
							  $flag=0;
						  else
							  $flag=1;
					  }
					
				if($flag==1)
				{
					echo "exist";
				}
				else
				{
					$sub1_id=$_POST['subcat_1_id'];
					//echo "sub1 id ".$sub1_id;
				 if($sub1_id=='')
				 {
					 if( $wpdb->insert($table_name, $datas))
						{
							$last_id=$wpdb->insert_id;
                         if($sub==1)
						 {
					    echo "create"."-divide-".$category_id."-divide-".$last_id.'-divide-'.$category;
						 }							 
						  else
						  {
					  $url=admin_url().'admin.php?page=coupon-store';	
						echo "inserted"."|".$url;
						  }

						}
					else
					{
					echo "sub category -1 insertion failed ";
					$wpdb->show_errors();
					} 
				 }
				 else
				 {
                       
                     
					 if($sub==1)
						 {
							 $wpdb->update($table_name, $datas, array("subcat_1_id" =>$sub1_id,'category_id'=>$category_id));  
							 
					    echo "create"."-divide-".$category_id."-divide-".$sub1_id.'-divide-'.$category;
						 }							 
						  else
						  {
							  $table2=$wpdb->prefix."sub_category_2";
							  $sql="DELETE FROM $table2 WHERE category_id=$category_id AND sub_cat1_id=$sub1_id";
                              $wpdb->query($sql); 
					        $url=admin_url().'admin.php?page=coupon-store';	
						    echo "inserted"."|".$url;
						  }
					 
              
                   // $url=admin_url().'admin.php?page=coupon-store';	
						//echo "inserted"."|".$url;					 
				 }
                   
			
			   }
                
			
            
					exit();
			 }
			 
	      
}
}

//ad more sub vcategory ajaxjquerymin
add_action('wp_ajax_add_more_sub1_category','add_more_sub1_category');
function add_more_sub1_category()
{
	  $pageurl=admin_url().'admin.php?page=coupon-category';
	   $last_id=$_POST['category_id'];
	    $cat1_edit=$_POST['cat1_edit'];
	    
		 
		 if($_POST['edit_id']=='edit_category')
		 {
		   $cat_name=$_POST['cat_name'];
		 $output .='start'.'-divide-'.'
								 <h3> Add Sub Categories     Under   '.
                   								     $cat_name.' </h3>
													 
							   <button type="button" class="btn btn-primary btn-sm" id="add_more_sub_cat" data-id="'.$last_id.'" edit_id="null" cat_name="null" >Add Category
           </button>&nbsp;&nbsp;
		   <button id="sub_cancel_btn" class="btn btn-primary" data-id="'.$pageurl.'" >Close</button>
													 ';
													  
													 $output .='-divide-';
		 
		 }
	 
			 
	 $output .='more'.'-divide-'.'			
						       <form method="post" action="'.$pageurl.'" enctype="multipart/form-data" class="form-horizontal" role="form">
                                
                                    
                                
                                 
                                <input type="hidden" id="cat1_edit_id" value="'.$cat1_edit.'" >
                            
                                <input type="hidden" id="cat_id" value="'.$last_id.'" >							   
									
                                <div class="form-group">
                                    <label for="subname" class="col-md-3 control-label">Sub Category Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="sub1_category" id="sub1_category" placeholder="Sub Category Name">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="description" class="col-md-3 control-label">Sub Category Description</label>
                                    <div class="col-md-9">
                                        <textarea  class="form-control" name="sub1_description" id="sub1_description" placeholder="Description"> </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subcategory" class="col-md-3 control-label">Does this has Sub category</label>
                                    <div class="col-md-9">
                                        <input type="radio" class="form-control" name="sub1_cat" value="1">   YES
										</br>
										</br>
										<input type="radio" class="form-control" name="sub1_cat" value="0">   NO
                                    </div>
									 <span id="sub" style="display:none;
									                        color:red;
															text-align:center;" >
									    Choose whether It has sub category? 
									 </span>
                                </div>
                               
                                    
                              

                                <div class="form-group">
                                                                        
                                    <div class="col-md-offset-3 col-md-9">
								
                               
                                     
									   <input type="button" class="btn btn-primary sub_more_category1_save" value="Save" >
									  
									   
									   
                                    </div>
                                </div>
                                
                           
                                
                            </form>
							
							';
							echo $output;
							exit();
	
}


//insert more sub category data

add_action('wp_ajax_insert_more_sub1_category','insert_more_sub1_category');
function insert_more_sub1_category()
{ 
     global $wpdb;
	
	  $table_name = $wpdb->prefix . "sub_category_1";
		
	
			
			if($_POST["category"])
			{
				$category = trim($_POST["category"]);
                $category_id=$_POST["last_cat_id"];
                $description= trim($_POST["desc"]);
                 $created_time=date('Y-m-d');
				 $sub=$_POST["sub"];
				 
				 $t1=strtolower($category);
                $datas = array("category_id"=>$category_id,	
                               "category"=>$t1,			
                               "description" => $description,                
							   "sub_category_2"=>$sub,
							   "created_at"=>$created_time
                               );   
					



                      
					
               $flag=0;
					
					 $sql="SELECT * FROM $table_name WHERE category='$t1' AND category_id=$category_id";
					 $result1=$wpdb->get_results($sql);
					
					//print_r($result1);
					
					  if(is_array($result1))
					  {
						  if(empty($result1))
					       {
							   $flag==0;
					       }
						   else
						   {
							    $flag=1;
						   }
			
					  }
					// echo "flag value ".$flag;
				if($flag==1)
				{
					echo "exist";
				}
				else
				{
					
					
					 if( $wpdb->insert($table_name, $datas))
						{
							$last_id=$wpdb->insert_id;
							if($sub==1)
							{
						   echo "create"."-divide-".$category_id."-divide-".$last_id.'-divide-'.$category;			  
							}
							else
							{
						  $url=admin_url().'admin.php?page=coupon-store';	
						   echo "inserted"."|".$url;
							}

						}
					else
					{
					echo "sub category -1 insertion failed ";
					$wpdb->show_errors();
					} 
			}
			
			exit();
			  }
			
}
//initioate sub2 option form
add_action('wp_ajax_sub_cat2_form','sub_cat2_form');
function sub_cat2_form()
{
	  $cat_id=$_POST['category_id'];
	  $sub1_id=$_POST['sub1_id'];
	  $category=$_POST['category'];
	  $append=$_POST['append'];
	   $cat1_edit=$_POST['cat1_edit'];
	  $output='';
	  
	  $pageurl=admin_url().'admin.php?page=coupon-category';
	

	 $output .=' 
         
		   
		    <h3> Add Sub Categories    of  '.
                   								     $category.' </h3>
													 
							   <button type="button" class="btn btn-primary btn-sm" id="add_more_sub2_cat" data-id="'.$cat_id .'" data-sub1-id="'. $sub1_id.'" data-subname="'.$category.'" cat1_edit="'.$cat1_edit.'">
             Add Category
           </button>&nbsp;
		     <button id="sub2_cancel_btn" class="btn btn-primary">Close</button>
													 ';
		   $output .='-divide-';
													 
$output .='													 
						       <form method="post" action="'.$pageurl.'" enctype="multipart/form-data" class="form-horizontal" role="form" id="form_data">
     
                                <input type="hidden" id="cat_id" value="'.$cat_id.'" >	
<input type="hidden" id="append" value="'.$append.'" >									
					             <input type="hidden" id="sub1_cat_id" value="'.$sub1_id.'" >	
								 <input type="hidden" id="sub1_name" value="'.$category.'" >
                                <div class="form-group">
                                    <label for="subname" class="col-md-3 control-label">Sub Category Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="sub2_category" id="sub2_category" placeholder="Sub Category Name">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="description" class="col-md-3 control-label">Sub Category Description</label>
                                    <div class="col-md-9">
                                        <textarea  class="form-control" name="sub2_description" id="sub2_description" placeholder="Description"> </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                   
                                  
									
                                </div>
                               
                                    </br></br>
                              

                                <div class="form-group">
                                                                        
                                    <div class="col-md-offset-3 col-md-9">
								
                               
                                     
									   <input type="button" class="btn btn-primary sub2_cat_save_data" value="Save" >
									  
									   
									   
                                    </div>
                                </div>
                                
                           
                                
                            </form>
							
							';
							echo $output;
							exit();
	  
}

//inseret subcategory-2 data into database

add_action('wp_ajax_insert_sub_cat2','insert_sub_cat2');
function insert_sub_cat2()
{
	 global $wpdb;
	
	  $table_name = $wpdb->prefix . "sub_category_2";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'" ) != $table_name)
		{
		     $sql= "CREATE TABLE $table_name(
                             subcat_2_id bigint(20) unsigned NOT NULL auto_increment,
							 category_id bigint(100) NOT NULL,
							 sub_cat1_id bigint(100) NOT NULL,
							 category varchar(255) NOT NULL,
							 description varchar(100) NOT NULL default '', 
							 total_offers int(50) NOT NULL default '0',						 
                             created_at date  NOT NULL default '0000-00-00',                          
                             PRIMARY KEY  (subcat_2_id)
                            
                         );";
		   require_once (ABSPATH. 'wp-admin/includes/upgrade.php' );
		    dbDelta($sql);
				    $category = trim($_POST["sub2_name"]);
					$subcat_id=trim($_POST["sub1_id"]);
                $category_id=$_POST["cat_id"];
                $description= trim($_POST["sub2_desc"]);
                  //$sub1_name=trim($_POST["sub1_name"]); use if it is need
                 $created_time=date('Y-m-d');
				 	$t1=strtolower($category);
                $datas = array("category_id"=>$category_id,	
				              "sub_cat1_id"=>$subcat_id,
                               "category"=>$t1,			
                               "description" => $description,                
							   "created_at"=>$created_time
                               );

							   
					
                       	
               $flag=0;
					
					 $sql="SELECT * FROM $table_name WHERE category_id=$category_id AND sub_cat1_id =$subcat_id AND category='$t1'";
					 $result1=$wpdb->get_results($sql);
					
					  if(is_array($result1))
					  {
						  foreach($result1 as $r1)
						  {
						  if($r1->category_id!=$category_id)
						  {
							  $flag=1;
							  break;
						  }
						  }
					  }


		
				if($flag==1)
				{
					echo "exist";
				}
				else
				{				   
					 if( $wpdb->insert($table_name, $datas))
						{
				
					  $url=admin_url().'admin.php?page=coupon-category';	
						echo "inserted"."|".$url;

						}
					else
					{
					echo "sub category -2 insertion failed ";
					$wpdb->show_errors();
					} 
		   }
			exit();
			  }
			 else
			 {
				//echo "insert";
				$_POST = stripslashes_deep($_POST);     
                 $category = trim($_POST["sub2_name"]);
					$subcat_id=trim($_POST["sub1_id"]);
                $category_id=$_POST["cat_id"];
                $description= trim($_POST["sub2_desc"]);
                  //$sub1_name=trim($_POST["sub1_name"]); use if it is need
                 $created_time=date('Y-m-d');
				 	$t1=strtolower($category);
                $datas = array("category_id"=>$category_id,	
				              "sub_cat1_id"=>$subcat_id,
                               "category"=>$t1,			
                               "description" => $description,                
							   "created_at"=>$created_time
                               );
            	
				
				 			  
                  $flag=0;
					
					 $sql="SELECT * FROM $table_name WHERE category_id=$category_id AND sub_cat1_id =$subcat_id AND category='$t1'";
					 $result1=$wpdb->get_results($sql);
					
				
				
				$sub2_id=$_POST['sub2_id'];
				//echo "sub2 id ".$sub2_id;
				//print_r($result1);
				if($sub2_id=='')
				{
					
					if(is_array($result1))
					    {
						   if(empty($result1))
							   $flag=0;
						   else
							   $flag=1;
		
					    }

				if($flag==1)
				{
					echo "exist";
				}
				
			   else
			      {
					
                    if( $wpdb->insert($table_name, $datas))
						{	
					  $url=admin_url().'admin.php?page=coupon-store';	
						echo "inserted"."|".$url;
						}						
					else
					{
					echo "sub category -2 insertion failed ";
					$wpdb->show_errors();
					}
				 }
				}
				else
				{
					//print_r($result1);
					if(is_array($result1))
					    {
							foreach($result1 as $row)
							{
								if($row->subcat_2_id!=$sub2_id)
									$flag=1;
							}
						}
					
					if($flag==1)
					{
						echo "exist";
					}
					else
					{
					 $wpdb->update($table_name, $datas, array("subcat_2_id" =>$sub2_id));  
							 
					 $url=admin_url().'admin.php?page=coupon-category';	
						echo "updated"."|".$url;
						
					}
				}
			 
					exit();
              } 
}

//delete category details
add_action('wp_ajax_category_delete','category_delete');

function category_delete()
{
	global $wpdb;
    $table1=$wpdb->prefix."coupon_category";
    $category_id = (int)$_POST["category_id"];
	$sql="DELETE FROM $table1 WHERE category_id=$category_id";
    $wpdb->query($sql); 
      $table1=$wpdb->prefix."sub_category_1";   
       $sql="DELETE FROM $table1 WHERE category_id=$category_id";
    $wpdb->query($sql); 
	   $table1=$wpdb->prefix."sub_category_2";   
       $sql="DELETE FROM $table1 WHERE category_id=$category_id";
    $wpdb->query($sql); 
	  $url=admin_url().'admin.php?page=coupon-category';	
    echo "ok"."|".$url;
    exit(); 		
}
//delete sub category 1 details
add_action('wp_ajax_subcat1_delete','subcat1_delete');

function subcat1_delete()
{
	global $wpdb;
    $table1=$wpdb->prefix."sub_category_1";
    $category_id = (int)$_POST["category_id"];
	$sql="DELETE FROM $table1 WHERE subcat_1_id=$category_id";
    $wpdb->query($sql); 
      $table1=$wpdb->prefix."sub_category_2";   
       $sql="DELETE FROM $table1 WHERE sub_cat1_id=$category_id";
    $wpdb->query($sql); 
     $url=admin_url().'admin.php?page=coupon-category';	
    echo "ok"."|".$url;
    exit(); 		
}


//delete sub category 2 details
add_action('wp_ajax_subcategory_2_delete','subcategory_2_delete');

function subcategory_2_delete()
{
	global $wpdb;
    $table1=$wpdb->prefix."sub_category_2";
    $category_id = (int)$_POST["category_id"]; 
       $sql="DELETE FROM $table1 WHERE subcat_2_id=$category_id";
    $wpdb->query($sql); 
     $url=admin_url().'admin.php?page=coupon-category';	
    echo "ok"."|".$url;
    exit(); 		
}
//category on change function
add_action('wp_ajax_category_on_change','category_on_change');
function category_on_change()
{
	global $wpdb;

	$cat_id=$_POST['category_id'];
	$table_name=$wpdb->prefix."sub_category_1";
	$sql="SELECT * FROM $table_name WHERE category_id=$cat_id";
	$result=$wpdb->get_results($sql);
	 
	    $output ='start'.'|';
		if(is_array($result)&& !empty($result))
		{
			$output .='<option value="" disabled selected>Select Your Sub Category</option>';
			foreach($result as $row)
			{
		  $output .='<option value="'.$row->subcat_1_id.'">'.$row->category.'</option>';
			}
		}
		else
		{
			$output .='empty';
		}
		echo $output;
		exit();
		
}
//sub category on change function
add_action('wp_ajax_subcategory_on_change','subcategory_on_change');
function subcategory_on_change()
{
	global $wpdb;

	$cat_id=$_POST['category_id'];
	$sub1_id=$_POST['subcat_id'];
	$table_name=$wpdb->prefix."sub_category_2";
	$sql="SELECT * FROM $table_name WHERE category_id=$cat_id AND sub_cat1_id=$sub1_id";
	$result=$wpdb->get_results($sql);
	 
	    $output ='start'.'|';
		if(is_array($result)&& !empty($result))
		{
			$output .='<option value="" disabled selected>Select Your Sub Category</option>';
			foreach($result as $row)
			{
		  $output .='<option value="'.$row->subcat_2_id.'">'.$row->category.'</option>';
			}
		}
		else
		{
			$output .='empty';
		}
		echo $output;
		exit();
		
}

//insert coupon detailsd into database
add_action('wp_ajax_insert_coupon_details','insert_coupon_details');
function insert_coupon_details()
{
	global $wpdb;
	$table_name=$wpdb->prefix."ultra_promocode";
	$coupon_name=trim($_POST['coupon_heading']);
	$coupon_id=$_POST['coupon_id'];
	if($coupon_name)
	{
		$t1=strtolower($coupon_name);
		$merchant_id=$_POST['merchant_id'];
		$category_id=$_POST['category_id'];
		$subcategory_id=$_POST['subcategory_id'];
		$subcategory_2_id=$_POST['subcategory_2_id'];
		$coupon_type_id=$_POST['coupon_type_id'];
		$coupon_code=trim($_POST['coupon_code']);
		$deal_button=trim($_POST['deal_button']);
		$coupon_link=trim($_POST['coupon_link']);
		$discount=trim($_POST['discount']);
		$description=trim($_POST['description']);
		$expiration_id=$_POST['expiration_id'];
		$coupon_start=$_POST['coupon_start'];
		$coupon_end=$_POST['coupon_end'];
		$hide_coupon_id=$_POST['hide_coupon_id'];
		$image_type_id=$_POST['image_coupon_type_id'];
		$coupon_image=$_POST['coupon_image'];
		$iframe_tag=$_POST['iframe_image'];
		
		//echo "coupon image type id ".$image_type_id."<br>";
		$p1=date_create($coupon_start);
		$start=date_format($p1,'Y-m-d');
		
		$p1=date_create($coupon_end);
		$end=date_format($p1,'Y-m-d');
		$created_time=date('Y-m-d');
		  $datas=array(
		   'type_id'=>$coupon_type_id,
		   'coupon_title'=>$t1,
		   'merchant_id'=>$merchant_id,
		   'category_id'=>$category_id,
		   'subcat1_id'=>$subcategory_id,
		   'subcat2_id'=>$subcategory_2_id
		   );   
		
	 if($coupon_id=='')
	  {
		
		  $flag=0;
		 if($coupon_type_id=='1')
		 {
			 
			  $data1=array(
		   'coupon_code'=>$coupon_code,
		   'link'=>$coupon_link,
		   'discount'=>$discount,
		   'product_description'=>$description,
		   'coupondeal_expiration'=>$expiration_id,
		  'coupon_start_date'=>$start,
		  'coupon_end_date'=>$end,
		   'hide_coupon'=>$hide_coupon_id,      
		  'created_at'=>$created_time);
			 
			 
			 $query_result=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE  merchant_id = %d AND link = %s",$merchant_id,$coupon_link));
 
               if(is_array($query_result))
			     {
				 if(empty($query_result))
					 $flag=0;
				 else
                   $flag=1;
				 }		
          $result_array=array_merge($datas,$data1);			
		 }
		 else if($coupon_type_id=='2')
		 {
          
			  $data1=array(
		   'link'=>$coupon_link,
		   'discount'=>$discount,
		   'product_description'=>$description,
		   'coupondeal_expiration'=>$expiration_id,
		  'coupon_start_date'=>$start,
		  'coupon_end_date'=>$end,
		   'deal_button_text'=>$deal_button,       
		  'created_at'=>$created_time);
				 
			 $query_result=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE  merchant_id = %d AND link = %s",$merchant_id,$coupon_link));
       
               if(is_array($query_result))
			     {
				 if(empty($query_result))
				 {	
				 $flag=0;
				 }
				 else
                   $flag=1;
				 }
		   // print_r($query_result);		 
			//echo "flag ".$flag;	
		    $result_array=array_merge($datas,$data1);		
		 }
		 else if($coupon_type_id=='3')
		 {
 	   if($image_type_id=='1')
	   {
				  $data1=array(
			  'image_coupon_type'=>$image_type_id,
		   'link'=>$coupon_link, 
           'coupon_image'=>$coupon_image,		   
		  'created_at'=>$created_time);   
				
 			
			  $query_result=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE  merchant_id = %d AND link = %s",$merchant_id,$coupon_link));
  
               if(is_array($query_result))
			     {
				 if(empty($query_result))
					 $flag=0;
				 else
                   $flag=1;
				 }
				  $result_array=array_merge($datas,$data1);	 
	             }
			  else if($image_type_id=='2')
			  {
				 
				  
				    $data1=array( 
		   'image_coupon_type'=>$image_type_id,			
		   'iframe_tag'=>$iframe_tag,
		  'created_at'=>$created_time);   
				  
				 $query_result=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE  merchant_id = %d AND iframe_tag = %s",$merchant_id,$iframe_tag));
  
               if(is_array($query_result))
			     {
				 if(empty($query_result))
					 $flag=0;
				 else
                   $flag=1;
				 }
			  
			  $result_array=array_merge($datas,$data1);	 
		 }
	   	
		 }	   
		 if($flag==1)
		 {
			 echo "exist";
		 }
		 else
		 {
		//echo "table name  ".$table_name;
	  // echo "data array ";
	 // print_r($result_array);
    	  if($wpdb->insert($table_name,$result_array))
						{	
				 $last_id=$wpdb->insert_id;
				 $code='[upc:'.$last_id.']';
				$short_data=array('short_code'=>$code
				);
				
				 $wpdb->update($table_name,$short_data, array("coupon_id" =>$last_id));  
					
					  $url=admin_url().'admin.php?page=my-coupon';	
						echo "inserted"."|".$url."|".$last_id;
						}						
					else
					{
					echo " coupon insertion failed ";
					$wpdb->show_errors();
					} 
			 
			 
		 }   
	  
		 }
	  else
	  {
		

		//echo "update coupon values";
		
		$coupon_id=$_POST['coupon_id'];
		  $flag=0;
		 if($coupon_type_id=='1')
		 {
			 
			  $data1=array(
		   'coupon_code'=>$coupon_code,
		   'link'=>$coupon_link,
		   'discount'=>$discount,
		   'product_description'=>$description,
		   'coupondeal_expiration'=>$expiration_id,
		  'coupon_start_date'=>$start,
		  'coupon_end_date'=>$end,
		   'hide_coupon'=>$hide_coupon_id,      
		  'created_at'=>$created_time);
			 
			 
			 $query_result=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE  merchant_id = %d AND link = %s",$merchant_id,$coupon_link));
 
               if(is_array($query_result))
			     {
					 foreach($query_result as $row)
					 {
						 if($row->coupon_id==$coupon_id)
					     $flag=0;
				            else
							{
                               $flag=1; 
							   break;
							}
					 }
				
				 }		
          $result_array=array_merge($datas,$data1);			
		 }
		 else if($coupon_type_id=='2')
		 {
          
			  $data1=array(
		   'link'=>$coupon_link,
		   'discount'=>$discount,
		   'product_description'=>$description,
		   'coupondeal_expiration'=>$expiration_id,
		  'coupon_start_date'=>$start,
		  'coupon_end_date'=>$end,
		   'deal_button_text'=>$deal_button,       
		  'created_at'=>$created_time);
				 
			 $query_result=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE  merchant_id = %d AND link = %s",$merchant_id,$coupon_link));
       
               if(is_array($query_result))
			     {
				 foreach($query_result as $row)
					 {
						 if($row->coupon_id==$coupon_id)
					     $flag=0;
				            else
							{
                               $flag=1; 
							   break;
							}
					 }
				 }
		   // print_r($query_result);		 
			//echo "flag ".$flag;	
		    $result_array=array_merge($datas,$data1);		
		 }
		 else if($coupon_type_id=='3')
		 {
 	   if($image_type_id=='1')
	   {
				  $data1=array(
			  'image_coupon_type'=>$image_type_id,
		   'link'=>$coupon_link, 
           'coupon_image'=>$coupon_image,		   
		  'created_at'=>$created_time);   
				
 			
			  $query_result=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE  merchant_id = %d AND link = %s",$merchant_id,$coupon_link));
  
               if(is_array($query_result))
			     {
				foreach($query_result as $row)
					 {
						 if($row->coupon_id==$coupon_id)
					     $flag=0;
				            else
							{
                               $flag=1; 
							   break;
							}
					 }
				 }
				  $result_array=array_merge($datas,$data1);	 
	             }
			  else if($image_type_id=='2')
			  {
				 
				  
				    $data1=array( 
		   'image_coupon_type'=>$image_type_id,			
		   'iframe_tag'=>$iframe_tag,
		  'created_at'=>$created_time);   
				  
				 $query_result=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE  merchant_id = %d AND iframe_tag = %s",$merchant_id,$iframe_tag));
  
               if(is_array($query_result))
			     {
				 foreach($query_result as $row)
					 {
						 if($row->coupon_id==$coupon_id)
					     $flag=0;
				            else
							{
                               $flag=1; 
							   break;
							}
					 }
				 }
			  
			  $result_array=array_merge($datas,$data1);	 
		 }
	   	
		 }	   
		 if($flag==1)
		 {
			 echo "exist";
		 }
		 else
		 {
		//echo "table name  ".$table_name;
	  // echo "data array ";
	 // print_r($result_array);
    	 
				 $wpdb->update($table_name,$result_array, array("coupon_id" =>$coupon_id));  
					
					  $url=admin_url().'admin.php?page=my-coupon';	
						echo "inserted"."|".$url."|".$last_id;
						}						
					
			 
			 
		 }  
		 
	  }  
	
	else
	{
		echo "Error while getting coupon data ";
	}
	exit();
}


//delete category details
add_action('wp_ajax_coupon_delete','coupon_delete');

function coupon_delete()
{
	global $wpdb;
    $table1=$wpdb->prefix."ultra_promocode";
    $coupon_id = (int)$_POST["coupon_id"];
	$sql="DELETE FROM $table1 WHERE coupon_id=$coupon_id";
    $wpdb->query($sql); 
	  $url=admin_url().'admin.php?page=my-coupon';	
    echo "ok"."|".$url;
    exit(); 		
}





//require_once dirname( __FILE__ ) . '\shortcode\generatecode.php';

require_once ULTRA_PROMOCODE_DIR . '\shortcode\generatecode.php';
require_once ULTRA_PROMOCODE_DIR . '\media_page\media_button.php';

//require_once ULTRA_PROMOCODE_DIR . '\sample\test.php';


/* end of slider plugin */

//Custom taxonomy

//require_once ULTRA_PROMOCODE_DIR . '\custom_taxonomy\custom_taxonomy_fn.php';

//End custom taxonomy

?>
