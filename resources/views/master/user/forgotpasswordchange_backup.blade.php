<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
.wrapper_mail {
	width: 100%;
	padding: 10px;
	font-family:Arial;
	font-size:14px;
}
.banner_container_mail {
   background: url("") repeat scroll 0 0 #ffffff;
	border: 1px solid #ccc;
	clear: both;
	padding: 10px;
	color: #111;
}
.mail_body {
	padding: 10px;
	border: 1px solid #ccc;
	color: #111;
	white-space: normal;
	line-height: 18px;
}
.mail_heading {
	color: #111;
	font-size:18px; font-weight:300;
	margin-bottom:15px;
}
.footer_mail {
	background: #4c609d;
	padding: 10px;
	text-align:center;
	color:#fff;
}

.mail_body p {
    white-space: normal;
}
</style>
</head>

<body>
<div class="wrapper_mail">
    <div class="banner_container_mail"> <img alt="" src="http://182.74.36.11/avada/assets/assets/img/login/avaada-logo.jpg" alt="" /> </div>
  <div class="mail_body">
    <div class="mail_heading"></div>
    <p>Please Click This Link Below for change Set New Password </p>
    <p><a href="{{$url}}">Click here</a> :</p>
	
   
    </div>
  <div class="footer_mail"> © Copyright <?php echo date('Y');?>. All right reserved.</div>
</div>
</body>
</html>
