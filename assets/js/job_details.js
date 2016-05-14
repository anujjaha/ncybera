function check_total(id) {
	var result;
	if (document.getElementById('flag_'+id).checked) {
		result = jQuery("#qty_"+id).val() * jQuery("#rate_"+id).val();
		jQuery("#sub_"+id).val(result);
	} else {
		result = jQuery("#sub_"+id).val() / jQuery("#qty_"+id).val();
		jQuery("#rate_"+id).val(result);
	}
}

function calc_subtotal() {
	var subtotal=0,sub1=0,sub2=0,sub3=0,sub4=0,sub5=0;
	
	for(i=1;i<=5;i++){
		if(jQuery("#sub_"+i).val().length > 0 ){
			subtotal = subtotal + parseFloat(jQuery("#sub_"+i).val());
		}
	}
	jQuery("#subtotal").val(subtotal);
}
function calc_tax() {
	var tax_amount=0;
	var tax_f,tax_l=0;
	if (document.getElementById('cb_checkbox').checked) {
		
		tax_f = Math.round( (jQuery("#subtotal").val() * 4 ) / 100);
		tax_l = Math.round( (jQuery("#subtotal").val() * 1 ) / 100);
		tax_amount = parseFloat(tax_f) + parseFloat(tax_l);
		jQuery("#tax").val(tax_amount);
	} else {
		tax_amount = 0;
		jQuery("#tax").val(tax_amount);
	}
}
function calc_total() {
	var total,sub_total,tax=0;
	if(jQuery("#tax").val().length > 0 ) {
		total = Math.round(parseFloat(jQuery("#subtotal").val()) + parseFloat(jQuery("#tax").val()));
	} else {
		total = Math.round( parseFloat(jQuery("#subtotal").val()));
	}
	jQuery("#total").val(total);
}
function calc_due() {
	var due;
	due = parseFloat(jQuery("#total").val()) - parseFloat(jQuery("#advance").val());
	jQuery("#due").val(due);
}
function set_customer(type) {
	if(type == 'new_customer') {
		jQuery("#new_customer").css("display",'block');
		jQuery("#regular_customer").css("display",'none');
		jQuery("#cybera_dealer").css("display",'none');
		jQuery("#cybera_voucher").css("display",'none');
		jQuery("#customer_type").val('new');
	}
	if(type == 'regular_customer') {
		jQuery("#new_customer").css("display",'none');
		jQuery("#regular_customer").css("display",'block');
		jQuery("#cybera_dealer").css("display",'none');
		jQuery("#cybera_voucher").css("display",'none');
		jQuery("#customer_type").val('customer');
	}
	if(type == 'cybera_dealer') {
		jQuery("#new_customer").css("display",'none');
		jQuery("#regular_customer").css("display",'none');
		jQuery("#cybera_voucher").css("display",'none');
		jQuery("#cybera_dealer").css("display",'block');
		jQuery("#customer_type").val('dealer');
	}
	if(type == 'voucher_customer') {
		jQuery("#new_customer").css("display",'none');
		jQuery("#regular_customer").css("display",'none');
		jQuery("#cybera_dealer").css("display",'none');
		jQuery("#cybera_dealer").css("display",'none');
		jQuery("#cybera_voucher").css("display",'block');
		jQuery("#customer_type").val('voucher');
	}
}


