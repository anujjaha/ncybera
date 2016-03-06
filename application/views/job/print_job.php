<style>
    @media print
        {
        body div, body table {display: none;}
        body div#FAQ, body div#FAQ table {display: block;}
        }
.print{font-size:6px; font-family:Arial, Helvetica, sans-serif}
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
<button onclick="print_job()">PRINT NOW</button>
<?php if($cutting_info) { ?>
<button onclick="print_cutting()">Cutting Slip</button> <?php } ?>
<button onclick="print_courier()">Courier Slip</button>
<div class="row">
	<div class="col-md-12">
		<h1>Print Job Details</h1>
	</div>
</div>
<div id="printJobTicket" style="height:8.3in; width:5.8in; font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<?php
$created_info = get_user_by_param('id',$job_data->user_id);
$show_name = $customer_details->companyname ? $customer_details->companyname :$customer_details->name;
$content ='';
$content .= '
		<table align="center" width="100%" border="0" style="border:0px solid;">';
		 for($j=0;$j<2;$j++) {
			$content .= '<tr>
				<td width="100%" align="left">
					<table width="100%"  align="left" style="border:1px solid;">
						<tr>
							<td>Name : '.$show_name.'
							</td>
							<td  align="right">Job Id : '.$job_data->id.' </td>
						</tr>
						<tr>
							<td>Mobile : '.$customer_details->mobile.' 
							</td>
							<td  align="right">Job date : '.$job_data->jdate.' </td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								Job Name : '.$job_data->jobname.'
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="100%" align="center" style="border:1px solid;">
									<tr>
										<td>Sr.</td>
										<td>Details</td>
										<td>Qty</td>
										<td>Rate</td>
										<td><p align="right">Amount</p></td>
									</tr>';
									 for($i=0;$i<6;$i++) {
										 $j1 = $i+1;
										if(isset($job_details[$i]['id'])){
										$content .= '
										<tr>
											<td> '.$j1 .'</td>
											<td> '.$job_details[$i]['jdetails'].'</td>
											<td> '.$job_details[$i]['jqty'].'</td>
											<td> '.$job_details[$i]['jrate'].' </td>
											<td align="right"> '.$job_details[$i]['jamount'].'</td>
										</tr>';
										} else {
											break;
										}
									} 
									$content .= '<tr>
										<td colspan="2">Receipt Number:'.$job_data->receipt.'</td>
										<td colspan="2" align="right">Sub Total :</td>
										<td align="right">'.$job_data->subtotal .'</td>
									</tr>';
									if(!empty($job_data->tax)) {
									$content .= '<tr>
										<td colspan="4" align="right">Tax :</td>
										<td align="right">'.$job_data->tax.'</td>
									</tr>';
									 } 
									$content .= '<tr>
										<td colspan="4" align="right">Total :</td>
										<td align="right">'. $job_data->total.'</td>
									</tr>
									<tr>
										<td colspan="4" align="right">Advance :</td>
										<td align="right">'.$job_data->advance.'</td>
									</tr>
									<tr>
										<td colspan="2">Created by :'.$created_info->nickname.'</td>
										<td colspan="2" align="right">Due :</td>
										<td align="right">'.$job_data->due.'</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
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
		} 
		$content .= '</table>
';
echo $content;
?>
</div>

<div id="printCuttingTicket" style="height:8.3in; width:5.8in; font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<!--Print Cutting Ticket-->
<?php
if($cutting_info) { 
$pcontent = "";
$pcontent .= '<table align="center" width="100%" align="center" style="border:1px solid;">
			<tr>
				<td align="left" width="50%">Customer Name : '.$customer_details->companyname.'</td>
				<td align="right">Date : '.$job_data->jdate.'</td>
			</tr>
			<tr><td align="center" colspan="2">Job Name : <strong>'.$job_data->jobname.'</strong></td></tr></table>';

$pcontent .='<table align="center" border="2" width="100%" style="border:1px solid;"><tr>';
$sr=1;
foreach($cutting_info as $cutting) {
	$pcontent .= '<td>
				<table align="center" border="2" width="100%" style="border:1px solid;">
				<tr><td align="right">Quantity : </td><td><strong>'.$cutting['c_qty'].'</strong></td></tr>
				<tr><td align="right">Material : </td><td>'.$cutting['c_material'].'</td></tr>
				<tr><td align="right">Machine : </td><td>'.$cutting['c_machine'].'</td></tr>
				<tr><td align="right">Size : </td><td>'.$cutting['c_size'].'</td></tr>
				<tr><td align="right">Size Details : </td><td>'.$cutting['c_sizeinfo'].'</td></tr>
				<tr><td align="right">Print : </td><td>'.$cutting['c_print'].'</td></tr>
				<tr><td align="right">Corner Cut : </td><td>'.$cutting['c_corner'].'</td></tr>
				<tr><td align="right">Lamination Details : </td><td>'.$cutting['c_lamination'].' '.$cutting['c_laminationinfo'] .'</td></tr>
				<tr><td align="right">Binding Details : </td><td>'.$cutting['c_binding'].' '.$cutting['c_bindinginfo'].'</td></tr>
				<tr><td align="right">Packing Details : </td><td>'.$cutting['c_packing'].'</td></tr>
				<tr><td align="right">Paper : </td><td>'.$cutting['c_checking'].'</td></tr>
				<tr><td align="right">Description : </td><td>'.$cutting['c_details'].'</td></tr>
				</table>
				</td>';
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
<div id="printCourierTickret" style="height:8.3in; width:5.8in; font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<?php
$ccontent = "";
$ccontent .= "<center><strong><p>To, ".$customer_details->companyname."</p>";
$ccontent .= "<p>Contact Person : ".$customer_details->name."</p>";
$ccontent .= "<p>Address : ".$customer_details->add1."</p><p>".$customer_details->add2."</p>";
$ccontent .= "<p>         ".$customer_details->city." ".$customer_details->state." ".$customer_details->pin."</p>";
$ccontent .= "<p>Mobile : ".$customer_details->mobile."</p></center>";
$ccontent .= "
			<div style='margin-left:45%'>
			<p>From : Cybera Print Art</p>
			<p>G/3, Samudra Annexe,Nr. Klassic Gold Hotel,</p>
			<p>Off C.G. Road, Navrangpura Ahmedabad - 009</p>
			<p>Call : 079-26565720 / 26465720 | 9898309897</p>
			<p>Email : cybera.printart@gmail.com</p>
			<p>Website : www.cybera.in | www.cyberaprint.com </p>
			</div></strong>
		</center>";
	echo $ccontent;?>
</div>
<!--Print Courier Service End-->
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
</script>
