<?php

include 'app/views/shares/header.php'; ?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <?php
                        if (isset($errors) && count($errors) > 0) {
                            echo "<div class='alert alert-danger'><ul class='mb-0'>";
                            foreach ($errors as $err) {
                                echo "<li>" . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . "</li>";
                            }
                            echo "</ul></div>";
                        }
                        ?>
                        <form class="user" action="/project-esports/auth/save" method="post">
                            <div class="form-group row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user"
                                        id="username" name="username" placeholder="Username" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control form-control-user"
                                        id="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                        id="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                        id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-icon-split p-3 w-100">
                                    Register
                                </button>
                            </div>
                        </form>
                        <div>
                            <p class="mb-2">Already have an account?
                                <a href="/project-esports/auth/login" class="text-white-50 fw-bold">Login</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'app/views/shares/footer.php'; ?>