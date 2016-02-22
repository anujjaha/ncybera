<?php
/*echo "<pre>";
print_r($job_data);

print_r($jdetails);
print_r($cutting_details);*/
$binding = explode(",",$cutting_details->c_binding);
?>

<script>

var cutting_details_material = $("#details_"+<?php echo $sr;?>).val();
var cutting_details_qty = $("#qty_"+<?php echo $sr;?>).val();
$("#c_material").val(cutting_details_material);
$("#c_qty").val(cutting_details_qty);
function update_box() {
	var machine,size,details,lamination,printing,packing,lamination_info,binding,checking;
        machine = $('input:radio[name=c_machine]:checked').val();// jQuery("#machine").val();
      binding = ""; 
      var $boxes = $('input[name=c_binding]:checked');
      $boxes.each(function(){
		  if($(this).val().length > 0 ) {
			binding = $(this).val() + ","+binding;  
		  }
		});
        
        lamination_info = jQuery("#lamination_info").val();
        size_info = jQuery("#size_info").val();
        binding_info = jQuery("#binding_info").val();
        details = jQuery("#details").val();
        lamination = $('input:radio[name=c_lamination]:checked').val();//jQuery("#lamination").val();
        checking = $('input:radio[name=c_checking]:checked').val();//jQuery("#lamination").val();
        size = $('input:radio[name=c_size]:checked').val();//jQuery("#lamination").val();
        printing =  $('input:radio[name=c_print]:checked').val();// jQuery("#printing").val();
        packing =  $('input:radio[name=c_packing]:checked').val(); //printing jQuery("#packing").val();
        cutting_id = $("#cutting_id").val();
        c_qty = $("#c_qty").val();
        c_material = $("#c_material").val();
        j_id = $("#j_id").val();
       
        $.ajax({
		type: "POST",
		url: "<?php echo site_url();?>/ajax/save_edit_cutting_details/", 
		data:{	
				'c_qty':c_qty,'c_material':c_material,'c_machine':machine,
				'c_size':size,'c_sizeinfo':size_info,'c_print':printing,
				'c_details':details,'c_lamination':lamination,'c_laminationinfo':lamination_info,
				'c_binding':binding,'c_bindinginfo':binding_info,'c_packing':packing,
				'c_checking':checking,'cutting_id':cutting_id,'j_id':j_id
		
			},
		success: 
			function(data){
				//alert(data);
					$.fancybox.close();
				}
		});
  
        
}
</script>
<!--<form action="<?php echo site_url();?>/ajax/save_edit_cutting_details" method="post" onsubmit="return check_form()">-->
<div style="width: 800px; margin: 0 auto;">
        <table  width="80%" border="2" align="center">
            <tr>
                <td colspan="2" align="center"><h1>Fill Cutting Details</h1></td>
            </tr>
            <tr>
                <td align="right" width="50%">Machine:</td>
                <td  width="50%">
                    <label><input type="radio" <?php if($cutting_details->c_machine == "1") { echo "checked='checked'";}?> id="machine" name="c_machine" value="1">1</label>
                    <label><input type="radio" <?php if($cutting_details->c_machine == "2") { echo "checked='checked'";}?> id="machine" name="c_machine" value="2">2</label>
                </td>
            </tr>
            <tr>
                <td align="right">Quantity:</td>
                <td>
                    <input type="text" name="c_qty" id="c_qty">
                </td>
            </tr>
            <tr>
                <td align="right">Material:</td>
                <td>
                    <input type="text" name="c_material" id="c_material">
                </td>
            </tr>
            <tr>
                <td align="right">Size:</td>
                <td>
                    <label><input type="radio" <?php if($cutting_details->c_size == "12X18") { echo "checked='checked'";}?> name="c_size" id="size" value="12X18">12X18</label>
                    <label><input type="radio" <?php if($cutting_details->c_size == "13X19") { echo "checked='checked'";}?> name="c_size" id="size" value="13X19">13X19</label>
                    <input type="text" name="c_sizeinfo" id="size_info" value="<?php echo $cutting_details->c_sizeinfo;?>">
                </td>
            </tr>
            <tr>
                <td align="right">Printing:</td>
                <td>
                    <label>
                        <input type="radio" <?php if($cutting_details->c_print == "SS") { echo "checked='checked'";}?> id="printing" name="c_print" value="SS">Single Side
                    </label>
                    <label><input type="radio" <?php if($cutting_details->c_print == "FB") { echo "checked='checked'";}?> id="printing" name="c_print" value="FB">
                        Double Side
                    </label>
                </td>
            </tr>
            <tr>
                <td align="right">Lamination:</td>
                <td>
                    <label>
                        <input type="radio" <?php if($cutting_details->c_lamination == "SS") { echo "checked='checked'";}?> id="lamination" name="c_lamination" value="SS">Single
                    </label>
                    <label>
                        <input type="radio" id="lamination" name="c_lamination" <?php if($cutting_details->c_lamination == "FB") { echo "checked='checked'";}?> value="FB">Double
                    </label>
                    <input type="text" name="c_laminationinfo" id="lamination_info" value="<?php echo $cutting_details->c_laminationinfo;?>">
                </td>
            </tr>
            <tr>
				<td align="right">Binding</td>
				<td>
					<label><input type="checkbox" <?php if(in_array('Creasing',$binding)) { echo "checked='checked'";}?> name="c_binding" value="Creasing">Creasing</label>
					<label><input type="checkbox" <?php if(in_array('Center Pin',$binding)) { echo "checked='checked'";}?> name="c_binding" value="Center Pin">Center Pin</label>
					<label><input type="checkbox" <?php if(in_array('Perfect Binding',$binding)) { echo "checked='checked'";}?>name="c_binding" value="Perfect Binding">Perfect Binding</label>
					<label><input type="checkbox" <?php if(in_array('Performance',$binding)) { echo "checked='checked'";}?>name="c_binding" value="Performance">Performance</label>
					<label><input type="checkbox" <?php if(in_array('Folding',$binding)) { echo "checked='checked'";}?> name="c_binding" value="Folding">Folding</label>
					<br>
					Half Cutting:<input type="text" name="c_bindinginfo" id="binding_info" value="<?php echo $cutting_details->c_bindinginfo;?>">
				</td>
            </tr>
            <tr>
                <td align="right">Packing:</td>
                <td>
                    <label><input type="radio" <?php if($cutting_details->c_packing == "Paper") { echo "checked='checked'";}?>   id="packing" name="c_packing" value="Paper">Paper</label>
                    <label><input type="radio" <?php if($cutting_details->c_packing == "Loose") { echo "checked='checked'";}?>  id="packing" name="c_packing" value="Loose">Loose</label>
                    <label><input type="radio" <?php if($cutting_details->c_packing == "Plastic Bag") { echo "checked='checked'";}?> id="packing" name="c_packing" value="Plastic Bag">Plastic Bag</label>
                    <label><input type="radio" <?php if($cutting_details->c_packing == "Letter Head") { echo "checked='checked'";}?> id="packing" name="c_packing" value="Letter Head">Letter Head</label>
                    <label><input type="radio" <?php if($cutting_details->c_packing == "Parcel") { echo "checked='checked'";}?> id="packing" name="packing" value="c_Parcel">Parcel</label>
                </td>
            </tr>
            <tr>
				<td align="right">Checking:</td>
                <td>
					<label><input type="radio" <?php if($cutting_details->c_checking == "Paper") { echo "checked='checked'";}?> name="c_checking" value="Paper">Paper</label>
                    <label><input type="radio" <?php if($cutting_details->c_checking == "Printing") { echo "checked='checked'";}?> name="c_checking" value="Printing">Printing</label>
                </td>
            </tr>
            <tr>
                <td align="right">Details:</td>
                <td>
                    <textarea name="c_details" id="details" rows="4" cols="40"><?php echo $cutting_details->c_details;?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
					<input type="text" name="cutting_id" id="cutting_id" value="<?php echo $cutting_details->id;?>">
					<input type="text" name="j_id" id="j_id" value="<?php echo $j_id;?>">
                    <button onclick="update_box();">Save/Update Details</button>
                    <!--<input type="submit" name="update" value="Save Cutting Details">-->
                </td>
            </tr>
        </table>
<!--</form>-->
