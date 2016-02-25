<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script src="<?php echo base_url();?>assets/js/calculator.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/calc_style.css" />
    <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url();?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
               Cybera Print Art
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
						<li class="dropdown messages-menu">
							<a href="#show_calculator" class="fancybox">
								Calculator
							</a>
						</li>
						<li class="dropdown messages-menu">
							<a href="#hfancy_box_demo" class="fancybox">
								Cybera Estimation
							</a>
						</li>
						<li class="dropdown messages-menu">
							<a href="#estimation_details" class="fancybox">
								SMS Estimatation
							</a>
						</li>
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo base_url('assets/img/avatar04.png')?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                        
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata['username'];?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <?php $profile = $this->session->userdata['profile_pic'];?>
                                    <img src="<?php echo base_url('assets/users/'.$profile)?>" class="img-circle" alt="User Image" />
                                    <p>
                                    <?php echo $this->session->userdata['username'];?> - 
                                    <?php echo $this->session->userdata['department'];?>
                                       
                                        <small>Cybera Team Member</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!--<li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <!--<div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>-->
                                    <div class="pull-right">
                                        <a href="<?php echo base_url();?>user/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
<div id="estimation_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="create_estimate">
    <?php $all_customer = get_all_customers(); ?>
    <table align="center" border="2" width="80%">
	<tr>
		<td align="right"> Select Customer :</td>
		<td> 
			<select class="form-control" name="customer" id="customer">
				<?php
				
				foreach($all_customer as $customer) {
					$c_name = $customer->companyname;
					if(empty($c_name)) {
						$c_name = $customer->name;
					}
					echo "<option value='".$customer->id."'>".$c_name."</option>";
				}
				?>
			</select>
			</td>
	</tr>
	<tr>
		<td align="right">Message:</td>
		<td><textarea id="sms_message" name="sms_message" cols="80" rows="6"></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" name="send" class="btn btn-success btn-lg" value="Send SMS" onclick="create_estimation();">
		</td>
	</tr>
</table>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
      $('.fancybox').fancybox({
        'width':900,
        'height':600,
        'autoSize' : false,
    });
});
function create_estimation(){
	var customer_id,sms_message;
	customer_id = $("#customer").val();
	sms_message = $("#sms_message").val();
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/create_estimation/", 
         data:{'customer_id':customer_id,"sms_message":sms_message},
         success: 
            function(data){
				alert("SMS Sent :"+data);
				$.fancybox.close();
            }
          });
}
</script>

<script>
function header_calculate_paper_cost(){
	var paper_gram,paper_size,paper_print,ori_paper_qty,paper_qty,amount=0,total=0,id,mby=1;
	paper_gram = jQuery("#hpaper_gram").val();
	paper_size = jQuery("#hpaper_size").val();
	paper_print = jQuery("#hpaper_print").val();
	id = jQuery("#hfancybox_id").val();
	paper_qty = jQuery("#hpaper_qty").val();
	ori_paper_qty = jQuery("h#paper_qty").val();
	if(paper_print == "FB") {
		paper_qty = paper_qty *2;
	}
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_paper_rate/", 
         data:{"paper_gram":paper_gram,"paper_size":paper_size,
                "paper_print":paper_print,"paper_qty":paper_qty},
         dataType:"json",
         success: 
              function(data){
                if(data.success != false ) {

                  amount = amount + parseFloat(data.paper_amount);
                  
                  total = (amount * paper_qty )* mby;
                  jQuery("#hresult_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );
                  
            } else {
                  jQuery("#hresult_paper_cost").html("[ Data not Found - Insert Manual Price]");
            }
        }
          });
}
</script>

<div id="show_calculator" style="width:800px;display: none;">
	<div class="main">
            <div class="answer"></div>
            <div class="digits">
                <table>
                    <tr>
                        <td class="tokens numbers">1</td>
                        <td class="tokens numbers">2</td>
                        <td class="tokens numbers">3</td>
                    </tr>
                    <tr>
                        <td class="tokens numbers">4</td>
                        <td class="tokens numbers">5</td>
                        <td class="tokens numbers">6</td>
                    </tr>
                    <tr>
                        <td class="tokens numbers">7</td>
                        <td class="tokens numbers">8</td>
                        <td class="tokens numbers">9</td>
                    </tr>
                    <tr>
                        <td class="tokens">+</td>
                        <td class="tokens numbers">0</td>
                        <td class="tokens">-</td>
                    </tr>
                    <tr>
                        <td class="tokens">*</td>
                        <td class="tokens clear">C</td>
                        <td class="tokens">/</td>
                    </tr>
                </table>
                <div class="answerbutton">ANSWER</div>
            </div>
        </div>
</div>
<div id="hfancy_box_demo" style="width:800px;display: none;">
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
					<td colspan="2">
					<span class="btn btn-primary btn-sm" onclick="header_calculate_paper_cost()">Estimate Cost</span>
					<span style="font-size:20px;" id="hresult_paper_cost"></span>
					</td>
				</tr>
			</table>
	</div>
    </div>
</div>
