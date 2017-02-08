<?php session_start();
	ob_start();
	if($_SESSION['usertype'] != 0) {
		header('Location: ' . $_SERVER["REQUEST_URI"] . '?notFound=1');
		exit;
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>View Application</title>
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
            <h1 style="text-align:center;font-size:50px;">Application</h1>
            <form method="post" action="#">
        		<table class="table table-bordered table-hover table-responsive">
        			<thead>
        				<tr>
        					<th class="col-md-1">Choose</th>
        					<th class="col-md-5">Project</th>
        					<th>Application Major</th>
        					<th>Application Year</th>
        					<th>Status</th>
        				</tr>
        			</thead>
        			<tbody>
                        <?php
            				include "db.php";
            				$applications = selectApplyStatus();
            				for ($i=0; $i < count($applications); $i++) {
								if($applications[$i]["status"] == 'pending') {
									echo
            						"<tr>
            							<td class=col-md-1><input type='Checkbox' name='checkboxvar[]' value=". $i ."> </td>";
								}
								else {
									echo
            						"<tr>
            							<td class=col-md-1></td>";
								}		
								echo 
            							"<td class=col-md-5>'" . $applications[$i]["Project"] . "'</td>
            							<td>'" . $applications[$i]["ApplicantMajor"] . "'</td>
            							<td>'" . $applications[$i]["ApplicantYear"] . "'</td>
            							<td>'" . $applications[$i]["status"] . "'</td>
            						</tr>";
            				}
            			?>
        			</tbody>
        		</table>
                <button type="submit" data-dismiss="modal" name="reject" class="btn btn-danger btn-lg col-lg-offset-9" style="margin-right:40px;">
                    Reject
                </button>
                <button type="submit" name="accept" class="btn btn-success btn-lg">
                    Accept
                </button>
			
            </form>
        </div>
    </body>
	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept'])) {
			$array = $_POST['checkboxvar'];
			foreach($array as $val) {
				print_r($applications[$val]["Project"]);
				print_r($applications[$val]["name"]);
				acceptApply($applications[$val]["Project"], $applications[$val]["name"]);
				header("Refresh:0");
			}
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject'])) {
			$array = $_POST['checkboxvar'];
			foreach($array as $val) {
				rejectApply($applications[$val]["Project"], $applications[$val]["name"]);
				header("Refresh:0");
			}
		}
	?>
</html>