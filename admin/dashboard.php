<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

// Dashboard Statistics
$totalIssues = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM issues"))['total'];

$pendingIssues = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM issues WHERE status='Pending'")
)['total'];

$progressIssues = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM issues WHERE status='In Progress'")
)['total'];

$resolvedIssues = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM issues WHERE status='Resolved'")
)['total'];

$totalUsers = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];

// Search & Filter
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$status = isset($_GET['status']) ? trim($_GET['status']) : "";

$sql = "SELECT issues.*, categories.category_name, departments.department_name
        FROM issues
        JOIN categories
            ON issues.category_id = categories.category_id
        JOIN departments
            ON issues.department_id = departments.department_id
        WHERE 1=1";

if($search != ""){
    $search = mysqli_real_escape_string($conn,$search);
    $sql .= " AND (issues.title LIKE '%$search%' OR issues.location LIKE '%$search%')";
}

if($status != ""){
    $status = mysqli_real_escape_string($conn,$status);
    $sql .= " AND issues.status='$status'";
}

$sql .= " ORDER BY issues.reported_at DESC";

$result = mysqli_query($conn,$sql);
?>
<div class="container" style="padding-top: 90px;">

<div class="alert alert-primary shadow-sm mt-10">
            <h2>Admin Dashboard</h2>
        <p>Welcome, <strong><?php echo $_SESSION['full_name']; ?></strong></p>
    </div>

    <!-- Dashboard Statistics -->

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body text-center">
                    <h5>Total Issues</h5>
                    <h2><?php echo $totalIssues; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body text-center">
                    <h5>Pending</h5>
                    <h2><?php echo $pendingIssues; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white shadow">
                <div class="card-body text-center">
                    <h5>In Progress</h5>
                    <h2><?php echo $progressIssues; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body text-center">
                    <h5>Resolved</h5>
                    <h2><?php echo $resolvedIssues; ?></h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card bg-dark text-white shadow">

                <div class="card-body text-center">

                    <h5>Total Users</h5>

                    <h2><?php echo $totalUsers; ?></h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Search & Filter -->

    <div class="card shadow mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-5">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search title or location"
                            value="<?php echo htmlspecialchars($search); ?>">

                    </div>

                    <div class="col-md-4">

                        <select name="status" class="form-control">

                            <option value="">All Status</option>

                            <option value="Pending"
                                <?php if($status=="Pending") echo "selected"; ?>>
                                Pending
                            </option>

                            <option value="In Progress"
                                <?php if($status=="In Progress") echo "selected"; ?>>
                                In Progress
                            </option>

                            <option value="Resolved"
                                <?php if($status=="Resolved") echo "selected"; ?>>
                                Resolved
                            </option>

                        </select>

                    </div>

                    <div class="col-md-3">

                        <button class="btn btn-primary w-100">
                            Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Reported Issues -->

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            <h4>Reported Issues</h4>

        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover table-striped">

                <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Location</th>
                    <th>Reported At</th>
                    <th>Action</th>

                </tr>

                </thead>

                <tbody>
                    <?php

if(mysqli_num_rows($result) > 0)
{

    while($row = mysqli_fetch_assoc($result))
    {

?>

<tr>

    <td>
        <?php echo $row['issue_id']; ?>
    </td>


    <td>
        <?php echo htmlspecialchars($row['title']); ?>
    </td>


    <td>
        <?php echo htmlspecialchars($row['category_name']); ?>
    </td>


    <td>
        <?php echo htmlspecialchars($row['department_name'] ?? 'N/A'); ?>
    </td>


    <td>

        <?php

        if($row['status']=="Pending")
        {
            echo '<span class="badge bg-warning text-dark">
                    Pending
                  </span>';
        }

        elseif($row['status']=="In Progress")
        {
            echo '<span class="badge bg-info">
                    In Progress
                  </span>';
        }

        else
        {
            echo '<span class="badge bg-success">
                    Resolved
                  </span>';
        }

        ?>

    </td>


    <td>

        <?php

        if(!empty($row['image']))
        {

        ?>

            <img src="../uploads/<?php echo $row['image']; ?>"
                 width="80"
                 height="60"
                 class="img-thumbnail">

        <?php

        }
        else
        {
            echo "No Image";
        }

        ?>

    </td>


    <td>

        <a href="https://www.google.com/maps?q=<?php echo $row['latitude']; ?>,<?php echo $row['longitude']; ?>"
           target="_blank"
           class="btn btn-sm btn-primary">

           View Map

        </a>

    </td>


    <td>

        <?php echo $row['created_at']; ?>

    </td>


    <td>


        <a href="view_issue.php?id=<?php echo $row['issue_id']; ?>"
           class="btn btn-sm btn-info mb-1">

           View

        </a>


        <a href="update_status.php?id=<?php echo $row['issue_id']; ?>"
           class="btn btn-sm btn-warning mb-1">

           Update

        </a>


        <a href="delete_issue.php?id=<?php echo $row['issue_id']; ?>"
           onclick="return confirm('Are you sure you want to delete this issue?');"
           class="btn btn-sm btn-danger">

           Delete

        </a>


    </td>


</tr>


<?php

    }

}

else
{

?>

<tr>

<td colspan="9" class="text-center text-danger">

No issues found

</td>

</tr>


<?php

}

?>

</tbody>

</table>

</div>

</div>


</div>


<?php

include '../includes/footer.php';

?>