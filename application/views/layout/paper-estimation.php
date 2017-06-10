<div style="width: 600px; margin: 0 auto; padding: 120px 0 40px;">
			<?php
				$data = get_papers_size();
				$paper_gsm = $data['papers'];
				$paper_size = $data['size'];
			?>
			<div class="row">
			<table width="80%" border="2">
				<tr>
					<td align="right">Select Paper : </td>
					<td><select  name="paper_gram" id="hpaper_gram">
						<?php foreach($paper_gsm as $gsm) {?>
						<option value="<?php echo strtolower($gsm['paper_gram']);?>">
						<?php echo $gsm['paper_gram'];?></option>
						<?php } ?>
					</select>
					</td>
				</tr>
				<tr>
					<td align="right">Select Paper Size: </td>
					<td><select name="paper_size" id="hpaper_size">
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
					<td><select name="paper_print" id="hpaper_print">
						<option value="SS">Single</option>
						<option value="FB">Double ( front & Back )</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Quantity : </td>
					<td><input type="text" name="paper_qty" value="1" id="hpaper_qty"></td>
				</tr>
				<tr>
					<td align="right">Cuttig Charges: </td>
					<td><input type="text" name="est_cutting_charge" value="0" id="est_cutting_charge"></td>
				</tr>
				<tr>
					<td align="right">Lamination Charges : </td>
					<td><input type="text" name="est_lamination_charge" value="0" id="est_lamination_charge"></td>
				</tr>
				<tr>
					<td align="right">Binding Charges : </td>
					<td><input type="text" name="est_binding_charge" value="0" id="est_binding_charge"></td>
				</tr>
				<tr>
					<td align="right">Other Charges : </td>
					<td><input type="text" name="est_other_charges" value="0" id="est_other_charges"></td>
				</tr>
				
				<tr>
					<td colspan="2">
					<span class="btn btn-primary btn-sm" onclick="header_calculate_paper_cost()">Estimate Cost</span>
					<span style="font-size:20px;" id="hresult_paper_cost"></span>
					</td>
				</tr>
			</table>
	</div>
</div>
