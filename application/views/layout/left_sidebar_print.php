<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                             <?php
								$profile = $this->session->userdata['profile_pic'];
								if(empty($profile)) {
									$profile = 'avatar5.png';
								}
                            ?>
                            <img src="<?php echo base_url('assets/users/'.$profile)?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $this->session->userdata['username'];?></p>

                            <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                        </div>
                    </div>
                    <!-- search form -->
                   
                    <form action="<?php echo base_url();?>prints/search" method="post" class="sidebar-form">
                        <div class="input-group">
                        <?php
                        $q = $this->input->post('q');
                        ?>
                            <input type="text" name="q" value="<?php echo $q;?>" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo base_url();?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                         <li>
                            <a href="<?php echo base_url();?>prints/get_all">
                                <i class="fa fa-envelope"></i> <span>All Jobs</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-envelope"></i> <span>Inbox</span>
                                <small class="badge pull-right bg-yellow">2</small>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-envelope"></i> <span>Tasks Alloted</span>
                                <small class="badge pull-right bg-yellow">5</small>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
<script>
jQuery("document").ready(function(){
	/*
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/user/get_leftbar_status/", 
          dataType: 'json',
         success: 
            function(data){
				jQuery("#show_jobs").html(data.jobs);
				jQuery("#show_dealers").html(data.dealers);
				jQuery("#show_customers").html(data.customers);
				
			}
          });*/
});
</script>
