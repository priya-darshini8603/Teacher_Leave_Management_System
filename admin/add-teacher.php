<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');

if(strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
    exit();
} else {
    if(isset($_POST['add'])) {
        $teacherid = $_POST['teachercode'];
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];   
        $email = $_POST['email']; 
        $password = md5($_POST['password']); 
        $gender = $_POST['gender']; 
        $joiningdate = $_POST['joiningdate']; 
        $department = $_POST['department']; 
        $designation = $_POST['designation']; 
        $status = 1;

        // Check if teacher ID or email already exists
        $checkTeacherIdQuery = "SELECT COUNT(*) AS count FROM tblteachers WHERE teacherid = :teacherid";
        $checkEmailQuery = "SELECT COUNT(*) AS count FROM tblteachers WHERE EmailId = :email";

        $checkTeacherIdStmt = $dbh->prepare($checkTeacherIdQuery);
        $checkTeacherIdStmt->bindParam(':teacherid', $teacherid, PDO::PARAM_STR);
        $checkTeacherIdStmt->execute();
        $teacherIdExists = $checkTeacherIdStmt->fetch(PDO::FETCH_ASSOC)['count'];

        $checkEmailStmt = $dbh->prepare($checkEmailQuery);
        $checkEmailStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $checkEmailStmt->execute();
        $emailExists = $checkEmailStmt->fetch(PDO::FETCH_ASSOC)['count'];

        if($teacherIdExists > 0) {
            $error = "Teacher ID already exists.";
        } elseif($emailExists > 0) {
            $error = "Email ID already exists.";
        } else {
            // Proceed with insertion
            $sql = "INSERT INTO tblteachers (teacherid, FirstName, LastName, EmailId, Password, Gender, JoiningDate, Department, Designation, Status)
                    VALUES (:teacherid, :fname, :lname, :email, :password, :gender, :joiningdate, :department, :designation, :status)";
            $query = $dbh->prepare($sql);
           
            $query->bindParam(':teacherid', $teacherid, PDO::PARAM_STR);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':lname', $lname, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':gender', $gender, PDO::PARAM_STR);
            $query->bindParam(':joiningdate', $joiningdate, PDO::PARAM_STR);
            $query->bindParam(':department', $department, PDO::PARAM_STR);
            $query->bindParam(':designation', $designation, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_INT);

            if($query->execute()) {
                $msg = "Record has been added Successfully";
            } else {
                $error = "ERROR: Could not execute query: " . implode(":", $query->errorInfo());
            }
        }
    }
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Portal - Add Teacher</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">

    <script type="text/javascript">
        function valid() {
            if(document.addteacher.password.value != document.addteacher.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match!");
                document.addteacher.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script>
        function checkAvailabilityTeacherid() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data:'teachercode='+$("#teachercode").val(),
                type: "POST",
                success:function(data){
                    $("#teacherid-availability").html(data);
                    $("#loaderIcon").hide();
                },
                error:function (){}
            });
        }
        
        function checkAvailabilityEmailid() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data:'emailid='+$("#email").val(),
                type: "POST",
                success:function(data){
                    $("#emailid-availability").html(data);
                    $("#loaderIcon").hide();
                },
                error:function (){}
            });
        }
    </script>
</head>
<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-header">
              
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <?php
                        $page='teachers';
                        include '../includes/admin-sidebar.php';
                    ?>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="pull-left">
                            <img src="../assets/images/nittelogo.png" alt="icon" >
                        </div> 
                    </div>
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                           
                            <?php include '../includes/admin-notification.php'?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Add Teacher Section</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="teachers.php">Teacher</a></li>
                                <li><span>Add</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="../assets/images/admin.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">ADMIN <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <?php if(isset($error)){ ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Info: </strong><?php echo htmlentities($error); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php } else if(isset($msg)){ ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>Info: </strong><?php echo htmlentities($msg); ?> 
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php } ?>
                                <div class="card">
                                    <form name="addteacher" method="POST" onsubmit="return valid();">
                                        <div class="card-body">
                                            <p class="text-muted font-14 mb-4">Please fill up the form in order to add teacher records</p>
                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Teacher ID</label>
                                                <input class="form-control" name="teachercode" type="text" autocomplete="off" required id="teachercode" onBlur="checkAvailabilityTeacherid()">
                                                <span id="teacherid-availability"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">First Name</label>
                                                <input class="form-control" name="firstName" type="text" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Last Name</label>
                                                <input class="form-control" name="lastName" type="text" autocomplete="off" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email-input" class="col-form-label">Email</label>
                                                <input class="form-control" name="email" type="email" autocomplete="off" required onBlur="checkAvailabilityEmailid()">
                                                <span id="emailid-availability"></span>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Gender</label>
                                                <select class="custom-select" name="gender" autocomplete="off" required>
                                                    <option value="">Choose...</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-date-input" class="col-form-label">Joining Date</label>
                                                <input class="form-control" name="joiningdate" type="date" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Department</label>
                                                <select class="custom-select" name="department" autocomplete="off" required>
                                                    <option value="">Choose...</option>
                                                    <option value="CSE">CSE</option>
                                                    <!-- Add more departments as needed -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Designation</label>
                                                <input class="form-control" name="designation" type="text" autocomplete="off" required>
                                            </div>
                                            <h4>Set Password for Teacher Login</h4>
                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Password</label>
                                                <input class="form-control" name="password" type="password" autocomplete="off" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Confirmation Password</label>
                                                <input class="form-control" name="confirmpassword" type="password" autocomplete="off" required>
                                            </div>
                                            <button class="btn btn-primary" name="add" id="update" type="submit">PROCEED</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script src="assets/js/line-chart.js"></script>
    <script src="assets/js/pie-chart.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>
<?php } ?>
