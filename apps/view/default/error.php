<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $h;?></title>
	<style type="text/css">

#container {
	border: 1px solid #f46d57;
	-webkit-box-shadow:0 0 15px #f46d57 ;
	-moz-box-shadow:0 0 15px #f46d57 ;
	-ms-box-shadow:0 0 15px #f46d57 ;
	-o-box-shadow:0 0 15px #f46d57 ;
	box-shadow:0 0 15px #f46d57 ;
	border-radius: 0  0 5px 5px;
}

p {
	margin: 12px 15px 12px 15px;
	color: #666;
	font-size: 15px;
    line-height: 30px;

}
h1 {
	color: #fff;
	background-color: #f46d57;
	border-bottom: 1px solid #cccccc;
	font-size: 20px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
    line-height: 30px;
}
a,.pre{
	color: #f46d57;
	text-decoration: underline;
	text-align: right;
	float: right;
	padding: 5px 15px;
	display: inline-block;
	cursor: pointer;
}
#center{
	width: 80%;
	max-width: 500px;
	margin: 3% auto 0 auto;
	font-size: 11px;
	font-family: sans-serif;
	text-transform: capitalize;
}
</style>
</head>
<body>
	<div id="center">
		<div id="container">
			<h1><?php echo $h;?></h1>
			<p><?php echo $msg;?></p> 
		</div>
		<a href="<?php echo HTTPPATH;?>">home</a>
		<div class='pre' style="float:left" onclick="history.go(-1);">Back</div>
	</div>
</body>
</html>