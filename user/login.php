<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->
<head>
     <meta charset="UTF-8" />
    <title>Nilai Akademik</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
     <!-- PAGE LEVEL STYLES -->
     <link rel="stylesheet" href="user/css/bootstrap.css" />
    <link rel="stylesheet" href="user/css/login.css" />
    <link rel="stylesheet" href="user/magic/magic.css" />
     <!-- END PAGE LEVEL STYLES -->
   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
    <!-- END HEAD -->
<?php
error_reporting(0);
  session_start();

  $host = 'localhost';
  $user ='root';
  $pass = '';
  $db = 'nilai_akademik';

  $koneksi = mysql_connect($host, $user, $pass);

  $koneksi_database = mysql_select_db($db);

  if(isset($_POST['login_guru'])){

    $username=$_POST['username'];
    $password = md5($_POST['password']);

    $pass = mysql_real_escape_string($_POST['password']);

    $sql = mysql_query("SELECT * from tb_login where username = '$username' and password = '$pass'");

    if(mysql_num_rows($sql) == 1){
      $row = mysql_fetch_array($sql);
      $_SESSION['username'] = $row['username'];
      $_SESSION['password'] = $row['password'];
      $_SESSION['level'] = $row['level'];
        header('Location:?url=status');
    }
    else{
      unset($_POST['login_guru']);
      echo "<script>alert('gagal');</script>";
      echo mysql_error();
    }
  }
?>

    <!-- BEGIN BODY -->

   <!-- PAGE CONTENT --> 
    <div class="container">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    Login untuk Masuk
                    <form role="form" method = "post" action="?url=login">
                        <div class= "form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" name = "username" class="form-control" placeholder="Username" required autofocus>
                            </div>
                        </div>
                        <div class= "form-group">
                            <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required autofocus>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
                        <button type="submit" name="login_guru" class="btn btn-primary"><span class="glyphicon glyphicon-lock"></span> Login</button>
                    </form>
                </div>
                <div class="col-md-4">
                </div>
            </div>
    </div>

	  <!--END PAGE CONTENT -->     
	      
      <!-- PAGE LEVEL SCRIPTS -->
      <script src="user/js/jquery-2.0.3.min.js"></script>
      <script src="user/js/bootstrap.js"></script>
      <script src="user/js/login.js"></script>
      <!--END PAGE LEVEL SCRIPTS -->

</body>
    <!-- END BODY -->
</html>
