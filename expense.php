<?php require_once "controllerUserData.php"; ?>  <!-- Include the controller for user data handling. -->
<?php require_once "controllerIncomeExpenseData.php"; ?>  <!-- Include the controller for income and expense data handling. -->
<?php require "connection.php"; ?>  <!-- Include the database connection file. -->
<?php
$email = $_SESSION['email'];  <!-- Retrieve the email from the session. -->
$password = $_SESSION['password'];  <!-- Retrieve the password from the session. -->
if($email != false && $password != false){  <!-- Check if email and password are set in the session. -->
    $sql = "SELECT * FROM usertable WHERE email = '$email'";  <!-- SQL query to fetch user details based on the email. -->
    $run_Sql = mysqli_query($con, $sql);  <!-- Execute the SQL query. -->
    if($run_Sql){  <!-- Check if the query execution was successful. -->
        $fetch_info = mysqli_fetch_assoc($run_Sql);  <!-- Fetch the result as an associative array. -->
        $status = $fetch_info['status'];  <!-- Retrieve the user's status from the result. -->
        $code = $fetch_info['code'];  <!-- Retrieve the user's code from the result. -->
        if($status == "verified"){  <!-- Check if the user is verified. -->
            if($code != 0){  <!-- Check if the code is not zero. -->
                header('Location: reset-code.php');  <!-- Redirect to the reset code page. -->
            }
        }else{
            header('Location: user-otp.php');  <!-- Redirect to the user OTP page if not verified. -->
        }
    }
}else{
    header('Location: login-user.php');  <!-- Redirect to the login page if email or password is not set in the session. -->
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Set the character encoding for the HTML document. -->
    <title><?php echo $fetch_info['name'] ?> | Expense</title>  <!-- Set the title of the page to the user's name followed by "Expense". -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">  <!-- Link to Font Awesome CSS for icons. -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">  <!-- Link to DataTables CSS. -->
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">  <!-- Link to DataTables dateTime CSS. -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">  <!-- Link to DataTables buttons CSS. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  <!-- Link to Bootstrap CSS for styling. -->
    <style>
        .dataTables_length{  <!-- Custom styling for DataTables length selector. -->
            margin-left: 40px;  <!-- Left margin of 40px. -->
            margin-top: 5px;  <!-- Top margin of 5px. -->
        }
    </style>
</head>
<body>
    <?php include "nav.php"; ?>  <!-- Include the navigation bar. -->
    <br>
    <div class="container">  <!-- Bootstrap container class for responsive layout. -->
        <div class="row">  <!-- Bootstrap row class for grid layout. -->
            <p class="h3 mb-3">Your Expenses statistics</p>  <!-- Heading for the expenses statistics section. -->
            <div class="col-3">  <!-- Bootstrap column with width 3. -->
                <div class="card border-danger mb-3" style="max-width: 18rem;">  <!-- Bootstrap card with a red border and a maximum width. -->
                    <div class="card-header h6">This month's expense</div>  <!-- Card header with a title. -->
                    <div class="card-body text-danger">  <!-- Card body with red text. -->
                        <h5 class="card-title"><?php echo date('F Y'); ?></h5>  <!-- Display the current month and year as the card title. -->
                        <p class="card-text display-4 text-dark">  <!-- Display the expense amount as card text. -->
                            <?php
                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));  <!-- Calculate the first date of the current month. -->
                            $query = "SELECT sum(value) AS amount FROM expense WHERE email = '" . $_SESSION['email'] . "' AND date >= '" . $date_min . "';";  <!-- SQL query to sum the expenses for the current month. -->
                            
                            $res = mysqli_query($con, $query);  <!-- Execute the query. -->

                            if (!$res) {
                                die('Error executing query: ' . mysqli_error($con));  <!-- Display an error message if the query fails. -->
                            }
                            
                            if (mysqli_num_rows($res) > 0) {  <!-- Check if the query returned any results. -->
                                $amount = mysqli_fetch_array($res, MYSQLI_ASSOC);  <!-- Fetch the result as an associative array. -->
                                
                                if(isset($amount["amount"])) {  <!-- Check if the 'amount' column exists in the result set. -->
                                    echo "p" . $amount["amount"];  <!-- Display the amount. -->
                                } else {
                                    echo "P0";  <!-- Display 0 if there is no amount. -->
                                }
                            } else {
                                echo "No records found.";  <!-- Display a message if no records are found. -->
                            }
                            
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-3">  <!-- Bootstrap column with width 3. -->
                <div class="card border-primary mb-3" style="max-width: 18rem;">  <!-- Bootstrap card with a blue border and a maximum width. -->
                    <div class="card-header h6">Previous month's expense</div>  <!-- Card header with a title. -->
                    <div class="card-body text-primary">  <!-- Card body with blue text. -->
                        <h5 class="card-title"><?php echo date('F Y', mktime(0, 0, 0, date('m')-1, 1, date('Y')));?></h5>  <!-- Display the previous month and year as the card title. -->
                        <p class="card-text display-4 text-dark">  <!-- Display the expense amount as card text. -->
                            <?php
                            $date_min = date('Y-m-d', mktime(0, 0, 0, date('m')-1, 1, date('Y')));  <!-- Calculate the first date of the previous month. -->
                            $date_max = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));  <!-- Calculate the first date of the current month. -->
                            $query = "SELECT sum(value) AS amount FROM expense WHERE email = '" . $_SESSION['email'] . "' AND date >= '" . $date_min . "' AND date < '" . $date_max . "';";  <!-- SQL query to sum the expenses for the previous month. -->
                            $res = mysqli_query($con, $query);  <!-- Execute the query. -->
                            if (mysqli_num_rows($res) > 0) {  <!-- Check if the query returned any results. -->
                                $amount = mysqli_fetch_array($res);  <!-- Fetch the result as an array. -->
                                if($amount["amount"] != NULL)  <!-- Check if the amount is not null. -->
                                    echo "₹" . $amount["amount"];  <!-- Display the amount with a currency symbol. -->
                                else
                                    echo "₹0";  <!-- Display 0 if there is no amount. -->
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-3">  <!-- Bootstrap column with width 3. -->
                <div class="card border-info mb-3" style="max-width: 18rem;">  <!-- Bootstrap card with a blue border and a maximum width. -->
                    <div class="card-header h6">This year's expense</div>  <!-- Card header with a title. -->
                    <div class="card-body">  <!-- Card body. -->
                        <h5 class="card-title" style="color: #00acc1"><?php echo date("Y",strtotime("-1 year"));?> - <?php echo date('Y'); ?></h5>  <!-- Display the previous and current year as the card title. -->
                        <p class="card-text display-4 text-dark">  <!-- Display the expense amount as card text. -->
                            <?php
                            $date_min = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));  <!-- Calculate the first date of the current year. -->
                            $query = "SELECT sum(value) AS amount FROM expense WHERE email = '" . $_SESSION['email'] . "' AND date >= '" . $date_min . "';";  <!-- SQL query to sum the expenses for the current year. -->
                            $res = mysqli_query($con, $query);  <!-- Execute the query. -->
                            if (mysqli_num_rows($res) > 0) {  <!-- Check if the query returned any results. -->
                                $amount = mysqli_fetch_array($res);  <!-- Fetch the result as an array. -->
                                if($amount["amount"] != NULL)  <!-- Check if the amount is not null. -->
                                    echo "₹" . $amount["amount"];  <!-- Display the amount with a currency symbol. -->
                                else
                                    echo "₹0";  <!-- Display 0 if there is no amount. -->
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-3">  <!-- Bootstrap column with width 3. -->
                <div class="card border-warning mb-3" style="max-width: 18rem;">  <!-- Bootstrap card with an orange border and a maximum width. -->
                    <div class="card-header h6">% change from last year</div>  <!-- Card header with a title. -->
                    <div class="card-body">  <!-- Card body. -->
                        <h5 class="card-title" style="color: #e65100">Compared to <?php echo date("Y",strtotime("-1 year"));?></h5>  <!-- Display the previous year as the card title. -->
                        <p class="card-text display-4 text-dark">  <!-- Display the percentage change as card text. -->
                            <?php
                            $date_min = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')-1));  <!-- Calculate the first date of the previous year. -->
                            $date_max = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));  <!-- Calculate the first date of the current year. -->
                            $query1 = "SELECT sum(value) AS amount FROM expense WHERE email = '" . $_SESSION['email'] . "' AND date >= '" . $date_min . "' AND date < '" . $date_max . "';";  <!-- SQL query to sum the expenses for the previous year. -->
                            $query2 = "SELECT sum(value) AS amount FROM expense WHERE email = '" . $_SESSION['email'] . "' AND date >= '" . $date_max . "';";  <!-- SQL query to sum the expenses for the current year. -->
                            $res1 = mysqli_query($con, $query1);  <!-- Execute the first query. -->
                            $res2 = mysqli_query($con, $query2);  <!-- Execute the second query. -->
                            if (mysqli_num_rows($res1) > 0 && mysqli_num_rows($res2) > 0) {  <!-- Check if both queries returned any results. -->
                                $amount1 = mysqli_fetch_array($res1);  <!-- Fetch the result of the first query as an array. -->
                                $amount2 = mysqli_fetch_array($res2);  <!-- Fetch the result of the second query as an array. -->
                                if($amount1["amount"] == NULL) {  <!-- Check if the amount of the previous year is null. -->
                                    $amount1["amount"] = 0;  <!-- Set the amount to 0 if null. -->
                                    echo "-";  <!-- Display a dash if the amount is null. -->
                                }
                                else {
                                    if($amount2["amount"] == NULL)  <!-- Check if the amount of the current year is null. -->
                                        $amount2["amount"] = 0;  <!-- Set the amount to 0 if null. -->
                                    $perc = ($amount2["amount"] - $amount1["amount"]) / $amount1["amount"] * 100;  <!-- Calculate the percentage change. -->
                                    $perc = number_format((float)$perc, 2, '.', '');  <!-- Format the percentage to two decimal places. -->
                                    echo $perc . "%";  <!-- Display the percentage change. -->
                                }
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 mb-2">  <!-- Bootstrap row with top and bottom margin. -->
                <p class="h3">Graphical Analysis</p>  <!-- Heading for the graphical analysis section. -->
                <div class="col-6">  <!-- Bootstrap column with width 6. -->
                    <div class="card shadow bg-body rounded">  <!-- Bootstrap card with shadow and rounded background. -->
                        <div class="card-body">  <!-- Card body. -->
                            <canvas id="category" width="600" height="400"></canvas>  <!-- Canvas element for category chart. -->
                        </div>
                    </div>
                </div>
                <div class="col-6">  <!-- Bootstrap column with width 6. -->
                    <div class="card shadow bg-body rounded">  <!-- Bootstrap card with shadow and rounded background. -->
                        <div class="card-body">  <!-- Card body. -->
                            <canvas id="time" width="600" height="400"></canvas>  <!-- Canvas element for time chart. -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-5 pt-2">  <!-- Bootstrap column with width 12 and top margin and padding. -->
                <p class="h3">Expense records</p>  <!-- Heading for the expense records section. -->
                <div class="card shadow bg-body rounded" style="width: 100%">  <!-- Bootstrap card with shadow and rounded background with full width. -->
                    <div class="card-body">  <!-- Card body. -->
                        <table>  <!-- Table for filtering options. -->
                            <tbody>
                                <tr>
                                    <td class="pe-2">Minimum date:</td>  <!-- Table cell for minimum date label. -->
                                    <td><input type="text" id="min" name="min"></td>  <!-- Input field for minimum date. -->
                                </tr>
                                <tr>
                                    <td class="pe-2">Maximum date:</td>  <!-- Table cell for maximum date label. -->
                                    <td><input type="text" id="max" name="max"></td>  <!-- Input field for maximum date. -->
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <div class="table-responsive">  <!-- Responsive table wrapper. -->
                            <table id="example"
                                class="table table-bordered text-nowrap text-center table-striped align-middle pt-3">  <!-- DataTable with various Bootstrap classes. -->
                                <thead style="background-color: #f1f4fb">  <!-- Table header with background color. -->
                                    <tr>
                                        <th hidden>ID</th>  <!-- Hidden ID column. -->
                                        <th>Name</th>  <!-- Name column. -->
                                        <th>Category</th>  <!-- Category column. -->
                                        <th>Amount</th>  <!-- Amount column. -->
                                        <th>Date</th>  <!-- Date column. -->
                                        <th>
                                            <a href="#create" class="btn p-2" style="height: 2.5em; width: 2.5em; "
                                                data-bs-toggle="modal"><i class="fa fa-lg fa-plus-circle"
                                                    aria-hidden="true"></i></a>  <!-- Button to open the create expense modal. -->
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $expense_data = "SELECT * FROM expense where email = '" . $_SESSION['email'] . "';";  <!-- SQL query to fetch all expenses for the logged-in user. -->
                                    $res = mysqli_query($con, $expense_data);  <!-- Execute the query. -->
                                    if (mysqli_num_rows($res) > 0) {  <!-- Check if the query returned any results. -->
                                        while($row = mysqli_fetch_array($res)) {  <!-- Fetch each row as an array. -->
                                    ?>
                                            <tr>
                                                <td hidden><?php echo $row["id"]; ?></td>  <!-- Hidden ID cell. -->
                                                <td><?php echo $row["name"]; ?></td>  <!-- Name cell. -->
                                                <td><?php echo $row["category"]; ?></td>  <!-- Category cell. -->
                                                <td><?php echo $row["value"]; ?></td>  <!-- Amount cell. -->
                                                <td><?php echo $row["date"]; ?></td>  <!-- Date cell. -->
                                                <td>
                                                    <button type="submit" class="btn p-2 editBtn" style="height: 2.5em; width: 2.5em; "><i class="fa fa-lg fa-edit"></i></button>  <!-- Button to edit the expense. -->
                                                    <button type="submit" class="btn p-2 deleteBtn" style="height: 2.5em; width: 2.5em; "><i class="fa fa-lg fa-trash"></i></button>  <!-- Button to delete the expense. -->
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                      } else {
                                        echo "0 results";  <!-- Display a message if no records are found. -->
                                      }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->  <!-- Modal for adding a new expense record. -->
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="CreateLabel" aria-hidden="true">  <!-- Bootstrap modal. -->
        <div class="modal-dialog modal-dialog-centered" role="document">  <!-- Modal dialog centered. -->
            <div class="modal-content">  <!-- Modal content. -->
            <div class="modal-header">  <!-- Modal header. -->
                <h4 class="modal-title" id="CreateLabel">Add Expense Record</h4>  <!-- Modal title. -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  <!-- Close button. -->
            </div>
            <div class="modal-body">  <!-- Modal body. -->
                <div class="container">  <!-- Container for the form. -->
                    <form action="expense.php" method="POST" autocomplete="">  <!-- Form to add a new expense record. -->
                        <div class="form-group row mt-2">  <!-- Form group for name input. -->
                            <label for="name" class="col-3 col-form-label"><strong>Name</strong></label>  <!-- Label for name input. -->
                            <div class="col-9">
                                <input type="text" class="form-control" id="name-create" name="name" placeholder="Enter Name">  <!-- Name input field. -->
                            </div>
                        </div>
                        <div class="form-group row mt-2">  <!-- Form group for category input. -->
                            <label for="OnSale" class="col-3 col-form-label"><strong>Category</strong></label>  <!-- Label for category input. -->
                            <div class="col-9">
                                <select class="form-control" id="category-create" name="category" onclick="EnableTextBox(this)">  <!-- Dropdown for category selection. -->
                                    <?php
                                    $categories = "SELECT DISTINCT category FROM expense where email = '" . $_SESSION['email'] . "';";  <!-- SQL query to fetch distinct categories. -->
                                    $res = mysqli_query($con, $categories);  <!-- Execute the query. -->
                                    if (mysqli_num_rows($res) > 0) {  <!-- Check if the query returned any results. -->
                                        while($row = mysqli_fetch_array($res)) {  <!-- Fetch each row as an array. -->
                                    ?>
                                            <option><?php echo $row["category"] ?></option>  <!-- Display each category as an option. -->
                                    <?php
                                        }
                                    ?>
                                        <option>Other</option>  <!-- Option to create a new category. -->
                                    <?php
                                    } else {
                                    ?>
                                        <option>Create category</option>  <!-- Option to create a new category if no categories are found. -->
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mt-2">  <!-- Form group for new category input. -->
                            <label for="new-category" class="col-3 col-form-label"><strong>New Category</strong></label>  <!-- Label for new category input. -->
                            <div class="col-9">
                                <input type="text" class="form-control" id="new-category-create" name="new-category" placeholder="Create new category" disabled>  <!-- Input field for new category, disabled by default. -->
                            </div>
                        </div>
                        <div class="form-group row mt-2">  <!-- Form group for amount input. -->
                            <label for="amount" class="col-3 col-form-label"><strong>Amount</strong></label>  <!-- Label for amount input. -->
                            <div class="col-9">
                                <input type="int" class="form-control" id="amount-create" name="amount" placeholder="Enter Amount">  <!-- Amount input field. -->
                            </div>
                        </div>
                        <div class="form-group row mt-2 mb-3">  <!-- Form group for date input. -->
                            <label for="date" class="col-3 col-form-label"><strong>Date</strong></label>  <!-- Label for date input. -->
                            <div class="col-9">
                                <input type="date" class="form-control" id="date-create" name="date" placeholder="Enter Date">  <!-- Date input field. -->
                            </div>
                        </div>
                        <div class="form-group row d-flex">  <!-- Form group for submit and close buttons. -->
                            <button type="submit" name="add-expense" class="btn btn-primary" style="width: 70px">Save</button>  <!-- Save button. -->
                            <button type="button" class="btn btn-secondary ms-2" style="width: 70px" data-bs-dismiss="modal">Close</button>  <!-- Close button. -->
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>



   <!-- Edit Modal -->
<!-- Modal for editing expense records -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Modal title -->
                    <h4 class="modal-title" id="editLabel">Edit Expense Record</h4>
                    <!-- Close button for the modal -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <!-- Form for editing expense records -->
                        <form action="expense.php" method="POST" autocomplete="">
                            <!-- Hidden input field for storing data -->
                            <input hidden id="hiddenInput1" name="hiddenInput1" />
                            <!-- Form group for Name -->
                            <div class="form-group row mt-2">
                                <label for="name" class="col-3 col-form-label"><strong>Name</strong></label>
                                <div class="col-9">
                                    <!-- Input field for Name -->
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                </div>
                            </div>
                            <!-- Form group for Category -->
                            <div class="form-group row mt-2">
                                <label for="OnSale" class="col-3 col-form-label"><strong>Category</strong></label>
                                <div class="col-9">
                                    <!-- Dropdown for selecting Category -->
                                    <select class="form-control" id="category" name="category" onchange="EnableTextBox(this)">
                                        <!-- PHP code for fetching and displaying categories -->
                                    </select>
                                </div>
                            </div>
                            <!-- Form group for creating new Category -->
                            <div class="form-group row mt-2">
                                <label for="new-category" class="col-3 col-form-label"><strong>New Category</strong></label>
                                <div class="col-9">
                                    <!-- Input field for creating new Category -->
                                    <input type="text" class="form-control" id="new-category" name="new-category" placeholder="Create new category" disabled>
                                </div>
                            </div>
                            <!-- Form group for Amount -->
                            <div class="form-group row mt-2">
                                <label for="amount" class="col-3 col-form-label"><strong>Amount</strong></label>
                                <div class="col-9">
                                    <!-- Input field for Amount -->
                                    <input type="int" class="form-control" id="amount" name="amount" placeholder="Enter Amount">
                                </div>
                            </div>
                            <!-- Form group for Date -->
                            <div class="form-group row mt-2 mb-3">
                                <label for="date" class="col-3 col-form-label"><strong>Date</strong></label>
                                <div class="col-9">
                                    <!-- Input field for Date -->
                                    <input type="date" class="form-control" id="date" name="date" placeholder="Enter Date">
                                </div>
                            </div>
                            <!-- Buttons for saving and closing -->
                            <div class="form-group row d-flex">
                                <button type="submit" name="edit-expense" class="btn btn-primary" style="width: 70px">Save</button>
                                <button type="button" class="btn btn-secondary ms-2" style="width: 70px" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <!-- Modal for deleting expense records -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Modal title -->
                    <h4 class="modal-title" id="deleteLabel">Delete Record</h4>
                    <!-- Close button for the modal -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <!-- Confirmation message for deleting record -->
                        <h5>Are you sure you want to delete this record?</h5> <br>
                        <!-- Form for deleting record -->
                        <form action="expense.php" method="POST" autocomplete="">
                            <!-- Hidden input field for storing data -->
                            <div class="form-group row d-flex">
                                <input hidden id="hiddenInput2" name="hiddenInput2" />
                                <!-- Button for deleting record -->
                                <button type="submit" name="delete-expense" class="btn" style="width: 130px; background-color: #df4b4b; color: #ffffff">Delete Record</button>
                                <!-- Button for closing the modal -->
                                <button type="button" class="btn btn-secondary ms-2" style="width: 70px" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Js -->
    <!-- Importing Chart.js library for creating charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootsrap + JQuery -->
    <!-- Importing Bootstrap and JQuery libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script>
        //Script for delete expense
        $(document).ready(function() {
            // Functionality for delete button
            $(".deleteBtn").on("click", function() {
                // Show delete modal
                $("#delete").modal("show");
                // Retrieve data for the selected row
                $tr = $(this).closest("tr");
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
                // Set data for deletion
                $("#hiddenInput2").val(data[0]);
            })

        })

        //Script for edit expense
        $(document).ready(function() {
            // Functionality for edit button
            $(".editBtn").on("click", function() {
                // Show edit modal
                $("#edit").modal("show");
                // Retrieve data for the selected row
                $tr = $(this).closest("tr");
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
                // Set data for editing
                $("#hiddenInput1").val(data[0]);
                $("#name").val(data[1]);
                $("#category").val(data[2]).change()
                $("#amount").val(data[3]);
                $("#date").val(data[4]);
            })

        })
    </script>

    <script>
        // Function to enable/disable text box based on category selection
        function EnableTextBox(ddlModels) {
            var selectedValue = ddlModels.options[ddlModels.selectedIndex].value;
            var create_input = document.getElementById("new-category-create");
            var edit_input = document.getElementById("new-category");
            create_input.disabled = (selectedValue == "Other" || selectedValue == "Create category") ? false : true;
            edit_input.disabled = (selectedValue == "Other" || selectedValue == "Create category") ? false : true;
    }
    </script>

    <script>
        $(document).ready(function () {
            // Show bar graph on page load
            showBarGraph();
        });

        // Function to generate random colors
        function dynamicColors() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgba(" + r + "," + g + "," + b + ", 0.6)";
        }

        // Function to generate array of colors
        function generateColors(a) {
            var pool = [];
            for(i = 0; i < a; i++) {
                pool.push(dynamicColors());
            }
            return pool;
        }

        // Function to show bar graph
        function showBarGraph()
        {
            $.post("getExpenseBarGraphData.php",
            function (data)
            {
                var category = [];
                var value = [];
                for (var i in data) {
                    category.push(data[i].category);
                    value.push(data[i].value);
                }

                var colors = generateColors(category.length); 
                
                var chartdata = {
                    labels: category,
                    datasets: [
                        {
                            label: 'expense',
                            backgroundColor: colors,
                            borderColor: colors,
                            data: value
                        }
                    ]
                };
                var graphTarget = $("#category");
                var barGraph = new Chart(graphTarget, {
                    type: 'bar',
                    data: chartdata,
                    options: {
                        responsive: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Category wise expense distribution (1 year)',
                            },
                        },
                    }
                });
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            // Show line graph on page load
            showLineGraph();
        });

        // Function to show line graph
        function showLineGraph() 
        {
            $.post("getExpenseLineGraphData.php",
            function (data)
            {
                let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                let currentMonth = new Date().getMonth();
                console.log(data);
                console.log(currentMonth);
                var value = [];
                var label = [];
                var tempMonth = "";
                for(var i=0; i<7; i++) {
                    tempMonth = (currentMonth - i + 12 ) % 12;
                    label.push(months[tempMonth]);
                }
                label.reverse();
                for (var i in data) {
                    value.push(data[i].value);
                }
                var chartdata = {
                    labels: label,
                    datasets: [
                        {
                            label: 'expense',
                            backgroundColor: '#8e5ea2',
                            borderColor: '#8e5ea2',
                            hoverBackgroundColor: '#CCCCCC',
                            hoverBorderColor: '#666666',
                            data: value
                        }
                    ]
                };
                var graphTarget = $("#time");
                var lineGraph = new Chart(graphTarget, {
                    type: 'line',
                    data: chartdata,
                    options: {
                        responsive: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Expenses over time (7 months)',
                            },
                        },
                    }
                });
            });
        }
    </script>

    <!-- Datatables -->
    <!-- Importing DataTables library -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable with buttons
            $('#example').DataTable( {
                dom: 'Blfrtip',
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                iDisplayLength: -1,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>
    <script>
        var minDate, maxDate;
        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date( data[4] );

                if (
                    ( min === null && max === null ) ||
                    ( min === null && date <= max ) ||
                    ( min <= date   && max === null ) ||
                    ( min <= date   && date <= max )
                ) {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });
            // DataTables initialization
            var table = $('#example').DataTable();

            // Refilter the table
            $('#min, #max').on('change', function () {
                table.draw();
            });
        });
    </script>
</body>
</html>
