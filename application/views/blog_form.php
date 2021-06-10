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
	<a href="<?php echo base_url();?>"><button type="button" class="btn-primary">Blog List</button></a>
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

	<form action="<?php echo base_url('blogs/submit_blog_form') ?>" method="post" class="form-horizontal blog_form" enctype="multipart/form-data" name="blog_form" >
		<div class="col-md-12">

			<input type="hidden" name="blog_id" id="blog_id" value="<?php echo $id; ?>">
			<div class="form-group">
				<label class="col-md-3">Blog Title:</label>
				<div class="col-md-9">
					<input type="text" class="form-control required" name="blog_title" id="blog_title" placeholder="Enter Blog Title" value="<?php echo $blog_title; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3">Blog Description:</label>
				<div class="col-md-9">
					<textarea class="form-control required" name="blog_description" id="blog_description"><?php echo $blog_description; ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3">Blog Image:</label>
				<div class="col-md-9">
					<input type="file" accept="image/*" name="form-control required" name="image" id="image" value="<?php echo $image; ?>">
					<img id="img_preview" src="<?php echo base_url('upload/').$image ?>" alt="<?php echo $image; ?>" width="100px" height="100px;">
				</div>
			</div>
			<div class="form-group text-center">
				<div class="col-md-12">
					<input class="btn btn-large btn-primary submit-blog-form" type="submit" name="blog_form_submit" id="blog_form_submit" value="Submit">
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
	function readFile(file,callback){
		var reader = new FileReader();
		reader.onload = callback;
		reader.readAsDataURL(file);
	}

	$(document).ready(function() {
		$(document).on("change","#image", function(e){
			var file = this.files[0];
			//const fileSize = file.size;
			if(this.files[0].size>102800){
				alert("File size must be less than 100KB");
				$("#image").val('');
				$("#img_preview").attr('src','');
				return false;
			}

			readFile(file,function(e){
				var image = new Image();
				image.src = e.target.result;
				image.onload = function(){
					$("#img_preview").attr('src',this.src);
				}
			});
		});

		$(".blog_form").validate({
			rules: {
				blog_title: {
					required: true,
					maxlength: 255
				},
				blog_description: {
					required: true,
					maxlength: 65535
				},
				image: {
					required: function(){
						if($("#blog_id").val()>0){
							return false;
						}else{
							return true;
						}
					}
				}
			},
		});

		$('.submit-blog-form').click(function(e) {
			e.preventDefault();
			if($(".blog_form").valid()){
				$(".blog_form").ajaxForm({
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