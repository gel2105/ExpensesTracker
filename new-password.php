<?php require_once "controllerUserData.php"; ?>  <!-- Include the controller for user data handling. -->
<?php 
$email = $_SESSION['email'];  <!-- Retrieve the email from the session. -->
if($email == false){  <!-- Check if the email is not set in the session. -->
  header('Location: login-user.php');  <!-- Redirect to login page if email is not set. -->
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Set the character encoding for the HTML document. -->
    <title>Create a New Password</title>  <!-- Set the title of the page. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  <!-- Link to Bootstrap CSS for styling. -->
    <link rel="stylesheet" href="styles.css">  <!-- Link to an external stylesheet for custom styles. -->
</head>
<body>
    <div class="container">  <!-- Bootstrap container class for responsive layout. -->
        <div class="row">  <!-- Bootstrap row class for grid layout. -->
            <div class="col-md-4 offset-md-4 form">  <!-- Center the form on the page using offset classes. -->
                <form action="new-password.php" method="POST" autocomplete="off">  <!-- Form to handle new password creation. -->
                    <h2 class="text-center">Change Password</h2>  <!-- Form heading, centered. -->
                    <?php 
                    if(isset($_SESSION['info'])){  <!-- Check if there is any informational message set in the session. -->
                        ?>
                        <div class="alert alert-success text-center">  <!-- Display informational message in a Bootstrap alert box, centered. -->
                            <?php echo $_SESSION['info']; ?>  <!-- Echo the informational message. -->
                        </div>
                        <?php
                    }
                    ?>
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
                    <div class="form-group">  <!-- Form group for spacing and styling. -->
                        <input class="form-control" type="password" name="password" placeholder="Create new password" required>  <!-- Input field for new password, required, with a placeholder. -->
                    </div>
                    <div class="form-group mt-3">  <!-- Form group with margin-top class for spacing. -->
                        <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password" required>  <!-- Input field for confirming new password, required, with a placeholder. -->
                    </div>
                    <div class="form-group mt-3">  <!-- Form group with margin-top class for spacing. -->
                        <input class="form-control button" type="submit" name="change-password" value="Change">  <!-- Submit button to send the form. -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>  <!-- Close the HTML document. -->
