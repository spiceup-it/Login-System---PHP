<?php 

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //validate username
        if(empty($_POST['username'])){
            $username_err = "Please enter your username";
        }else{
            require_once './includes/config.php';

            $sql = "SELECT id FROM user WHERE username = ?";

                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "s", $param_username);

                    $param_username = $_POST["username"];

                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_store_result($stmt);

                        if(mysqli_stmt_num_rows($stmt) == 1){
                            $username_err = "This username is already taken";
                        }else{
                            $username = $_POST["username"];
                        }
                    }
                    else{
                        echo "Something went wrong. Please try again later.";
                    }
                }
                mysqli_stmt_close($stmt);
            }

        //validate password
         if(empty($_POST["password"])){
            $password_err = "Please enter your password";
        }elseif(strlen($_POST["password"]) < 6){
            $password_err = "Password must have atleast 6 characters";  
         } else{
            $password = $_POST["password"];
        }

        //validate confirm password
         if(empty($_POST["confirm_password"])){
            $confirm_password_err = "Please confirm your password";
        }else{
            $confirm_password = $_POST["confirm_password"];
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Passwords did not match";
            }
        }

        //set terms to false by default
        $termsAccepted = false;
        if(isset($_POST['terms_of_service'])){
            //if checkbox is checked
            $termsAccepted = true;
        }

        if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && $termsAccepted == true){
            
            require_once './includes/config.php';

            $sql = "INSERT INTO user(username, password)VALUES(?, ?)";

            if($stmt = $conn->prepare($sql)){
                $stmt->bind_param("ss",$param_username,$param_password);

                $param_username = $username;
                $param_password = password_hash($password,PASSWORD_DEFAULT);

                if($stmt->execute()){
                    header("location: login.php");
                }else{
                    echo "Something went wrong. Please try again later";
                }
            }
            $stmt->close();
        }
        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REGISTER</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body{ background-color: #59F4C0; }
        .wrapper{
            width: 550px;
            padding:100px 100px;
            margin-left: 30%;
        }
        .error{ color: red; }
    </style>
</head>
<body>
    <div class="wrapper">
    <h1 class="text-center">Sign Up</h1>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control">
                <span class="error">*<?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
                <span class="error">*<?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="error">*<?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="terms_of_service" value="Y">I accept the terms of service
                </label>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>