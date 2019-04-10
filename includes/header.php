<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8' />
	
	<title><?php echo (isset($title)) ? $title : "IZCMS2" ; ?></title>
	
	<link rel='stylesheet' href='css/style.css' />
</head>

<body>
	<div id="container">
	<div id="header">
		<h1><a href="">izCMS</a></h1>
        <p class="slogan">The iz Content Management System</p>
	</div>
	<div id="navigation">
		<ul>
	        <li><a href='#'>Home</a></li>
			<li><a href='#'>About</a></li>
			<li><a href='#'>Services</a></li>
			<li><a href='#'>Contact us</a></li>
		</ul>
        
        <p class="greeting">Xin chào bạn hiền!</p>
	</div><!-- end navigation-->