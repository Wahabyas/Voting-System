<?php
// Get the current file name


require_once 'model/class_model.php';


$conn = new class_model();
session_start();
$me=$_SESSION['user_ids'];
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
        <li class="<?= $current_page == 'indexbase.php' ? 'active' : '' ?>">
            <a href="indexbase.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="<?= $current_page == 'Result.php' ? 'active' : '' ?>">
            <a href="Result.php">
            <i class='bx bxs-check-circle'></i>
                <span class="text">Data Result</span>
            </a>
        </li>
        <li class="<?= $current_page == 'Add-year.php' ? 'active' : '' ?>">
            <a href="Add-year.php">
                <i class='bx bxs-calendar-alt'></i>
                <span class="text">Year</span>
            </a>
        </li>
        <li class="<?= $current_page == 'analytics.php' ? 'active' : '' ?>">
            <a href="analytics.php">
                <i class='bx bxs-doughnut-chart'></i>
                <span class="text">Analytics</span>
            </a>
        </li>
        <li class="<?= $current_page == 'Candidate.php' ? 'active' : '' ?>">
            <a href="Candidate.php">
            <i class='bx bx-user'></i>
                <span class="text">Candidate</span>
            </a>
        </li>
        <li class="<?= $current_page == 'messages.php' ? 'active' : '' ?>">
            <a href="messages.php">
                <i class='bx bxs-message-dots'></i>
                <span class="text">Message</span>
            </a>
        </li>
        <li class="<?= $current_page == 'team.php' ? 'active' : '' ?>" <?= $role == 'User' ? 'hidden' : ''  ?>>
            <a href="team.php">
                <i class='bx bxs-group'></i>
                <span class="text">Team</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li class="<?= $current_page == 'Voucher.php' ? 'active' : '' ?>">
            <a href="Voucher.php">
                <i class='bx bx-refresh'></i>
                <span class="text">Generate Voter</span>
            </a>
        </li>
        <li>
            <a href="./controllers/logout.php" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>
