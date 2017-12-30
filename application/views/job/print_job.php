<style>
    @media print
        {
        body div, body table {display: none;}
        body div#FAQ, body div#FAQ table {display: block;}
        }
td{font-size:9px; font-family:Arial, Helvetica, sans-serif}
.own-address td {
	font-size:12px;
	
}
.customer-address  td{
	font-size:12px;
}
.small-own-address td {
	font-size:7px;
	
}
.small-customer-address  td{
	font-size:8px;
}
#smallprintCourierTickret td {
	font-size:8px;
}

.table-curved {
    border-collapse:separate;
    border: solid #ccc 1px;
    border-radius: 25px;
}
</style>
<script type="text/javascript">
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}


</script>
<button class="btn btn-primary" onclick="print_job()">PRINT NOW</button>
<?php if($cutting_info) {?>
<span class="btn btn-primary" id="printCuttingPdfBtn" onclick="print_cutting_pdf(<?php echo $job_data->id;?>);">Cutting Slip</span>
 <?php } ?>
<button class="btn btn-primary" onclick="print_courier()">Courier Slip</button>
<button class="btn btn-primary" onclick="print_courier_small()">Small Courier Slip</button>
<button class="btn btn-primary" onclick="edit_job()">Edit Job</button>
<a href="<?php echo site_url();?>jobs/job_print_with/<?php echo $job_data->id;?>#editCuttingSlipLive">Quick Edit Cutting Slip</a>
<!--<button class="btn btn-primary" onclick="print_cutting()">Cutting Slip</button>-->
<div class="row">
	<div class="col-md-12">
		<h1>Print Job Details</h1>
	</div>
</div>

<?php
	if(strlen($job_data->extra_notes) > 0)
	{
?>
<div class="row">
	<div class="col-md-2 text-bold">
	Extra Notes
	</div>
	<div class="col-md-10">
		<?php echo $job_data->extra_notes;?>
	</div>
</div>
<hr>
<?php } ?>
<div id="printJobTicket" style="height:8.3in; width:5.8in; font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<?php
$created_info = get_user_by_param('id',$job_data->user_id);
$show_name = $customer_details->companyname ? $customer_details->companyname :$customer_details->name;
$content ='';
$customerTitle = "Name";
if($customer_details->ctype == 1 )
{
	$customerTitle = "Dealer";
}
		 for($j=0; $j<2; $j++)
		 {
			 $mobileNumber = (strlen($job_data->jsmsnumber) > 1 ) ? "-".$job_data->jsmsnumber : '';
			 $mobileNumber = $customer_details->mobile.$mobileNumber;
			$content .= '
				<table align="center" width="90%" border="0" style="border:0px solid;font-size:9px;height:3in;">
				<tr>
				<td width="100%" align="left">
					<table width="100%"  align="left" style="border:1px solid;font-size:9px;">
						<tr>
							<td align="center" style="font-size:12px;" colspan="2">
								<strong>Estimate</strong>
							</td>
						</tr>
						<tr>
							<td style="font-size:12px;">'.$customerTitle.' : <strong>'.$show_name.'</strong>
							</td>
							<td align="right" style="font-size:12px;">Mobile : <strong>'.$mobileNumber.'</strong> </td>
						</tr>
						<tr>
						<td  style="font-size:12px;" >Est Id : <strong>'.$job_data->id.'</strong> </td>
							
							<td style="font-size:12px;"  align="right">Est date : <strong>'.date('d-m-Y',strtotime($job_data->jdate)).' </strong></td>
						</tr>
						<tr>
							<td colspan="2" align="center" style="font-size:12px;">
								Title : <strong>'.$job_data->jobname.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="100%" align="center" style="border:1px solid; font-size:9px;">
									<tr>
										<td style="font-size:9px;">Sr.</td>
										<td style="font-size:9px;">Details</td>
										<td style="font-size:9px;">Qty</td>
										<td style="font-size:9px;">Rate</td>
										<td><p align="right" style="font-size:9px;">Amount</p></td>
									</tr>';
									 for($i=0;$i<6;$i++) {
										 $j1 = $i+1;
										if(isset($job_details[$i]['id'])){
										$content .= '
										<tr>
											<td style="font-size:9px;"> '.$j1 .'</td>
											<td style="font-size:9px;"> '.$job_details[$i]['jdetails'].'</td>
											<td style="font-size:9px;"> '.$job_details[$i]['jqty'].'</td>
											<td style="font-size:9px;"> '.$job_details[$i]['jrate'].' </td>
											<td style="font-size:9px;" align="right"> '.$job_details[$i]['jamount'].'</td>
										</tr>';
										} else {
											break;
										}
									} 
									$content .= '<tr>
										<td style="font-size:9px;" colspan="2">Receipt Number:'.$job_data->receipt.'</td>
										<td style="font-size:9px;" colspan="2" align="right">Sub Total :</td>
										<td style="font-size:9px;" align="right">'.$job_data->subtotal .'</td>
									</tr>';
									if(!empty($job_data->tax)) {
									$content .= '<tr>
										<td style="font-size:9px;" colspan="4" align="right">Tax :</td>
										<td style="font-size:9px;" align="right">'.$job_data->tax.'</td>
									</tr>';
									 } 
									$content .= '<tr>
										<td style="font-size:9px;" colspan="4" align="right">Total :</td>
										<td style="font-size:9px;" align="right">'. $job_data->total.'</td>
									</tr>
									<tr>
										<td style="font-size:9px;" colspan="4" align="right">Advance :</td>
										<td style="font-size:9px;" align="right">'.$job_data->advance.'</td>
									</tr>
									<tr>
										<td style="font-size:9px;" colspan="2">Created by :'.$created_info->nickname.'</td>
										<td style="font-size:9px;" colspan="2" align="right">Due :</td>
										<td style="font-size:9px;" align="right">'.$job_data->due.'</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span style="font-size:9px;">
								<strong>Note :</strong>'.$job_data->notes.'
								</span>
							</td>
						</tr>';

						if($j == 0) {
							$content .= '	
							';
						}
						$content .= '<tr>
							<td colspan="2">
							<span style="font-size:9px;">
								I/We have checked all content,color,material in the sample print.
								It is acceptable to me/us.
							</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								Signature : __________________________
							</td>
						</tr>
					</table>';
				$content .= '</td>
				
			</tr>';
			if($j == 0) {
				$content .= ' <tr><td colspan="2"><br><hr><br></td></tr>';
			}
			$content .= '</table>';
		} 
echo $content;
?>
</div>

<div id="printCuttingTicket" style="height:8.3in; width:5.8in; font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<!--Print Cutting Ticket-->
<?php
if($cutting_info) { 
$pcontent = "";
$pcontent .= '<table align="center" width="90%" align="center" style="border:1px solid;">
			<tr>
				<td align="left" width="50%">'.$customerTitle.' : '.$customer_details->companyname.'</td>
				<td align="right">Date : '.$job_data->jdate.'</td>
			</tr>
			<tr>
				<td align="left">Title : <strong>'.$job_data->jobname.'</strong></td>
				<td align="right">Est Id : <strong>'.$job_data->id.'</strong></td>
			</tr></table>';
$pcontent .='<table align="center" border="2" width="90%" style="border:1px solid;"><tr>';
$sr=1;
foreach($cutting_info as $cutting) {
	$pcontent .= '<td>
				<table align="center" border="2" width="100%" style="border:1px solid;">';
				
				if(!empty($cutting['c_machine'])) {
					$pcontent .= '<tr><td align="right">Machine : </td><td>'.$cutting['c_machine'].'</td></tr>';
				}
				
				if(!empty($cutting['c_material'])) {
					$c_m_label = "Material : ";
					if($cutting['c_material'] == "ROUND CORNER CUTTING") {
							$c_m_label = "";
					}	
					$pcontent .= '<tr><td align="right">'.$c_m_label.'  </td><td>'.$cutting['c_material'].'</td></tr>';
				}
				
				if(!empty($cutting['c_qty'])) {
					$pcontent .= '<tr><td align="right">Quantity : </td><td>'.$cutting['c_qty'].'</td></tr>';
				}
				
				if(!empty($cutting['c_size'])) { 
					$pcontent .= '<tr><td align="right">Size : </td><td>'.$cutting['c_size'].'</td></tr>';
				}
				
				if(!empty($cutting['c_print'])) {
					$pcontent .= '<tr><td align="right">Print : </td><td>'.$cutting['c_print'].'</td></tr>';
				}
				
				if(!empty($cutting['c_sizeinfo']) && strlen($cutting['c_sizeinfo']) > 2 ) { 
					$pcontent .= '<tr><td align="right"><strong>Cutting Details :</strong> </td><td>'.$cutting['c_sizeinfo'].'</td></tr>';
				}
				
							
				if(!empty($cutting['c_corner'])) {
					$pcontent .= '<tr><td align="right"><strong>Corner Cut : </strong></td><td>'.$cutting['c_corner'].'</td></tr>';
				}
				
				if(!empty($cutting['c_cornerdie'])) {
					$pcontent .= '<tr><td align="right"><strong>Corner Die No : </strong></td><td>'.$cutting['c_cornerdie'].'</td></tr>';
				}
				
				if(!empty($cutting['c_rcorner'])) {
					$pcontent .= '<tr><td align="right"><strong>Round Cutting Side : </strong></td><td>'.$cutting['c_rcorner'].'</td></tr>';
				}
				
				if(!empty($cutting['c_laser'])) {
					$pcontent .= '<tr><td align="right"><strong>Laser Cut : </strong></td><td>'.$cutting['c_laser'].'</td></tr>';
				}
			
				if(!empty($cutting['c_lamination'])) {
					$pcontent .= '<tr><td align="right"><strong>Lamination Details : </strong></td><td>'.$cutting['c_lamination'];
					if(!empty($cutting['c_laminationinfo'])) {
						$pcontent .= '<br>'.$cutting['c_laminationinfo'];
					}
					
					$pcontent .= '</td></tr>';
				}
			
				if(!empty($cutting['c_binding'])) {	
					$pcontent .= '<tr><td align="right"><strong>Binding Details : </strong></td><td>'.$cutting['c_binding'];
					
					if(!empty($cutting['c_bindinginfo'])) {
						$pcontent .= '<br>'.$cutting['c_bindinginfo'];
					}
					$pcontent .= '</td></tr>';
				}
			
				if(!empty($cutting['c_details'])) {
					$pcontent .= '<tr><td colspan="2">Description : <strong>'.$cutting['c_details'].'</strong></td></tr>';
				}
				
				if(!empty($cutting['c_packing'])) {
					$pcontent .= '<tr><td align="right">Packing Details : </td><td>'.$cutting['c_packing'].'</td></tr>';
				}
			
				$pcontent .= '</table> </td>';
				if($sr > 1 && ($sr % 2) ==0) {
					$pcontent .= '</tr><tr>';
				}
				$sr++;
}
$pcontent .= '</tr></table>';
echo $pcontent;
}
?>
</div>
<!--Print Cutting Ticket End-->

<!--Print Courier Service-->
<div id="printCourierTickret" style="height:8.3in; width:5.8in; font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<table align="center" border="2" width="85%" style="border: 2px solid #000000; border-radius: 10px;">
<tr>
<td>
<table align="center" border="0" width="100%">
	<tr>
		<td>
			<table align="left" width="100%" border="0" style="margin-left: 10px; margin-top: 20px; line-height: 95%;">
			<tr>
				<td> 
					<span style="font-size:20px; line-height: 95%;">
						<strong>To, </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td> 
					<span style="font-size:20px; font-weight: bold; line-height: 95%;">
						<strong><?php echo $customer_details->companyname ?  $customer_details->companyname :  $customer_details->name;?> </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" class="customer-address">
					<tr>
						<td style="font-size:18px; line-height: 95%;">
							<?php echo $customer_details->add1."<br>".$customer_details->add2;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:18px; line-height: 95%;">
							<?php echo $customer_details->city." ".$customer_details->state." ".$customer_details->pin;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:18px; line-height: 95%;">
							Mobile - <?php echo $customer_details->mobile;?>
						</td>
					</tr>
					<?php
					if(isset($transporter_info)) {
					?>
					<tr>
						<td style="font-size:18px; line-height: 95%;">
							Delivery By : <?php echo $transporter_info->name;?>
						</td>
					</tr>
					<?php } ?>
					</table>
				</td>
			</tr>
		</table>
		 </td>
	</tr>
	<tr>
		<td>
			<table align="center" width="100%">
			<tr>
				<td width="16%">&nbsp;</td>
				<td>
					<table width='100%' align='right' border='0' style="font-size:15px; line-height: 95%;" class="own-address">
					<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td><td><strong>From, </strong></td></tr>
					<tr><td>&nbsp;</td><td><strong>CYBERA PRINT ART</strong> </td></tr>
					<tr><td>&nbsp;</td><td>G/3, Samudra Annexe, Nr. Girish Cold Drinks Cross Road,</td></tr>
					<tr><td>&nbsp;</td><td>Off C.G. Road, Navrangpura, Ahmedabad - 009</td></tr>
					<tr><td>&nbsp;</td><td>Call : 079-26565720 / 26465720</td></tr>
					<tr><td>&nbsp;</td><td>Mobile : 9898309897</td></tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

</td>
</tr>

</table>
</div>


<!--Small Print Courier Service-->
<div id="smallprintCourierTickret" style="height:3.5in; width:3.5in;  font-family:Arial, Helvetica, sans-serif;">
<table align="center" border="2" width="65%" style="border: 2px solid #000000; border-radius: 10px;">
<tr>
<td>
<table align="center" border="0" width="95%">
	<tr>
		<td>
			<table align="left" width="100%" border="0">
			<tr>
				<td> 
					<span style="font-size:15px;  line-height: 95%;">
						<strong>To, </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td> 
					<span style="font-size:15px; font-weight: bold;  line-height: 95%;">
						<strong><?php echo $customer_details->companyname ?  $customer_details->companyname :  $customer_details->name;?> </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" class="small-customer-address" style="font-size:14px;  line-height: 95%;">
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							<?php echo $customer_details->add1." ".$customer_details->add2;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							<?php echo $customer_details->city." ".$customer_details->state." ".$customer_details->pin;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							Mobile - <?php echo $customer_details->mobile;?>
						</td>
					</tr>
					<?php
					if(isset($transporter_info)) {
					?>
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							Delivery By : <?php echo $transporter_info->name;?>
						</td>
					</tr>
					<?php } ?>
					</table>
				</td>
			</tr>
		</table>
		 </td>
	</tr>
	<tr>
		<td>
			<table align="center" width="100%">
			<tr>
				<td width="8%">&nbsp;</td>
				<td>
					<table width='100%' align='right' border='0' class="small-own-address">
					<tr style="height:5px;"><td>&nbsp;</td><td style="font-size:12px;  line-height: 14px;"><strong>From, CYBERA PRINT ART</strong> </td></tr>
					<tr style="height:5px;"><td>&nbsp;</td><td style="font-size:12px;  line-height: 14px;">
					G/3, Samudra Annexe,Nr. Girish Cold Drink Cross Road,
					<br>
					Off C.G. Road, Navrangpura Ahmedabad - 009
					<br>
					Call : 079-26565720 / 26465720 | 9898309897</td></tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</div>
<!--Small Print Courier Service End-->

<script>
function print_job() {
	printDiv('printJobTicket');
/*$.ajax({
type: "POST",
url: "<?php echo site_url();?>/jobs/print_job_ticket/"+<?php echo $job_data->id;?>, 
success: 
function(data){
print_cutting();
return true;
}
});*/
}
function print_cutting() {
	printDiv('printCuttingTicket');
/*$.ajax({
type: "POST",
url: "<?php echo site_url();?>/jobs/print_cutting_ticket/"+<?php echo $job_data->id;?>, 
success: 
function(data){
return true;
}
});*/
}

function print_courier_small() {
	printDiv('smallprintCourierTickret');
}
function print_courier() {
	printDiv('printCourierTickret');
	/*$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/jobs/print_courier_ticket/"+<?php echo $job_data->id;?>, 
         success: 
              function(data){
							return true;
			 }
          });*/	
}

function edit_job() {
	window.location.assign("<?php echo site_url();?>/jobs/edit_job/<?php echo $job_data->id;?>");
}

function print_cutting_pdf(id)
{
	jQuery("#printCuttingPdfBtn").attr('disabled', 'disabled');
	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/generaeAjaxCuttingSlip/"+id,
		method: "GET",
		dataType: 'JSON',
		success: function(data)
		{
			if(data.status == true)
			{
				window.open(data.link);
			}
			else
			{
				alert("Unable to Create PDF");
			}
		},
		complete: function(data) {
			jQuery("#printCuttingPdfBtn").removeAttr('disabled');
		}
	});

}
</script>
<div id="editCuttingSlipLive">
<?php
//pr($cutting_info);
	//	pr($job_data);
?>
		this is test
</div>