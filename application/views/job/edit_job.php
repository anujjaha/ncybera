<script src="<?php echo base_url();?>assets/js/job_details.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />
<script>
    $(document).ready(function() {
      $('.fancybox').fancybox({
		'width':800,
        'height':600,
        'autoSize' : false,
        'afterClose':function () {
			fancy_box_closed();
		},
    });
});

function customer_selected(type,userid) {
	jQuery("#customer_id").val(userid);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_customer_ajax/id/"+userid, 
         success: 
              function(data){
				jQuery("#mobile_"+type).val('');
				jQuery("#mobile_"+type).val(data);
			 }
          });
}
function auto_suggest_price(id){
	jQuery("#fancybox_id").val(id);
}
function set_cutting_details(id,cutting_id,job_id){
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_update_cutting_details/"+cutting_id+"/"+job_id+"/"+id, 
         success: 
            function(data){
                  jQuery("#fancy_box_cutting").html(data);
            }
          });
}

function set_fbox_data(data) {
	$("#machine").val(data['c_machine']);
	$("#size").val(data['c_size']);
	$("#size_info").val(data['c_sizeinfo']);
	$("#printing").val(data['c_print']);
	$("#lamination").val(data['c_lamination']);
	$("#lamination_info").val(data['c_laminationinfo']);
	$("#binding").val(data['c_binding']);
	$("#binding_info").val(data['c_bindinginfo']);
	$("#packing").val(data['c_packing']);
	$("#checking").val(data['c_checking']);
	$("#details").val(data['c_details']);
}

function set_cutting_details_box(id){
	var data_id =jQuery("#fancybox_cutting_id").val();
	var machine,size,details,lamination,printing,packing,lamination_info,binding,checking;
        machine = $('input:radio[name=machine]:checked').val();// jQuery("#machine").val();
        
      binding = ""; 
      var $boxes = $('input[name=binding]:checked');
      $boxes.each(function(){
		  if($(this).val().length > 0 ) {
			binding = $(this).val() + ","+binding;  
		  }
		});
        
        lamination_info = jQuery("#lamination_info").val();
        size_info = jQuery("#size_info").val();
        binding_info = jQuery("#binding_info").val();
        details = jQuery("#details").val();
        lamination = $('input:radio[name=lamination]:checked').val();//jQuery("#lamination").val();
        checking = $('input:radio[name=checking]:checked').val();//jQuery("#lamination").val();
        size = $('input:radio[name=size]:checked').val();//jQuery("#lamination").val();
        printing =  $('input:radio[name=printing]:checked').val();// jQuery("#printing").val();
        packing =  $('input:radio[name=packing]:checked').val(); //printing jQuery("#packing").val();
        jQuery("#c_machine_"+data_id).val(machine);
        jQuery("#c_qty_"+data_id).val(jQuery("#qty_"+data_id).val());
        jQuery("#c_material_"+data_id).val(jQuery("#details_"+data_id).val());
        jQuery("#c_size_"+data_id).val(size);
        jQuery("#c_details_"+data_id).val(details);
        jQuery("#c_lamination_"+data_id).val(lamination);
        jQuery("#c_print_"+data_id).val(printing);
        jQuery("#c_packing_"+data_id).val(packing);
        jQuery("#c_laminationinfo_"+data_id).val(lamination_info);
        jQuery("#c_sizeinfo_"+data_id).val(size_info);
        jQuery("#c_bindinginfo_"+data_id).val(binding_info);
        jQuery("#c_binding_"+data_id).val(binding);
        jQuery("#c_checking_"+data_id).val(checking);
        $.fancybox.close();
}
function remove_cutting_details(data_id) {
    jQuery("#cut_icon_"+data_id).css('display','none');
     jQuery("#c_machine_"+data_id).val('');
        jQuery("#c_qty_"+data_id).val('');
        jQuery("#c_material_"+data_id).val('');
        jQuery("#c_size_"+data_id).val('');
        jQuery("#c_details_"+data_id).val('');
        jQuery("#c_lamination_"+data_id).val('');
        jQuery("#c_print_"+data_id).val('');
        jQuery("#c_packing_"+data_id).val('');
    }
function fancy_box_closed(id){
	//alert(jQuery("#fancybox_id").val());
}

function calculate_paper_cost(){
	var paper_gram,paper_size,paper_print,ori_paper_qty,paper_qty,amount=0,total=0,id,mby=1;
	paper_gram = jQuery("#paper_gram").val();
	paper_size = jQuery("#paper_size").val();
	paper_print = jQuery("#paper_print").val();
	id = jQuery("#fancybox_id").val();
	paper_qty = jQuery("#paper_qty").val();
	ori_paper_qty = jQuery("#paper_qty").val();
	if(paper_print == "FB") {
		paper_qty = paper_qty *2;
	}
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_paper_rate/", 
         data:{"paper_gram":paper_gram,"paper_size":paper_size,
                "paper_print":paper_print,"paper_qty":paper_qty},
         dataType:"json",
         success: 
              function(data){
                if(data.success != false ) {

                  amount = amount + parseFloat(data.paper_amount);
                  if(paper_print == "FB" ) {
						if(paper_size == "13X19" || paper_size == "13x19" ) {
							amount = amount * 2 - 3;
						}
					}
					
                  total = (amount * paper_qty )* mby;
                  jQuery("#result_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );
                  jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
                  if(paper_print == "FB") {
                          jQuery("#rate_"+id).val(amount * 2);
                    if(paper_size == "13X19" || paper_size == "13x19" ) {
						  jQuery("#rate_"+id).val(amount * 2 - 3);
					}
                  } else {
					  jQuery("#rate_"+id).val(amount);
				  }
                  
                  jQuery("#qty_"+id).val(ori_paper_qty);
                  jQuery("#sub_"+id).val(total);
                  $('#flag_'+id).prop('checked', true);
            } else {
                   jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
                  jQuery("#result_paper_cost").html("[ Data not Found - Insert Manual Price]");
            }
        }
          });
}
function check_form() {
	
	if(jQuery("#confirmation").val().length > 0 ) {
		return true;
	}
	if(jQuery("#subtotal").val().length < 1 ) {
		jQuery("#subtotal").focus();
	} else {
		jQuery("#confirmation").focus();
	}
	
	return false;
}
function check_visiting_card(sr) {
		if($("#category_"+sr).val() == "Cutting") {
			$("#details_"+sr).val("Cutting Details");
		}
		if($("#category_"+sr).val() == "Lamination") {
			$("#details_"+sr).val("Lamination");
		}
		if($("#category_"+sr).val() == "B/W Print") {
			$("#details_"+sr).val("B/W Print");
		}
}
</script>
<?php
$this->load->helper('form');
$this->load->helper('general');
$modified_by = $this->session->userdata['user_id'];
?>
<form action="<?php echo base_url();?>jobs/edit_job/<?php echo $job_data->id;?>" method="post" onsubmit="return check_form();">
<div class="col-md-12">
<table width="100%" border="2">
	<tr>
		<td colspan="2">
			<div id="regular_customer" style="display:block;">
				<table width="100%">
					<tr>
						<td width="50%">
							Customer Name : <?php echo $customer_details->companyname ? $customer_details->companyname : $customer_details->name;?>
						</td>
						<td width="50%" align="right">
							Contact Number : <input type="text" value="<?php echo $customer_details->mobile;?>" name="user_mobile" id="mobile_customer">
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<table width="100%" border="2">
	<tr>
		<td colspan="7" align="center">
			Job Name : <input type="text" name="jobname" id="jobname" value="<?php echo $job_data->jobname;?>" style="width:250px;">
		</td>
	</tr>
	<tr>
		<td width="5%">Sr</td>
		<td width="5%">Rate</td>
		<td width="10%">Category</td>
		<td width="50%">Details</td>
		<td width="10%">Qty.</td>
		<td width="10%">Rate</td>
		<td width="10%">Amount</td>
	</tr>
	<?php 
	$j=0;
	for($i=1;$i<6;$i++){ 
		?>
	<tr>
		<td><?php echo $i;?>
		<input type="hidden" name="jdid_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['id'])) { echo $job_details[$j]['id']; }?>" >
		</td>
		<td><input type="checkbox" id="flag_<?php echo $i;?>" name="flag_<?php echo $i;?>"></td>
		<td>
			<select name="category_<?php echo $i;?>" onChange="check_visiting_card(<?php echo $i;?>);">
				<option
				 <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Digital Print' ) { echo 'selected="selected"';} ?>>
				 Digital Print</option>
				<option
				 <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Visiting Card' ) { echo 'selected="selected"';} ?>>
				 Visiting Card</option>
				<option <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Offset Print' ) { echo 'selected="selected"';} ?>>
				Offset Print</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Cutting' ) { echo 'selected="selected"';} ?>>
				Cutting</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Designing' ) { echo 'selected="selected"';} ?>>
				Designing</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Binding' ) { echo 'selected="selected"';} ?>>
				Binding</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Packaging and Forwading' ) { echo 'selected="selected"';} ?>>
				Packaging and Forwading</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Transportation' ) { echo 'selected="selected"';} ?>>
				Transportation</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Lamination' ) { echo 'selected="selected"';} ?>>
				Lamination</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'B/W Print' ) { echo 'selected="selected"';} ?>>
				B/W Print</option>
			</select>
		</td>
		<td>
		<a class="fancybox fa fa-fw fa-question-circle" 
               onclick="return auto_suggest_price(<?php echo $i;?>);" href="#fancy_box_demo">
            </a>
         <input type="text" id="details_<?php echo $i;?>" name="details_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jdetails'])) { echo $job_details[$j]['jdetails']; }?>" style="width:70%;">
          <a class="fancybox fa fa-fw fa-cut" 
               onclick="return set_cutting_details(<?php echo $i;?>,<?php echo $job_details[$j]['id'] ? $job_details[$j]['id']:0;?>,<?php echo $job_data->id;?>);" href="#fancy_box_cutting"></a>
           <a class="fa fa-fw fa-minus-square" id="cut_icon_<?php echo $i;?>" style="display:none;"
                onclick="return remove_cutting_details(<?php echo $i;?>);" href="javascript:void(main);">
           </a>    
         </td>
		<td><input type="text" id="qty_<?php echo $i;?>" name="qty_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jqty'])) { echo $job_details[$j]['jqty']; }?>" ></td>
		<td><input type="text" id="rate_<?php echo $i;?>" name="rate_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jrate'])) { echo $job_details[$j]['jrate']; }?>" ></td>
		<td align="right"><input type="text" id="sub_<?php echo $i;?>" name="sub_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jamount'])) { echo $job_details[$j]['jamount']; }?>" onblur="check_total(<?php echo $i;?>)"></td>
	</tr>
	<?php $j++;} ?>
	<tr>
		<td rowspan="4" colspan="5">
			Notes : <textarea name="notes" cols="120" rows="5"><?php echo $job_data->notes;?></textarea>
		</td>
		<td align="right">
			Sub Total :
		</td>
		<td><input type="text" id="subtotal" name="subtotal"  onblur="calc_subtotal()"></td>
	</tr>
	<tr>
		<td align="right">
			Tax :
		</td>
		<td>
		<input type="checkbox" name="cb_checkbox" id="cb_checkbox" <?php if(!empty($job_data->tax)) { echo 'checked="checked"'; }?>>
		<input type="text" id="tax" name="tax" value="<?php if(!empty($job_data->tax)) { echo $job_data->tax; }?>" onblur="calc_tax()"></td>
	</tr>
	<tr>
		<td align="right">
			Total :
		</td>
		<td><input type="text" id="total" value="<?php if(!empty($job_data->total)) { echo $job_data->total; }?>" name="total" onfocus="calc_total()"></td>
	</tr>
	<tr>
		<td align="right">
			Advance :
		</td>
		<td><input type="text" id="advance" value="<?php echo $job_data->advance ? $job_data->advance: 0;?>" name="advance" value="0"></td>
	</tr>
	<tr>
		<td colspan="6" align="right">
			Due :
		</td>
		<td><input type="text" id="due" value="<?php if(!empty($job_data->due)) { echo $job_data->due; }?>" name="due" onfocus="calc_due()"></td>
	</tr>
</table>
    
    <hr>
<div class="col-md-12">
<div class="row">
	<div class="col-md-4">
            Bill Number : <input type="text" name="bill_number" value="<?php if(!empty($job_data->bill_number)) { echo $job_data->bill_number;}?>">
	</div>
	<div class="col-md-4">
		Voucher Number : <input type="text" name="voucher_number"  value="<?php if(!empty($job_data->voucher_number)) { echo $job_data->voucher_number;}?>">
	</div>
	<div class="col-md-4">
		Reciept Number : <input type="text" name="receipt"  value="<?php if(!empty($job_data->receipt)) { echo $job_data->receipt;}?>">
	</div>
</div>
<hr>
<div class="col-md-12">
<div class="form-group">
		<input type="hidden" name="job_id" value="<?php echo $job_data->id;?>">
		<input type="hidden" name="modified" value="<?php echo $modified_by;?>">
		<input type="hidden" name="customer_id" value="<?php echo $customer_details->id;?>">
		Confirm : 1 <input type="text" name="confirmation" id="confirmation" value="">
		<input type="submit" name="save" value="Save" class="btn btn-success btn-lg">
	</div>
</div>
</form>


<div id="view_job_status" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="fancy_box_cutting"></div>
</div>
</div>


<div id="fancy_box_demo" style="width:400px;display: none;">
	<div style="width: 500px; margin: 0 auto; padding: 120px 0 40px;">
		<input type="hidden" name="fancybox_id" id="fancybox_id">
        <ul class="tabs" data-persist="true">
            <li><a href="#paper_tab">Paper</a></li>
            <li><a href="#view2">Visiting Cards</a></li>
            <li><a href="#view3">Binding</a></li>
        </ul>
        <div class="tabcontents">
			<div id="paper_tab">
				<div class="row">
				<table width="80%" border="2">
					<tr>
						<td align="right">Select Paper : </td>
						<td><select  name="paper_gram" id="paper_gram">
							<?php foreach($paper_gsm as $gsm) {?>
							<option value="<?php echo strtolower($gsm['paper_gram']);?>">
							<?php echo $gsm['paper_gram'];?></option>
							<?php } ?>
						</select>
						</td>
					</tr>
					<tr>
						<td align="right">Select Paper Size: </td>
						<td><select name="paper_size" id="paper_size">
							<?php foreach($paper_size as $psize) {?>
							<option value="<?php echo strtolower($psize['paper_size']);?>">
							<?php echo $psize['paper_size'];?></option>
							<?php } ?>
							<option>10X10</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Print Side: </td>
						<td><select name="paper_print" id="paper_print">
							<option value="SS">Single</option>
							<option value="FB">Double ( front & Back )</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Quantity : </td>
						<td><input type="text" name="paper_qty" value="1" id="paper_qty"></td>
					</tr>
					<tr>
						<td colspan="2">
						<span class="btn btn-primary btn-sm" onclick="calculate_paper_cost()">Estimate Cost</span>
						<span id="result_paper_cost"></span>
						</td>
					</tr>
				</table>
				</div>
			</div>
            <div id="view2">
                <p>Pqrss...</p>
            </div>
            <div id="view3">
                <p>5466898...</p>
            </div>
            
        </div>
    </div>
</div>
