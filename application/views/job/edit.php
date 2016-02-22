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
function set_cutting_details(id){
    jQuery("#fancybox_cutting_id").val(id);
    jQuery("#cut_icon_"+id).css('display','inline');
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
                  
                  total = (amount * paper_qty )* mby;
                  jQuery("#result_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );
                  jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
                  if(paper_print == "FB") {
                          jQuery("#rate_"+id).val(amount * 2);
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
}
</script>
<?php
$this->load->helper('form');
$this->load->helper('general'); ?>
<form action="<?php echo site_url();?>/jobs/edit" method="post" onsubmit="return check_form()">
<div class="col-md-12">
<table width="100%" border="2">
	<tr>
        <td colspan="2" align="center">
        <h3>Customer Type</h3>
        <div class="row">
            <div class="col-md-4">
                <span onClick="set_customer('new_customer');">
                    New Customer
                </span>
            </div>
            <div class="col-md-4">
                <span onClick="set_customer('regular_customer');">
                    Regular Customer
                </span>
            </div>
            <div class="col-md-4">
                <span onClick="set_customer('cybera_dealer');" >
                    Cybera Dealer
                </span>
            </div>
        </div>
        </td>
	</tr>
	<tr>
        <td colspan="2">
            <div id="new_customer" style="display:none;">
                <div class="col-md-6">
					<div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" 
                                    name="companyname"  value="" placeholder="Company Name">
                            </div>
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="" placeholder="Name">
                    </div>
                </div>
                    <div class="col-md-6">
							<div class="form-group">
								<label>Contact Number</label>
								<input type="text" class="form-control" name="user_mobile" value="" placeholder="Mobile Number">
							</div>
                            <div class="form-group">
                                    <label>Email Id</label>
                                    <input type="text" class="form-control"
                                           name="emailid" value="" placeholder="Email Id">
                            </div>
                    </div>

            </div>
                <div id="regular_customer" style="display:none;">
                        <table width="100%">
                                <tr>
                                        <td width="50%">
                                                Customer Name : <?php echo create_customer_dropdown('customer',true); ?>
                                        </td>
                                        <td width="50%" align="right">
                                                Contact Number : <input type="text" name="mobile" id="mobile_customer">
                                        </td>
                                </tr>
                        </table>
                </div>
                <div id="cybera_dealer" style="display:none;">
                        <table width="100%">
                        <tr>
                                <td width="50%">
                                        Dealer Name : <?php echo create_customer_dropdown('dealer',true); ?>
                                </td>
                                <td width="50%" align="right">
                                        Contact Number : <input type="text" name="mobile" id="mobile_dealer">
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
                    Job Name : <input type="text" name="jobname"
                                      id="jobname" required="required" style="width:250px;">
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
	<?php for($i=1;$i<6;$i++){ ?>
	<tr>
        <td><?php echo $i;?></td>
            <td><input type="checkbox" id="flag_<?php echo $i;?>" name="flag_<?php echo $i;?>"></td>
            <td>
                    <select class="form-control" name="category_<?php echo $i;?>" id="category_<?php echo $i;?>" onChange="check_visiting_card(<?php echo $i;?>);">
                            <option>Digital Print</option>
                            <option>Visiting Card</option>
                            <option>Offset Print</option>
                            <option>Cutting</option>
                            <option>Designing</option>
                            <option>Binding</option>
                    </select>
            </td>
            <td>
            <a class="fancybox fa fa-fw fa-question-circle" 
               onclick="return auto_suggest_price(<?php echo $i;?>);" href="#fancy_box_demo">
            </a>

            <input type="text" id="details_<?php echo $i;?>" 
                   name="details_<?php echo $i;?>" style="width:70%;">
            
            <a class="fancybox fa fa-fw fa-cut" 
               onclick="return set_cutting_details(<?php echo $i;?>);" href="#fancy_box_cutting">
             </a>
			<a class="fa fa-fw fa-minus-square" id="cut_icon_<?php echo $i;?>" style="display:none;"
                onclick="return remove_cutting_details(<?php echo $i;?>);" href="javascript:void(main);">
            </a>
            </td>
            <td><input type="text" id="qty_<?php echo $i;?>" name="qty_<?php echo $i;?>"></td>
            <td><input type="text" id="rate_<?php echo $i;?>" name="rate_<?php echo $i;?>"></td>
            <td align="right"><input type="text" id="sub_<?php echo $i;?>" name="sub_<?php echo $i;?>" 
            onblur="check_total(<?php echo $i;?>)"></td>
	</tr>
	<?php } ?>
	<tr>
        <td rowspan="4" colspan="5">
                Notes : <textarea name="notes" cols="120" rows="5"></textarea>
        </td>
        <td align="right">
                Sub Total :
        </td>
        <td><input type="text" id="subtotal"
                       name="subtotal" required="required" onblur="calc_subtotal()"></td>
	</tr>
	<tr>
            <td align="right">
                    Tax :
            </td>
            <td>
            <input type="checkbox" name="cb_checkbox" id="cb_checkbox">
            <input type="text" id="tax" name="tax" onblur="calc_tax()" style="width:100px;">
            </td>
	</tr>
	<tr>
            <td align="right">
                    Total :
            </td>
            <td>
                <input type="text" id="total" name="total" required="required" onfocus="calc_total()">
            </td>
	</tr>
	<tr>
            <td align="right">
                    Advance :
            </td>
            <td><input type="text" id="advance" name="advance" value="0"></td>
	</tr>
	<tr>
            <td colspan="6" align="right">
                    Due :
            </td>
            <td><input type="text" id="due" name="due" value="0" onfocus="calc_due()"></td>
	</tr>
</table>
<hr>
<div class="col-md-12">
<div class="row">
	<div class="col-md-4">
		Bill Number : <input type="text" name="bill_number">
	</div>
	<div class="col-md-4">
		Voucher Number : <input type="text" name="voucher_number">
	</div>
	<div class="col-md-4">
		Reciept Number : <input type="text" name="receipt">
	</div>
</div>
<hr>
<div class="form-group">
		<input type="hidden" name="dealer_id" value="<?php if(!empty($dealer_info->id)){echo $dealer_info->id;}?>">
		<input type="hidden" name="customer_type" id="customer_type">
		<input type="hidden" name="customer_id" id="customer_id">
		Confirm : 1 <input type="text" name="confirmation" id="confirmation" value="">
		<input type="submit" name="save" value="Save" class="btn btn-success btn-lg">
	</div>
</div>
</form>

<div id="fancy_box_cutting" style="width:800px;display: none;">
    <div style="width: 800px; margin: 0 auto;">
        <table  width="80%" border="2" align="center">
            <tr>
                <td colspan="2" align="center"><h1>Fill Cutting Details</h1></td>
            </tr>
            <tr>
                <td align="right" width="50%">Machine:</td>
                <td  width="50%">
                    <label><input type="radio" id="machine" name="machine" value="1">1</label>
                    <label><input type="radio" id="machine" name="machine" value="2">2</label>
                </td>
            </tr>
            <tr>
                <td align="right">Size:</td>
                <td>
                    <label><input type="radio" name="size" id="size" value="12X18">12X18</label>
                    <label><input type="radio" name="size" id="size" value="13X19">13X19</label>
                    <input type="text" name="size_info" id="size_info" value="1/">
                </td>
            </tr>
            <tr>
                <td align="right">Printing:</td>
                <td>
                    <label>
                        <input type="radio" id="printing" name="printing" value="SS">Single Side
                    </label>
                    <label><input type="radio" id="printing" name="printing" value="FB">
                        Double Side
                    </label>
                </td>
            </tr>
            <tr>
                <td align="right">Lamination:</td>
                <td>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="SS">Single
                    </label>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="FB">Double
                    </label>
                    <input type="text" name="lamination_info" id="lamination_info">
                </td>
            </tr>
            <tr>
				<td align="right">Binding</td>
				<td>
					<label><input type="checkbox" name="binding" value="Creasing">Creasing</label>
					<label><input type="checkbox" name="binding" value="Center Pin">Center Pin</label>
					<label><input type="checkbox" name="binding" value="Perfect Binding">Perfect Binding</label>
					<label><input type="checkbox" name="binding" value="Performance">Performance</label>
					<label><input type="checkbox" name="binding" value="Folding">Folding</label>
					<br>
					Half Cutting:<input type="text" name="binding_info" id="binding_info">
				</td>
            </tr>
            <tr>
                <td align="right">Packing:</td>
                <td>
                    <label><input type="radio" id="packing" name="packing" value="Paper">Paper</label>
                    <label><input type="radio" id="packing" name="packing" value="Loose">Loose</label>
                    <label><input type="radio" id="packing" name="packing" value="Plastic Bag">Plastic Bag</label>
                    <label><input type="radio" id="packing" name="packing" value="Letter Head">Letter Head</label>
                    <label><input type="radio" id="packing" name="packing" value="Parcel">Parcel</label>
                </td>
            </tr>
            <tr>
				<td align="right">Checking:</td>
                <td>
					<label><input type="radio" name="checking" value="Paper">Paper</label>
                    <label><input type="radio" name="checking" value="Printing">Printing</label>
                </td>
            </tr>
            <tr>
                <td align="right">Details:</td>
                <td>
                    <textarea name="details" id="details" rows="4" cols="40"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="hidden" name="fancybox_cutting_id" value="" id="fancybox_cutting_id">
                    <span class="btn btn-primary btn-sm" onclick="set_cutting_details_box()">Save</span>
                </td>
            </tr>
        </table>
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

<?php 
for($i=1;$i<6;$i++) { ?>
<div style="display:none;">
    <input type="text" name="c_machine_<?php echo $i;?>" id="c_machine_<?php echo $i;?>">
    <input type="text" name="c_qty_<?php echo $i;?>" id="c_qty_<?php echo $i;?>">
    <input type="text" name="c_material_<?php echo $i;?>" id="c_material_<?php echo $i;?>">
    <input type="text" name="c_size_<?php echo $i;?>" id="c_size_<?php echo $i;?>">
    <input type="text" name="c_details_<?php echo $i;?>" id="c_details_<?php echo $i;?>">
    <input type="text" name="c_lamination_<?php echo $i;?>" id="c_lamination_<?php echo $i;?>">
    <input type="text" name="c_packing_<?php echo $i;?>" id="c_packing_<?php echo $i;?>">
    <input type="text" name="c_print_<?php echo $i;?>" id="c_print_<?php echo $i;?>">
    <input type="text" name="c_laminationinfo_<?php echo $i;?>" id="c_laminationinfo_<?php echo $i;?>">
    <input type="text" name="c_sizeinfo_<?php echo $i;?>" id="c_sizeinfo_<?php echo $i;?>">
    <input type="text" name="c_bindinginfo_<?php echo $i;?>" id="c_bindinginfo_<?php echo $i;?>">
    <input type="text" name="c_binding_<?php echo $i;?>" id="c_binding_<?php echo $i;?>">
    <input type="text" name="c_checking_<?php echo $i;?>" id="c_checking_<?php echo $i;?>">
</div>
<?php } ?>
