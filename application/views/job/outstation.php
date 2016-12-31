<script src="<?php echo base_url();?>assets/js/job_details.js"></script>
<script>
$(document).ready(function() {
      $('.fancybox').fancybox({
		'width':1000,
        'height':600,
        'autoSize' : false,
        'afterClose':function () {
			fancy_box_closed();
		},
    });
    
    
    var options_dealer = $('select.select-dealer option');
     var arr = options_dealer.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options_dealer.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
    
    var select_voucher = $('select.select-voucher option');
    var arr = select_voucher.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    select_voucher.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
    
    var options = $('select.select-customer option');
    var arr = options.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options.each(function(i, o) {
        //console.log(i);
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });

	console.log('done');


});

function show_due(userid) {
	$.ajax({
		 type: "POST",
		 url: "<?php echo site_url();?>/ajax/get_customer_due/"+userid, 
		 success: 
			function(data){
				if(data.length > 0 ){ 
					jQuery("#show_balance").html("Due : "+data);
				} else {
					jQuery("#show_balance").html("");
				}
			}
	  });
}
function customer_selected(type,userid) {
jQuery("#customer_id").val(userid);
    $.ajax({
     type: "POST",
     url: "<?php echo site_url();?>/customer/get_customer_ajax/id/"+userid, 
     success: 
        function(data){
		jQuery("#mobile_"+type).val('');
        jQuery("#mobile_"+type).val(data);
        show_due(userid);
        }
  });
  
  $.ajax({
     type: "GET",
     url: "<?php echo site_url();?>/ajax/getOutstationTransporterName/"+userid, 
     dataType: 'JSON',
     success: function(data){
		 if(data.status == true)
		 {
			 setTransporterDetails(data.transporter);
		 }
	}
  });
}


function setTransporterDetails(object)
{
	jQuery("#tranporter_name").val(object.name);
	jQuery("#tranporter_contact_person").val(object.contact_person);
	jQuery("#tranporter_contact_number").val(object.contact_number);
}

function auto_suggest_price(id){
    jQuery("#fancybox_id").val(id);
}
function set_cutting_details(id){
	jQuery("#fancybox_cutting_id").val(id);
    jQuery("#cut_icon_"+id).css('display','inline');
	if(jQuery("#category_"+id).val() == "ROUND CORNER CUTTING") {
		jQuery("#popup_cornercutting").css('display','none');
		jQuery("#popup_packing").css('display','none');
		jQuery("#popup_lasercutting").css('display','none');
		jQuery("#popup_machine").css('display','none');
		jQuery("#popup_size").css('display','none');
		jQuery("#popup_printing").css('display','none');
		jQuery("#popup_lamination").css('display','none');
		jQuery("#popup_binding").css('display','none');
		jQuery("#cutting_title").html('Round Corner - Cutting Details');
		return false;
	} else {
		jQuery("#popup_cornercutting").show();
		jQuery("#popup_lasercutting").show();
		jQuery("#popup_packing").show();
		jQuery("#popup_machine").show();
		jQuery("#popup_size").show();
		jQuery("#popup_printing").show();
		jQuery("#popup_lamination").show();
		jQuery("#popup_binding").show();
		jQuery("#cutting_title").html('Fill Cutting Details');
		return false;
	}
	
	if( jQuery("#category_"+id).val() == "Visiting Card" ) {
		jQuery("#popup_lamination").css('display','none');
		jQuery("#popup_binding").css('display','none');
		jQuery("#cutting_title").html('Visiting Card - Cutting Details');
		return false;
	} else {
		jQuery("#popup_lamination").show();
		jQuery("#popup_binding").show();
		jQuery("#cutting_title").html('Fill Cutting Details');
		return false;
	}
	
}

function set_cutting_details_box(id){
	var data_id =jQuery("#fancybox_cutting_id").val();
	var machine,size,details,lamination,printing,packing,lamination_info,binding,checking,c_corner,c_laser,c_rcorner,c_cornerdie;
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
        jQuery("#c_corner_"+data_id).val($("#c_corner").val());
        jQuery("#c_laser_"+data_id).val($("#c_laser").val());
        jQuery("#c_rcorner_"+data_id).val($("#c_rcorner").val());
        jQuery("#c_cornerdie_"+data_id).val($("#c_cornerdie").val());
        $.fancybox.close();
        
        if(jQuery("#c_machine_"+data_id).val().length > 0 && data_id < 5)
        {
			var nextElement = parseInt(data_id) + 1;
			
			jQuery("#category_" + nextElement).val("Cutting");
			jQuery("#details_" + nextElement).val("Cutting");
			jQuery("#qty_" + nextElement).focus();
		}
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
							//amount = amount * 2 - 3;
							amount = amount * 2 - 3;
							paper_qty = paper_qty / 2;
						}
					}
                  
                  total = (amount * paper_qty )* mby;
                  jQuery("#result_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );
                  jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
                  if(paper_print == "FB") {
					jQuery("#rate_"+id).val(amount * 2);
                    if(paper_size == "13X19" || paper_size == "13x19" ) {
						  jQuery("#rate_"+id).val(amount);
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
		
		var status = confirm("Do You want to Create Bill ?");
		if(status) {
			jQuery("#subtotal").focus();
			return false;
		}
		
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
			$("#details_"+sr).val("Cutting");
		}
		if($("#category_"+sr).val() == "Digital Print") {
			$("#details_"+sr).val("");
		}
		if($("#category_"+sr).val() == "Lamination") {
			$("#details_"+sr).val("Lamination");
		}
		if($("#category_"+sr).val() == "B/W Print") {
			$("#details_"+sr).val("B/W Print");
		}
		if($("#category_"+sr).val() == "Designing") {
			$("#details_"+sr).val("Designing");
		}
		if($("#category_"+sr).val() == "Sticker Sheet") {
			$("#details_"+sr).val("Sticker Sheet");
		}
		if($("#category_"+sr).val() == "Binding") {
			$("#details_"+sr).val("Binding");
		}
		if($("#category_"+sr).val() == "Packaging and Forwading") {
			$("#details_"+sr).val("Packaging and Forwading");
		}
		if($("#category_"+sr).val() == "Transportation") {
			$("#details_"+sr).val("Transportation");
		}
		if($("#category_"+sr).val() == "Offset Print") {
			$("#details_"+sr).val("Offset Print");
		}
		if($("#category_"+sr).val() == "Visiting Card") {
			$("#details_"+sr).val("Visiting Card");
		}
		if($("#category_"+sr).val() == "B/W Xerox") {
			$("#details_"+sr).val("B/W Xerox");
		}
		if($("#category_"+sr).val() == "ROUND CORNER CUTTING") {
			$("#details_"+sr).val("ROUND CORNER CUTTING");
		}
		if($("#category_"+sr).val() == "Laser Cutting") {
			$("#details_"+sr).val("Laser Cutting");
		}
		if($("#category_"+sr).val() == "Not Applicable") {
			$("#details_"+sr).val("Not Applicable");
			$("#qty_"+sr).val("0");
			$("#rate_"+sr).val("0");
			$("#sub_"+sr).val("0");
		}
		
		open_price_list(sr);
}

function open_price_list(sr)
{
	auto_suggest_price(sr);
	var catValue = jQuery("#category_" + sr ).val();
	
	if(catValue == 'Digital Print' || catValue == 'Visiting Card')
	{
		$.fancybox({
                'href': '#fancy_box_demo',
                'width':1000,
				'height':600,
				'autoSize' : false,
				'afterClose':function () {
					fancy_box_closed();
				}
            });
	}
	
}

function check_existing_customer(value) {
	if(jQuery("#new_customer_name").val().length > 0 || jQuery("#new_customer_companyname").val().length > 0 ) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_customer_details_by_param/mobile/"+value, 
			success: 
			function(data){
				if(data.length > 0 ) {
					jQuery("#save_button").attr("disabled","disabled");
					jQuery("#mobile_error_message").html(data + " Customer already Exists");
					alert("Customer "+ data +" already Exists with Contact Number : "+value);
				}
			}
		});
	} 
	
}
</script>

<script>
function check_receipt() {
	var s_receipt = $("#receipt").val();
	if(s_receipt.length > 0 ){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_check_receipt/"+s_receipt, 
			success: 
				function(data){
					if(data == 1) {
						$("#receipt").focus();
						alert("Receipt Alread Exist !");
						return false;
					} 
			 }
          });
	  }
}
</script>
<?php
$this->load->helper('form');
$this->load->helper('general'); ?>
<form action="<?php echo site_url();?>/jobs/edit" method="post" onsubmit="return check_form();check_receipt();calc_due();">
<div class="col-md-12">
<table width="100%" border="2">
	<tr>
        <td colspan="2" align="center">
        <h3>Outstation Customer Type</h3>
        <p id="balance"  align="right"><h2 class="red" id="show_balance" ></h2></p>
        Customer Name : <?php echo create_customer_dropdown('outstation',true); ?>
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
            <td width="10%">Category</td>
            <td width="120px;">Details</td>
            <td width="10%">Qty.</td>
            <td width="5%">Calculate</td>
            <td width="10%">Rate</td>
            <td width="10%">Amount</td>
	</tr>
	<?php for($i=1;$i<6;$i++){ ?>
	<tr>
        <td><?php echo $i;?></td>
            
            <td>
                    <select class="form-control" style="width: 100px;" name="category_<?php echo $i;?>" id="category_<?php echo $i;?>" onChange="check_visiting_card(<?php echo $i;?>);">
                            <option>Select Category</option>
                            <option>Digital Print</option>
                            <option>Visiting Card</option>
                            <option>Offset Print</option>
                            <option>Cutting</option>
                            <option>Designing</option>
                            <option>Binding</option>
                            <option>Sticker Sheet</option>
                            <option>Lamination</option>
                            <option>Laser Cutting</option>
                            <option>ROUND CORNER CUTTING</option>
                            <option>Packaging and Forwading</option>
                            <option>Transportation</option>
                            <option>B/W Print</option>
                            <option>B/W Xerox</option>
                            <option>Not Applicable</option>
                    </select>
            </td>
            <td>
            <!---<a class="fancybox fa fa-fw fa-question-circle" 
               onclick="return auto_suggest_price(<?php echo $i;?>);" href="#fancy_box_demo">
            </a>-->

            <input  type="text" id="details_<?php echo $i;?>" name="details_<?php echo $i;?>" style="width: 90%;">
            </td>
            
            <td><input type="text" id="qty_<?php echo $i;?>" name="qty_<?php echo $i;?>"  style="width: 60px;"></td>
            <td align="center"><input type="checkbox" id="flag_<?php echo $i;?>" name="flag_<?php echo $i;?>" ></td>
            <td><input type="text" id="rate_<?php echo $i;?>" name="rate_<?php echo $i;?>" style="width: 60px;"></td>
            <td align="right"><input type="text" id="sub_<?php echo $i;?>" name="sub_<?php echo $i;?>" 
            onblur="check_total(<?php echo $i;?>)" style="width: 60px;">
             <a class="fancybox fa fa-fw fa-cut" 
               onclick="return set_cutting_details(<?php echo $i;?>);" href="#fancy_box_cutting">
             </a>
			<a class="fa fa-fw fa-minus-square" id="cut_icon_<?php echo $i;?>" style="display:none;"
                onclick="return remove_cutting_details(<?php echo $i;?>);" href="javascript:void(main);">
            </a>
            </td>
	</tr>
	<?php } ?>
	<tr>
        <td rowspan="3" colspan="5">
                Notes : <textarea name="notes" cols="60" rows="5"></textarea>
        </td>
        <td align="right">
                Sub Total :
        </td>
        <td><input type="text" id="subtotal"
                       name="subtotal" required="required" onblur="calc_subtotal()" style="width: 80px;"></td>
	</tr>
	<tr>
            <td align="right">
                    Tax :
            </td>
            <td>
            <input type="checkbox" name="cb_checkbox" id="cb_checkbox">
            <input type="text" id="tax" name="tax" onblur="calc_tax()" style="width: 80px;">
            </td>
	</tr>
	<tr>
            <td align="right">
                    Total :
            </td>
            <td>
                <input type="text" id="total" name="total" required="required" onfocus="calc_total(); calc_due();"  style="width: 80px;">
            </td>
	</tr>
	<tr>
		<td colspan="7" align="right">
			<input type="hidden" id="advance" name="advance" value="0">
			<input type="hidden" id="receipt" name="receipt" value="0">
			<input type="hidden" id="bill_number" name="bill_number" value="0">
			<input type="hidden" id="due" name="due" >
			<input type="hidden" name="dealer_id" value="<?php if(!empty($dealer_info->id)){echo $dealer_info->id;}?>">
			<input type="hidden" name="customer_type" id="customer_type">
			<input type="hidden" name="customer_id" id="customer_id">
			Confirm : 1 <input type="text" name="confirmation" style="width: 30px;" id="confirmation" value="">
			<input type="submit" name="save" id="save_button"  value="Save" class="btn btn-success btn-lg">
		</td>
	</tr>
</table>
</form>

<table align="center" border="1" width="100%">
	<tr>
		<td width="30%" align="right"> Transporter Name: </td>
		<td> <input type="text" name="tranporter_name" id="tranporter_name"> </td>
	</tr>
	<tr>
		<td width="30%" align="right"> Transporter Contact Person: </td>
		<td> <input type="text" name="tranporter_contact_person" id="tranporter_contact_person"> </td>
	</tr>
	<tr>
		<td width="30%" align="right"> Transporter Contact Number: </td>
		<td> <input type="text" name="tranporter_contact_number" id="tranporter_contact_number"> </td>
	</tr>
</table>

<div id="fancy_box_cutting" style="width:800px;display: none;">
    <div style="width: 800px; margin: 0 auto;">
        <table  width="80%" border="2" align="center">
            <tr>
                <td colspan="2" align="center">
					<h1 id="cutting_title">Fill Cutting Details</h1>
                </td>
            </tr>
            <tr id="popup_machine">
                <td align="right" width="50%">Machine:</td>
                <td  width="50%">
                    <label><input type="radio" id="machine" name="machine" value="1">1</label>
                    <label><input type="radio" id="machine" name="machine" value="2">2</label>
                    <label><input type="radio" id="machine" name="machine" value="Xrox">Xrox</label>
                </td>
            </tr>
            <tr id="popup_size">
                <td align="right">Size:</td>
                <td>
                    <label><input type="radio" name="size" id="size" value="A4">A4</label>
                    <label><input type="radio" name="size" id="size" value="A3">A3</label>
                    <label><input type="radio" name="size" id="size" value="12X18">12X18</label>
                    <label><input type="radio" name="size" id="size" value="13X19">13X19</label>
                    <input type="text" name="size_info" id="size_info" value="1/">
                </td>
            </tr>
            <tr id="popup_printing">
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
            <tr id="popup_cornercutting">
                <td align="right">Corner Cutting :</td>
                <td>
                    <input type="text" name="c_corner" id="c_corner">
                </td>
            </tr>
            <tr>
                <td align="right">Corner Cutting Die No. :</td>
                <td>
                    <input type="text" name="c_cornerdie" id="c_cornerdie">
                </td>
            </tr>
            <tr>
                <td align="right">Round Cutting Side:</td>
                <td>
                    <input type="text" name="c_rcorner" id="c_rcorner">
                </td>
            </tr>
            <tr id="popup_lasercutting">
                <td align="right">Laser Cutting :</td>
                <td>
                    <input type="text" name="c_laser" id="c_laser">
                </td>
            </tr>
            <tr id="popup_lamination">
                <td align="right">Lamination:</td>
                <td>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="SS">Single
                    </label>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="FB">Double
                    </label>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="N/A">N/A
                    </label>
                    <input type="text" name="lamination_info" id="lamination_info">
                </td>
            </tr>
            <tr id="popup_binding">
				<td align="right">Binding</td>
				<td>
					<label><input type="checkbox" name="binding" value="Creasing">Creasing</label>
					<label><input type="checkbox" name="binding" value="Center Pin">Center Pin</label>
					<label><input type="checkbox" name="binding" value="Perfect Binding">Perfect Binding</label>
					<label><input type="checkbox" name="binding" value="Perforation">Perforation</label>
					<label><input type="checkbox" name="binding" value="Folding">Folding</label>
					<br>
					Half Cutting:<input type="text" name="binding_info" id="binding_info">
				</td>
            </tr>
                        <!--<tr>
				<td align="right">Checking:</td>
                <td>
					<label><input type="radio" name="checking" value="Paper">Paper</label>
                    <label><input type="radio" name="checking" value="Printing">Printing</label>
                </td>
            </tr>-->
            <tr>
                <td align="right">Details:</td>
                <td>
                    <textarea name="details" id="details" rows="4" cols="40"></textarea>
                </td>
            </tr>
            
            <tr id="popup_packing">
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
                <td colspan="2" align="center">
                    <input type="hidden" name="fancybox_cutting_id" value="" id="fancybox_cutting_id">
                    <span class="btn btn-primary btn-sm" onclick="set_cutting_details_box()">Save</span>
                </td>
            </tr>
        </table>
    </div>
</div>

<div id="fancy_box_demo" style="width:100%;display: none;">
	<div style="width: 100%; margin: 0 auto; padding: 10px 0 10px;">
		<input type="hidden" name="fancybox_id" id="fancybox_id">
        <ul class="tabs" data-persist="true">
            <li><a href="#paper_tab">Paper</a></li>
            <li><a href="#view2">Visiting Cards</a></li>
            <li><a href="#view3">Exclusive Visiting Cards</a></li>
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
				<?php
					require_once('visiting-card-rates.php');
				?>
            </div>
            <div id="view3">
                <?php
					require_once('excluive-visiting-card-rates.php');
				?>
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
    <input type="text" name="c_corner_<?php echo $i;?>" id="c_corner_<?php echo $i;?>">
    <input type="text" name="c_laser_<?php echo $i;?>" id="c_laser_<?php echo $i;?>">
    <input type="text" name="c_rcorner_<?php echo $i;?>" id="c_rcorner_<?php echo $i;?>">
    <input type="text" name="c_cornerdie_<?php echo $i;?>" id="c_cornerdie_<?php echo $i;?>">
</div>
<?php } ?>
