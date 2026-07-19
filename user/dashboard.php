<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php';
include '../includes/user_navbar.php';

$user_id = $_SESSION['user_id'];

/* -------------------- Statistics -------------------- */

// Total Reports
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM issues WHERE user_id='$user_id'");
$totalReports = mysqli_fetch_assoc($totalQuery)['total'];

// Pending
$pendingQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM issues WHERE user_id='$user_id' AND status='Pending'");
$pending = mysqli_fetch_assoc($pendingQuery)['total'];

// In Progress
$progressQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM issues WHERE user_id='$user_id' AND status='In Progress'");
$progress = mysqli_fetch_assoc($progressQuery)['total'];

// Resolved
$resolvedQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM issues WHERE user_id='$user_id' AND status='Resolved'");
$resolved = mysqli_fetch_assoc($resolvedQuery)['total'];

// Recent Reports
$recentReports = mysqli_query($conn,"
SELECT issues.*, categories.category_name
FROM issues
JOIN categories
ON issues.category_id = categories.category_id
WHERE issues.user_id='$user_id'
ORDER BY reported_at DESC
LIMIT 5
");
?>

<div class="page-bg"  style="background-image: url('assets/images/hero.png');">

    <div class="container pt-5 mt-5">

    <!-- Welcome Card -->
    <div class="card shadow-lg border-0 bg-primary text-white mb-4">
        <div class="card-body">

            <h2>
                Welcome,
                <?php echo $_SESSION['full_name']; ?> 👋
            </h2>

            <p class="mb-0">
                Manage your reported issues and track their progress.
            </p>

        </div>
    </div>

    <!-- Statistics -->
    <div class="row g-4">

        <div class="col-md-3">

            <div class="card shadow border-0 text-center h-100">

                <div class="card-body">

                    <i class="bi bi-file-earmark-text display-4 text-primary"></i>

                    <h5 class="mt-3">Total Reports</h5>

                    <h2 class="text-primary">
                        <?php echo $totalReports; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow border-0 text-center h-100">

                <div class="card-body">

                    <i class="bi bi-hourglass-split display-4 text-warning"></i>

                    <h5 class="mt-3">Pending</h5>

                    <h2 class="text-warning">
                        <?php echo $pending; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow border-0 text-center h-100">

                <div class="card-body">

                    <i class="bi bi-arrow-repeat display-4 text-info"></i>

                    <h5 class="mt-3">In Progress</h5>

                    <h2 class="text-info">
                        <?php echo $progress; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow border-0 text-center h-100">

                <div class="card-body">

                    <i class="bi bi-check-circle display-4 text-success"></i>

                    <h5 class="mt-3">Resolved</h5>

                    <h2 class="text-success">
                        <?php echo $resolved; ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->
    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-dark text-white">

            <h4 class="mb-0">
                Quick Actions
            </h4>

        </div>

        <div class="card-body">

            <a href="../report_issue.php" class="btn btn-primary btn-lg me-2 mb-2">
                <i class="bi bi-plus-circle"></i>
                Report New Issue
            </a>

            <a href="my_report.php" class="btn btn-success btn-lg me-2 mb-2">
                <i class="bi bi-list-check"></i>
                My Reports
            </a>

            <a href="../contact.php" class="btn btn-secondary btn-lg mb-2">
                <i class="bi bi-headset"></i>
                Contact Support
            </a>

        </div>

    </div>
        <!-- Recent Reports -->
    <div class="card shadow border-0 mt-5">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-clock-history"></i>
                Recent Reports
            </h4>
        </div>

        <div class="card-body">

            <?php if(mysqli_num_rows($recentReports) > 0){ ?>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th>ID</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php while($row=mysqli_fetch_assoc($recentReports)){ ?>

                        <tr>

                            <td>
                                <?php echo $row['issue_id']; ?>
                            </td>

                            <td>
                                <?php echo $row['category_name']; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($row['title']); ?>
                            </td>

                            <td>

                                <?php

                                if($row['status']=="Pending"){

                                    echo "<span class='badge bg-warning text-dark'>Pending</span>";

                                }

                                elseif($row['status']=="In Progress"){

                                    echo "<span class='badge bg-info'>In Progress</span>";

                                }

                                else{

                                    echo "<span class='badge bg-success'>Resolved</span>";

                                }

                                ?>

                            </td>

                            <td>

                                <?php
                                echo date("d M Y",strtotime($row['reported_at']));
                                ?>

                            </td>

                            <td>

                                <a href="view_issue.php?id=<?php echo $row['issue_id']; ?>" class="btn btn-sm btn-outline-primary">

                                    <i class="bi bi-eye"></i>
                                    View

                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

            <?php } else { ?>

                <div class="alert alert-info mb-0">

                    <i class="bi bi-info-circle"></i>

                    You haven't reported any issues yet.

                    <br><br>

                    <a href="../report_issue.php" class="btn btn-primary">

                        Report Your First Issue

                    </a>

                </div>

            <?php } ?>

        </div>

    </div>


    <!-- Notifications -->

    <div class="card shadow border-0 mt-4 mb-5">

        <div class="card-header bg-success text-white">

            <h4 class="mb-0">

                <i class="bi bi-bell-fill"></i>

                Latest Notifications

            </h4>

        </div>

        <div class="card-body">

            <ul class="list-group">

                <li class="list-group-item">

                    <i class="bi bi-check-circle-fill text-success"></i>

                    Welcome to the Citizen Issue Reporting System.

                </li>

                <li class="list-group-item">

                    <i class="bi bi-clock-fill text-warning"></i>

                    Track your issue status from the "My Reports" section.

                </li>

                <li class="list-group-item">

                    <i class="bi bi-geo-alt-fill text-primary"></i>

                    You can report issues using Google Maps location.

                </li>

                <li class="list-group-item">

                    <i class="bi bi-envelope-fill text-danger"></i>

                    The concerned department will update your issue status.

                </li>

            </ul>

        </div>
    </div>
<div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>