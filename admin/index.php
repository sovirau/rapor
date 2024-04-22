<?php
error_reporting(0);
  session_start();
  require_once "config.php";

  if(isset($_POST['login'])){

    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql = mysql_query("Select * from tb_admin where admin = '$username' and password = '$password'");
    $row = mysql_fetch_array($sql);

    if($password == $row['password']){
      $_SESSION['admin'] = $row['admin'];
      header('Location:home.php');
    }
    else{
      unset($_POST['login']);
      header('Location:index.php?submit=error');
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Nilai Akademik</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<div class="row">
            <div class="col-md-4">
                </div>
            <div class="col-md-4">
                <div class="panel panel-primary">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" name = "form" method = "post" action = "index.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type = "submit" name = "login" value = "Login" class="btn btn-success">
                                <button type="reset" class = "btn btn-danger">Reset</button><br><br>

    <?php 
    if($_GET['submit']=='error'){
        echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-ok"></span> Username atau Password Salah</div>';
    }
    else if($_GET['submit']=='logout'){
        echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Anda sudah logout</div>';
        }
    else if($_GET['submit']=='login'){
        echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span> Silahkan Login </div>';
        }
    ?>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class = "col-md-4">
            </div>
        </div>
</body>
</html>