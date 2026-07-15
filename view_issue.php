<?php
include 'config/db.php';

$sql = "SELECT id, title, description, latitude, longitude FROM issues";
$result = mysqli_query($conn, $sql);

$issues = [];

while ($row = mysqli_fetch_assoc($result)) {
    $issues[] = $row;
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container mt-4">
    <h2>Reported Issues</h2>
    <div id="map" style="height:600px;"></div>
</div>

<script>
const issues = <?php echo json_encode($issues); ?>;

function initMap() {

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: { lat: 27.7172, lng: 85.3240 }
    });

    issues.forEach(issue => {

        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(issue.latitude),
                lng: parseFloat(issue.longitude)
            },
            map: map,
            title: issue.title
        });

        const infoWindow = new google.maps.InfoWindow({
            content:
                "<h5>" + issue.title + "</h5>" +
                "<p>" + issue.description + "</p>"
        });

        marker.addListener("click", () => {
            infoWindow.open(map, marker);
        });

    });
}
</script>

<script async
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjiPZCxts6XWJnDA9vEkXsPkYpijHtaUU&callback=initMap">
</script>

<?php include 'includes/footer.php'; ?>