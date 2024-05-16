<?php require_once "controllerUserData.php"; ?>  <!-- Include the controller for user data handling. -->
<?php
if($_SESSION['info'] == false){  <!-- Check if there is no informational message in the session. -->
    header('Location: login-user.php');  <!-- Redirect to the login page if the informational message is not set. -->
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Set the character encoding for the HTML document. -->
    <title>Login</title>  <!-- Set the title of the page. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  <!-- Link to Bootstrap CSS for styling. -->
    <link rel="stylesheet" href="styles.css">  <!-- Link to an external stylesheet for custom styles. -->
</head>
<body>
    <div class="container">  <!-- Bootstrap container class for responsive layout. -->
        <div class="row">  <!-- Bootstrap row class for grid layout. -->
            <div class="col-md-4 offset-md-4 form login-form">  <!-- Center the form on the page using offset classes and apply a custom class for additional styling. -->
            <?php 
            if(isset($_SESSION['info'])){  <!-- Check if there is any informational message set in the session. -->
                ?>
                <div class="alert alert-success text-center">  <!-- Display informational message in a Bootstrap alert box, centered. -->
                <?php echo $_SESSION['info']; ?>  <!-- Echo the informational message. -->
                </div>
                <?php
            }
            ?>
                <form action="login-user.php" method="POST">  <!-- Form to handle user login. -->
                    <div class="form-group">  <!-- Form group for spacing and styling. -->
                        <input class="form-control button" type="submit" name="login-now" value="Login Now">  <!-- Submit button to send the form, styled with a Bootstrap class. -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>  <!-- Close the HTML document. -->
