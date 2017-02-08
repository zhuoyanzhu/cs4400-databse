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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $project_name = $_POST['projectName'];
        $advisor = $_POST['advisor'];
        $email = $_POST['advisorEmail'];
        $description = $_POST['description'];
        $designation = $_POST['designation'];
        $category = $_POST['category'];
        $est_num = $_POST['estimate'];
		if(isset($_POST['majorreq']))
			$major_req = $_POST['majorreq'];
		else
			$major_req = '';
		if(isset($_POST['yearreq']))
			$year_req = $_POST['yearreq'];
		else
			$year_req = '';
		if(isset($_POST['depreq']))
			$dep_req = $_POST['depreq'];
		else
			$dep_req = '';
        if (validateInputs($project_name, $advisor, $email, $description, $designation, $category, $est_num) === FALSE) {
            $emptyInput = TRUE;
        } elseif ($est_num <= 0) {
            $numless = TRUE;
        } elseif (!insertNewProject($project_name, $description, $est_num, $advisor, $email, $designation)) {
            $alreadyexists = TRUE;
        } else {
			foreach ($_POST['category'] as $val) {
                insertNewProject_is_category($project_name, $val);
            }
            insertNewProject($project_name, $description, $est_num, $advisor, $email, $designation);
            if (isset($major_req)) {
                insertNewProjectReq($project_name, $major_req);
            }
            if (isset($year_req)) {
                insertNewProjectReq($project_name, $year_req);
            }
            if (isset($dep_req)) {
                insertNewProjectReq($project_name, $dep_req);
            }
            Redirect("./adminPage.php");
        }
    }
    function validateInputs($project_name, $advisor, $email, $description, $designation, $category, $est_num) {
        if (!isset($project_name) || !isset($advisor) || !isset($email) || !isset($description) || !isset($designation) || !isset($category) || !isset($est_num)) {
            return FALSE;
        }
        return TRUE;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add a Project</title>
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
            <h1 style="text-align:center;margin-bottom:40px;">Add a Project</h1>
            <?php
                if ($emptyInput === TRUE) {
                    echo '<p class="alert alert-danger" id="error">
                            <strong>Every Field is required.</strong></p>';
                } elseif ($alreadyexists === TRUE) {
                    echo '<p class="alert alert-danger" id="error">
                            <strong>This project already exists.</strong></p>';
                } elseif ($numless === TRUE) {
                    echo '<p class="alert alert-danger" id="error">
                            <strong>Estimated number should be greater than 0.</strong></p>';
                }
            ?>
            <form action="#" method="post">
                <div class="form-group">
                    <strong style="font-size:16px;">Project Name</strong>
                    <input type="text" class="form-control" name="projectName" placeholder="Project Name" style="display:inline;width:400px;margin-left:100px;" autofocus="autofocous"/>
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Advisor</strong>
                    <input type="text" class="form-control" name="advisor" placeholder="Advisor"  style="display:inline;width:400px;margin-left:148px;"/>
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Advisor email</strong>
                    <input type="email" class="form-control" name="advisorEmail" placeholder="Advisor Email"  style="display:inline;width:400px;margin-left:99px;"/>
                </div>
                <div class="form-group" style="display:inline-block;">
                    <strong style="font-size:16px;">Description</strong>
                    <textarea type="text" name="description" class="form-control" placeholder="Enter a short Description" style="width: 500px;height: 150px; resize: none;margin-left:211px; "></textarea>
                </div>
				<div class="form-group">
                    <strong style="font-size:16px; margin-right:130px;">Category</strong>
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
                    <strong style="font-size:16px;">Designation</strong>
                    <select name="designation" class="form-control" style="display: inline; width: 200px;margin-left:112px;">
                        <option selected="selected" disabled="disabled">None selected</option>
                        <?php
                            $desig = selectAllDesignation();
                            for($i = 0; $i < count($desig); $i++) {
                                echo '<option>' . $desig[$i]['name'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Estimated # of <br>Students</strong>
                    <input type="number" class="form-control" name="estimate" placeholder="Estimated #"  style="display:inline;width:400px;margin-left:136px;"/>
                </div>

                <div class="form-group">
                    <strong style="font-size:16px;">Major Requiremnet</strong>
                    <select name="majorreq" class="form-control" style="display: inline; width: 200px;margin-left:55px;">
                        <option selected="selected" disabled="disabled">No Requirement</option>
						<?php
							$major_requiremnet = selectMajor();
							for($i = 0; $i < count($major_requiremnet); $i++) {
								echo '<option>' . $major_requiremnet[$i]['name'] . '   sudents only</option>';
							}
						?>
                    </select>
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Year Requiremnet</strong>
                    <select name="yearreq" class="form-control" style="display: inline; width: 200px;margin-left:63px;">
                        <option selected="selected" disabled="disabled">No Requirement</option>
						<option value="freshman Students Only">freshman students only</option>
						<option value="sophmore Students Only">sophmore students only</option>
						<option value="junior Students Only">junior students only</option>
						<option value="senior Students Only">senior students only</option>
                    </select>
                </div>
                <div class="form-group">
                    <strong style="font-size:16px;">Department Requiremnet</strong>
                    <select name="depreq" class="form-control" style="display: inline; width: 200px;margin-left:3px;">
                        <option selected="selected" disabled="disabled">No Requirement</option>
						<?php
							$department = getDepartment();
							for($i = 0; $i < count($department); $i++) {
								echo '<option>' . $department[$i]['name'] . ' sudents only</option>';
							}
						?>
                    </select>
                </div>
                <input type="submit" name="button" class="btn btn-success btn-lg col-lg-2 col-lg-offset-8" value="Submit" style="margin-bottom:100px;">
            </form>
    </body>
</html>