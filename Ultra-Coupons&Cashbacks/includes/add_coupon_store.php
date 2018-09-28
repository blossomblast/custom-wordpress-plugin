<?php 
$flag=0;
if($_GET["page"]=="coupon-store"){
	$pageurl=site_url("wp-admin/admin.php?page=coupon-store");
}



if(isset($_GET["merchantid"])){
	
	global $wpdb;
	$merchantid=$_GET["merchantid"];

	$table_name=$wpdb->prefix.'coupon_merchants';

	$row=$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE merchant_id = %d", $merchantid));
	
	
	//print_r($row);
	
	
	$flag=1;
}
?>
<div class="wrap">
    <?php
	 if($flag==0)
	 {
		 ?>
		 <h2><?php _e( 'Add Your New Merchant' ); ?></h2>
	<h3>can add your new merchant info</h3>
	<span id="merchant_response"></span>
		 <?php
	 }
	 else
	 {
		 ?>
		  <h2><?php _e( 'Edit Your Merchant' ); ?></h2>
	<h3>Edit merchant info</h3>
	<span id="merchant_response"></span>
		 <?php
	 }
	?>
	
	<form method="post" action="<?php echo $pageurl;?>" id="coupon_edit_form" enctype='multipart/form-data'>
		<div class="media-single">
			<div class='media-item'>
				<table class="slidetoggle describe form-table" style="border: 0;">
					<thead class="media-item-info" id="media-head-">
						<tr valign="top">
							<td class="A1B1" id="thumbnail-head-">								
								
							</td>
						</tr>			
					</thead>
					<tbody>	
					<tr>
                          <input type="hidden" class="text" id="merchant_id" name="merchant_id" value="<?php echo (isset($row))?stripslashes($row->merchant_id):""; ?>" >
                       
                        	</tr>				
						<tr class="post_title">
							<th valign="top" scope="row" class="label">
								<label for="attachments[0][merchant_name]">
									<span class="alignleft">Merchant Name</span><br class="clear">
								</label>
							</th>
							<td class="field">
						
								<input type="text" class="text" id="merchant_name" name="merchant_name" value="<?php echo (isset($row))?stripslashes($row->name):""; ?>" >
							</td>
						</tr>
						
							<tr class="post_title">
							<th valign="top" scope="row" class="label">
								<label for="attachments[0][merchant_desc]">
									<span class="alignleft">Company description</span><br class="clear">
								</label>
							</th>
							<td class="field">
								<input type="text" class="text" id="merchant_desc" name="merchant_desc" value="<?php echo (isset($row))?stripcslashes($row->description):"";?>" >
							</td>
						</tr>
						
						<tr class="post_title">
							<th valign="top" scope="row" class="label">
								<label for="attachments[0][merchant_logo]">
									<span class="alignleft">Logo</span><br class="clear">
								</label>
							</th>
							<td class="field">
								<input type="file" class="text" id="merchant_logo" name="merchant_logo" >
							</td>
						</tr>
					
					
						
					
					    <tr>
						<div id="file_response"></div>
						<div id="uploaded_profile_image">
                               <?php
							   if($row->logo)
							   {
								   ?>
								   <img src="<?php echo COUPON_PLUGIN_URL.'/uploads/logo/'.$row->logo ?>" class="img-responsive" width="100px" height="100px" />
								   <?php
							   }
							   ?>
							   
						</div>
						 <input type="hidden" id="profile_image_id">
						 
						 
						</tr>
                        							
					</tbody>
				</table>
			</div>
		</div>			
		<p class="submit">
			<input type="button" class="button-primary store_save" value="<?php esc_attr_e('Store/save'); ?>" />
		</p>
		
	</form>	
</div>
