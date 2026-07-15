<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';


if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}


$id = $_GET['id'];


// Fetch issue details first

$result = mysqli_query($conn, 
    "SELECT * FROM issues WHERE issue_id='$id'"
);

$issue = mysqli_fetch_assoc($result);



if (!$issue) {
    echo "Issue not found";
    exit();
}



// Update status

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $status = $_POST['status'];

    $remarks = $_POST['remarks'];



    $sql = "UPDATE issues 
            SET status='$status',
                remarks='$remarks'
            WHERE issue_id='$id'";



    if (mysqli_query($conn, $sql)) {

        header("Location: dashboard.php");
        exit();

    } else {

        echo "Error: " . mysqli_error($conn);

    }

}



include '../includes/header.php';
include '../includes/navbar.php';

?>


<div class="container mt-5">


    <div class="card shadow">


        <div class="card-header bg-primary text-white">

            <h3>
                Update Issue Status
            </h3>

        </div>



        <div class="card-body">


            <h5>
                <?php echo $issue['title']; ?>
            </h5>


            <p>
                <?php echo $issue['description']; ?>
            </p>



            <form method="POST">


                <div class="mb-3">


                    <label>
                        Status
                    </label>


                    <select name="status" class="form-control">


                        <option value="Pending"
                        <?php if($issue['status']=="Pending") echo "selected"; ?>>
                            Pending
                        </option>



                        <option value="In Progress"
                        <?php if($issue['status']=="In Progress") echo "selected"; ?>>
                            In Progress
                        </option>



                        <option value="Resolved"
                        <?php if($issue['status']=="Resolved") echo "selected"; ?>>
                            Resolved
                        </option>


                    </select>


                </div>




                <div class="mb-3">


                    <label>
                        Admin Remarks / Solution
                    </label>


                    <textarea name="remarks"
                              class="form-control"
                              rows="4"><?php echo $issue['remarks'] ?? ''; ?></textarea>


                </div>




                <button type="submit" class="btn btn-success">

                    Update Status

                </button>



                <a href="dashboard.php" class="btn btn-secondary">

                    Back

                </a>


            </form>



        </div>


    </div>


</div>



<?php include '../includes/footer.php'; ?>