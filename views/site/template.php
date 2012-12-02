<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Binlagin's DemonBuddy Bots - <?php echo $title;?></title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Pragma" CONTENT="no-cache">
	<meta http-equiv="Expires" CONTENT="-1">
	<meta name="format-detection" content="telephone=no">
	<link href="<?php echo $this->config->item('site_url');?>includes/favicon.ico" rel="icon" type="image/x-icon" />
	<script type="text/javascript" src="<?php echo $this->config->item('base_url');?>includes/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url');?>includes/js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url');?>includes/js/jquery.timeago.js"></script>
</head>
<body>
	<style>
		body {
			background-color: #232323;
			background-image:url('<?php echo $this->config->item('base_url');?>includes/images/bg.jpg');
			background-repeat:no-repeat;
			background-attachment:fixed;
			background-position:center; 
			color: white;
			font-size: 0.750em;
			font-family: sans-serif;
		}
		
		h1, h2, h3, h4 {
			font-size: 2em;
			padding: 0px;
			margin: 0px;
			padding-bottom: 5px;
		}
		
		.splitPanel {
			float: left;
			width: 49%;
			margin-right: 10px;
		}
		
		.clearFix {
			clear: both;
		}
		
		.legendary {
			color: #bf642f;
		}
		.rare {
			color: #ffff00;
		}
		.left {
			float: left;
		}
		.right {
			float: right;
		}
	</style>
	<?php echo $content; ?>
</body>
</html>