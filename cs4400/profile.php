<?php
	session_start();
	ob_start();
	if($_SESSION['usertype'] != 1) {
		header('Location: ' . $_SERVER["REQUEST_URI"] . '?notFound=1');
		exit;
	}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SLS</title>
        <link rel="stylesheet" type="text/css" href="public/stylesheets/profile.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Josefin+Slab:400,600' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
    </head>
    <body>
      <header>
          <h1 class="bigwelcome"><span>Me</span></h1>        
          <div class="buttons" style="text-align:center;">  	  
                  <div class="buttonone">
                      <button type="submit" name="edit" data-toggle="modal" data-target="#myModalone">Edit Profile</button>
                  </div>
                  <div class="buttonone">
                      <button type="submit" name="apply" data-toggle="modal" data-target="#myModaltwo">My Application
                      </button>
                  </div> 
                  <div class="buttonone">
                      <button name="back" onclick="window.location = 'userPage.php';">Back
                      </button>
                  </div> 				  
          </div>
      </header>

      <!--Edit Profile Modal-->
      <div class="modal fade" id="myModalone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong>Edit Profile</strong>
                        </h2>
                    </div>
                    <div class="modal-body">    
                      <div class="row">
                        <div class="col-sm-6">
                          Major
                        </div>
                        <div class="col-sm-3">
                          Year
                        </div>
                        <div class="col-sm-3">
                          Department
                        </div>
                      </div>
					  <form method="post" action="#">
						<div class="row">
							<?php
								include "db.php";
								if(isset($_SESSION['user'])) {
									$name = $_SESSION['user'];
									$res = getMajorFromUser($name["name"]);
									$major = $res[0]["major"];
									$res1 = getYearFromUser($name["name"]);
									$year = $res1[0]["year"];
									$department = getDepartmentByMajor($major);
									$majors = selectMajor();
									echo '<div class="col-sm-6">';
									echo '<select class="selectpicker" name="major">';
									if($major != NULL){
										echo "<option> " . $major . " </option>";
									}
									for($i = 0; $i < count($majors); $i++) {
										if($majors[$i]['name'] != $major)
											echo "<option>" . $majors[$i]['name'] . "</option>";
									}
									echo "</select>";
									echo "</div>";           
									echo '<div class="col-sm-3">'
									. '<select class="selectpicker" name="year">';
									echo "<option>" . $year . "</option>";
									$year_Array = array("freshman", "sophomore", "junior", "senior");
									foreach($year_Array as $val)
									{
										if($val != $year)
											echo "<option>" . $val . "</option>";
									}
									echo "</select>"            
									. "</div>";
									echo '<div class="col-sm-3">'
										. $department[0]['dept_name']
										. "</div>";
								}
							?>
						</div>
                        <div class="modal-body" id = "backbutt">
                                <button type="button" name="button" class="btn btn-success btn-lg" data-dismiss="modal" >
                                    Back
                                </button>
								<div class='col-md-2'></div>
                                <button type="submit" name="change" class="btn btn-success btn-lg">
                                    Change
                                </button>
                        </div>
					  </form>
                    </div>
                </div>
            </div>
        </div>

        <!--My Application Modal-->
        <div class="modal fade" id="myModaltwo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                          </button>
                          <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong>My Application</strong>
                          </h2>
                      </div>
                      <div class="modal-body">
                          <!-- <p class="alert alert-danger" id="error">
                              <strong>Username or password does not match any existing entry. Please try again.</strong>
                          </p> -->
                           <div class="panel panel-default">
                            <table class="table table-condensed" >
                                <thead>
                                    <tr>
                                        <th class='col-md-3 app-date'>Date</th>
                                        <th class='col-md-3' style='text-align:center'>Project Name</th>
                                        <th class='col-md-3'style='text-align:center'>Status</th>
                                    </tr>
                                </thead>
                            </table>

                        <div class="div-table-content">
                            <table class="table table-condensed">
                                <tbody>
									<?php
										if(isset($_SESSION['user'])) {
											$re = $_SESSION['user'];
											$name = $re['name'];
											$res = selectApplication($name);
											for($i = 0; $i < count($res); $i++) {
												echo "<tr>";
												echo "<td style='text-align:right'>" . $res[$i]["date"] . "</td>";
												echo "<td style='text-align:center'>" . $res[$i]["project_name"] . "</td>";
												echo "<td>" . $res[$i]["status"] . "</td>";
												echo "</tr>";
											}
										}
									?>
                                </tbody>
                            </table>
                        </div>
                      </div>
                      <div class="col-md-offset-0">
                                <button type="submit" name="button" class="btn btn-success btn-lg" data-dismiss="modal">
                                    Back
                                </button>
                            </div>
                  </div>
              </div>
          </div>
		  </div>
			<?php
				$name = $_SESSION['user'];
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					if(isset($_POST['change'])) {
						$major = $_POST['major'];
						$year = $_POST['year'];
						print_r($year);
						updateTableUserMajor($name["name"], $major);
						updateTableUserYear($name["name"], $year);
						header("Refresh:0");
					}
				}
			?>
    </body>
</html>

