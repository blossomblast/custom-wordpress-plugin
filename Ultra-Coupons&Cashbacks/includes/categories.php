<?php 
	global $wpdb;
	$table_name=$wpdb->prefix."coupon_category";
$sql="SELECT * FROM $table_name ORDER BY category_id DESC";
	$results=$wpdb->get_results($sql);



$table_name1=$wpdb->prefix."sub_category_1";

$table_name2=$wpdb->prefix."sub_category_2";
	
?>
<style>

</style>
<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2>Categories details   </h2>
 <h2>	<a href="admin.php?page=coupon-category&id=add_cat" class="button add-new-merchant">Add New Categories</a> </h2>
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
				$per_page=2;
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
			
				<th><?php _e('Category Name'); ?></th>
				<th><?php _e('Description'); ?></th>
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
                         
							echo "<tr id='category_$result->category_id' class='alternate author-self status-publish format-default iedit'>";
							echo "<td  width='10px'><input type='checkbox' class='check_box'/></td>";
							echo "<td>
								<a href='admin.php?page=coupon-category&id=add_cat&cat_id=$result->category_id'>".stripslashes($result->category)."</a>
									<div class='row-actions'>
										<span class='inline hide-if-no-js'><a href='admin.php?page=coupon-category&id=add_cat&cat_id=$result->category_id' class='editinline'>Edit</a> 
										|
										<span class='inline hide-if-no-js'><a href='admin.php?page=coupon-category&id=add_cat&merchantid=$result->merchant_id' class='editinline'>Quick Edit</a>|
										</span>
										<span class='trash'><a class='categorydelete' href='#' alt='$result->category_id'>Delete</a> | </span>
										
								
									</div>									
								  </td>";
								  
								
							echo "<td>$result->description</td>";
							
							echo "<td>$result->total_offers</td>";
							echo "<td>$result->created_at</td>";
							
							echo "</tr>";	

                          $sql1="SELECT * FROM $table_name1 WHERE category_id=$result->category_id";
	                       $result1=$wpdb->get_results($sql1);
						   if($result1)
						   {
							  // print_r($result1);
                           foreach($result1 as $row1)
						   {
							   
                  						
							echo "<tr id='category1_$row1->category_id' class='alternate author-self status-publish format-default iedit'>";
							echo "<td  width='10px'><input type='checkbox' class='check_box'/></td>";
							echo "<td>
								<a href='admin.php?page=coupon-category&id=add_cat&cat_id=$result->category_id&sub1_id=$row1->subcat_1_id'>"."_".stripslashes($row1->category)."</a>
									<div class='row-actions'>
										<span class='inline hide-if-no-js'><a href='admin.php?page=coupon-category&id=add_cat&cat_id=$result->category_id&sub1_id=$row1->subcat_1_id' class='editinline'>Edit</a>
										| </span>
										<span class='trash'><a class='sub1_delete' href='#'  sub1_id='$row1->subcat_1_id'>Delete</a> | </span>
										
								
									</div>									
								  </td>";
								  
								
							echo "<td>$row1->description</td>";
							
							echo "<td>$row1->total_offers</td>";
							echo "<td>$row1->created_at</td>";
							
							echo "</tr>";	 
                               	 


                                $sql2="SELECT * FROM $table_name2 WHERE category_id=$result->category_id AND sub_cat1_id=$row1->subcat_1_id";
	                       $result2=$wpdb->get_results($sql2);
						   if($result2)
						   {
							   //print_r($result2);
                           foreach($result2 as $row2)
						   {
							    
                  						
							echo "<tr id='category2_$row2->category_id' class='alternate author-self status-publish format-default iedit'>";
							echo "<td  width='10px'><input type='checkbox' class='check_box'/></td>";
							echo "<td>
								<a href='admin.php?page=coupon-category&id=add_cat&cat_id=$result->category_id&sub1_id=$row1->subcat_1_id&sub2_id=$row2->subcat_2_id'>"." _ _".stripslashes($row2->category)."</a>
									<div class='row-actions'>
										<span class='inline hide-if-no-js'><a href='admin.php?page=coupon-category&id=add_cat&cat_id=$result->category_id&sub1_id=$row1->subcat_1_id&sub2_id=$row2->subcat_2_id' class='editinline'>Edit</a>
										|
										</span>
										<span class='trash'><a class='cat2_delete' href='#' cat_id=$row2->subcat_2_id >Delete</a> | </span>
										
								
									</div>									
								  </td>";
								  
								
							echo "<td>$row2->description</td>";
							
							echo "<td>$row2->total_offers</td>";
							echo "<td>$row2->created_at</td>";
							
							echo "</tr>";	   
						   }
						   }

								 
						   }
						   }
						   
							
						}
						$count++;
					}
				?>
			<?php else:?>
				<tr>
					<td align="center" colspan="6" class="empty">No Categories are Added</td>
				</tr>
			<?php endif;?>			
		</tbody>
		<?php if($results):?>
			<tfoot>
				<tr>
				 <th class="checkbox_heading check_cat"><input type="checkbox" class='checkbox_all'></th>
					<th><?php _e('Category Name'); ?></th>
					<th><?php _e('Description'); ?></th>
					
					<th><?php _e('Total Offers'); ?></th>
					<th><?php _e('Created Time'); ?></th>
					
				</tr>
			</tfoot>
		<?php endif;?>	
	</table>
	<div id="ajax-response"></div>
	<br class="clear">
</div>
