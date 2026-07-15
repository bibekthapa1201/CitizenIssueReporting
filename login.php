<?php
session_start();
include 'includes/db.php';

$message = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows==1){

        $user = $result->fetch_assoc();

        if(password_verify($password,$user['password'])){

            $_SESSION['user_id']=$user['user_id'];
            $_SESSION['full_name']=$user['full_name'];
            $_SESSION['role']=$user['role'];

            if($user['role']=="admin"){

                header("Location: admin/dashboard.php");

            }else{

                header("Location: user/dashboard.php");

            }

            exit();

        }else{

            $message="<div class='alert alert-danger'>Incorrect Password</div>";

        }

    }else{

        $message="<div class='alert alert-danger'>Email Not Found</div>";

    }

}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="page-bg">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="page-card">

                    <h3 class="text-center ">Login to Your Account</h3>

                    <?php
                    if(isset($_GET['success'])){
                        echo "<div class='alert alert-success'>
                        Registration Successful. Please Login.
                        </div>";
                    }

                    echo $message;
                    ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your Email"  required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input placeholder="Enter your Password" type="password" name="password" class="form-control" required>
                        </div>

                        <div class="d-grid">
    <button
        type="submit"
        name="login"
        class="btn btn-warning btn-lg fw-bold">

        Login

    </button>
</div>

<div class="text-center mt-4">

    <p class="text-white mb-0">

        Don't have an account?

        <a href="register.php"
           class="text-warning fw-bold text-decoration-none">

            Register

        </a>

    </p>

</div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>