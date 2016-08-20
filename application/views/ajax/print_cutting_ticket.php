<?php
$content .= '<table align="center" width="100%" align="center" style="border:1px solid;">
			<tr>
				<td align="left" width="50%">Customer Name : '.$customer_details->companyname.'</td>
				<td align="right">Date : '.$job_data->jdate.'</td>
			</tr>
			<tr><td align="center" colspan="2">Job Name : <strong>'.$job_data->jobname.'</strong></td></tr></table>';

$content .='<table align="center" border="2" width="100%" style="border:1px solid;"><tr>';
$sr=1;
foreach($cutting_info as $cutting) {
	$content .= '<td>
				<table align="center" border="2" width="100%" style="border:1px solid;">
				<tr><td align="right">Material : </td><td>'.$cutting['c_material'].'</td></tr>
				<tr><td align="right">Machine : </td><td>'.$cutting['c_machine'].'</td></tr>
				<tr><td align="right">Size : </td><td>'.$cutting['c_size'].'</td></tr>
				<tr><td align="right">Print : </td><td>'.$cutting['c_print'].'</td></tr>
				<tr><td align="right">Cutting Details : </td><td>'.$cutting['c_sizeinfo'].'</td></tr>
				<tr><td align="right">Quantity : </td><td><strong>'.$cutting['c_qty'].'</strong></td></tr>
				<tr><td align="right">Corner Cut : </td><td>'.$cutting['c_corner'].'</td></tr>
				<tr><td align="right">Lamination Details : </td><td>'.$cutting['c_lamination'].' '.$cutting['c_laminationinfo'] .'</td></tr>
				<tr><td align="right">Binding Details : </td><td>'.$cutting['c_binding'].' '.$cutting['c_bindinginfo'].'</td></tr>
				<tr><td align="right">Packing Details : </td><td>'.$cutting['c_packing'].'</td></tr>
				<tr><td align="right">Paper : </td><td>'.$cutting['c_checking'].'</td></tr>
				<tr><td align="right">Description : </td><td>'.$cutting['c_details'].'</td></tr>
				</table>
				</td>';
				if($sr > 1 && ($sr % 2) ==0) {
					$content .= '</tr><tr>';
				}
				$sr++;
}
$content .= '</tr></table>';
//echo $content;
create_pdf($content);

