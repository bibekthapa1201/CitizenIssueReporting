<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: my_reports.php");
    exit();
}

$issue_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT i.*, c.category_name
        FROM issues i
        JOIN categories c ON i.category_id = c.category_id
        WHERE i.issue_id = ? AND i.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $issue_id, $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Issue not found.");
}

$issue = $result->fetch_assoc();

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h3>Issue Details</h3>
        </div>

        <div class="card-body">

            <h4><?php echo htmlspecialchars($issue['title']); ?></h4>

            <hr>

            <p><strong>Category:</strong> <?php echo htmlspecialchars($issue['category_name']); ?></p>

            <p><strong>Description:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($issue['description'])); ?></p>

            <p><strong>Location:</strong> <?php echo htmlspecialchars($issue['location']); ?></p>

            <p>
                <strong>Status:</strong>

                <?php
                if($issue['status']=="Pending"){
                    echo "<span class='badge bg-warning text-dark'>Pending</span>";
                }elseif($issue['status']=="In Progress"){
                    echo "<span class='badge bg-info'>In Progress</span>";
                }else{
                    echo "<span class='badge bg-success'>Resolved</span>";
                }
                ?>
            </p>

            <p><strong>Reported At:</strong> <?php echo $issue['reported_at']; ?></p>

            <?php if(!empty($issue['image'])){ ?>

                <hr>

                <h5>Issue Image</h5>

                <img src="../uploads/<?php echo $issue['image']; ?>"
                     class="img-fluid rounded border"
                     style="max-width:500px;">

            <?php } ?>

            <hr>

            <h5>Location on Map</h5>

            <div id="map" style="height:400px;"></div>

            <br>

            <a href="my_reports.php" class="btn btn-secondary">
                Back
            </a>

        </div>

    </div>

</div>

<script>
function initMap() {

    const location = {
        lat: <?php echo $issue['latitude']; ?>,
        lng: <?php echo $issue['longitude']; ?>
    };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: location
    });

    new google.maps.Marker({
        position: location,
        map: map
    });
}
</script>

<script async
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjiPZCxts6XWJnDA9vEkXsPkYpijHtaUU&callback=initMap">
</script>

<?php include '../includes/footer.php'; ?>