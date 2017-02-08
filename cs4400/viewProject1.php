<?php session_start(); 
	if($_SESSION['usertype'] != 0) {
		header('Location: ' . $_SERVER["REQUEST_URI"] . '?notFound=1');
		exit;
	}?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Popular Project</title>
        <link rel="stylesheet" type="text/css" href="public/stylesheets/index.css">
        <link rel="stylesheet" type="text/css" href="public/stylesheets/style1.css">
        <link rel="stylesheet" type="text/css" href="public/stylesheets/font-awesome-4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Quicksand:700" rel="stylesheet" type='text/css'>
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

        <div class="container" style="margin-top:80px;">
            <h1 style="text-align:center;font-size:50px;">Popular Project</h1>
            <table class="table table-bordered table-hover table-responsive">
    			<thead>
    				<tr>
    					<th class="col-md-8">Project</th>
    					<th>Number of Applicants</th>
    				</tr>
    			</thead>
			    <tbody>
                        <?php
                            include "db.php";
                            $displayrep = selectNumOfApply();
                            for ($i=0; $i < count($displayrep); $i++) {
                                echo '<tr><td class="col-md-8">' . $displayrep[$i]["Project"] . '</td>';
                                echo '<td>' . $displayrep[$i]["Number"] . '</td></tr>';
                            }
                        ?>
 
    			</tbody>
    		</table>
		</div>
    </body>
</html>