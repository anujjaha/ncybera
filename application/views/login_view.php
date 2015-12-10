<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title;?> - Cybera</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>"/>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css')?>"/>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.css')?>"/>
 <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>" type="text/javascript"></script>
    </head>
    <body style='background-color: #222222;'>

    <div class="form-box" id="login-box">
        <div class="header">
            Sign In
        <h4><?php echo $this->session->flashdata('msg'); ?></h4>
        </div>
        <?php echo form_open('user/login'); ?>
            <div class="body bg-gray">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="User ID"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                </div>          
                <div class="form-group">
                    <!--<input type="checkbox" name="remember_me"/> Remember me-->
                </div>
            </div>
            <div class="footer">   
                <input type="submit" class="btn bg-olive btn-block" value="Login"/>
            </div>
        </form>
    </div>
</body>
</html>