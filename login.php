<?php
session_start();
if (isset($_SESSION['admin_username'])) {
    header("location:logged.php");
}

$koneksi    = mysqli_connect("localhost", "root", "", "bsw_fix");
$username = "";
$password = "";
$err = null;


if (isset($_POST['login'])) {
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    if ($username == '' or $password == '') {
            $err .= "<li>Silakan masukkan username dan password</li>";
    }
    if (empty($err)) {
        $sql1 = "select * from user where username = '$username'";
        $q1 = mysqli_query($koneksi, $sql1);
        $r1 = mysqli_fetch_array($q1);
        if (mysqli_num_rows($q1) === 0) 
        {
            if ( isset($r1['password']) != md5($password)) {
            $err .= "<li>Akun tidak ditemukan</li>";
        }
        }        
    }
    if (empty($err)) {
        $login_id = $r1['id_akses'];
        $sql2 = "select * from akses_halaman where id_akses = '$login_id'";
        $q2 = mysqli_query($koneksi, $sql2);
        while ($r2 = mysqli_fetch_array($q2)) {
            $akses[] = $r2['halaman_akses']; 
        }
        if (empty($akses)) {
            $err .= "<li>Kamu tidak punya akses ke halaman ini</li>";
        }
    }
    if (empty($err)) {
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_akses'] = $akses;
        header("location:logged.php");
        exit();
    }
    
}

if (isset($_POST['kembali'])){
    header("location:pengunjung.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="assets/css/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400;700&display=swap" rel="stylesheet">
</head>
<body>
   <div class="overlay"></div>
   <?php
   if ($err) {
            echo "<ul>$err</ul>";
        }
        ?>
   <form method="post" class="box">
       <div class="header">
           <h4>Halaman Login</h4>
           <p>Masukkan username dan password anda</p>
       </div>
       <div class="login-area">
           <input type="text" value="<?php echo $username ?>" name="username" class="username" placeholder="Username">
           <input type="password" name="password" class="password" placeholder="Password">
           <input type="submit" name="login" value="Login" class="submit">
           <input type="submit" name="kembali" value="Kembali" class="submit">
       </div>
   </form> 
</body>
</html>
