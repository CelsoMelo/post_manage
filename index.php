<?php
	ob_start();
	session_start();
	if(isset($_SESSION['usercms']) && isset($_SESSION['pswcms'])){
		header("Location: home.php");exit;
	}

	include("conex/connect.php");
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Login - Bootstrap Admin Template</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="index.html">
				Bootstrap Admin Template				
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					
					<li class="">						
						<a href="signup.html" class="">
							Don't have an account?
						</a>
						
					</li>
					
					<li class="">						
						<a href="../" class="">
							<i class="icon-chevron-left"></i>
							Back to Homepage
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->



<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="#" method="post" enctype="multpart/form-data">
		
			<h1>Member Login</h1>		
			
			<div class="login-fields">
				
				<p>Please provide your details</p>
				<?php
				if(isset($_GET['access']) && $_GET['access'] == 'denied' && !isset($_POST['signIn'])){
					echo '<div class="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Erro!</strong> Você precisa estar logado para acessar o sistema.</div>';
				}
				if(isset($_POST['signIn'])) {
					$usr = trim(strip_tags($_POST['username']));
					$psw = trim(strip_tags($_POST['password']));
			
					$querySelect = 'SELECT * FROM login WHERE BINARY login_username = :username AND BINARY login_password = :password';
			
					try{
						$result = $conection->prepare($querySelect);
						$result->bindParam(':username', $usr, PDO::PARAM_STR);
						$result->bindParam(':password', $psw, PDO::PARAM_STR);
						$result->execute();
						$count = $result->rowCount();
						if($count > 0) {
							$usr = $_POST['username'];
							$psw = $_POST['password'];
							$_SESSION['usercms'] = $usr;
							$_SESSION['pswcms'] = $psw;
							echo '<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Sucesso!</strong> Redirecionando...</div>';
							header("Refresh: 3, home.php");
						}else{
							echo '<div class="alert">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Erro ao logar!</strong> Dados incorretos!</div>';
						}
					} catch(PDOExpetion $e) {
						echo 'ERRO: ' . $e;
					}
				}
				?>
				
				<div class="field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>
									
				<input type="submit" value="Sign In" name="signIn" class="button btn btn-success btn-large">
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<div class="login-extra">
	<a href="#">Reset Password</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
