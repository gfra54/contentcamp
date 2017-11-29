<?php

session_start();
$file = $_GET['file'];

if(!$file)  {
	$file = 'story.html';
}
$file= realpath('.').'/site/'.$file;
if(isset($_POST['login'])) {
	$login = $_POST['login'];
	$pass = $_POST['pass'];

	$ok = array('test'=>'test');
	if($ok[$login] == $pass) {
		$_SESSION['ok']=true;
		header('Location: /');
		exit;
	}
}

if(isset($_SESSION['ok'])) {

	if(strstr($file, '.png')) {
		$ct = 'image/png';
	} elseif(strstr($file, '.jpg')) {
		$ct = 'image/jpeg';
	} elseif(strstr($file, '.css')) {
		$ct = 'text/css';
	} elseif(strstr($file, '.js')) {
		$ct = 'text/javascript';
	} elseif(strstr($file, '.html')) {
		$ct = 'text/html';
	} else {

		$mimepath='/usr/share/file/magic';
		$mime = finfo_open(FILEINFO_MIME,$mimepath);
		$ct = finfo_file($mime,$file);
		finfo_close($mime);

	}
	header("Content-type: ".$ct);
	readfile($file);
	exit;
} else {?>

<!doctype html>
<html lang="en">
 <head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">
  <title>Log In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.min.css" />
 </head>
 <body>
  
<div class="container is-fullhd" style="margin-top:2em;max-width: 600px;">
	<!--   <div class="notification">
	    This container is <strong>fullwidth</strong> <em>until</em> the <code>$fullhd</code> breakpoint.
	  </div>
	 -->
	<h1 class="title">Restricted access</h1>
	<h2 class="subtitle">Please log in to continue</h1>

	<form method="post" action="check_auth.php?file=<?php echo htmlspecialchars($file);?>">
	<div class="box">

		<div class="field">
		  <p class="control has-icons-left has-icons-right">
		    <input class="input" type="text" name="login" placeholder="Name">
		    <span class="icon is-small is-left">
		      <i class="fa fa-user"></i>
		    </span>
		  </p>
		</div>
		<div class="field">
		  <p class="control has-icons-left">
		    <input class="input" type="password" name="pass" placeholder="Password">
		    <span class="icon is-small is-left">
		      <i class="fa fa-lock"></i>
		    </span>
		  </p>
		</div>
		<div class="field">
		  <p class="control">
		    <button class="button is-success">
		      Log In
		    </button>
		  </p>
		</div>

	</div>
	</form>
 </div>

 </body>
</html>


<?php }