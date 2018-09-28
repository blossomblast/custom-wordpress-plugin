<?php
global $wpdb;

add_shortcode('hello', 'shortcode_HelloWorld');
function shortcode_HelloWorld() {	
	global $wpdb;	 
  return '<h1>Hello World!</h1>';
}





 
 function short_code_custom_files() {

        wp_register_script('shortcode_script', plugins_url('script.js', __FILE__), array('jquery'));
	  
		wp_localize_script( 'shortcode_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));   
		 wp_enqueue_script( 'jquery' );
	 
	  wp_register_style('shortcode_style', plugins_url('style.css', __FILE__));
	 wp_register_script('bootstrapjs', plugins_url('assets/bootstrap/js/bootstrap.min.js', __FILE__), array('bootstrap'));
	  // wp_register_script('clipboardjs', plugins_url('clipboard.min.js', __FILE__));
	  
	  wp_enqueue_script('shortcode_script');	
   	 
	    wp_enqueue_style('shortcode_style');
	     	
 }

add_action( 'wp_enqueue_scripts', 'short_code_custom_files' );



$table1=$wpdb->prefix."coupon_merchants";
$table_name=$wpdb->prefix."ultra_promocode";
//$sql="SELECT * FROM $table_name";
$sql="SELECT * FROM $table_name LEFT JOIN  $table1 ON $table_name.merchant_id=$table1.merchant_id ";
$result=$wpdb->get_results($sql);
$count=0;

foreach($result as $row)
{
	//$merchant=$wpdb->get_row("SELECT * FROM $table1 WHERE merchant_id=$row->merchant_id");
		/* echo "merchnat ".$row->merchant_id."******";
			echo "merchnat  id  ***".$merchant->name."******";
	print_r($merchant); */
	//echo "****************************** inside for front ".$count."<br>";
	$name=$merchant->name;
	$count++;
	$id=$row->coupon_id;
	$r1=function() use ($row){
		
		$t=date_create($row->coupon_end_date);
					$end_date=date_format($t,'d-m-Y');
		
		 $today=date('d-m-Y');
		 //if($t<=$today)
		if( strtotime($row->coupon_end_date) <= strtotime('now') ) 
		 {
			 $output .='';
		 }
		 else
		 {
		 
	  $output ='<div class="row col-md-12 row_block">
	          <div class="col-md-3">
			    <a href="#"><img src="'.COUPON_PLUGIN_URL.'/uploads/logo/'.$row->logo.'" class="img-responsive img-thumbnail" width="150px" height="150px"/></a>
	           </div>
			  ';
		
	   
				if($row->type_id==3)
				{
					$output .=' <div class="col-md-6">';
					if($row->image_coupon_type==1)
					{
					$output .='<a class="image_coupon"   merchant_id="'.$row->merchant_id.'" coupon_id="'.$row->coupon_id.'" target="__blank"><h2>'.$row->coupon_title.'</h2></a>
					<ul>
					  <li>No coupon code needed</li>
					  <li>Valid once per user.</li>
					  </ul></div><div class="col-md-3">
					      <a class="image_coupon" target=="__blank" merchant_id="'.$row->merchant_id.'" coupon_id="'.$row->coupon_id.'"><img src="'.COUPON_PLUGIN_URL.'/uploads/logo/'.$row->coupon_image.'" img-thumbnail" width="150px" height="150px"/></a>
					        </div>';

					  
					}
					else
					{
						
					$output .='<h2>'.$row->	coupon_title.'</h2>
					<ul>
					  <li>No coupon code needed</li>
					  <li>Valid once per user.</li>
					  </ul></div><div class="col-md-3">
					  
					   '.$row->iframe_tag.'
            </div>
    
					  
					  
					   ';	
					}
					
					   
					
				}
                 else
				 {
					$output .=' <div class="col-md-7">
					<a class="copy_class"   merchant_id="'.$row->merchant_id.'" coupon_id="'.$row->coupon_id.'"  ajax_url="'.$ajaxurl.'" target="__blank"><h2>'.$row->coupon_title.'</h2></a>';
					$t=date_create($row->coupon_end_date);
					$end_date=date_format($t,'d-m-Y');
					 if($row->coupondeal_expiration==1)
					 {
						$output .='<label>Expires  :</label>'.$end_date.'</br>'; 
					 }
				    
					$output .='
					   <label>From       :</label>'.$row->name.'';
					 
						 $random = rand();  
					      $outptut .='<ul>';
						  if($row->product_description)
						 $output .='<li>'.$row->product_description.'</li>';
					     if($row->discount)
							  $output .='<li>'.$row->discount.'</li>';
						  $output .='</ul>';
						 $output .='</div><div class="col-md-2">';
						  if($row->type_id==1)
					     { 
					 
						   $output .='</br></br><button class="btn btn-success get_code copy_class" id="copy" merchant_id="'.$row->merchant_id.'" coupon_id="'.$row->coupon_id.'">GET CODE</button>';
						    
					     }
					   else if($row->type_id==2)
					   {
						   $output .='</br></br><button class="btn btn-success get_code copy_class" id="copy" url="'.$row->link.'" merchant_id="'.$row->merchant_id.'" coupon_id="'.$row->coupon_id.'">'.$row->deal_button_text.'</button>';
					   }
					$output .='</div>'; 
				 }
				$output .= '
		
				  </div>';
	
				 // $output .=' <div class="modal fade" id="myModal_'.$row->coupon_id.'" role="dialog"></div>';
		 }		  
	
	// wp_enqueue_script('shortcode_script');	
   	 
	// wp_enqueue_style('shortcode_style');
    // wp_enqueue_script('bootstrapjs');	
   //wp_enqueue_script('clipboardjs');	  
return $output;	
			  
	};
	//echo "****************************** inside for befor shortcode".$count."<br>";
	
	add_shortcode("upc:$id",$r1);
	//echo '[upc:$id]'."<br>";
}


//secone method_exists
add_action('wp_ajax_confirmation_form','confirmation_form');

add_action('wp_ajax_nopriv_confirmation_form','confirmation_form');
function confirmation_form()
{
	//echo "controller confirmation_form ";
	
	global $wpdb;
	//print_r($_POST);
	$coupon_id=$_POST['coupon_id'];
	$merchant_id=$_POST['merchant_id'];
	
	$table1=$wpdb->prefix."coupon_merchants";
  $table_name=$wpdb->prefix."ultra_promocode";
   $sql="SELECT * FROM $table_name WHERE coupon_id=$coupon_id";
   $row=$wpdb->get_row($sql);
   $sql1="SELECT * FROM $table1 WHERE merchant_id=$merchant_id";
   $result1=$wpdb->get_row($sql1);
 //  echo "merchant ";
   //print_r($row);
  // echo "name ".$result1->name;
  // print_r($result1);
  
 
				    
    $output=' <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		 <div class="imag_tag" align="center">
         <img src="'.COUPON_PLUGIN_URL.'/uploads/logo/'.$result1->logo.'" align="center" width="150px" height="150px" class="img-responsive"/>
		 </div>
      </div>
      <div class="modal-body content">';
	    
             
				   
				    $t=date_create($row->coupon_end_date);
					$end_date=date_format($t,'d-m-Y');
				   
					 if($row->coupondeal_expiration==1)
					 {
						$output .='<label>Expires  :</label>'.$end_date.'</br>'; 
					 }
				$outptut .='<ul>';
						  if($row->product_description)
						 $output .='<li>'.$row->product_description.'</li>';
					     if($row->discount)
							  $output .='<li>'.$row->discount.'</li>';
						  $output .='</ul>';
						  if($row->type_id==1)
						  {
						  
                     if($row->hide_coupon==0)
					 {
						 $output .='<div class="button_tag">
						        <input type="text" value="'.$row->coupon_code.'" id="myInput">
								<span id="copied" style="display:none; color:blue;">Code Copied</span>
                               <button onclick="myFunction()" class="btn btn-primary">Copy Text</button>
							   <a href="'.$row->link.'" class="btn btn-success" target="__blank">Go To'.ucfirst($result1->name).'</a>
							   </div>';
					 }
					 else
					 {
						  $output .='<div class="button_tag">
						  <input type="hidden" value="'.$row->link.'"  id="hide_code" />
						 <button class="btn btn-primary" id="hide_code_click" onclick="myhideFunction()" data-clipboard-text="'.$row->coupon_code.'" >Go To '.ucfirst($result1->name).'</button>
						 
						 </div>';
						
					 }
         
						  }else
						  {
							   $output .='<div class="button_tag">
						      <a href="'.$row->link.'" class="btn btn-primary">'.ucfirst($result1->name).'</a>
						 </div>';
						  }							  
	$output .='
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>';
    
	echo $output;  
	
	exit();
}
add_action('wp_ajax_confirmation_image_modal','confirmation_image_modal');
add_action('wp_ajax_nopriv_confirmation_image_modal','confirmation_image_modal');
function confirmation_image_modal()
{
	
	//echo "controller confirmation_image_modal ";
	
	global $wpdb;
	//print_r($_POST);
	$coupon_id=$_POST['coupon_id'];
	$merchant_id=$_POST['merchant_id'];
	
	$table1=$wpdb->prefix."coupon_merchants";
  $table_name=$wpdb->prefix."ultra_promocode";
   $sql="SELECT * FROM $table_name WHERE coupon_id=$coupon_id";
   $row=$wpdb->get_row($sql);
   $sql1="SELECT * FROM $table1 WHERE merchant_id=$merchant_id";
   $result1=$wpdb->get_row($sql1);
 //  echo "merchant ";
   //print_r($row);
  // echo "name ".$result1->name;
  // print_r($result1);
  
 
				    
    $output=' <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
		 <div class="imag_tag" align="center">
         <img src="'.COUPON_PLUGIN_URL.'/uploads/logo/'.$result1->logo.'" align="center" width="150px" height="150px" class="img-responsive"/>
		 </div>
      </div>
      <div class="modal-body content">';
	    
                 $output.='<ul>
					  <li>No coupon code needed</li>
					  <li>Valid once per user.</li>
					  </ul>';
				   if($row->image_coupon_type==1)
				   {
					  $output .='<div class="button_tag">
					  <a href="'.$row->link.'" target=="__blank"><img src="'.COUPON_PLUGIN_URL.'/uploads/logo/'.$row->coupon_image.'" img-thumbnail" width="150px" height="150px"/></a>'; 
					  $output .='</br></br><a href="'.$row->link.'" class="btn btn-success" target="__blank">Go To '.ucfirst($result1->name).'</a></div>';
				   }
				   else
				   {
					  $output .='<div class="button_tag">
					    '.$row->iframe_tag.'
					  </div>';
					 
				   }
		             				  
	$output .='
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>';
    
	echo $output;  
	
	exit();
}



// genertae perma link  and add contents into categories

 add_action('init', 'projects_cpt');
function projects_cpt() {
 /*   $labels = array(
        'name' => 'jai Projects',
        'singular_name' => 'Jai Project',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Project',
        'edit_item' => 'Edit Project',
        'new_item' => 'New Project',
        'all_items' => 'All Projects',
        'view_item' => 'View Project',
        'search_items' => 'Search Projects',
        'not_found' => 'No projects found',
        'not_found_in_trash' => 'No projects found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Jai Projects'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'taxonomies' => array('projectstype'),
        'rewrite' => array('slug' => 'projects/%projectscategory%', 'with_front' => false), 
        //Adding custom rewrite tag
        'capability_type' => 'post',
        'has_archive' => 'projectsarchives',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
    );
    register_post_type('projects', $args);
*/
    $labels = array(
        'name' => 'My Test Categories',
        'singular_name' => 'Projects',
        'search_items' => 'Search Projects Categories',
        'all_items' => 'All Projects Categories',
        'parent_item' => 'Parent Project Category',
        'parent_item_colon' => 'Parent Project Category:',
        'edit_item' => 'Edit Project Category',
        'update_item' => 'Update Project Category',
        'add_new_item' => 'Add New Project Category',
        'new_item_name' => 'New Project Category',
    );

    $args = array(
        'hierarchical' => true,
        'rewrite' => array('slug' => 'projects'),
        'show_in_nav_menus' => true,
        'labels' => $labels
    );

    register_taxonomy('projectscategory', 'My projects', $args);

    unset($labels);
    unset($args);
}



 add_filter('post_type_link', 'projectcategory_permalink_structure', 10, 4);
function projectcategory_permalink_structure($post_link, $post, $leavename, $sample) {
    if (false !== strpos($post_link, '%projectscategory%')) {
        $projectscategory_type_term = get_the_terms($post->ID, 'projectscategory');
        if (!empty($projectscategory_type_term))
            $post_link = str_replace('%projectscategory%', array_pop($projectscategory_type_term)->
            slug, $post_link);
        else
            $post_link = str_replace('%projectscategory%', 'uncategorized', $post_link);
    }
    return $post_link;
}  



function people_init() {
	// create a new taxonomy
	register_taxonomy(
		'people',
		'post',
		array(
			'label' => __( 'People' ),
			'rewrite' => array( 'slug' => 'person' ),
			'capabilities' => array(
				'assign_terms' => 'edit_guides',
				'edit_terms' => 'publish_guides'
			)
		)
	);
}
add_action( 'init', 'people_init' );

wp_set_object_terms( 123, 'Bob', 'person' );


$terms = get_terms( array(
                          'taxonomy' => 'people_taxonony',
                          'hide_empty' => false,  ) );

 $output = '';
 foreach($terms as $term){
    $output .= '<input type="checkbox" name="terms" value="' . $term->name . '" /> ' .  $term->name . '<br />';
  }
  
  
  
  

?>
