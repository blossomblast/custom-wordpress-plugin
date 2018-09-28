<?php 

/* if($_GET["page"]=="coupon-new"){
	$pageurl=site_url("wp-admin/admin.php?page=coupon");
}



if(isset($_GET["couponid"])){
	$couponid=$_GET["couponid"];
	$row=$wpdb->get_row($wpdb->prepare("SELECT * FROM $this->coupon_table WHERE id = %d", $couponid));
} */

global $wpdb;
$table=$wpdb->prefix."coupon_type";
$sql="SELECT * FROM $table";
$coupon_type=$wpdb->get_results($sql);


$table1=$wpdb->prefix."coupon_merchants";
$sql="SELECT * FROM $table1";
$merchants=$wpdb->get_results($sql);


$table2=$wpdb->prefix."coupon_category";
$sql="SELECT * FROM $table2";
$category=$wpdb->get_results($sql);

$table3=$wpdb->prefix."sub_category_1";
$sql="SELECT * FROM $table3";
$sub_cat1=$wpdb->get_results($sql);

$table4=$wpdb->prefix."sub_category_2";
$sql="SELECT * FROM $table4";
$sub_cat2=$wpdb->get_results($sql);


$table5=$wpdb->prefix."image_coupon_type";
$sql="SELECT * FROM $table5";
$image_coupon=$wpdb->get_results($sql);

if($_GET['c_id'])
{
	$table_name=$wpdb->prefix."ultra_promocode";
	$coupon_id=$_GET['c_id'];
	//echo "coupon id ".$coupon_id;
 $result=$wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE coupon_id=%d",$coupon_id));
 //print_r($result);
 
}

?>

 <script type="text/javascript">
            jQuery(function () {
    var todayDate=new Date();
     jQuery('#coupon_start').datepicker(
	{
		format:'dd-mm-yyyy',
		todayHighlight: true,
		autoclose: true,
		 startView:3,
		 // todayBtn: true,
		 "setDate": new Date(),
		 orientation: "auto right",
        keyboardNavigation:true
	}).datepicker('update','<?php $start=$result->coupon_start_date;
                                    $t1=date_create($start);
                         $s1=date_format($t1,'d-m-Y');
						 $date=date("d-m-Y");
                   echo (isset($result)&&$result->coupon_start_date)?$s1:$date;						 ?>');
	 
	
	
	
	
	  jQuery('#coupon_end').datepicker(
	{
		format:'dd-mm-yyyy',
		todayHighlight: true,
		autoclose: true,
		 startView:3,
		 // todayBtn: true,
		 "setDate": new Date(),
		 orientation: "auto right",
        keyboardNavigation:true
	}).datepicker('update','<?php $start=$result->coupon_end_date;
                                    $t1=date_create($start);
                         $s1=date_format($t1,'d-m-Y');
						 $date=date("d-m-Y");
                   echo (isset($result)&&$result->coupon_end_date)?$s1:$date;						 ?>');
	
	
	
	jQuery("input[name='image_coupon_type']").click(function () {
            if (jQuery("#image_coupon_type1").is(":checked")) {
                jQuery("#image_id").show();
				jQuery("#link_id").show();
				jQuery("#uploaded_profile_image").show();
				jQuery("#iframe_image_id").hide();
				
            } else {
                jQuery("#iframe_image_id").show();
				 jQuery("#image_id").hide();
				jQuery("#link_id").hide();
				jQuery("#uploaded_profile_image").hide();
            }
        });
	
 });

 </script>
<div class="wrap">
	<h2><?php _e( 'Add New Coupon' ); ?></h2>

	
<div class="container">
<div class="row">
<span id="coupon_form_response"></span>
<div class="page-header">
<!-- <h3>Add New coupon</h3> -->
</div>
<form class="form-horizontal" role="form" method="post" id="coupon_form">
 
 <div class="form-group">
 <label for="coupon_heading" class="col-md-2 control-label">Coupon Title</label>
  <div class="col-md-6">
   <input type="text" name="coupon_heading" id="coupon_heading"class="form-control" placeholder="Coupon Title" value="<?php echo (isset($result))?stripslashes($result->coupon_title):""; ?>"/>
  </div>
 </div>
<div class="form-group">
<label for="Merchantname" class="col-sm-2 control-label">Merchant </label>
<div class="col-sm-6">
<select class="form-control" name="merchant" id="merchant">
<option value="" disabled selected>Select Your Merchant</option> 
<?php
if(is_array($merchants)&& !empty($merchants))
{
    foreach($merchants as $row)
	{
		 ?>
		<option value="<?php echo $row->merchant_id;?>" <?php echo (isset($result)&&($result->merchant_id==$row->merchant_id))?"selected":"";?>><?php echo $row->name; ?></option>
		<?php 
		
		
	}		
}	
?>
</select>

</div>
</div>
 <div class="form-group">
  <label for="category" class="col-sm-2 control-label">Category</label>
    <div class="col-sm-6">
	 <select id="category" name="category" class="form-control">
	   <option value="" disabled selected>Select Your Category</option>
	    <?php
		if(is_array($category)&& !empty($category))
		{
			foreach($category as $row)
			{
				//echo "<option value='".$row->category_id."'>".$row->category."</option>";
				echo "<option value='".$row->category_id."'  ";
				echo (isset($result)&&($row->category_id==$result->category_id))?"selected":"";
				echo ">".$row->category."</option>";
				
				
			}
		}
		//echo "<option value='".$row->category_id."'>".$row->category."</option>";
		?>
	 </select>
	</div>
 </div>
  <div class="form-group" id="sub1_id" style="<?php
                            echo (isset($result)&&($result->subcat1_id))?"":"display:none"  ?>">
  <label for="category" class="col-sm-2 control-label">Sub Category</label>
    <div class="col-sm-6">
	 <select id="subcategory" name="subcategory" class="form-control">
	   <option value="" disabled selected>Select Your Sub Category</option>
	    <?php
		if(is_array($sub_cat1)&& !empty($sub_cat1))
		{
			foreach($sub_cat1 as $row)
			{
				//echo "<option value='".$row->subcat_1_id."'>".$row->category."</option>";
				echo "<option value='".$row->subcat_1_id."' ";
				echo (isset($result)&&($row->subcat_1_id==$result->subcat1_id))?"selected ":"";
				echo ">".$row->category."</option>";
			}
		}
		?>
	 </select>
	</div>
 </div>
 
   <div class="form-group" id="sub2_id" style="<?php
                            echo (isset($result)&&($result->subcat2_id))?"":"display:none"  ?>">
  <label for="category" class="col-sm-2 control-label">Sub Category 2</label>
    <div class="col-sm-6">
	 <select id="subcategory_2" name="subcategory_2" class="form-control">
	   <option value="" disabled selected>Select Your Sub Category 2</option>
	    <?php
		if(is_array($sub_cat2)&& !empty($sub_cat2))
		{
			foreach($sub_cat2 as $row)
			{
				//echo "<option value='".$row->subcat_2_id."'>".$row->category."</option>";
				echo "<option value='".$row->subcat_2_id."' ";
				echo (isset($result)&&($row->subcat_2_id==$result->subcat2_id))?"selected ":"";
				echo ">".$row->category."</option>";
			}
		}
		?>
	 </select>
	</div>
 </div>

<div class="form-group">
<label for="lastName" class="col-sm-2 control-label">Coupon Type</label>
<div class="col-sm-6">
    <select id="coupon_type" name="coupon_type" class="form-control">
	   <option value="" disabled selected>Select Coupon Type</option>
	    <?php
	
		if(is_array($coupon_type)&& !empty($coupon_type))
		{
			foreach($coupon_type as $row)
			{
				echo "<option value='".$row->type_id."' ";
				echo (isset($result)&&$result->type_id==$row->type_id)?"selected ":"";
				echo ">".$row->coupon."</option>";
			}
		}
		?>
	 </select>
</div>
</div>

<div class="form-group" id="coupon_code_id" style="<?php
                          echo (isset($result)&&($result->coupon_code))?"":"display:none"  ?>">
  <label for="coupon-code" class="col-sm-2 control-label">Coupon Code</label>
   <div class="col-sm-6">
      <input type="text" name="coupon_code" id="coupon_code" placeholder="Place Your Product  Coupon Code" class="form-control" value="<?php echo (isset($result))?$result->coupon_code:"";?>">
   </div>
</div>

<div class="form-group" id="deal_button_id" style="<?php
                          echo (isset($result)&&($result->deal_button_text))?"":"display:none"  ?>">
<label for="deal_button" class="col-sm-2 control-label">Deal Button Text</label>
<div class="col-sm-6">
<input type="text" name="deal_button" class="form-control" id="deal_button" placeholder="ie: Get Deal or DEAL Or GET" value="<?php echo (isset($result)&&($result->deal_button_text))?$result->deal_button_text:""; ?>">
</div>
</div>
 

<div class="form-group" id="link_id" style="<?php 
    echo (isset($result)&&$result->image_coupon_type)?"display:none":"";?>" >
  <label for="coupon-link" class="col-sm-2 control-label">Link</label>
   <div class="col-sm-6">
      <input type="text" name="coupon_link" id="coupon_link" placeholder="Place Your Product Link" class="form-control" value="<?php echo (isset($result)&&$result->link)?$result->link:""; ?>">
   </div>
</div>
<div class="form-group"  id="discount_id" style="<?php
                          echo (isset($result)&&($result->discount))?"":"display:none"  ?>" >
  <label for="discount" class="col-sm-2 control-label">discount</label>
   <div class="col-sm-6">
      <input type="text" name="discount" id="discount" placeholder="ie. 60% offer or 70%Off" class="form-control" value="<?php echo (isset($result)&&$result->discount)?$result->discount:"";?>">
   </div>
</div>
<div class="form-group" id="description_id" style="<?php
                          echo (isset($result)&&($result->product_description))?"":"display:none"  ?>" >
  <label for="description" class="col-sm-2 control-label">Description</label>
   <div class="col-sm-6">      
	  <textarea name="description" id="description" placeholder="Enter your product Description" class="form-control" value="<?php echo (isset($result)&&$result->product_description)?$result->product_description:"";?>"></textarea>
   </div>
</div>

<div class="form-group" id="coupon_expire_id"  style="<?php
                          echo (isset($result)&&$result->type_id!=3)?"":"display:none"  ?>">
<label for="expiration" class="col-sm-2 control-label">Coupon/Deal Expiration</label>
<div class="col-sm-6">
<label class="radio-inline">
<input type="radio" name="coupon_expiration" id="expire1" value="<?php echo (isset($result)&&$result->coupondeal_expiration==1)?stripcslashes($result->coupondeal_expiration):"1";?>" <?php echo (isset($result)&&$result->coupondeal_expiration==1)?"checked":'1';?>>Show
</label>
<label class="radio-inline">
<input type="radio" name="coupon_expiration" id="expire2" value="<?php echo (isset($result)&&$result->coupondeal_expiration==0)?stripcslashes($result->coupondeal_expiration):"0";?>" <?php echo (isset($result)&&$result->coupondeal_expiration==0)?"checked":'0';?>>Hide
</label>
 
</div>
</div>
 <span id="expire_err"></span>
 
<div class="form-group" id="coupon_start_id" style="<?php
                          echo (isset($result)&&($result->coupon_start_date)&&$result->type_id!=3)?"":"display:none"  ?>" >
<label for="coupon_start" class="col-sm-2 control-label">Coupon Start Date</label>
<div class="col-sm-6">

<input type="text" name="coupon_start" class="form-control datepicker" id="coupon_start" placeholder=" Date of Start"  onkeydown="event.preventDefault()" >
</div>
</div>
 <div class="form-group" id="coupon_end_id" style="<?php
                          echo (isset($result)&&($result->coupon_end_date)&&$result->type_id!=3)?"":"display:none"  ?>">
<label for="coupon_end" class="col-sm-2 control-label">Coupon End Date</label>
<div class="col-sm-6">
<input type="text" name="coupon_end" class="form-control datepicker" id="coupon_end" placeholder=" Date of End" onkeydown="event.preventDefault()">
</div>
</div>

<div class="form-group" id="coupon_hide_id" style="<?php 
                    echo (isset($result)&&$result->type_id==1)?"display:block":"display:none";   ?>" >
<label for="expiration" class="col-sm-2 control-label">Hide coupon</label>
<div class="col-sm-6">
<label class="radio-inline">
<input type="radio" name="hide_coupon" id="hide_coupon" value="<?php echo (isset($result)&&$result->hide_coupon==1)?stripcslashes($result->hide_coupon):"1";?>" <?php echo (isset($result)&&$result->hide_coupon==1)?"checked":'1';?>>Yes
</label>
<label class="radio-inline">
<input type="radio" name="hide_coupon" id="hide_coupon1" value="<?php echo (isset($result)&&$result->hide_coupon==0)?stripcslashes($result->hide_coupon):"0";?>" <?php echo (isset($result)&&$result->hide_coupon==0)?"checked":'0';?>>No
</label>
 
</div>
</div>

<div class="form-group" id="image_coupon_id"  style="<?php
            echo (isset($result)&&($result->image_coupon_type)&&$result->type_id==3)?"":"display:none" ?>">
<label for="expiration" class="col-sm-2 control-label">Image coupon format</label>
<div class="col-sm-6">
<!--
<label class="radio-inline">
<input type="radio" name="image_coupon_type" id="image_coupon_type1" value="1">Custom Upload
</label>
<label class="radio-inline">
<input type="radio" name="image_coupon_type" id="image_coupon_type2" value="2">I frame tag
</label>   -->
 
  <?php
  //echo $row->image_type_id;
    foreach($image_coupon as $row)
	{
		?>
		<label class="radio-inline">
<input type="radio" name="image_coupon_type" id="image_coupon_type<?php echo $row->image_type_id?>"  value="<?php echo (isset($result)&&$result->image_coupon_type==$row->image_type_id)?stripcslashes($result->image_coupon_type):$row->image_type_id;?>" <?php echo (isset($result)&&$result->image_coupon_type==$row->image_type_id)?"checked":'';?>><?php echo $row->category;?>
</label>
		<?php
	}
  ?> 
</div>

</div>

 
 
 <div class="form-group">

<div class="col-sm-2">
<span id="file_response"></span>
</div>
<div class="col-sm-8">
	<div id="uploaded_profile_image">
                              <?php
							  if($result->coupon_image)
							   {
								   ?>
								   <img src="<?php echo COUPON_PLUGIN_URL.'/uploads/logo/'.$result->coupon_image?>" class="img-responsive" width="150px" height="150px" />
								   <?php
							   }
                               else if($result->iframe_tag) 
								   {
									   echo $result->iframe_tag;
							       }								   
							 ?>  
							    
						</div>
						 <input type="hidden" id="profile_image_id">

</div>
<div class="col-sm-2">
</div>
</div>

 
 
 
<div class="form-group" id="image_id" style="<?php 
    echo (isset($result)&&($result->coupon_image))?"":"display:none" ?>">
<label for="coupon_image" class="col-sm-2 control-label">Coupon Image</label>
<div class="col-sm-6">
<input type="file" name="coupon_image" class="form-control" id="coupon_image" placeholder="coupon image">
</div>
</div>
 
 <div class="form-group" id="iframe_image_id" style="<?php 
         echo (isset($result)&&($result->iframe_tag)&&$result->type_id==3)?"":"display:none" ?>">
<label for="iframe_image" class="col-sm-2 control-label">I-Frame  Code</label>
<div class="col-sm-6">

<textarea name="iframe_image" class="form-control" id="iframe_image" placeholder="Place I freme image code"></textarea>
</div>
</div>
 
  <input type="hidden" id="coupon_id" value="<?php echo (isset($result)&&($result->coupon_id))?$result->coupon_id:"";?>"/>
<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-primary" id="register">Add Coupon</button>
</div>
</div>
 
</form>
 
</div><!-- end for class "row" -->
</div><!-- end for
</div>

