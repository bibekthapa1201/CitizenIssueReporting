<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

 if ($_SERVER["REQUEST_METHOD"]=="POST") {


    $user_id = $_SESSION['user_id'];

    $title = $_POST['title'];

    $category_id = $_POST['category_id'];
    $department_id = $_POST['department_id'];

    $description = $_POST['description'];

    $location = $_POST['location'];

    $latitude = $_POST['latitude'];

    $longitude = $_POST['longitude'];

    $image = "";



    // Image Upload

    if (!empty($_FILES['image']['name'])) {


        $image = time() . "_" . basename($_FILES['image']['name']);

        $target = "uploads/" . $image;


        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $target
        );

    }




    // Insert Issue

    $sql = "INSERT INTO issues
(
user_id,
category_id,
department_id,
title,
description,
image,
location,
latitude,
longitude,
status
)

    VALUES
(
'$user_id',
'$category_id',
'$department_id',
'$title',
'$description',
'$image',
'$location',
'$latitude',
'$longitude',
'Pending'
)";



    if (mysqli_query($conn, $sql)) {

        echo "<div class='alert alert-success'>
                Issue submitted successfully!
              </div>";

    } else {

        echo "<div class='alert alert-danger'>
                Error: " . mysqli_error($conn) . "
              </div>";

    }

}



include 'includes/header.php';
include 'includes/navbar.php';

?>


<div class="container mt-5">

<div class="card shadow">


<div class="card-header bg-primary text-white">

<h3>Report an Issue</h3>

</div>


<div class="card-body">


<form method="POST" enctype="multipart/form-data">



<div class="mb-3">

<label>Issue Title</label>

<input
type="text"
name="title"
class="form-control"
required>

</div>



<!-- Department Dropdown -->
<div class="mb-3">

    <label class="form-label">Select Department</label>

    <select name="department_id" class="form-control" required>

        <option value="">
            Select Department
        </option>

        <?php
        $dept_query = mysqli_query($conn, "SELECT * FROM departments");

        while($dept = mysqli_fetch_assoc($dept_query)){
            echo "
            <option value='".$dept['department_id']."'>
                ".$dept['department_name']."
            </option>";
        }
        ?>

    </select>

</div>


<!-- Category Dropdown -->
<div class="mb-3">

    <label class="form-label">Category</label>

    <select
        name="category_id"
        id="category"
        class="form-control"
        required>

        <option value="">
            Select Category
        </option>

        <?php
        $cat_query = mysqli_query($conn, "SELECT * FROM categories");

        while($cat = mysqli_fetch_assoc($cat_query)){
            echo "
            <option value='".$cat['category_id']."'>
                ".$cat['category_name']."
            </option>";
        }
        ?>

    </select>

</div>


<?php

$result = mysqli_query($conn,
"SELECT * FROM categories");


while($row = mysqli_fetch_assoc($result))

{

?>


<option
value="<?php echo $row['category_id']; ?>"
data-department="<?php echo $row['department_id']; ?>">

<?php echo $row['category_name']; ?>

</option>


<?php

}

?>


</select>


</div>




<div class="mb-3">

<label>Description</label>


<textarea
name="description"
class="form-control"
rows="5"
required></textarea>


</div>




<div class="mb-3">

<label>Location</label>


<input
type="text"
name="location"
class="form-control"
required>


</div>




<div class="mb-3">

<label>Select Issue Location</label>


<div id="map" style="height:400px;"></div>


</div>



<input type="hidden" name="latitude" id="latitude">

<input type="hidden" name="longitude" id="longitude">




<div class="mb-3">

<label>Upload Image</label>


<input
type="file"
name="image"
class="form-control">


</div>




<button type="submit" name="submit" class="btn btn-primary">
Submit Issue
</button>



</form>


</div>


</div>


</div>





<script>

let map;

let marker;



function initMap(){


const defaultLocation = {

lat:27.7172,

lng:85.3240

};



map = new google.maps.Map(
document.getElementById("map"),
{
zoom:13,
center:defaultLocation
}
);



map.addListener("click",function(event){


let lat = event.latLng.lat();

let lng = event.latLng.lng();



document.getElementById("latitude").value = lat;

document.getElementById("longitude").value = lng;



if(marker){

marker.setMap(null);

}



marker = new google.maps.Marker({

position:event.latLng,

map:map

});



});


}


</script>



<script async
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjiPZCxts6XWJnDA9vEkXsPkYpijHtaUU&callback=initMap">
</script>



<?php include 'includes/footer.php'; ?>