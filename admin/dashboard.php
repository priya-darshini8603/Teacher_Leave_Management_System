<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');
if(strlen($_SESSION['alogin'])==0){   
    header('location:index.php');
} else {

    // Fetch data for the leave status chart
    $pendingQuery = "SELECT COUNT(*) AS count FROM tblleaves WHERE Status = 0";
    $approvedQuery = "SELECT COUNT(*) AS count FROM tblleaves WHERE Status = 1";
    $declinedQuery = "SELECT COUNT(*) AS count FROM tblleaves WHERE Status = 2";

    $pendingResult = $dbh->query($pendingQuery)->fetch(PDO::FETCH_ASSOC)['count'];
    $approvedResult = $dbh->query($approvedQuery)->fetch(PDO::FETCH_ASSOC)['count'];
    $declinedResult = $dbh->query($declinedQuery)->fetch(PDO::FETCH_ASSOC)['count'];

    // Fetch data for active and inactive teachers
    $activeTeachersQuery = "SELECT COUNT(*) AS count FROM tblteachers WHERE Status = 1";
    $inactiveTeachersQuery = "SELECT COUNT(*) AS count FROM tblteachers WHERE Status = 0";

    $activeTeachersResult = $dbh->query($activeTeachersQuery)->fetch(PDO::FETCH_ASSOC)['count'];
    $inactiveTeachersResult = $dbh->query($inactiveTeachersQuery)->fetch(PDO::FETCH_ASSOC)['count'];
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Portal - Teacher Leave</title>
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

    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
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
                        $page='dashboard';
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
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <!-- Notification bell -->
                            <?php include '../includes/admin-notification.php'?>
                        </ul>
                        <!-- notification ends -->
                    </div>
                </div>
            </div>
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="dashboard.php">Home</a></li>
                                <li><span>Admin's Dashboard</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
    <div class="user-profile pull-right">
        <img class="avatar user-thumb" src="../assets/images/admin.png" alt="avatar">
        <h4 class="user-name dropdown-toggle" id="adminDropdownToggle">ADMIN <i class="fa fa-angle-down"></i></h4>
        <div class="dropdown-menu" id="adminDropdownMenu">
            <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>
    </div>
</div>

                </div>
            </div>
            <div style="background: linear-gradient(to right, #f0f0f0, #333); padding: 20px;">
                <h1>Welcome!</h1>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col-lg-6 col-md-6">
                    <div class="card h-100">
                        <div class="card-body "> 
                            <h5 class="card-title mb-5">Leave Status Distribution</h5>
                            <div class="chart-container"> 
                                <canvas id="leaveStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card h-100">
                        <div class="card-body"> 
                            <h5 class="card-title">Teacher Status</h5>
                            <div class="chart-container"> 
                                <canvas id="teacherStatusChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-center">
                                <div class="trd-history-tabs">
                                    <ul class="nav" role="tablist">
                                        <li>
                                            <a class="active" data-toggle="tab" href="dashboard.php" role="tab">Recent List</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped progress-table text-center">
                                        <thead class="text-uppercase">
                                            <tr>
                                                <th>S.N</th>
                                                <th>Teacher ID</th>
                                                <th width="120">Full Name</th>
                                                <th>Leave Type</th>
                                                <th>Applied On</th>
                                                <th>Current Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $sql = "SELECT tblleaves.id as lid, tblteachers.FirstName, tblteachers.LastName, tblteachers.teacherid, tblteachers.id, tblleaves.LeaveType, tblleaves.PostingDate, tblleaves.Status 
                                                    FROM tblleaves 
                                                    JOIN tblteachers ON tblleaves.teacherid = tblteachers.id 
                                                    ORDER BY lid DESC 
                                                    LIMIT 7";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {         
                                            ?>  
                                            <tr>
                                                <td><b><?php echo htmlentities($cnt);?></b></td>
                                                <td><?php echo htmlentities($result->teacherid);?></td>
                                                <td><a href="update-teacher.php?teacherid=<?php echo htmlentities($result->id);?>" target="_blank"><?php echo htmlentities($result->FirstName." ".$result->LastName);?></a></td>
                                                <td><?php echo htmlentities($result->LeaveType);?></td>
                                                <td><?php echo htmlentities($result->PostingDate);?></td>
                                                <td>
                                                    <?php 
                                                    $status = $result->Status;
                                                    if ($status == 1) {
                                                        echo '<span style="color: green">Approved <i class="fa fa-check-square-o"></i></span>';
                                                    } elseif ($status == 2) {
                                                        echo '<span style="color: red">Declined <i class="fa fa-times"></i></span>';
                                                    } elseif ($status == 0) {
                                                        echo '<span style="color: blue">Pending <i class="fa fa-spinner"></i></span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><a href="teacherLeave-details.php?leaveid=<?php echo htmlentities($result->lid);?>" class="btn btn-secondary btn-sm">View Details</a></td>
                                            </tr>
                                            <?php 
                                            $cnt++;
                                                }
                                            } else {
                                                echo '<tr><td colspan="7" class="text-center">No data found</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../includes/footer.php' ?>
        </div>
    </div>

    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    // Leave status chart
    var leaveStatusCtx = document.getElementById('leaveStatusChart').getContext('2d');
    var leaveStatusChart = new Chart(leaveStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Declined'],
            datasets: [{
                data: [<?php echo $pendingResult; ?>, <?php echo $approvedResult; ?>, <?php echo $declinedResult; ?>],
                backgroundColor: ['#FDD419', '#62C10E','#EE4521']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'top',
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });

    // Teacher status chart
    var teacherStatusCtx = document.getElementById('teacherStatusChart').getContext('2d');
    var teacherStatusChart = new Chart(teacherStatusCtx, {
        type: 'bar',
        data: {
            labels: ['Active Teachers', 'Inactive Teachers'],
            datasets: [{
                label: 'Teacher Status',
                data: [<?php echo $activeTeachersResult; ?>, <?php echo $inactiveTeachersResult; ?>],
                backgroundColor: [
                    'rgba(46, 204, 113, 0.5)', 
                'rgba(231, 76, 60, 0.5)'
                ],
                borderColor: [
                    'rgba(46, 204, 113, 1)',  // Green for Active Teachers
                'rgba(231, 76, 60, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            responsive: true,
            legend: {
                position: 'top',
            }
        }
    });
    </script>
</body>
</html>
