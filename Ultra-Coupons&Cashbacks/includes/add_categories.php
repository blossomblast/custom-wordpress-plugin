<?php 
$flag=0;
if($_GET["page"]=="coupon-category")
{
	$pageurl=site_url("wp-admin/admin.php?page=coupon-category");
}

if(isset($_GET["cat_id"])){
	
	global $wpdb;
	$category_id=$_GET["cat_id"];

	$table_name=$wpdb->prefix.'coupon_category';

	$row=$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE category_id = %d", $category_id));
	//print_r($row);
	//echo "view file end";	
	$flag=1;
}
if((isset($_GET['cat_id']))&&(isset($_GET['sub1_id'])))
{
	
  $category_id=$_GET["cat_id"];
  $sub1_id=$_GET["sub1_id"];
  if(isset($_GET['sub2_id']))
  {
	  $sub2_id=$_GET["sub2_id"];
	$table_name=$wpdb->prefix.'sub_category_2';
  // echo "sub1 id ".$sub1_id."<br>";
	$row=$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE category_id = %d AND sub_cat1_id=%d AND subcat_2_id" , $category_id,$sub1_id,$sub2_id));
	$flag=3;	
	 
  }
   else
   {
	$table_name=$wpdb->prefix.'sub_category_1';
  // echo "sub1 id ".$sub1_id."<br>";
	$row=$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE category_id = %d AND subcat_1_id=%d" , $category_id,$sub1_id));
	$flag=2;	
   }
}
	//print_r($row);
	//echo "view file end";	
	//echo "flag value ".$flag;
?>

<div class="wrap">
    <?php
	 if($flag==0)
	 {
		 ?>
		 <h2><?php _e( 'Add New category' ); ?></h2>
	<h3>can add  new category  info</h3>
		 <?php
	 }
	 else
	 {
		 ?>
		  <h2><?php _e( 'Edit Your category' ); ?></h2>
	<h3>Edit category info</h3>
		 <?php
	 }
	?>
	
	       <div class="container ">    
        
       
                    <div class="panel panel-info ">
					
                        <div class="panel-heading">
						
                            <div class="panel-title">
							<?php if($flag!=0)
								echo "Edit Category";
							  else
								echo "Add Category";
								?>
							</div>
                         
                        </div>  
                        <div class="panel-body" >
						<div class="row">
						<div class="col-md-6">
					      <span id="response"></span>
						  </div>
						  <div class="col-md-6">
						  <span id="response1"></span>
						  </div>
						  </div>
						  <div class="row">
					    <div class="col-md-6 " id="category_block_id">
                        <div id="cat_head">
					       <?php
						    if($flag==1)
							{
								$val=$row->category_id;
								 $url=admin_url().'admin.php?page=coupon-category';	 
								 $edit="edit_category";
								?>
							
												 
							   <button type="button" class="btn btn-primary btn-sm" id="add_more_sub_cat" data-id="<?php echo $val;?>" edit_id="<?php echo $edit;?>" cat_name="<?php echo (isset($row))?stripcslashes($row->category):"";?>" cat1_edit="cat1_edit">Add Category
           </button>&nbsp;&nbsp;
		   <button id="sub_cancel_btn" class="btn btn-primary" data-id="<?php echo $url;?>">Close</button>
								<?php
							}
							if($flag==2)
							{
								if($row->sub_category_2==1)
								{
									$sql="SELECT category FROM wp_coupon_category WHERE category_id=$row->category_id";
									$cat=$wpdb->get_row($sql);
									 //print_r($cat);
									//echo "cate ".$cat->category;
									 $pageurl=admin_url().'admin.php?page=coupon-category';
									?>
									 <h3> Add Sub Categories    of  <?php echo $cat->category;?> </h3>
									 <button type="button" class="btn btn-primary btn-sm" id="add_sub2_cat_by_sub1" data-id="<?php echo $row->category_id; ?>" data-sub1-id="<?php echo $row->subcat_1_id; ?>" data-subname="<?php echo $row->category;?>"  >
             Add Sub Category
           </button>&nbsp;
		     <button id="sub_cancel_btn" data-id="<?php echo $pageurl; ?>" class="btn btn-primary">Close</button>
									<?php
								}
								
							}else if($flag==3)
							{
									$sql="SELECT category FROM wp_coupon_category WHERE category_id=$row->category_id";
									$cat=$wpdb->get_row($sql);
										$sql="SELECT category FROM wp_sub_category_1 WHERE subcat_1_id=$row->sub_cat1_id";
									$sub=$wpdb->get_row($sql);
						   ?>
						   <h3> Under  the Category :<strong>  <?php echo $cat->category;?> </strong> </h3>
						    
						   <h3>Sub Category          :              <strong><?php echo $sub->category;?></strong></h3>
						   <?php
							}
							?>
							</div><div id="cat_block">
                              <form method="post" action="<?php echo $pageurl;?>"  enctype='multipart/form-data' class="form-horizontal" role="form">  
                                
                                    
                                <input type="hidden" class="text" id="category_id" name="category_id" value="<?php echo (isset($row))?stripslashes($row->category_id):""; ?>" >
                                  
                                <div class="form-group">
                                    <label for="name" class="col-md-3 control-label">Category Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="category" id="category" placeholder="Category Name" value="<?php echo (isset($row))?stripcslashes($row->category):"";?>" >
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="description" class="col-md-3 control-label">Description</label>
                                    <div class="col-md-9">
                                        <textarea  class="form-control" name="description" id="description" placeholder="Description"><?php echo (isset($row))?stripcslashes($row->description):"";?>
										</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                   
                                   
									
									 <?php
									 if($flag==2)
									 {
										 ?>
										   <label for="subcategory" class="col-md-3 control-label">Does this has Sub category</label> 
										  <div class="col-md-9">
                                        <input type="radio" class="form-control" name="sub_cat" value="<?php echo (isset($row)&&$row->sub_category_2==1)?stripcslashes($row->sub_category_2):"1";?>" <?php echo (isset($row)&&$row->sub_category_2==1)?"checked":'1';?>>   YES
										</br>
										</br>
										<input type="radio" class="form-control" name="sub_cat"  value="<?php echo (isset($row)&&$row->sub_category_2==0)?stripcslashes($row->sub_category_2):"0";?>" <?php echo (isset($row)&&$row->sub_category_2==0)?"checked":'0';?>>   NO
                                    </div>
										 <?php
									 }
									 else if($flag==0||$flag==1)
									 {
										  ?>
										   <label for="subcategory" class="col-md-3 control-label">Does this has Sub category</label>
										  <div class="col-md-9">
                                        <input type="radio" class="form-control" name="sub_cat" value="<?php echo (isset($row)&&$row->sub_category==1)?stripcslashes($row->sub_category):"1";?>" <?php echo (isset($row)&&$row->sub_category==1)?"checked":'1';?>>   YES
										</br>
										</br>
										<input type="radio" class="form-control" name="sub_cat"  value="<?php echo (isset($row)&&$row->sub_category==0)?stripcslashes($row->sub_category):"0";?>" <?php echo (isset($row)&&$row->sub_category==0)?"checked":'0';?>>   NO
                                    </div> 
										  
										  <?php
									 }
									 ?>
									 <span id="sub" style="display:none;
									                        color:red;
															text-align:center;" >
									    Choose whether It has sub category? 
									 </span>
                                </div>
                               
                                    
                              

                                <div class="form-group">
                                                                        
                                    <div class="col-md-offset-3 col-md-9">
                               
                                     <?php
									   if($flag==2)
									   {
										   ?>
										   
										      <input type="hidden" id="sub1_id" value="<?php echo $row->subcat_1_id; ?>"/>
										   <input type="hidden" id="last_cat_id" value="<?php echo $row->category_id; ?>"/>
										   <input type="button" class="btn btn-primary   sub_category1_update" value="<?php esc_attr_e('Save'); ?>" />
										   <?php
										   
									   }
									   else if($flag==3)
									   {
										   ?>
										   
										     <input type="hidden" id="sub2_id" value="<?php echo $row->subcat_2_id; ?>"/>
										   
										      <input type="hidden" id="sub1_id" value="<?php echo $row->sub_cat1_id; ?>"/>
										   <input type="hidden" id="cat_id" value="<?php echo $row->category_id; ?>"/>
										   <input type="button" class="btn btn-primary   sub_category2_update" value="<?php esc_attr_e('Save'); ?>" />
										   <?php
									   }
									   else
									   {
									 ?>
									   <input type="button" class="btn btn-primary   category_save" value="<?php esc_attr_e('Save'); ?>" />
									   <?php
									   }
									   ?>
									   
                                    </div>
                                </div>
                                
                             
                                
                                
                            </form>
							</div>
							
						  </div>
							  <div class="col-md-6" id="sub_head">

                            </div>						  
					      </div>
					 <div class="row col-md-12">
					 
					   <div class="col-md-6" id="sub1_id" class="content_block" style="padding-top: 15px;">

                               							   
					   </div>
					   <div class="col-md-6" id="sub2_id" class="content_block" style="padding-top: 15px;">
					   </div>
					  
                   </div>	
					
					        
                         </div>
						 
						 
						 
						
						 
                    </div>
					

									
               
			   
			  <!-- 
			   <h4>Stored Categories are:</h4>
							   <div class="category_block">
							   <?php
							   if(is_array($results))
							   {
							   ?>
							    <table class="table table-responsive" border='2'>
							
								   <thead>
								   <th>S.NO</th> 
								    <th>Category</th>
									</thead>
									
									<tbody>
									 <?php
									 $count=0;
									 
									 foreach($results as $row)
									 {
										 $count++;
										 echo "<tr>";
										 echo "<td>".$count."</td>";
										 echo "<td>".$row->category."</td>";
										 echo "</tr>";
									 }
									 ?>
									</tbody>
								</table>
								<?php
							   }
							   else
							   {
								   echo "No categories are Found. Please add category";
								   }
								?>
								
							   </div>  -->
							
			   
               
                
        
    </div>
	 
	 
</div>





<div class="wrap" id="all_categories">

	<?php
	
	$table_name=$wpdb->prefix."coupon_category";
$sql="SELECT * FROM $table_name ORDER BY category_id DESC";
	$results=$wpdb->get_results($sql);

	
	$table_name1=$wpdb->prefix."sub_category_1";

$table_name2=$wpdb->prefix."sub_category_2";
	?>
	
	<table class="table table-striped table-responsive" cellspacing="0" id="example2">
		<thead>
			
			<th class="checkbox_heading"><input type="checkbox" class='checkbox_all'></th>
			
				<th><?php _e('Category Name'); ?></th>
				<th><?php _e('Description'); ?></th>
				<th><?php _e('Total Offers'); ?></th>
				<th><?php _e('Has subcategory'); ?></th>
				<th><?php _e('Created Time'); ?></th>
				
				
		
		</thead>
		
		<tbody id="merchant_list">
		
			<?php if($results):?>
				<?php 
					//echo $pagenum;
					
					$count = 0;
					$start = ($pagenum - 1) * $per_page;
					$end = $start + $per_page;
					foreach ($results as $result){						
							echo "<tr id='merchant_$result->category_id' class='alternate author-self status-publish format-default iedit'>";
							echo "<td  width='10px'><input type='checkbox' class='check_box'/></td>";
							echo "<td>
									<span>".stripslashes($result->category)."</span>
									<div class='row-actions'>
										<span class='inline hide-if-no-js'><a href='admin.php?page=coupon-store&id=add&merchantid=$result->merchant_id' class='editinline'>Edit</a> | </span>
										<span class='trash'><a class='merchantdelete' href='#' alt='$result->merchant_id'>Delete</a> | </span>
										
								
									</div>									
								  </td>";
								  
								
							echo "<td>$result->description</td>";
							
							echo "<td>$result->total_offers</td>";
							echo "<td>$result->sub_category</td>";
							echo "<td>$result->created_at</td>";
							
							echo "</tr>";							
						    
						$count++;
					}
				?>
			<?php else:?>
				<tr>
					<td align="center" colspan="6" class="empty">No Merchants are Added</td>
				</tr>
			<?php endif;?>			
		</tbody>
		<?php if($results):?>
			<tfoot>
				<tr>
				 <th class="checkbox_heading"><input type="checkbox" class='checkbox_all'></th>
					<th ><?php _e('Category Name'); ?></th>
					<th><?php _e('Description'); ?></th>
					
					<th><?php _e('Total Offers'); ?></th>
					<th><?php _e('Created Time'); ?></th>
					
				</tr>
			</tfoot>
		<?php endif;?>	
	</table>
	
  
</div>


<script>
  jQuery(function () {
	  
    jQuery('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>  