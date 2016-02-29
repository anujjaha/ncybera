<?php
$content .= "<center><strong><p>To, ".$customer_details->companyname."</p>";
$content .= "<p>Contact Person : ".$customer_details->name."</p>";
$content .= "<p>Address : ".$customer_details->add1."</p><p>".$customer_details->add2."</p>";
$content .= "<p>         ".$customer_details->city." ".$customer_details->state." ".$customer_details->pin."</p>";
$content .= "<p>Mobile : ".$customer_details->mobile."</p></center>";
$content .= "
			<div style='margin-left:45%'>
			<p>From : Cybera Print Art</p>
			<p>G/3, Samudra Annexe,Nr. Klassic Gold Hotel,</p>
			<p>Off C.G. Road, Navrangpura Ahmedabad - 009</p>
			<p>Call : 079-26565720 / 26465720 | 9898309897</p>
			<p>Email : cybera.printart@gmail.com</p>
			<p>Website : www.cybera.in | www.cyberaprint.com </p>
			</div></strong>
		</center>";

create_pdf($content,'A6-L');
