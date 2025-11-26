<?php
// Get the current file name


require_once 'model/class_model.php';


$conn = new class_model();
session_start();
$me=$_SESSION['user_idx'];
$role = $conn->fetch_user($me);

foreach($role as $row){

    $role = $row['role'];
};
$current_page = basename($_SERVER['PHP_SELF']);
?>
<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-smile'></i>
        <span class="text">Voting System</span>
    </a>
    <ul class="side-menu top">
        <li class="<?= $current_page == 'voterdashboard.php' ? 'active' : '' ?>">
            <a href="indexbase.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
       
      
       
       
       
    </ul>
    <ul class="side-menu">
      
        <li>
            <a href="./controllers/logout.php" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>
