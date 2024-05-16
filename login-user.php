<?php require_once "controllerUserData.php"; ?>  <!-- Include the controller for user data handling. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Set the character encoding for the HTML document. -->
    <title>Login</title>  <!-- Set the title of the page. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  <!-- Link to Bootstrap CSS for styling. -->
    <link rel="stylesheet" href="styles.css">  <!-- Link to an external stylesheet for custom styles. -->
</head>
<body>
    <div class="card">  <!-- Bootstrap card component for a bordered box layout. -->
        <div class="card-header">  <!-- Card header section for the title. -->
            <h1>Expenses Tracker</h1>  <!-- Main title of the application. -->
        </div>
        <div class="card-body">  <!-- Card body section for the form. -->
            <form action="login-user.php" method="POST" autocomplete="">  <!-- Form to handle user login. -->
                <h2 class="text-center">Login</h2>  <!-- Form heading, centered. -->
                <p class="text-center">Login with your email and password.</p>  <!-- Instruction for the user, centered. -->
                <?php
                if(count($errors) > 0){  <!-- Check if there are any errors. -->
                    ?>
                    <div class="alert alert-danger text-center">  <!-- Display errors in a Bootstrap alert box, centered. -->
                        <?php
                        foreach($errors as $showerror){  <!-- Loop through each error and display it. -->
                            echo $showerror;  <!-- Echo the error message. -->
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group mt-3">  <!-- Form group with margin-top class for spacing. -->
                    <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">  <!-- Input field for email, required, with a placeholder. -->
                </div>
                <div class="form-group mt-3">  <!-- Form group with margin-top class for spacing. -->
                    <input class="form-control" type="password" name="password" placeholder="Password" required>  <!-- Input field for password, required, with a placeholder. -->
                </div>
                <div class="link forget-pass text-left mt-2"><a href="forgot-password.php">Forgot password?</a></div>  <!-- Link to the forgot password page. -->
                <div class="form-group mt-3">  <!-- Form group with margin-top class for spacing. -->
                    <input class="btn-login" type="submit" name="login" value="Login">  <!-- Submit button to send the form. -->
                </div>
                <div class="link login-link text-center mt-1">Don't have an account? <a href="signup-user.php">Signup now</a></div>  <!-- Link to the signup page. -->
            </form>
        </div>
    </div>
</body>
</html>  <!-- Close the HTML document. -->
