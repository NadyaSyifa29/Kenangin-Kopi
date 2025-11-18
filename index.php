<?php
session_start();

// contoh role dan username
$_SESSION['role'] = "admin";
$_SESSION['username'] = "admin123";

// ambil tanggal saat ini
$currentDate = date('l, d F Y'); 
?>

<nav style="display: flex; justify-content: space-between; padding: 10px 20px; border: 1px solid #ccc; align-items:center;">
    
    <!-- Company Name -->
    <a href="index.php" style="font-weight: bold; text-decoration:none; color:#8B4513;">
        KenanginKopi
    </a>

    <!-- Current Date -->
    <span><?php echo $currentDate; ?></span>

    <!-- Right Side (Admin Options) -->
    <div style="display:flex; align-items:center; gap:10px;">

        <!-- Dropdown Manage -->
        <div class="dropdown">
            <button class="dropdown-toggle" type="button" onclick="toggleMenu()" style="
                padding:5px 10px; 
                background:#d7b892; 
                border:1px solid #000; 
                cursor:pointer;
            ">
                Manage ▼
            </button>

            <div id="menu" style="
                display:none;
                background:white; 
                border:1px solid #ccc; 
                position:absolute; 
                right:100px;
                margin-top:5px;">
                <a href="manage_user.php" style="display:block; padding:8px;">Manage User</a>
                <a href="manage_store.php" style="display:block; padding:8px;">Manage Store</a>
                <a href="manage_coffee.php" style="display:block; padding:8px;">Manage Coffee</a>
            </div>
        </div>

        <!-- Username -->
        <a href="profile.php" style="text-decoration:none; color:black;">
            <?php echo $_SESSION['username']; ?>
        </a>

        <!-- Logout -->
        <a href="logout.php" 
           style="padding:5px 10px; background:#d7b892; border:1px solid black; text-decoration:none;">
           Logout
        </a>
    </div>
</nav>

<script>
function toggleMenu() {
    const menu = document.getElementById("menu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}
</script>
