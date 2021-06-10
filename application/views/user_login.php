<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css');?>">
</head>
<body>

<div class="text-right">
	<a href="<?php echo base_url('user/user_signup');?>"><button type="button" class="btn-primary">Sign Up</button></a>
</div>
<div id="container">
	<h1><?php echo $title; ?></h1>

	<div id="body" class="container">
	<?php
	$success_msg = $this->session->flashdata("success_msg");
	$error_msg_new = $this->session->flashdata("error_msg");
	if(isset($success_msg)){?>
		<div class="alert-success">
			<?php echo $success_msg; ?>
		</div>
	<?php } if(isset($error_msg_new)){?>
		<div class="alert-danger">
			<?php echo $error_msg_new; ?>
		</div>
	<?php } ?>
	</div>

	<form action="<?php echo base_url('user/submit_login') ?>" method="post" class="form-horizontal login_form" name="login_form" >
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-md-3">Email:</label>
				<div class="col-md-9">
					<input type="email" class="form-control required" name="user_email" id="user_email" placeholder="Enter Your email id" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3">Password:</label>
				<div class="col-md-9">
					<input type="password" class="form-control required" name="password" id="password" placeholder="Enter Your Password" value="">
				</div>
			</div>
			<div class="form-group text-center">
				<div class="col-md-12">
					<input class="btn btn-large btn-primary submit-login-form" type="submit" name="login" id="login" value="Submit">
				</div>
			</div>
		</div>
	</form>

</div>

</body>
</html>
<script type="text/javascript" src="<?php echo base_url('js/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery.form.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery.validate.min.js') ?>"></script>


<script type="text/javascript">
	$(document).ready(function() {
    $(".login_form").validate({
        rules: {
            user_email: {
                required: true,
                email:true
            },
            password: {
                required: true
            }
        },
    })

    $('.submit-login-form').click(function(e) {
    	e.preventDefault();
        if($(".login_form").valid()){
        	$(".login_form").ajaxForm({
        		success: function(res)
                {
                	res = $.parseJSON(res);
                    window.location.href = res.redirect_url;
                }
        	}).submit();
        }
    });
});
</script>