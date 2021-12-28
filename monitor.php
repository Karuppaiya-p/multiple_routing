<?php
	$out="";
	$error= "";
	$sucesss=0;
	$r_username="";
	$r_password="";
	$r_host="";
	$r_dest="";
	$r_file="";
	if(isset($_POST["send"]))
	{
		if(is_uploaded_file($_FILES['Filedata']['tmp_name']))
		{
			setcookie("UserFormData", serialize($_POST), time()+3600);
			if(isset($_POST["share_with"]))
			{
				$share_with=implode(",",$_POST["share_with"]);
			}
			$r_host=$ftp_host=$_POST["ipaddress"];
			$r_username=$ftp_user_name=$_POST["username"];
			$r_password=$ftp_user_pass=$_POST["password"];
			$r_dest=$destination=$_POST["destination"];
			$r_file=$_FILES['Filedata']['name'];
			$file_ext=pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION);
			$basefile=basename($_FILES['Filedata']['name'],".".$file_ext);
				$filename=$basefile.uniqid().".".$file_ext;
				$local_file   = $_FILES['Filedata']['tmp_name'];
				$remote_file = $destination.$filename;
				/* Connect using basic FTP */
				$connect_it = ftp_connect( $ftp_host ) or die("Could not connect to $ftp_host");
	
				/* Login to FTP */
				$login_result = ftp_login( $connect_it, $ftp_user_name, $ftp_user_pass );
				
				/* Send $local_file to FTP */
				if ( ftp_put( $connect_it, $remote_file, $local_file, FTP_BINARY ) ) {
					$error= "<h1 style='text-align:center; color:red'>Successfully transfered</h5>\n";
					
					$sucesss=1;
				}
				else {
					$error=  "<h1 > There was a problem\n</h1>";
					$sucesss=0;
				}

				/* Close the connection */
				ftp_close( $connect_it );
		}
		else
		{
			$out="*Please give all inputs";
		}
	}

	$track_file=explode("\n",shell_exec("Netsh WLAN show interfaces"));
	$network="";
	foreach($track_file as $img)
	{
		if(!empty($img))
		{
			$network.="<p>".$img."</p>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MULTIPLE ROUTING CONFIGURATIONS FOR FAST IP NETWORK</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div id="mySidenav" class="sidenav">
  <a href="index.php" id="index">Index</a>
  <a href="project.php" id="projects">Projects</a>
  <a href="monitor.php" id="monitor">Monitor</a>
</div>
<div style="margin-left:80px;">
	<h1 style="color:blue;text-align:center">MULTIPLE ROUTING CONFIGURATIONS FOR FAST IP NETWORK</h1>
	<p style="text-align:center"><img src="3d.jpg"></p>
	<div class="card">
	<h3>Detected Network</h3>
	<?=$network;?>
	<?=$error;?>
	<form action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST" enctype="multipart/form-data">
		Browse File<input type="file" name="Filedata">
		<label for="key"><h5>Enter System IP Address</h5></label>
		<input type="text" name="ipaddress" id="ipaddress" placeholder="Enter ip address" required>
		<label for="username"><h5>Enter another system Shared user name</h5></label>
		<input type="text" name="username" id="username" placeholder="Enter User name" required>
		<label for="password"><h5> Another system Shared Password</h5></label>
		<input type="text" name="password" id="password" placeholder="Enter Password" required>
		<label for="destination"><h5>Sharable Path ( From server root path )</h5></label>
		<input type="text" name="destination" id="destination" placeholder="Enter destination path" required>
		<input type="submit" name="send" value="upload">
	</form>
	<form action = "<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST" name="myform" enctype="multipart/form-data">
		<input type="hidden" name="sucesss" value="<?=$sucesss?>">
		<input type="hidden" name="r_username" value="<?=$r_username?>">
		<input type="hidden" name="r_password" value="<?=$r_password?>">
		<input type="hidden" name="r_host" value="<?=$r_host?>">
		<input type="hidden" name="r_dest" value="<?=$r_dest?>">
		<input type="hidden" name="r_file" value="<?=$r_file?>">
	</form>
	</div>
</div>
</body>
</html> 