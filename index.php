<?php
require_once "config.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
session_start();
if (isset($_SESSION['admin_username'])) {
    header("location:logged.php");
}
$username = "";
$password = "";
$err = false;
if (isset($_POST['login'])) {
    require_once "config.php";
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    if ($username == '' or $password == '') {
        $err = true;
    }
    if (empty($err)) {
        $sql1 = "select * from user where username = '$username'";
        $q1 = mysqli_query($connection, $sql1);
        $r1 = mysqli_fetch_array($q1);
        if (mysqli_num_rows($q1) === 0) {
            if (isset($r1['password']) != md5($password)) {
                $err = true;
            }
        }
    }
    if (empty($err)) {
        $login_id = $r1['id_akses'];
        $sql2 = "select * from akses_halaman where id_akses = '$login_id'";
        $q2 = mysqli_query($connection, $sql2);
        while ($r2 = mysqli_fetch_array($q2)) {
            $akses[] = $r2['halaman_akses'];
        }
        if (empty($akses)) {
            $err = true;
        }
    }
    if (empty($err)) {
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_akses'] = $akses;
        header("location:logged.php");
        exit();
    }
    if ($err) {
        $message = 'swal(
            "Akun tidak ditemukan",
    "Maaf",
    "error"
          ).then(function() {
            window.location = "index.php";
        });';
        echo "<script type='text/javascript'>$message</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- start: Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aladin&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- start: Icons -->
    <!-- start: CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="modal.css">
    <!-- end: CSS -->
    <title>SI Beasiswa</title>
</head>

<body>

    <!-- start: Sidebar -->
    <div class="sidebar position-fixed top-0 bottom-0 bg-white border-end">
        <div class="d-flex align-items-center p-3">
            <a href="#" class="sidebar-logo text-uppercase fw-bold text-decoration-none text-indigo fs-4">SIBEA</a>
            <i class="sidebar-toggle ri-arrow-left-circle-line ms-auto fs-5 d-none d-md-block"></i>
        </div>
        <ul class="sidebar-menu p-3 m-0 mb-0">
            <li class="sidebar-menu-item active">
                <a href="?page=pengumuman">
                    <i class="ri-home-5-line sidebar-menu-item-icon"></i>
                    Informasi Umum
                </a>
            </li>
            <li class="sidebar-menu-item has-dropdown">
                <a href="#">
                    <i class="ri-book-3-line sidebar-menu-item-icon"></i>
                    Daftar Beasiswa
                    <i class="ri-arrow-down-s-line sidebar-menu-item-accordion ms-auto"></i>
                </a>
                <ul class="sidebar-dropdown-menu">
                    <?php $query = $connection->query("SELECT * FROM beasiswa");
                    while ($row = $query->fetch_assoc()) : ?>
                        <li><a href="?page=pengumuman_bsw&beasiswa=<?= $row["kd_beasiswa"] ?>"><?= $row["nama"] ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </li>
            <li class="sidebar-menu-item">
                <a href="#staticBackdrop" data-toggle="modal" data-target="#staticBackdrop">
                    <i class="ri-door-open-line sidebar-menu-item-icon"></i>
                    Login
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
    <!-- end: Sidebar -->

    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <!-- start: Navbar -->
            <nav class="px-3 py-2 bg-white rounded shadow-sm">
                <i class="ri-menu-line sidebar-toggle me-3 d-block d-md-none"></i>
                <h5 class="font-weight-normal mb-0 me-auto">Sistem Informasi Pengelolaan & Penerimaan Beasiswa</h5>
            </nav>
            <!-- end: Navbar -->

            <div class="row">
                <div class="col-md-12">
                    <?php include page($_PAGE); ?>
                </div>
            </div>

            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: 6610F2;" id="staticBackdropLabel">
                                <b>Login SiBea</b>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post">
                                <label>
                                    <i class="fas fa-user"></i>
                                    Username
                                </label>
                                <div>
                                    <input type="text" placeholder="Username" name="username" required />
                                </div>

                                <label>
                                    <i class="fas fa-key"></i>
                                    Password
                                </label>
                                <div>
                                    <input type="password" placeholder="Password" name="password" required />
                                </div>

                                <div>
                                    <button style="background-color: 6610F2; color:aliceblue;" class="btn" type="submit" name="login">
                                        <i class="fas fa-lock"></i>
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><br>
            </div>

        </div>
        <!-- end: Content -->
        </div>
    </main>
    <!-- end: Main -->

    <!-- start: JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>

    <!-- end: JS -->
</body>

</html>