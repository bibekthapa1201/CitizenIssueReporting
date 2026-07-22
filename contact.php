<?php
include 'includes/header.php';
include 'includes/navbar.php';
?>

<section class="py-5 mt-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Contact Us</h2>
            <p class="text-muted">
                Have questions or need assistance? Get in touch with us.
            </p>
        </div>

        <div class="row g-4">

            <!-- Contact Information -->
            <div class="col-lg-5">
                <div class="card shadow border-0 h-100">
                    <div class="card-body">
                        <h4 class="mb-4">Contact Information</h4>

                        <p><strong>Office:</strong><br>
                        Citizen Issue Reporting Office</p>

                        <p><strong>Address:</strong><br>
                        Bharatpur, Chitwan, Nepal</p>

                        <p><strong>Email:</strong><br>
                        support@cir.gov.np</p>

                        <p><strong>Phone:</strong><br>
                        +977-56-XXXXXX</p>

                        <p><strong>Office Hours:</strong><br>
                        Sunday – Friday<br>
                        10:00 AM – 5:00 PM</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h4 class="mb-4">Send a Message</h4>

                        <form action="" method="POST">

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control" name="subject" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" rows="5" name="message" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">
                                Send Message
                            </button>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<?php
include 'includes/footer.php';
?>