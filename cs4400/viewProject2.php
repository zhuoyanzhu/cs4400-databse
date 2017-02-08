<?php session_start(); 
	if($_SESSION['usertype'] != 0) {
		header('Location: ' . $_SERVER["REQUEST_URI"] . '?notFound=1');
		exit;
	}?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Application Report</title>
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
            <h1 style="text-align:center;font-size:50px;">Application Report</h1>
            <?php
                include "db.php";
                $totalapp = selectNumber();
                $accepted = selectAcceptions();
            ?>
    		<p style="text-align:center;font-size:18px;"><?PHP echo $totalapp[0]['number'];?> applications in total, accepted <?PHP echo $accepted[0]['number'];?> applications</p>
            <table class="table table-bordered table-hover table-responsive">
    			<thead>
    				<tr>
                        <th class="col-md-5">Project</th>
                        <th>Number of Applicants</th>
                        <th>Accept Rate</th>
                        <th>Top 3 Major</th>
    				</tr>
    			</thead>
    			<tbody>
                    <?php
                        $appreport = selectReportOfApply();
                        for ($i=0; $i < count($appreport); $i++) {
                            echo '<tr><td class="col-md-5">' . $appreport[$i]["Project"] . '</td>';
                            echo '<td>' . $appreport[$i]["NumberofApplicant"] . '</td>';
                            echo '<td>' . round($appreport[$i]["accepterate"]) . '%</td>';
                            echo '<td>' . $appreport[$i]["Major"] . '</td></td>';
                        }
                    ?>
    			</tbody>
    		</table>
		</div>
    </body>
</html>