<div class="box">
	<div class="box-header">
		<h3 class="box-title">Customer Account Details</h3>
	</div><!-- /.box-header -->
	<div class="box-header">
	</div>
	<div class="box-body table-responsive">
		<?php
		$sr =1;	
		$collection = array();
		foreach($customers as $customer) { 
			$balance = round($customer->total_credit - $customer->total_debit,0);
			if($balance != 0 )
			{
				$collection[] = $customer;
			}
			else
			{
				continue;
			}
		?>
		<?php $sr++; } 
		
			pr($collection);	
		?>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>
