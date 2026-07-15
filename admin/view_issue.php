<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: ../login.php");
    exit();
}


include '../includes/db.php';


if(!isset($_GET['id']))
{
    header("Location: dashboard.php");
    exit();
}


$id = $_GET['id'];



$query = "

SELECT 

issues.*,

categories.category_name,

departments.department_name,

users.full_name


FROM issues


LEFT JOIN categories

ON issues.category_id = categories.category_id


LEFT JOIN departments

ON categories.department_id = departments.department_id


LEFT JOIN users

ON issues.user_id = users.user_id



WHERE issues.issue_id='$id'

";


$result = mysqli_query($conn,$query);


$issue = mysqli_fetch_assoc($result);



include '../includes/header.php';
include '../includes/navbar.php';


?>



<div class="container mt-5">


<div class="card shadow">


<div class="card-header bg-primary text-white">

<h3>Issue Details</h3>

</div>



<div class="card-body">


<h4>
<?php echo $issue['title']; ?>
</h4>


<hr>


<p>
<strong>Reported By:</strong>

<?php echo $issue['full_name']; ?>

</p>



<p>
<strong>Category:</strong>

<?php echo $issue['category_name']; ?>

</p>



<p>
<strong>Department:</strong>

<?php echo $issue['department_name']; ?>

</p>



<p>
<strong>Description:</strong>

<br>

<?php echo $issue['description']; ?>

</p>



<p>
<strong>Status:</strong>

<span class="badge bg-warning">

<?php echo $issue['status']; ?>

</span>

</p>



<p>
<strong>Location:</strong>

<?php echo $issue['location']; ?>

</p>



<?php

if(!empty($issue['image']))
{

?>

<img src="../uploads/<?php echo $issue['image']; ?>"
class="img-thumbnail"
width="300">


<?php

}

?>



<hr>


<h5>Map Location</h5>


<a target="_blank"
class="btn btn-primary"
href="https://www.google.com/maps?q=<?php echo $issue['latitude']; ?>,<?php echo $issue['longitude']; ?>">

Open Google Map

</a>



<br><br>


<a href="dashboard.php"
class="btn btn-secondary">

Back

</a>


</div>


</div>


</div>



<?php

include '../includes/footer.php';

?>