<?php 
	global $wpdb;
	$table_name=$wpdb->prefix."coupon_merchants";
$sql="SELECT * FROM $table_name ORDER BY merchant_id DESC";
	$results=$wpdb->get_results($sql);

	
?>
<style>
.checkbox_all
{
	margin:0 0 0 !important;
	
}
.checkbox_heading
{
	width:51px;
}
</style>
<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2>Merchant Details   </h2>
 <h2>	<a href="admin.php?page=coupon-store&id=add" class="button add-new-merchant">Add New Merchants</a> </h2>
	<!--
	  Any description 
	-->
	   <input type="hidden" id="plugin_url" value="<?php echo plugins_url();?>"/>
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
			    <select id="bulck_select" name="bulck_select">
				    <option value="" disabled selected>Bulk Action</option>
					  <option value="trash">Move to Trash</option>
		             
                       <option value="export">Export to Xsl</option>  					  
				</select>
			   </td>
			    <td>
				 <button type="submit" name="submit" id="apply" class="btn btn-primary">Apply</button>
				</td>
				
				<td>
				<?php $this_month=date("F");
                    $month=date("Y-m"); 				?>
			    <select id="bulck_filter" name="bulck_filter">
				    <option value="all" selected>Alldates</option>
					  <option value="<?php echo $this_month;?>"><?php echo $this_month?> </option>
		               
				</select>
			   </td>
			    <td>
				 <input type="submit" name="submit" id="filter" value="filter" class="btn btn-primary"/>
				</td>
				
		   </tr>
		</table>
	</br>
	<table class="wp-list-table widefat fixed posts" cellspacing="0" id="table_items">
		<thead>
			
			<th class="checkbox_heading"><input type="checkbox" class='checkbox_all'></th>
				<th><?php _e('Merchant Name'); ?></th>
				<th><?php _e('Description'); ?></th>
				<th><?php _e('Logo'); ?></th>
				<th><?php _e('Total Offers'); ?></th>
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
						if ( $count >= $end )
							break;
						if ( $count >= $start ){	
                          
                  						
							echo "<tr id='merchant_$result->merchant_id' class='alternate author-self status-publish format-default iedit'>";
							echo "<td  width='10px'><input type='checkbox' class='check_box'/></td>";
							echo "<td>
									<span>".stripslashes($result->name)."</span>
									<div class='row-actions'>
										<span class='inline hide-if-no-js'><a href='admin.php?page=coupon-store&id=add&merchantid=$result->merchant_id' class='editinline'>Edit</a> | </span>
										<span class='trash'><a class='merchantdelete' href='#' alt='$result->merchant_id'>Delete</a> | </span>
										
								
									</div>									
								  </td>";
							echo "<td>$result->description</td>";
							if($result->logo)
							{
							//COUPON_PLUGIN_URL."/uploads/logo/
							echo "<td><img src='".COUPON_PLUGIN_URL."/uploads/logo/$result->logo' class='img-responsive' width='100px' height='100px'/></td>";
							}else 
							{
								echo "<td>No image </td>";
							}
							echo "<td>$result->total_offers</td>";
							echo "<td>$result->created_at</td>";
							
							echo "</tr>";							
						}
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
					<th><?php _e('Merchant Name'); ?></th>
					<th><?php _e('Description'); ?></th>
					<th><?php _e('Logo'); ?></th>
					<th><?php _e('Total Offers'); ?></th>
					<th><?php _e('Created Time'); ?></th>
					
				</tr>
			</tfoot>
		<?php endif;?>	
	</table>
	<div id="ajax-response"></div>
	<br class="clear">
</div>
