<?php
session_start();
require_once "config.php";
if (!isset($_SESSION['admin_username'])) {
    header("location:index.php");
}
?>
<?php
require_once "config.php";
$sesi = $_SESSION["admin_username"];
$ino = $connection->query("SELECT nama_user from user where username='$sesi'");
$getname = $ino->fetch_assoc()["nama_user"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- start: Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- start: Icons -->
    <!-- start: CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- end: CSS -->
    <title>SI Beasiswa</title>
</head>

<body>
    <?php include "content.php"; ?>


    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <!-- start: Navbar -->
            <nav class="px-3 py-2 bg-white rounded shadow-sm">
                <i class="ri-menu-line sidebar-toggle me-3 d-block d-md-none"></i>
                <h5 class="font-weight-normal mb-0 me-auto">Sistem Informasi Pengelolaan & Penerimaan Beasiswa</h5>
                <div class="dropdown">
                    <div class="d-flex align-items-center cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2 d-none d-sm-block"><?= $getname; ?></span>
                        <img class="navbar-profile-image" src="https://live.staticflickr.com/65535/52976237801_f8c718a681_n.jpg" alt="Image">
                    </div>
                </div>
            </nav>
            <!-- end: Navbar -->
            <!-- start: Content -->
            <div class="py-4">
                <!-- start: Summary -->
                <div class="row">
                    <div class="col-md-12">
                        <?php include page($_PAGE); ?>
                    </div>
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
    <!-- end: JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>


</body>

</html>