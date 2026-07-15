<?php
include 'includes/db.php';

$message = "";

if (isset($_POST['register'])) {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        $message = "<div class='alert alert-danger'>Passwords do not match.</div>";
    } else {

        // Check if email already exists
        $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $message = "<div class='alert alert-danger'>Email already exists.</div>";

        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users(full_name,email,password,phone) VALUES(?,?,?,?)");
            $stmt->bind_param("ssss", $full_name, $email, $hashedPassword, $phone);

            if ($stmt->execute()) {

                header("Location: login.php?success=1");
                exit();

            } else {

                $message = "<div class='alert alert-danger'>Registration Failed.</div>";

            }
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="page-bg">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-6 col-md-8">

                <div class="page-card">

                    <h2 class="text-center text-white fw-bold mb-4">
                        User Registration
                    </h2>

                    <?= $message; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input
                                type="text"
                                name="full_name"
                                class="form-control"
                                placeholder="Enter your full name"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter your email"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                placeholder="Enter your phone number">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Create a password"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm Password</label>
                            <input
                                type="password"
                                name="confirm_password"
                                class="form-control"
                                placeholder="Confirm your password"
                                required>
                        </div>

                        <div class="d-grid">
                            <button
                                type="submit"
                                name="register"
                                class="btn btn-warning btn-lg fw-bold">
                                Register
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-white mb-0">
                                Already have an account?
                                <a href="login.php"
                                   class="text-warning fw-bold text-decoration-none">
                                    Login
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