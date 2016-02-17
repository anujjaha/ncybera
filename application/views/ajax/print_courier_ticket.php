<?php
$content .= "<center><p>To, ".$customer_details->companyname."</p>";
$content .= "<p>Contact Person : ".$customer_details->name."</p>";
$content .= "<p>Address : ".$customer_details->add1." ".$customer_details->add2."</p>";
$content .= "<p>         ".$customer_details->city." ".$customer_details->state."</p>";
$content .= "<p>         ".$customer_details->pin."</p>";
$content .= "<p>Mobile : ".$customer_details->mobile."</p></center>";
create_pdf($content,'A6-L');
