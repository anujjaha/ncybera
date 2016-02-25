<?php
$created_info = get_user_by_param('id',$job_data->user_id);
$show_name = $customer_details->companyname ? $customer_details->companyname :$customer_details->name;
$content ='';
$content .= '
		<table align="center" width="900px" border="0" style="border:0px solid;">';
		 for($j=0;$j<2;$j++) {
			$content .= '<tr>
				<td width="100%" align="left">
					<table width="850px"  align="left" style="border:1px solid;">
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
								<table width="800px" align="center" style="border:1px solid;">
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
//echo $content;
create_pdf($content,'A5');
