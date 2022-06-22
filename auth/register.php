<?php
    require_once "../config/config_sql.php";
    
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        if(empty(trim($_POST["username"]))){
            $username_err = "Username.";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
            $username_err = "Username hanya dapat menggunakan huruf, nomor atau garis bawah.";
        } else{
            $sql = "SELECT id FROM users WHERE username = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                $param_username = trim($_POST["username"]);
                
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $username_err = "Username telah digunakan.";
                    } else{
                        $username = trim($_POST["username"]);
                    }
                } else{
                    echo "Terjadi error, mohon dicoba kembali.";
                }

                mysqli_stmt_close($stmt);
            }
        }
        
        if(empty(trim($_POST["password"]))){
            $password_err = "Password.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Panjang minimum password adalah 6.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Confirm Password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password tidak cocok.";
            }
        }

        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
                
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                
                if(mysqli_stmt_execute($stmt)){
                    header("location: login.php");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Register</h2>
        <p>Isilah data dibawah ini untuk mendaftar.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Daftar">
                <input type="reset" class="btn btn-secondary ml-2" value="Ulangi">
            </div>
            
            <p>Sudah punya akun? <a href="login.php">Kembali ke login</a>.</p>
        </form>
    </div>    
</body>
</html>