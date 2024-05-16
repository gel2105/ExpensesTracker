<?php require_once "controllerUserData.php"; ?>  <!-- Include the controller for user data handling. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Set the character encoding for the HTML document. -->
    <title>Forgot Password</title>  <!-- Set the title of the page. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  <!-- Link to Bootstrap CSS for styling. -->
    <link rel="stylesheet" href="styles.css">  <!-- Link to an external stylesheet for custom styles. -->
</head>
<body>
    <div class="container">  <!-- Bootstrap container class for responsive layout. -->
        <div class="row">  <!-- Bootstrap row class for grid layout. -->
            <div class="col-md-4 offset-md-4 form">  <!-- Center the form on the page using offset classes. -->
                <form action="forgot-password.php" method="POST" autocomplete="">  <!-- Form to handle the forgot password request. -->
                    <h2 class="text-center">Forgot Password</h2>  <!-- Form heading, centered. -->
                    <p class="text-center">Enter your email address</p>  <!-- Instruction for the user, centered. -->
                    <?php
                        if(count($errors) > 0){  <!-- Check if there are any errors. -->
                            ?>
                            <div class="alert alert-danger text-center">  <!-- Display errors in a Bootstrap alert box, centered. -->
                                <?php 
                                    foreach($errors as $error){  <!-- Loop through each error and display it. -->
                                        echo $error;  <!-- Echo the error message. -->
                                    }
                                ?>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="form-group mt-4">  <!-- Form group with margin-top class for spacing. -->
                        <input class="form-control" type="email" name="email" placeholder="Enter email address" required value="<?php echo $email ?>">  <!-- Input field for email, required, with a placeholder. -->
                    </div>
                    <div class="form-group mt-4">  <!-- Form group with margin-top class for spacing. -->
                        <input class="form-control button" type="submit" name="check-email" value="Continue">  <!-- Submit button to send the form. -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>  <!-- Close the HTML document. -->
