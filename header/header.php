<nav>

<?php 
require_once 'model/class_model.php';


if (($_SESSION['user_ids']===null)) {
    header("Location: index.php");
    exit();
}
		$me=$_SESSION['user_ids'];
        $conn = new class_model();
        $role = $conn->fetch_user($me);
        foreach($role as $row){

            $profile_picture = $row['profile_picture'];
            $role = $row['role'];

        };
        
?>

<script src="js/jquery.min.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link"><?php echo  $role;  ?></a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			
             <div class="dropdown-menu1" id="dropdown-menu1">
        <a href="#" style="color: #333;">Profile</a>
        <a href="#" style="color: #333;">Settings</a>
        <a href="logout.php" style="color: #333;">Log Out</a>
    </div>
			<div class="profile-dropdown">
            <a href="#" class="profile">
				<img src="uploads/profile_pictures/<?php echo  $profile_picture ?>" alt="Profile" id="profile-menu">
			</a>
    
    <div class="dropdown-menu" id="dropdown-menu">
      
        <a href="./controllers/logout.php" style="color: #333;">Log Out</a>
    </div>
</div>
		</nav>
		<style>
             #searchResults {
        display: none;
        position: absolute;
        background-color: white;
        border: 1px solid #ddd;
        max-height: 200px;
        overflow-y: auto;
        width: 100%;
        z-index: 1000;
    }
    #searchResults a {
        display: block;
        padding: 8px;
        text-decoration: none;
        color: #333;
    }
    #searchResults a:hover {
        background-color: #007bff;
        color: white;
    }
    .profile-dropdown {
		width: 36px;
	height: 36px;
	object-fit: cover;
	border-radius: 50%;
        position: relative;
        display: inline-block;
    }
    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        padding: 10px;
        z-index: 1000;
    }
    .dropdown-menu a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: #333;
    }
    .dropdown-menu a:hover {
        background-color: #007bff;
        color: white;
    }
    .dropdown-menu1 {
        display: none;
        position: absolute;
        margin-top: 180px;
        right: 20px;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        padding: 10px;
        z-index: 1000;
    }
    .dropdown-menu1 a {
        display: block;
        padding: 10px;
        text-decoration: none;
        color: #333;
    }
    .dropdown-menu1 a:hover {
        background-color: #007bff;
        color: white;
    }
</style>

<script>
 
    document.getElementById("profile-menu").addEventListener("click", function () {
        const dropdown = document.getElementById("dropdown-menu");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    });
    document.getElementById("profile-menu1").addEventListener("click", function () {
        const dropdown = document.getElementById("dropdown-menu1");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    });
</script>
