<?php 
	global $wpdb;
	
	
$table_name=$wpdb->prefix."ultra_promocode";

$sql="SELECT * FROM $table_name ORDER BY coupon_id DESC";
	$results=$wpdb->get_results($sql);
	
$table1=$wpdb->prefix."coupon_merchants";
$table2=$wpdb->prefix."coupon_type";	
$merchant=$wpdb->get_results("SELECT * FROM $table1");
$coupon_list=$wpdb->get_results("SELECT * FROM $table2");
	
//print_r($merchant);
//print_r($coupon_list);
	?>
<style>

</style>
<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2>Coupon Details   </h2>
 <h2>	<a href="admin.php?page=my-coupon&id=add_coupon" class="button add-new-merchant">Add New coupon</a> </h2>
	<!--
	  Any description 
	-->
	  
	<div class="tablenav">
		<div class="tablenav-pages">
			<?php 
			if($results)
			{
				$count_posts = count($results);
				$pagenum=(isset($_GET["paged"])) ? $_GET["paged"] : 1;
				$per_page=5;
				$allpages=ceil($count_posts / $per_page);
				$base= add_query_arg( 'paged', '%#%' );
				$page_links = paginate_links( array(
					'base' => $base,
					'format' => '',
					'prev_text' => __('&laquo;'),
					'next_text' => __('&raquo;'),
					'total' => $allpages,
					'current' => $pagenum
				));
				$page_links_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s' ) . '</span>%s',
						number_format_i18n( ( $pagenum - 1 ) * $per_page + 1 ),
						number_format_i18n( min( $pagenum * $per_page, $count_posts ) ),
						number_format_i18n( $count_posts ),
						$page_links
						);
				echo $page_links_text;
			}	
			?>
		</div>
	</div>
	
		<table class="wp-list-table widefat fixed posts" cellspacing="0" >
		<tr id="bulk_res"></tr>
		   <tr >
		      <td>
			    <select id="bulck_select_category" name="bulck_select_category">
				    <option value="" disabled selected>Bulk Action</option>
					  <option value="trash">Move to Trash</option>
		             
                       <option value="export">Export to Xsl</option>  					  
				</select>
			   </td>
			    <td>
				 <button type="submit" name="submit" id="apply_category" class="btn btn-primary">Apply</button>
				</td>
				
				<td>
				<?php $this_month=date("F");
                    $month=date("Y-m"); 				?>
			    <select id="bulck_filter_category" name="bulck_filter_category">
				    <option value="all" selected>Alldates</option>
					  <option value="<?php echo $this_month;?>"><?php echo $this_month?> </option>
		               
				</select>
			   </td>
			    <td>
				 <input type="submit" name="submit" id="filter_category" value="filter" class="btn btn-primary"/>
				</td>
				
		   </tr>
		</table>
	</br>
	<table class="wp-list-table widefat fixed posts" cellspacing="0" id="table_items">
		<thead>
			
			<th class="checkbox_heading check_cat"><input type="checkbox" class='checkbox_all'></th>
			    
				<th><?php _e('Coupon Title'); ?></th>
				<th><?php _e('Coupon Type'); ?></th>
				<th><?php _e('Merchant Name'); ?></th>
				<th><?php _e('Merchant Logo'); ?></th>
				
				<th><?php _e('Coupon Code'); ?></th>
				<th><?php _e('Description'); ?></th>
				<th><?php _e('Coupon Image/Iframe'); ?></th>
				<th><?php _e('Short Code'); ?></th>
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



                         foreach($coupon_list as $r1)
						 {
							 if($r1->type_id==$result->type_id)
							 {
								 $coupon=ucfirst($r1->coupon);
							 }
						 }
						    foreach($merchant as $r1)
						 {
							 if($r1->merchant_id==$result->merchant_id)
							 {
								 $merchant_name=ucfirst($r1->name);
								 $logo=$r1->logo;
							 }
						 }
						if ( $count >= $end )
							break;
						if ( $count >= $start ){	
						    
                         
							echo "<tr id='coupon_$result->coupon' class='alternate author-self status-publish format-default iedit'>";
							echo "<td  width='10px'><input type='checkbox' class='check_box'/></td>";
							echo "<td>
								<a href='admin.php?page=my-coupon&id=add_cat&cat_id=$result->coupon_id'>".stripslashes($result->coupon_title)."</a>
									<div class='row-actions'>
										<span class='inline hide-if-no-js'><a href='admin.php?page=my-coupon&id=add_coupon&c_id=$result->coupon_id' class='editinline'>Edit</a> 
										|
										<span class='inline hide-if-no-js'><a href='#'>Quick Edit</a>|
										</span>
										<span class='trash'><a class='coupondelete' href='#' alt='$result->coupon_id'>Delete</a> | </span>
										
								
									</div>									
								  </td>";
								  
								
							echo "<td>$coupon</td>";
							echo "<td>$merchant_name</td>";
							echo "<td><img src='".COUPON_PLUGIN_URL."/uploads/logo/$logo' width='80px' height='80px'/></td>";
							echo "<td>$result->coupon_code</td>";
							echo "<td>$result->product_description</td>";
							 if($result->coupon_image)
							echo "<td><img src='".COUPON_PLUGIN_URL."/uploads/logo/$result->coupon_image' width='80px' height='100px'/></td>";
						    else if($result->iframe_tag)
								echo "<td>$result->iframe_tag</td>";
							else
							  echo "<td>No image</td>";
							echo "<td>$result->short_code</td>";
							echo "<td>$result->created_at</td>";
							
							echo "</tr>";	

                         
							
						}
						$count++;
					}
				?>
			<?php else:?>
				<tr>
					<td align="center" colspan="6" class="empty">No Coupons are Added</td>
				</tr>
			<?php endif;?>			
		</tbody>
		<?php if($results):?>
			<tfoot>
				<tr>
				 <th class="checkbox_heading check_cat"><input type="checkbox" class='checkbox_all'></th>
					<th><?php _e('Copon Type'); ?></th>
				<th><?php _e('Merchant Name'); ?></th>
				<th><?php _e('Merchant Logo'); ?></th>
				<th><?php _e('Coupon Title'); ?></th>
				<th><?php _e('Coupon Code'); ?></th>
				<th><?php _e('Description'); ?></th>
				<th><?php _e('Coupon Image/Iframe'); ?></th>
				<th><?php _e('Short Code'); ?></th>
				<th><?php _e('Created Time'); ?></th>
					
				</tr>
			</tfoot>
		<?php endif;?>	
	</table>
	<div id="ajax-response"></div>
	<br class="clear">
</div>
