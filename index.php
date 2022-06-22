<?php
    session_start();
    
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: Laptop_Catalog.php");
        exit;
    }
    
    require_once "config/config_sql.php";
    
    $username = $password = "";
    $username_err = $password_err = $login_err = "";
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty(trim($_POST["username"]))) {
            $username_err = "Username belum diinput.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        if(empty(trim($_POST["password"]))) {
            $password_err = "Password belum diinput.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        if(empty($username_err) && empty($password_err)) {
            $sql = "SELECT id, username, password FROM users WHERE username = ?";
            
            if($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                $param_username = $username;
                
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){           
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){
                                session_start();
                                
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;                            
                                
                                header("location: Laptop_Catalog.php");
                            } else{
                                $login_err = "Username atau Password salah.";
                            }
                        }
                    } else{
                        $login_err = "Username atau Password salah.";
                    }
                } else{
                    echo "Terjadi error, mohon dicoba kembali.";
                }

                mysqli_stmt_close($stmt);
            }
        }
        
        mysqli_close($link);
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>

</head>
<body>

    <div class="wrapper">
        <h2>Login</h2> <br>

        <?php 
            if(!empty($login_err)) {
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }   
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Masuk">
            </div>

            <p>Belum punya akun? <a href="auth/register.php">Daftar sekarang</a>.</p>
        </form>
    </div>

</body>
</html>