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
	<?php if($this->session->userdata("id")==NULL){ ?>
		<a href="<?php echo base_url('user/user_login');?>"><button type="button" class="btn-primary">Login</button></a>
		<a href="<?php echo base_url('user/user_signup');?>"><button type="button" class="btn-primary">Sign Up</button></a>
	<?php }else{ ?>
		<a href="<?php echo base_url('user/user_logout');?>"><button type="button" class="btn-primary">Logout</button></a><br><br>
		<a href="<?php echo base_url('blogs/blog_form');?>"><button type="button" class="btn-primary">Add Blog</button></a>
	<?php } ?>
</div>

<div class="container">
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

<div id="container">
	<h1><?php echo $title; ?></h1>

	<div id="body">
		<table>
			<tr>
				<th>Image</th>
				<th>Title</th>
				<th>Description</th>
				<th>Tags</th>
				<th>Actions</th>
			</tr>
			<?php echo $blog_listing; ?>
		</table>
	</div>

</div>

</body>
</html>