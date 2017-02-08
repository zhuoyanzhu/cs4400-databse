    <?php
	include "db.php";
	include "utils.php";
	ob_start();
      // check qualification and apply
      $failedApplyAttempt = FALSE;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if(isset($_POST['select'])) {
			$name = $_POST['name'];
            $major = getMajorFromUser($name);
            $year = getYearFromUser($name);
			$projectname = $_POST['projectname'];
            if (canSelectProject($projectname, $major[0]['major'], $year[0]['year'])) {
			  date_default_timezone_set('UTC');
              $now = new DateTime();
              $date = $now->format('Y-m-d H:i:s');
              $status = "pending";
              insertNewApply($projectname, $name, $date, $status);
            }
            else {
              $failedApplyAttempt = TRUE;
            }
          }
        }
		if($failedApplyAttempt)
			echo '<script type="text/javascript">alert("apply is failed");window.location.href = "userPage.php";</script>';
		else
			Redirect("userPage.php");
    ?>