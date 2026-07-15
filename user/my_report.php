<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php';
include '../includes/navbar.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT i.*, c.category_name
        FROM issues i
        JOIN categories c ON i.category_id = c.category_id
        WHERE i.user_id = ?
        ORDER BY i.reported_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3>My Reported Issues</h3>
        </div>

        <div class="card-body">

            <?php if($result->num_rows > 0){ ?>

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-dark">

                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Reported Date</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php while($row = $result->fetch_assoc()){ ?>

                        <tr>

                            <td><?php echo $row['issue_id']; ?></td>

                            <td><?php echo htmlspecialchars($row['title']); ?></td>

                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>

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

                            <td><?php echo $row['reported_at']; ?></td>

                            <td>

                                <a href="view_issue.php?id=<?php echo $row['issue_id']; ?>"
                                   class="btn btn-sm btn-primary">
                                   View
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

            <?php } else { ?>

                <div class="alert alert-info">
                    You haven't reported any issues yet.
                </div>

            <?php } ?>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>