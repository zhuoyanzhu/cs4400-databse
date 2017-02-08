<?php
	session_start();
	if($_SESSION['usertype'] != 1) {
		header('Location: ' . $_SERVER["REQUEST_URI"] . '?notFound=1');
		exit;
	}
	$_POST['projectname'] = '';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SLS</title>
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
                    buttonWidth: '300px'
                });
            });
        </script>
    </head>
    <body>
        <header>
            <div class="nav">
                <ul>
			<li><a href="UserPage.php">Home</a></li>
                    	<li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['user']['name']; ?> <i class="fa fa-caret-down fa-lg" aria-hidden="true"></i></a>
                        	<ul>
                            	<li><a href="profile.php"><i class="fa fa-pencil fa-fw"></i> Profile</a></li>
                            	<li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a></li>
                        	</ul>
                    	</li>
                </ul>
            </div>
        </header>

        <div class="container">
            <div class="mainpage">
                <h1 style="text-align:center;padding:10px;">Main Page</h1>
                <div class="searchfilter" style="margin: 0 auto 30px 0px;">
				  <form method="post">
                    <div class="form-group">
                        <strong style="font-size:16px;">Title</strong>
                        <input type="text" class="form-control" name="search" placeholder="Search" style="display:inline;width:450px;margin:0 70px 0 75px;"/>
						<strong style="font-size:16px; margin-left:20px; margin-right:15px;">Category</strong>
                        <select name="category[]" class="form-control" style="display: inline; width: 400px;" id="multiselect" multiple="multiple">
                            <?php
                              include 'db.php';
                              // fetch data
                              $categories = selectAllCategory();
                              for($i = 0; $i < count($categories); $i++) {
                                echo "<option>"
                                  . $categories[$i]['name']
                                  . "</option> ";
                              }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong style="font-size:16px;">Designation</strong>
                        <select name="designation" class="form-control" style="display: inline; width: 200px;margin-left:15px;">
                            <option selected="selected" disabled="disabled">-</option>
                            <?php
                              // fetch data
                              $designations = selectAllDesignation();
                              for($i = 0; $i < count($designations); $i++) {
                                echo "<option>"
                                  . $designations[$i]['name']
                                  . "</option> ";
                              }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong style="font-size:16px;">Major</strong>
                        <select name="major" class="form-control" style="display: inline; width: 200px;margin-left:65px;">
                            <option selected="selected" disabled="disabled">-</option>
                            <?php
                              // fetch data
                              $majors = selectMajor();
                              for($i = 0; $i < count($majors); $i++) {
                                echo "<option>"
                                  . $majors[$i]['name']
                                  . "</option> ";
                              }
                            ?>
                        </select>
                    </div>
                    <div class="form-inline" style="margin-bottom:30px">
                        <strong style="font-size:16px;">Year</strong>
                        <select name="year" class="form-control" style="display: inline; width: 200px;margin-left:72px;margin-right:40%;">
                            <option selected="selected" disabled="disabled">-</option>
                            <option>freshman</option>
                            <option>sophomore</option>
                            <option>junior</option>
                            <option>senior</option>
                        </select>

			<div class="radio">
				<input type="radio" name="optradio[<?php echo $i; ?>]" value="Project">
				<label for="one">Project</label>
				<input type="radio" name="optradio[<?php echo $i; ?>]" value="Course" style="margin-left:10px;">
				<label for="one">Course</label>
				<input type="radio" name="optradio[<?php echo $i; ?>]" value="Both" style="margin-left:10px;">
				<label for="one">Both</label>
			</div>
                    </div>
                    <div class="col-md-offset-8 col-md-2">
                        <button type="submit" name="apply" class="btn btn-primary btn-md">
                            Apply Filter
                        </button>
                    </div>
                    <button type="submit" name="button" class="btn btn-primary btn-md" data-toggle="modal" data-dismiss="modal" data-target="#myModalone">
							Reset Filter
                    </button>
				  </form>
                </div>


                <hr class="bar">


                <table class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							if ($_SERVER['REQUEST_METHOD'] === 'POST') {
								if(isset($_POST['apply'])) {
									if(!isset($_POST["search"]))
										$title = "";
									else
										$title = $_POST["search"];
									if(!isset($_POST["category"]))
										$category_array = array();
									else{
										$category_array = $_POST["category"];
									}
									if(!isset($_POST["designation"]))
										$designation = "";
									else{
										$designation = $_POST["designation"];
									}
									if(!isset($_POST["major"]))
										$major = "";
									else{
										$major = $_POST["major"];
									}
									if(!isset($_POST["year"]))
										$year = "";
									else{
										$year = $_POST["year"];
									}
									if(!isset($_POST["optradio"]))
										$select = "";
									else{
										$se = $_POST["optradio"];
										$select = $se[35];
									}
									$projects = NULL;
									$courses = NULL;
									if($select != "")
									{
										if($select == "Project")
										{
											$projects = selectProjectBy($title, $designation, $category_array, $major, $year);
											for($i = 0; $i < count($projects); $i++) {
												echo '<tr data-toggle="modal" style="cursor:pointer;" data-target="#projectModal' .$i. '">'
													. '<td>'. $projects[$i]["name"]. '</td>'
													. "<td>Project</td></tr>";
											}
										}
										else if($select == "Course")
										{
											$courses = selectCourseBy($title, $designation, $category_array);
											for($i = 0; $i < count($courses); $i++) {
												echo '<tr data-toggle="modal" style="cursor:pointer;" data-target="#courseModal' .$i. '">'
													. '<td>'. $courses[$i]["name"]. '</td>'
													. "<td>Course</td></tr>";
											}
										}
										else if($select == "Both")
										{
											$projects = selectProjectBy($title, $designation, $category_array, $major, $year);
											for($i = 0; $i < count($projects); $i++) {
												echo '<tr data-toggle="modal" style="cursor:pointer;" data-target="#projectModal' .$i. '">'
													. '<td>'. $projects[$i]["name"]. '</td>'
													. "<td>Project</td></tr>";
											}
											$courses = selectCourseBy($title, $designation, $category_array);
											for($i = 0; $i < count($courses); $i++) {
												echo '<tr data-toggle="modal" style="cursor:pointer;" data-target="#courseModal' .$i. '">'
													. '<td>'. $courses[$i]["name"]. '</td>'
													. "<td>Course</td></tr>";
											}
										}
									}
						?>
                    </tbody>
                </table>
            </div>
        </div>
		<?php if($courses != null) {
			for($i = 0; $i < count($courses); $i++) {
		?>
		    <div class="modal fade" id="courseModal<?php echo $i ?>"> tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                          </button>
                          <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong><?php echo $courses[$i]["name"];?></strong>
                          </h2>
                      </div>
                      <div class="modal-body" style="font-size:16px;">
                          <p><strong>Course Name: </strong> <?php echo $courses[$i]["name"];?></p>
                          <p><strong>Instructor: </strong> <?php echo $courses[$i]["instructor"];?></p>
                          <p><strong>Designation: </strong><?php echo $courses[$i]["designation_name"];?></p>
                          <p><strong>Category: </strong><?php
								$categories = getCourseCategory($courses[$i]["name"]);
									for($j = 0; $j < count($categories); $j++)
										echo $categories[$j]["category_name"] . ",";
							  ?></p>
                          <p><strong>Estimated # of students: </strong><?php echo $courses[$i]["est_num"];?></p>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" data-dismiss="modal" name="button" class="btn btn-danger btn-lg col-lg-4 col-lg-offset-4">
                              Cancel
                          </button>
                      </div>
                  </div>
              </div>
          </div>
		<?php }
			}?>
		<?php if($projects != null) {
			for($i = 0; $i < count($projects); $i++) {
		?>
        <div class="modal fade" id="projectModal<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                          </button>
                          <h2 class="modal-title" id="myModalLabel" style="text-align:center;">
							<strong><?php echo $projects[$i]["name"];?></strong>
                          </h2>
                      </div>
                      <div class="modal-body" style="font-size:16px;">
                          <form method="post" action="apply.php">
                              <p><strong>Advisor: </strong><?php echo $projects[$i]["adivisor_name"] . "(" . $projects[$i]["adivisor_email"] . ")"; ?></p>
                              <p><strong>Description: </strong><?php echo $projects[$i]["description"];?></p>
                              <p><strong>Designation: </strong><?php echo $projects[$i]["designation_name"];?></p>
                              <p><strong>Category: </strong><?php
								$categories = getProjectCategory($projects[$i]["name"]);
									for($j = 0; $j < count($categories); $j++)
										echo $categories[$j]["category_name"] . ",";
							  ?></p>
							  <?php echo '<input type="hidden" name="projectname" value="'. $projects[$i]["name"] . '"/>';?>
							  <?php echo '<input type="hidden" name="name" value="'. $_SESSION['user']['name'] . '"/>';?>
                              <p><strong>Requirements: </strong><?php $requirements = getRequirement($projects[$i]["name"]); 
							  for($k=0; $k < count($requirements); $k++) 
								  echo $requirements[$k]["requirement"]. ",";?></p>
                              <p><strong>Estimated # of students: </strong><?php echo $projects[$i]["est_num"];?></p>
							  <div class="modal-footer">
								  <button type="submit" data-dismiss="modal" name="button" class="btn btn-danger btn-lg col-lg-offset-2">
									  Cancel
								  </button>
								  <button type="submit" name="select" class="btn btn-success btn-lg">
									  Apply
								  </button>
							  </div>
						  </form>
                      </div>
                  </div>
              </div>
          </div>
		  <?php 	}
				}
			}
		}?>

    </body>
</html>