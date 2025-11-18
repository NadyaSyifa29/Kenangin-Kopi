<?php
session_start();
include "Utility/db.php";

$error_fullname = "";
$error_username = "";
$error_email = "";
$error_password = "";

$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $isValid = true;

    if ($fullname == "") {
        $error_fullname = "Full name cannot be empty!";
        $isValid = false;
    }

    if ($username == "") {
        $error_username = "Username cannot be empty!";
        $isValid = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = "Invalid email format!";
        $isValid = false;
    }


    if (strlen($password) < 5) {
        $error_password = "Password must be at least 5 characters!";
        $isValid = false;
    }


    if ($isValid) {
        $checkuser = $conn->prepare("select * from users where UserEmail = ?");
        $checkuser-> bind_param("s", $email);
        $checkuser-> execute();
        $dr = $checkuser->get_result();

        if($dr-> num_rows > 0){
            $error_email = "Email already existed";
            $isValid = false;
        }
        else{
            $result = $conn->query("select UserID from users order by UserID desc limit 1");
            if($result-> num_rows > 0){
                $rows = $result->fetch_assoc();
                $lastId = $rows['UserID'];
                $num = intval(substr($lastId,2));
                $num++;
            }
            else{
                $num = 1;
            }

            $newUserId = "US" . str_pad($num,3,"0", STR_PAD_LEFT);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $statement = $conn->prepare("insert into users(UserID, FullName, UserName, UserEmail, UserPassword, UserRole) values (?, ?, ?, ?, ?, 'User')");
            $statement->bind_param("sssss", $newUserId, $fullname, $username, $email, $hash);

            if ($statement-> execute()){
                $success = "Registration successful!";
                // header("Location: login.php");
                exit();
            }
            else{
                $error_email = "Registration failed";
            }
        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - KenanginKopi</title>
</head>
<body>
    <header class="navbar-guest">
        <a href="home_guest.php" class="logo">KenanginKopi</a>

     
        <div class="date">
            <?php echo date("l, d F Y"); ?>
        </div>

        <button>Logout</button>  
    </header>

    <main>
        <div class="form-bg">
            <div class="form-card">

                <form method="POST">
                    <h1>Register</h1>

                    <label>Full Name: </label><br>
                    <input type="text" name="fullname">
                    <div><?php echo $error_fullname; ?></div>

                    <br>

                    <label>Username: </label><br>
                    <input type="text" name="username">
                    <div><?php echo $error_username; ?></div>

                    <br>

                    <label>Email: </label><br>
                    <input type="email" name="email">
                    <div><?php echo $error_email; ?></div>

                    <br>

                    <label>Password: </label><br>
                    <input type="password" name="password">
                    <div><?php echo $error_password; ?></div>

                    <br>

                    <button type="submit" class="submit">Register</button>

                    <p>
                        Already have an account?
                        <a href="login.php">Login here</a>
                    </p>

                </form>

            </div>
        </div>
    </main>
</body>
</html>
