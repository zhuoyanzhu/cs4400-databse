<?php   
    $username = 'cs4400_Team_57';
    $password = 'mjLOyFgW'; 
	$database = 'cs4400_Team_57';
	$host = 'academic-mysql.cc.gatech.edu';
    // $conn = new mysqli($servername, $username, $password, $database);
    $conn = new mysqli($host, $username, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    // echo "Database: Connected successfully" . PHP_EOL; 
###########################################################################################################################################
    #some private funtions used for interact with db
    function query($query) {
        $conn = $GLOBALS['conn'];
        if ($conn->query($query) === TRUE) {
                echo '<script type="text/javascript">alert("The insert is successful");</script>';
        } else {
				echo '<script type="text/javascript">alert("The insert is failed");</script>';
        }
    }
	
    function queryInsert($query) {
        $conn = $GLOBALS['conn'];
        return $conn->query($query);
    }
   
    function queryRet($query) {
        $conn = $GLOBALS['conn'];
        $queryResult = $conn->query($query);
        return $queryResult->num_rows > 0 ? $queryResult->fetch_all(MYSQLI_ASSOC) : NULL;
    }
	
    # create the table
    function createTableUser() {
        $querystring = "CREATE TABLE User ("
            . "username VARCHAR(30) PRIMARY KEY,"
            . "email VARCHAR(50) UNIQUE NOT NULL,"
            . "password VARCHAR(30) NOT NULL,"
            . "year ENUM('freshman', 'sophomore', 'junior', 'senior'),"
            . "major VARCHAR(50),"
			. "usertype ENUM('0','1'))";
        query($querystring);
    }
    # add foreign key constraints
    function alterTableUser() {
        $querystring = "ALTER TABLE User ADD CONSTRAINT student_major "
            . "FOREIGN KEY (major) REFERENCES Major(name)";
        query($querystring);
    }
    # edit profile
    function updateTableUserMajor($username, $major) {
        $querystring = "UPDATE User "
            . "SET major='" . $major . "' "
            . "WHERE username='" . $username . "'";
        query($querystring);
    }
    function updateTableUserYear($username, $year) {
        $querystring = "UPDATE User "
            . "SET year='" . $year . "' "
            . "WHERE username='" . $username . "'";
        query($querystring);
    }
    function dropTableUser() {
        $querystring = "DROP TABLE User";        
        query($querystring);
    }
    
    function insertNewUserStu($username, $email, $password) {
        $querystring = "INSERT INTO User ("
            . "username, "
            . "email, "
            . "password, "
            . "userType) "
            . "VALUES("
            . "'" . $username . "', "
            . "'" . $email . "', "
            . "'" . $password . "', "
            . "'" . '1' . "')";
        return queryInsert($querystring);
    }
    function selectUser($username, $password) {
        $querystring = "SELECT * FROM User "
            . "WHERE "
            . "Username='" . $username . "' "
            . "AND "
            . "Password='" . $password . "'";
        return queryRet($querystring);
    }
    
	function getMajorFromUser($username) {
        $querystring = "SELECT major FROM User "
            . "WHERE "
            . "Username='" . $username . "'";
        return queryRet($querystring);
    }
	
	function getYearFromUser($username) {
        $querystring = "SELECT year FROM User "
            . "WHERE "
            . "Username='" . $username . "'";
        return queryRet($querystring);
    }
	
	
    function createTableProject() {
        $querystring = "CREATE TABLE Project ("
            . "name VARCHAR(50) PRIMARY KEY,"
            . "description TEXT NOT NULL,"
            . "est_num INT NOT NULL,"
            . "adivisor_name VARCHAR(30) NOT NULL,"
            . "adivisor_email VARCHAR(50) UNIQUE NOT NULL,"
            . "designation_name VARCHAR(30) NOT NULL)";
        query($querystring);
    }
    # add foreign key constraints
    function alterTableProject() {
        $querystring = "ALTER TABLE Project "
            . "ADD CONSTRAINT project_designation "
            . "FOREIGN KEY (designation_name) "
            . "REFERENCES Designation(name)";
        query($querystring);
    }
    function dropTableProject() {
        $querystring = "DROP TABLE Project";        
        query($querystring);
    }
    function insertNewProject($name, $description, $est_num, $adivisor_name, $adivisor_email, $designation_name) {
        $querystring = "INSERT INTO Project "
            . "VALUES("
            . "'" . $name . "', "
            . "'" . $description . "', "
            . "'" . $est_num . "', "
            . "'" . $adivisor_name . "', "
            . "'" . $adivisor_email . "', "
            . "'" . $designation_name . "')";            
        return queryInsert($querystring);
    }
    function selectProjectByName($name) {
        $querystring = "SELECT * FROM Project "
            . "WHERE "
            . "name='" . $name . "' ";        
        return queryRet($querystring);
    }

    function createTableProjectReq() {
        $querystring = "CREATE TABLE Project_requirement ("
            . "name VARCHAR(50) NOT NULL,"
            . "requirement VARCHAR(100) NOT NULL,"
            . "PRIMARY KEY(name, requirement))";
        query($querystring);
    }
    # add foreign key constraints
    function alterTableProjectReq() {
        $querystring = "ALTER TABLE Project_requirement "
            . "ADD CONSTRAINT requirement_project "
            . "FOREIGN KEY (name) "
            . "REFERENCES Project(name)";
        query($querystring);
    }
    function dropTableProjectReq() {
        $querystring = "DROP TABLE Project_requirement";        
        query($querystring);
    }
    function insertNewProjectReq($name, $requirement) {
        $querystring = "INSERT INTO Project_requirement "
            . "VALUES("
            . "'" . $name . "', "
            . "'" . $requirement . "')";            
        return queryInsert($querystring);
    }
    
    function getRequirement($name) {
    	$querystring = "SELECT requirement "
            . "FROM Project_requirement WHERE name='" . $name . "'";  
        return queryRet($querystring);
    }

    function createTableDesignation() {
        $querystring = "CREATE TABLE Designation ("
            . "name VARCHAR(30) PRIMARY KEY)";
        query($querystring);
    }
    function dropTableDesignation() {
        $querystring = "DROP TABLE Designation";        
        query($querystring);
    }
    function insertNewDesignation($name) {
        $querystring = "INSERT INTO Designation "
            . "VALUES("
            . "'" . $name . "')";            
        return queryInsert($querystring);
    }
	
	function selectAllDesignation() {
		$querystring = "SELECT name "
		. "FROM Designation";  
		return queryRet($querystring);
	}
	
    function createTableCategory() {
        $querystring = "CREATE TABLE Category ("
            . "name VARCHAR(50) PRIMARY KEY)";
        query($querystring);
    }
    function dropTableCategory() {
        $querystring = "DROP TABLE Category";        
        query($querystring);
    }
    function insertNewCategory($name) {
        $querystring = "INSERT INTO Category "
            . "VALUES("
            . "'" . $name . "')";            
        return queryInsert($querystring);
    }
	
	function selectAllCategory() {
		$querystring = "SELECT name "
		. "FROM Category";  
		return queryRet($querystring);
	}
	
    function createTableMajor() {
        $querystring = "CREATE TABLE Major ("
            . "name VARCHAR(50) PRIMARY KEY,"
            . "dept_name VARCHAR(50) NOT NULL)";
        query($querystring);
    }
    # add foreign key constraints
    function alterTableMajor() {
        $querystring = "ALTER TABLE Major ADD CONSTRAINT major_dept "
            . "FOREIGN KEY (dept_name) REFERENCES Department(name)";
        query($querystring);
    }
    function dropTableMajor() {
        $querystring = "DROP TABLE Major";        
        query($querystring);
    }
	
    function insertNewMajor($name, $dept_name) {
        $querystring = "INSERT INTO Major "
            . "VALUES("
            . "'" . $name . "', "
            . "'" . $dept_name ."')";
        return queryInsert($querystring);
    }
	
    function getDepartmentByMajor($major) {
    	$querystring = "SELECT dept_name "
		. "FROM Major WHERE name='" . $major . "'";  
	return queryRet($querystring);
    }

	function selectMajor() {
	$querystring = "SELECT name "
		. "FROM Major";  
	return queryRet($querystring);
    }

    function createTableDepartment() {
        $querystring = "CREATE TABLE Department ("
            . "name VARCHAR(30) PRIMARY KEY)";
        query($querystring);
    }
    function dropTableDepartment() {
        $querystring = "DROP TABLE Department";        
        query($querystring);
    }
    function insertNewDepartment($name) {
        $querystring = "INSERT INTO Department "
            . "VALUES("
            . "'" . $name . "')";
        return queryInsert($querystring);
    }
    
###########################################################################################################################################
    
    function createTableCourse() {
        $querystring = "CREATE TABLE Course ("
            . "name VARCHAR(100) PRIMARY KEY,"
            . "course_number VARCHAR(50) UNIQUE  NOT NULL,"
            . "instructor VARCHAR(30) NOT NULL,"
            . "est_num INT NOT NULL,"
            . "designation_name VARCHAR(30) NOT NULL,"
            . "FOREIGN KEY (designation_name),"
            . "REFERENCES Designation(name))";
        query($querystring);
    }
    
    function dropTableCourse() {
        $querystring = "DROP TABLE Course";        
        query($querystring);
    }
    function insertNewCourse($name, $course_number, $instructor, $est_num, $designation_name) {
        $querystring = "INSERT INTO Course "
            . "VALUES("
            . "'" . $name . "', "
            . "'" . $course_number . "', "
            . "'" . $instructor . "', "
            . "'" . $est_num . "', "
            . "'" . $designation_name . "')";            
        return queryInsert($querystring);
    }
    
    function createTableApply() {
        $querystring = "CREATE TABLE Apply ("
            . "project_name VARCHAR(50) NOT NULL,"
            . "student_name VARCHAR(50) NOT NULL,"
            . "date DATE NOT NULL,"
            . "status ENUM('pending', 'accepted', 'rejected') NOT NULL,"
            . "PRIMARY KEY(student_name, project_name),"
            . "FOREIGN KEY(student_name) REFERENCES User(username),"
            . "FOREIGN KEY(project_name) REFERENCES Project(name))";
        query($querystring);
    }
    
    function dropTableApply() {
        $querystring = "DROP TABLE Apply";        
        query($querystring);
    }
    
    function insertNewApply($pname, $sname, $date, $status) {
        $querystring = "INSERT INTO Apply "
            . "VALUES("
            . "'" . $pname . "', "
            . "'" . $sname . "', "
            . "'" . $date . "', "
            . "'" . $status . "')";            
        return queryInsert($querystring);
    }
	
    function acceptApply($name1, $name2) {
        $querystring = "UPDATE Apply "
            . "SET status='accepted' "
            . "WHERE project_name='" . $name1 . "' "
			. "AND student_name='" . $name2 . "'";
        query($querystring);
    }
	
	function rejectApply($name1, $name2) {
        $querystring = "UPDATE Apply "
            . "SET status='rejected' "
            . "WHERE project_name='" . $name1 . "' "
			. "AND student_name='" . $name2 . "'";
        query($querystring);
    }
	
    function createTableProject_is_category() {
        $querystring = "CREATE TABLE Project_is_category ("
            . "project_name VARCHAR(50) NOT NULL,"
            . "category_name VARCHAR(50) NOT NULL,"
            . "PRIMARY KEY(category_name, project_name),"
            . "FOREIGN KEY(category_name) REFERENCES Category(name),"
            . "FOREIGN KEY(project_name) REFERENCES Project(name))";
        query($querystring);
    }
    
    function dropTableProject_is_category() {
        $querystring = "DROP TABLE Project_is_category";        
        query($querystring);
    }
    
    function insertNewProject_is_category($pname, $cname) {
        $querystring = "INSERT INTO Project_is_category "
            . "VALUES("
            . "'" . $pname . "', "
            . "'" . $cname . "')";            
        return queryInsert($querystring);
    }
    
    function getProjectCategory($name) {
    	$querystring = "SELECT category_name FROM Project_is_category "
            . "WHERE project_name='" . $name . "'";            
        return queryRet($querystring);
    }
    
    function createTableCourse_is_category() {
        $querystring = "CREATE TABLE Course_is_category ("
            . "course_name VARCHAR(100) NOT NULL,"
            . "category_name VARCHAR(50) NOT NULL,"
            . "PRIMARY KEY(category_name, course_name),"
            . "FOREIGN KEY(category_name) REFERENCES Category(name),"
            . "FOREIGN KEY(course_name) REFERENCES Course(name))";
        query($querystring);
    }
    
    function dropTableCourse_is_category() {
        $querystring = "DROP TABLE Course_is_category";        
        query($querystring);
    }
    
    function insertNewCourse_is_category($pname, $cname) {
        $querystring = "INSERT INTO Course_is_category "
            . "VALUES("
            . "'" . $pname . "', "
            . "'" . $cname . "')";            
        return queryInsert($querystring);
    }
	
    function getCourseCategory($name) {
    	$querystring = "SELECT category_name FROM Course_is_category "
            . "WHERE course_name='" . $name . "'";            
        return queryRet($querystring);
    }
    
    function selectApplyStatus() {
        $querystring = "SELECT project_name AS Project,  major AS ApplicantMajor, year AS ApplicantYear, status, User.username AS name "
            . "FROM Apply INNER JOIN User ON User.username=Apply.student_name";        
        return queryRet($querystring);
    }
    function selectNumOfApply() {
        $querystring = "SELECT project_name AS Project,  count(student_name) AS Number "
            . "FROM Apply GROUP BY project_name ORDER BY number DESC LIMIT 10";        
        return queryRet($querystring);
    }
    function selectNumber() {
        $querystring = "SELECT count(*) AS number "
            . "FROM Apply";  
            return queryRet($querystring);
    }
    
    function selectAcceptions() {
        $querystring = "SELECT count(*) AS number "
            . "FROM Apply WHERE status='accepted'";  
         return queryRet($querystring);
    }
    
    function selectReportOfApply() {
        $querystring1 = "((SELECT project_name AS Project,  count(student_name) AS number "
            . "FROM Apply GROUP BY project_name) AS number1)";   
        $querystring2 = "(((SELECT project_name AS Project,  count(student_name) AS number "
            . "FROM Apply  WHERE status='accepted' GROUP BY project_name) UNION (SELECT project_name AS Project,  
			   0 "
            . "FROM Apply  GROUP BY project_name HAVING COUNT(status IN ('accepted') OR NULL)=0))AS number2)";  
        $querystring3 = "(SELECT number1.Project,  number1.number AS NumberofApplicant, "
            . "(number2.number * 100 / number1.number) AS accepterate "
            . "FROM "
            . $querystring1
            . " INNER JOIN "
            . $querystring2
            . " ON number1.Project=number2.Project) AS res1"; 
        $querystring4 = "((SELECT project_name, major, count(*) AS number "
            . "FROM Apply INNER JOIN User ON User.username=Apply.student_name "
            . "GROUP BY Apply.project_name, User.major) AS p)";
        $querystring5 = "(SELECT p.project_name AS Project, substring_index(GROUP_CONCAT(p.major ORDER BY p.number DESC SEPARATOR '/'), '/', 3) AS Major "
            . "FROM "
            . $querystring4
            . " GROUP BY p.project_name) AS res2";
        $querystring = "SELECT res1.Project, res1.NumberofApplicant, res1.accepterate, res2.Major "
            . "FROM " . $querystring3 . " INNER JOIN " . $querystring5
            . " ON res1.Project=res2.Project ORDER BY accepterate DESC";
        return queryRet($querystring);
    }
    
    function selectCourseBy($name, $designation_name, $category_array) {
        $array = '("' . join('","', (array)$category_array) . '")';
		if(empty($category_array)) {
			$querystring1 = "(SELECT name AS course_name FROM Course"
			. ") AS res1";
		}
		else {
			$querystring1 = "(SELECT DISTINCT course_name FROM Course_is_category "
				. "WHERE category_name IN " . $array . " GROUP BY course_name "
				. "HAVING COUNT(DISTINCT category_name)=" . count($category_array) 
				. ") AS res1";
		}
        $querystring2 = "(SELECT * FROM Course "
            . "WHERE "
            . "(name LIKE '%" . $name . "%' OR '" . $name . "'='') AND "
            . "(designation_name='" . $designation_name . "' OR '"
            . $designation_name . "'='')) AS res2";
        $querystring = "SELECT * FROM" . $querystring1
            . " INNER JOIN " . $querystring2 . " ON res1.course_name=res2.name";
        return queryRet($querystring);
    }
	
    function selectProjectBy($name, $designation_name, $category_array, $major, $year) {
		if(empty($category_array)) {
			$querystring1 = "(SELECT name AS project_name FROM Project "
			. ") AS res1";
		}
		else {
			$array = '("' . join('","', (array)$category_array) . '")';
			$querystring1 = "(SELECT DISTINCT project_name FROM Project_is_category "
				. "WHERE category_name IN " . $array . " GROUP BY project_name "
				. "HAVING COUNT(DISTINCT category_name)=" . count($category_array) 
				. ") AS res1";
		}
		$querystring2 = "(SELECT * FROM Project "
			. "WHERE "
			. "(name LIKE '%" . $name . "%' OR '" . $name . "'='') AND "
			. "(designation_name='" . $designation_name . "' OR '"
			. $designation_name . "'='')) AS res2";
		if($major == '' && $year == '') {
			$querystring3 = "(SELECT name FROM Project "
			. ") AS res3";
		}
		else {
			$leftReg = "%";
			$rightReg = "%";
			$res = getDepartmentByMajor($major);
			$department = $res[0]["dept_name"];
			$querystring3 = "(SELECT t1.name FROM (SELECT name, GROUP_CONCAT(requirement SEPARATOR ', ') AS requirements
			FROM Project_requirement GROUP BY name) AS t1 WHERE"
				. " (((t1.requirements LIKE '" . $leftReg . $major
				. $rightReg . "' "
				. ") OR (t1.requirements LIKE '" . $leftReg . $department 
				. $rightReg . "' ))"
				. "AND t1.requirements LIKE '" . $leftReg . $year
				. $rightReg . "')) AS res3 ";
		}
		$querystring = "SELECT DISTINCT * FROM " . $querystring1 . " "
			. " INNER JOIN " . $querystring2
			. " INNER JOIN " . $querystring3
			. " WHERE res1.project_name=res2.name"
			. " AND res2.name=res3.name";
		return queryRet($querystring);
    }
    
	function canSelectProject($name, $major, $year) {
		if(selectProjectByName($name) == null)
			return false;
		else {
			if(getRequirement($name) == null)
				return true;
			else {
			
				$res1 = getDepartmentByMajor($major);
				$res2 = getRequirement($name);
				$department = $res1[0]['dept_name'];
				for($i=0; $i < count($res2); $i++) {
					$requirement = $res2[$i]['requirement'];
					if(strpos($requirement, $major) === false AND strpos($requirement, $year) === false AND strpos($requirement, $department) === false)
						return false;
				}
				return true;
			}
		}
	}

	
    function selectApplication($name) {
        $querystring = "SELECT project_name, date, status FROM Apply"
            . " WHERE student_name='" . $name. "'";
        return queryRet($querystring);
    }
	
    function getDepartment() {
	$querystring = "SELECT name
			FROM Department";
        return queryRet($querystring);
    	
    }
?>