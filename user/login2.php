<html>
<head>
  <title>Nilai Akademik</title>
    <link rel="stylesheet" href="user/css/bootstrap.css" />
    <link rel="stylesheet" href="user/css/login.css" />
    <link rel="stylesheet" href="user/magic/magic.css" />
</head>
<body>
<?php
error_reporting(0);
  session_start();

  $host = 'localhost';
  $user ='root';
  $pass = '';
  $db = 'nilai_akademik';

  $koneksi = mysql_connect($host, $user, $pass);

  $koneksi_database = mysql_select_db($db);

  if(isset($_POST['submit'])){

    $username=$_POST['username'];
    $password = mysql_real_escape_string($_POST['password']);

    $sql = mysql_query("SELECT * from tb_login where username = '$username'");
    $row = mysql_fetch_array($sql);

    if($password == $row['password']){
      $_SESSION['username'] = $row['username'];
      $_SESSION['password'] = $row['password'];
      $_SESSION['level'] = $row['level'];
      print "<script>window.location='?url=status'</script>";
    }
    else{
      unset($_POST['submit']);
      echo "<script> alert('Login Gagal!'); </script>";
      echo mysql_error();
    }
  }
?>
</html>