<?php
	session_start();
	if($_SESSION['usertype'] != 0) {
		header('Location: ' . $_SERVER["REQUEST_URI"] . '?notFound=1');
		exit;
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome</title>
        <link rel="stylesheet" type="text/css" href="public/stylesheets/style1.css">
        <link rel="stylesheet" type="text/css" href="public/stylesheets/index.css">
        <link rel="stylesheet" type="text/css" href="public/stylesheets/font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Josefin+Slab:400,600' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet' type='text/css'>
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
        <div class="container" style="margin-top:90px;">
            <h1 class="functionality">Choose Functionality</h1>
    		<p class="fun1"><a href="./viewApplication.php">View Applications</a></p>
    		<p class="fun2"><a href="./viewProject1.php">View Popular Project Report</a></p>
    		<p class="fun3"><a href="./viewProject2.php">View Application Report</a></p>
    		<p class="fun4"><a href="./projectadd.php">Add a Project</a></p>
    		<p class="fun5"><a href="./courseadd.php">Add a Course</a></p>
        </div>
    </body>
</html>