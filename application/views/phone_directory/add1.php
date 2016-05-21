<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/paper/add_paper" method="post">
<div class="row">
<button class="btn btn-primary btn-sm add_field_button">Add More</button>
<div class="col-md-12">
	<div class="row">
		<div class="col-md-2">
			Paper Gram
		</div>
		<div class="col-md-2">
			Paper Size
		</div>
		<div class="col-md-2">
			Paper Name
		</div>
		<div class="col-md-2">
			Minimum Quantity
		</div>
		<div class="col-md-2">
			Maximum Quantity
		</div>
		<div class="col-md-2">
			Cost
		</div>
	</div>
	<div class="row">
	<div>
		<div class="col-md-2">
			<input type="text" id="paper_gram" name="paper_gram[]" required="required">
		</div>
		<div class="col-md-2">
			<input type="text" id="paper_size" name="paper_size[]" required="required">
		</div>
		<div class="col-md-2">
			<input type="text" id="paper_name" name="paper_name[]">
		</div>
		<div class="col-md-2">
			<input type="text" id="paper_qty_min" name="paper_qty_min[]">
		</div>
		<div class="col-md-2">
			<input type="text" id="paper_qty_max" name="paper_qty_max[]">
		</div>
		<div class="col-md-2">
			<input type="text" id="paper_amount" name="paper_amount[]" style="width:50px;">
		</div>
	</div></div>
	<span class="input_fields_wrap"></span>
	<hr>
	<center><input type="submit" name="Save" value="Save" class ="btn btn-success btn-lg">	</center>
</div>
</div>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var paper_gram,paper_size,paper_name,paper_qty_min,paper_qty_max,paper_amount;
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
    paper_gram = jQuery("#paper_gram").val();
    paper_size = jQuery("#paper_size").val();
    paper_name = jQuery("#paper_name").val();
    paper_qty_min = jQuery("#paper_qty_min").val();
    paper_qty_max = jQuery("#paper_qty_max").val();
    paper_amount = jQuery("#paper_amount").val();
    
    
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="row"><hr><div class="col-md-2"><input type="text" name="paper_gram[]" value="'+paper_gram+'"></div><div class="col-md-2"><input type="text" name="paper_size[]" value="'+paper_size+'"></div><div class="col-md-2"><input type="text" name="paper_name[]" value="'+paper_name+'"></div><div class="col-md-2"><input type="text" name="paper_qty_min[]" value="'+paper_qty_min+'"></div><div class="col-md-2"><input type="text" name="paper_qty_max[]" value="'+paper_qty_max+'"></div><div class="col-md-1"><input type="text" name="paper_amount[]" value="'+paper_amount+'" style="width:50px;"></div><a href="#" class="glyphicon glyphicon-minus-sign remove_field"></a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); 
        $(this).parent('div').remove(); 
        $(this).parent('hr').remove(); 
        x--;
    })
});
</script>
