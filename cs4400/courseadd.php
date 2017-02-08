<?php session_start();
	if($_SESSION['usertype'] != 0) {
		header('Location: ' . $_SERVER["REQUEST_URI"] . '?notFound=1');
		exit;
}?>
<?php
    include "utils.php";
    include "db.php";
    $emptyInput = FALSE;
    $alreadyexists = FALSE;
    $numless = FALSE;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button'])) {
        $course_num = $_POST['courseNumber'];
        $course_name = $_POST['courseName'];
        $instructor = $_POST['instructor'];
        $designation = $_POST['designation'];
        $category = $_POST['category'];
        $est_num = $_POST['estimate'];
        if (validateInputs($course_num, $course_name, $instructor, $designation, $category, $est_num) === FALSE) {
            $emptyInput = TRUE;
        } elseif ($est_num <= 0) {
            $numless = TRUE;
        } elseif (!insertNewCourse($course_name, $course_num, $instructor, $est_num, $designation)) {
            $alreadyexists = TRUE;
        } else {
			foreach ($_POST['category'] as $val) {
                insertNewCourse_is_category($course_name, $val);
            }
            insertNewCourse($course_name, $course_num, $instructor, $est_num, $designation);
            Redirect("./adminPage.php");
        }
    }
    function validateInputs($course_num, $course_name, $instructor, $designation, $category, $est_num) {
        if (!isset($course_num) || !isset($course_name) || !isset($instructor) || !isset($designation) || !isset($category) || !isset($est_num)) {
            return FALSE;
        }
        return TRUE;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add a Course</title>
        <link rel="stylesheet" type="text/css" href="public/stylesheets/index.css">
        <link rel="stylesheet" type="text/css" href="public/stylesheets/font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Quicksand:700" rel="stylesheet" type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#multiselect').multiselect({
                    buttonWidth: '400px'
                });
            });
        </script>
    </head>
    <body>
        <header>
            <div class="nav">
                <ul>
                    <li><a href="./adminPage.php">Home</a></li>
                    <li><a href="./logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a></li>
                </ul>
            </div>
        </header>

        <div class="container" style="margin-top:80px;">
            <h1 style="text-align:center;margin-bottom:40px;">Add a Course</h1>
            <?php
                if ($emptyInput === TRUE) {
                    echo '<p class="alert alert-danger" id="error">
                            <strong>Every Field is required.</strong></p>';
                } elseif ($alreadyexists === TRUE) {
                    echo '<p class="alert alert-danger" id="error">
                            <strong>This course already exists.</strong></p>';
                } elseif ($numless === TRUE) {
                    echo '<p class="alert alert-danger" id="error">
                            <strong>Estimated number should be greater than 0.</strong></p>';
                }
            ?>
            <form method="POST">
                <div class="form-group">
                    <strong style="font-size:16px;">Course Number</strong>
                    <input type="text" class="form-control" name="courseNumber" placeholder="Course Number" style="display:inline;width:400px;margin-left:60px;" autofocus="autofocous" />
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Course Name</strong>
                    <input  type="text" class="form-control" name="courseName" placeholder="Course Name" style="display:inline;width:400px;margin-left:76px;"/>
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Instructor</strong>
                    <input type="text" class="form-control" name="instructor" placeholder="Instructor Name" style="display:inline;width:400px;margin-left:106px;" />
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Designation</strong>
                    <select name="designation" class="form-control" style="display: inline; width: 200px;margin-left:90px;">
                        <option selected="selected" disabled="disabled">-</option>
                        <?php
                            $desig = selectAllDesignation();
                            for($i = 0; $i < count($desig); $i++) {
                                echo '<option>' . $desig[$i]['name'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <strong style="font-size:16px; margin-right:106px;">Category</strong>
                    <select name="category[]" class="form-control" style="display: inline; width: 500px;" id="multiselect" multiple="multiple">
                        <?php
                            $categoy = selectAllCategory();
                            for($i = 0; $i < count($categoy); $i++) {
                                echo '<option>' . $categoy[$i]['name'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Estimated # of <br>Students</strong>
                    <input  type="number" class="form-control" name="estimate" placeholder="Estimated #"  min="1" style="display:inline;width:400px;margin:auto auto 20px 110px;"/>
                </div>
                <input type="submit" name="button" class="btn btn-success btn-lg col-lg-2 col-lg-offset-10" value="Submit">
            </form>
        </div>
    </body>
</html>