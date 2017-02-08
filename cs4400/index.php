<?php session_start();
	ob_start();
?>
<?php
	include "utils.php";
	$failedLoginAttempt = FALSE;
	$failedRegisterAttempt = FALSE;
	if(isset($_SESSION['user'])) {
		Redirect("userPage.php");
	} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
			include "db.php";
			$username = $_POST['username'];
			$password = $_POST['password'];
			$confirmPassword = $_POST['confirmPassword'];
			$email = $_POST['email'];

			if (validateInputs($username, $password, $confirmPassword, $email) && validateEmail($email) && insertNewUserStu($username, $email, $password) === TRUE) {
				$_SESSION['user'] = array('name' => $username);
				$_SESSION['usertype'] = 1;
				Redirect("userPage.php");
			} else {
				$failedRegisterAttempt = TRUE;
			}
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
			include "db.php";
			$username = $_POST['loginusername'];
			$password = $_POST['loginpassword'];
			$UserRows = selectUser($username, $password);
			if ($UserRows != NULL && $UserRows[0]["usertype"] == "1") {
				$_SESSION['user'] = array('name' => $UserRows[0]['username']);
				$_SESSION['usertype'] = 1;
				Redirect("userPage.php");
			} elseif ($UserRows != NULL && $UserRows[0]["usertype"] == "0") {
				$_SESSION['user'] = array('name' => $UserRows[0]['username']);
				$_SESSION['usertype'] = 0;
				Redirect("adminPage.php");
			} else {
				$failedLoginAttempt = TRUE;
			}
		}


		function validateInputs($username, $password, $confirmPassword, $email) {
			if ($username === "" || $password === "" || $email === "")
				return FALSE;
			if ($password !== $confirmPassword)
				return FALSE;
			return TRUE;
		}

		function validateEmail($email) {
			$allowed = array('gatech.edu');

			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$explodedEmail = explode('@', $email);
				$domain = array_pop($explodedEmail);

				if (!(in_array($domain, $allowed))) {
					return FALSE;
				}
			}
			return TRUE;
		}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SLS</title>
        <link rel="stylesheet" type="text/css" href="./public/stylesheets/stylesheet.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Josefin+Slab:400,600' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
    </head>
    <body>
      <header>
          <h1 class="bigwelcome"><span>Welcome</span></h1>
          <p class="SLS">Service, Learn, Sustain</p>
          <div class="buttons" style="text-align:center;">
              <div class="samelinebtn">
                  <div class="buttonone">
                      <button type="submitone" name="submit" data-toggle="modal" data-target="#myModalone">Register</button>
                  </div>
              </div>
              <div class="samelinebtn">
                  <div>
                      <button type="submittwo" name="submit" data-toggle="modal" data-target="#myModaltwo">LOGIN</button>
                  </div>
              </div>
          </div>
      </header>

      <!--Registration Modal-->
      <div class="modal fade" id="myModalone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong>Registration</strong>
                        </h2>
                    </div>
                    <div class="modal-body">
                        <!-- <p class="alert alert-danger" id="error">
                            <strong>Registration Failed. Please Try Again.</strong>
                        </p> -->
                        <form method="post">
                            <div class="form-group">
                                <label style="font-size:16;">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username" required/>
                            </div>
                            <div class="form-group">
                                <label style="font-size:16;">GT Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="GT Email Address" required/>
                            </div>
                            <div class="form-group">
                                <label style="font-size:16;">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <label style="font-size:16;">Confirm Password</label>
                                <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" required/>
                            </div>
                            <div class="col-md-offset-5">
                                <button type="submit" name="register" class="btn btn-success btn-lg" >
                                    CREATE
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Login Modal-->
        <div class="modal fade" id="myModaltwo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                          </button>
                          <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong>Login</strong>
                          </h2>
                      </div>
                      <div class="modal-body">
                          <form method="post">
                              <div class="form-group">
                                  <label style="font-size:16;">Username</label>
                                  <input type="text" name="loginusername" class="form-control" placeholder="Username" autofocus required/>
                              </div>
                              <div class="form-group">
                                  <label style="font-size:16;">Password</label>
                                  <input type="password" name="loginpassword" class="form-control" placeholder="Password" required/>
                              </div>
                              <div class="col-md-offset-3 col-md-3">
                                  <button type="submit" name="login" class="btn btn-success btn-lg">
                                      LOGIN
                                  </button>
                              </div>
                              <button type="submit" name="button" class="btn btn-danger btn-lg" data-toggle="modal" data-dismiss="modal" data-target="#myModalone">
                                  REGISTER
                              </button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>

		  <div class="modal fade" id="loginerror" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                            </button>
                            <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong>Login Failed</strong>
                            </h2>
                        </div>
                        <div class="modal-body">
                            <p class="alert alert-danger" id="error" style="font-size:18px;">
                                <strong>Username or password does not match any existing entry. Please try again.</strong>
                            </p>
                        </div>
						<div class="modal-footer">
							<button type="button" name="buttonlog" class="btn btn-success btn-lg" data-toggle="modal" data-dismiss="modal" data-target="#myModaltwo">
								Try Again
							</button>
                        </div>
                    </div>
                </div>
            </div>

			<div class="modal fade" id="regstererror" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                              </button>
                              <h2 class="modal-title" id="myModalLabel" style="text-align:center;"><strong>Registration Failed</strong>
                              </h2>
                          </div>
                          <div class="modal-body">
                              <p class="alert alert-danger" id="error" style="font-size:18px;">
								  <strong>Registration Failed. Please Try Again.</strong>
                              </p>
                          </div>
  						<div class="modal-footer">
  							<button type="button" name="buttonlog" class="btn btn-success btn-lg" data-toggle="modal" data-dismiss="modal" data-target="#myModalone">
  								Try Again
  							</button>
                          </div>
                      </div>
                  </div>
              </div>

		<script type="text/javascript">
			<?php if($failedLoginAttempt) { ?>
				$(function(){
					$("#loginerror").modal('show');
				});
			<?php } ?>
		</script>

		<script type="text/javascript">
			<?php if($failedRegisterAttempt) { ?>
				$(function(){
					$("#regstererror").modal('show');
				});
			<?php } ?>
		</script>
	</body>
</html>
