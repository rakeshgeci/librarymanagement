<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Library Manager - <?php echo  $_SESSION['user']; ?></title>
<link rel="stylesheet" type="text/css" href="../res/css/style.css" />
<link rel="stylesheet" type="text/css" href="../res/css/request.css" />
<link rel="stylesheet" type="text/css" href="../res/css/login.css" />
<script type="text/javascript" src="../res/js/jquery-2.1.1.js"></script>
<style type="text/css">
.bgimage {
  left: 5%;
  height: 300px;
  position: absolute;
  top: 10%;
  width: 300px;
}

</style>
</head>
<body>
<div class="container">
	<section id="content">
            <form action="index.php" method="post">
			<h1>Login Here</h1>
			<div>
                            <input type="text" placeholder="Username" name="userid" required="" id="userid" />
			</div>
			<div>
                            <input type="password" placeholder="Password" name="password" required="" id="password" />
			</div>
			<div>
                            <input type="submit" value="Log in" />
				<!--<a href="#">Lost your password?</a>
				<a href="#requestLogin">Request Login</a>-->
			</div>
		</form><!-- form -->
		
	</section><!-- content -->
</div><!-- container -->
<div class="bgimage">
<img src="nitc-logo.png" width="500px" height="600px">
</div>
<div id="requestLogin"> <a href="#" class="cancel">&times;</a> 
<section id="contentReq"> 
    <form>  <h1> Fill This </h1>
        <div>
		<input type="text" placeholder="Id No" required="" id="name">
        </div>
        <div>   <input type="text" placeholder="Name" required="" id="name">
        </div>        
        <div>         <input type="text" placeholder="Email" required="" id="name">
        </div>        
        <div>       <input type="text" placeholder="Phone" required="" id="name">
        </div> 
        <div>        <input type="text" placeholder="ppp" required="" id="name">
        </div>
        <div>
		<input type="submit" value="Log in" />
	</div>
	</form>
	</section>
</div> <div id="cover" > </div>
</body>
</html>