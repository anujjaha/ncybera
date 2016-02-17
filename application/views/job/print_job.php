<style>
    @media print
        {
        body div, body table {display: none;}
        body div#FAQ, body div#FAQ table {display: block;}
        }
</style>

<button onclick="print_job()">PRINT NOW</button>
<button onclick="print_cutting()">Cutting Slip</button>
<button onclick="print_courier()">Courier Slip</button>
<div class="row">
	<div class="col-md-12">
		<h1>Print Job Details</h1>
	</div>
</div>
<div id="printableArea" style="height:8.3in; width:5.8in; font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<div class="row" style="margin-top:-50px;">
	<div class="col-md-12">
		<table align="center" width="100%" border="0">
		<?php for($j=0;$j<2;$j++) {?>
			<tr>
				<td width="48%">
					<table width="100%" border="0">
						<tr>
							<td>Name : <?php	echo $customer_details->companyname;?> 
													 [<?php echo $customer_details->mobile;?>] 
							</td>
							<td  align="right">Job Num:<?php echo $job_data->id;?> [<?php echo $job_data->jdate;?>] </td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								Job Name : <?php echo $job_data->jobname;?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="200%" border="0">
									<tr>
										<th>Sr.</th>
										<th>Details</th>
										<th>Qty</th>
										<th>Rate</th>
										<th><p align="right">Amount</p></th>
									</tr>
									<?php for($i=0;$i<6;$i++) {
										if(isset($job_details[$i]['id'])){
										?>
										<tr>
											<td> <?php echo $i+1;?> </td>
											<td> <?php echo $job_details[$i]['jdetails'];?> </td>
											<td> <?php echo $job_details[$i]['jqty'];?> </td>
											<td> <?php echo $job_details[$i]['jrate'];?> </td>
											<td align="right"> <?php echo $job_details[$i]['jamount'];?> </td>
										</tr>
									<?php 
									} else {
										break;
									}
									} ?>
									<tr>
										<td colspan="2">Receipt Number:<?php echo $job_data->receipt;?></td>
										<td colspan="2" align="right">Sub Total :</td>
										<td align="right"><?php echo $job_data->subtotal;?></td>
									</tr>
									<?php if(!empty($job_data->tax)) {?>
									<tr>
										<td colspan="4" align="right">Tax :</td>
										<td align="right"><?php echo $job_data->tax;?></td>
									</tr>
									<?php } ?>
									<tr>
										<td colspan="4" align="right">Total :</td>
										<td align="right"><?php echo $job_data->total;?></td>
									</tr>
									<tr>
										<td colspan="4" align="right">Advance :</td>
										<td align="right"><?php echo $job_data->advance;?></td>
									</tr>
									<tr>
										<td colspan="2">Created by :<?php
											$created_info = get_user_by_param('id',$job_data->user_id);
											echo $created_info->nickname;
										?></td>
										<td colspan="2" align="right">Due :</td>
										<td align="right"><?php echo $job_data->due;?></td>
									</tr>
								</table>
							</td>
						</tr>
						
					</table>
				</td>
				<td width="4%">&nbsp;</td>
				<td width="48%"> 
					<table width="100%" border="0">
						<tr>
							<td>Name : <?php	echo $customer_details->name;?> 
													 [<?php echo $customer_details->mobile;?>] 
							</td>
							<td  align="right">Job Num:<?php echo $job_data->id;?> [<?php echo $job_data->jdate;?>] </td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								Job Name : <?php echo $job_data->jobname;?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="200%" border="0">
									<tr>
										<th>Sr.</th>
										<th>Details</th>
										<th>Qty</th>
										<th>Rate</th>
										<th><p align="right">Amount</p></th>
									</tr>
									<?php for($i=0;$i<6;$i++) {
										if(isset($job_details[$i]['id'])){
										?>
										<tr>
											<td> <?php echo $i+1;?> </td>
											<td> <?php echo $job_details[$i]['jdetails'];?> </td>
											<td> <?php echo $job_details[$i]['jqty'];?> </td>
											<td> <?php echo $job_details[$i]['jrate'];?> </td>
											<td align="right"> <?php echo $job_details[$i]['jamount'];?> </td>
										</tr>
									<?php 
									} else {
										break;
									}
									} ?>
									<tr>
										<td colspan="2">Receipt Number:<?php echo $job_data->receipt;?></td>
										<td colspan="2" align="right">Sub Total :</td>
										<td align="right"><?php echo $job_data->subtotal;?></td>
									</tr>
									<?php if(!empty($job_data->tax)) {?>
									<tr>
										<td colspan="4" align="right">Tax :</td>
										<td align="right"><?php echo $job_data->tax;?></td>
									</tr>
									<?php } ?>
									<tr>
										<td colspan="4" align="right">Total :</td>
										<td align="right"><?php echo $job_data->total;?></td>
									</tr>
									<tr>
										<td colspan="4" align="right">Advance :</td>
										<td align="right"><?php echo $job_data->advance;?></td>
									</tr>
									<tr>
										<td colspan="2">Created by : <?php
											$created_info = get_user_by_param('id',$job_data->user_id);
											echo $created_info->nickname;
										?></td>
										<td colspan="2" align="right">Due :</td>
										<td align="right"><?php echo $job_data->due;?></td>
									</tr>
								</table>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
		<?php 
		} ?>
		</table>
	</div>
</div></div>
<script>
function print_job() {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/jobs/print_job_ticket/"+<?php echo $job_data->id;?>, 
         success: 
              function(data){
							return true;
			 }
          });
}
function print_cutting() {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/jobs/print_cutting_ticket/"+<?php echo $job_data->id;?>, 
         success: 
              function(data){
							return true;
			 }
          });
}
function print_courier() {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/jobs/print_courier_ticket/"+<?php echo $job_data->id;?>, 
         success: 
              function(data){
							return true;
			 }
          });
}
</script>
