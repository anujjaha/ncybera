<?php
$created_info = get_user_by_param('id',$job_data->user_id);
$content ='';
$content .= '
		<table align="center" width="650px" border="0" style="border:0px solid;">';
		 for($j=0;$j<2;$j++) {
			$content .= '<tr>
				<td width="50%" align="left">
					<table width="100%" align="left" style="border:1px solid;">
						<tr>
							<td>Name : '.$customer_details->companyname.'['.$customer_details->mobile.'] 
							</td>
							<td  align="right">Job Num:'.$job_data->id.'['.$job_data->jdate.'] </td>
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
						
					</table>';
				$content .= '</td>
				<td width="50%" align="right"> 
					<table width="100%" align="center" style="border:1px solid;">
						<tr>
							<td>Name : '.$customer_details->companyname.'
													 ['.$customer_details->mobile.'] 
							</td>
							<td  align="right">Job Num:'.$job_data->id .' ['.$job_data->jdate.'] </td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								Job Name : '.$job_data->jobname.'
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table align="center" width="100%" style="border:1px solid;">
									<tr>
										<td>Sr.</td>
										<td>Details</td>
										<td>Qty</td>
										<td>Rate</td>
										<td><p align="right">Amount</p></td>
									</tr>';
									for($i=0;$i<6;$i++) {
										if(isset($job_details[$i]['id'])){
										$j2 = $i +1;
										$content .= '<tr>
											<td> '.$j2 .'</td>
											<td> '. $job_details[$i]['jdetails'] .' </td>
											<td> '.$job_details[$i]['jqty'] .'</td>
											<td> '. $job_details[$i]['jrate'].' </td>
											<td align="right"> '. $job_details[$i]['jamount'].' </td>
										</tr>';
										} else {
											break;
										}
									} 
									$content .= '<tr>
										<td colspan="2">Receipt Number:'.$job_data->receipt.'</td>
										<td colspan="2" align="right">Sub Total :</td>
										<td align="right">'. $job_data->subtotal.'</td>
									</tr>';
									 if(!empty($job_data->tax)) {
									$content .= '<tr>
										<td colspan="4" align="right">Tax :</td>
										<td align="right">'.$job_data->tax.'</td>
									</tr>';
									 } 
									$content .= '<tr>
										<td colspan="4" align="right">Total :</td>
										<td align="right">'.$job_data->total.'</td>
									</tr>
									<tr>
										<td colspan="4" align="right">Advance :</td>
										<td align="right">'. $job_data->advance.'</td>
									</tr>
									<tr>
										<td colspan="2">Created by :'.$created_info->nickname.'</td>
										<td colspan="2" align="right">Due :</td>
										<td align="right">'.$job_data->due.'</td>
									</tr>
								</table>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>';
			if($j == 0) {
				$content .= ' <tr><td colspan="2"><hr></td></tr>';
			}
		} 
		$content .= '</table>
';
//echo $content;
create_pdf($content);
