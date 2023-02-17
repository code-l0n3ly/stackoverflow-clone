<?php
    include "includes/header.php";
    if(!isset($_SESSION['user'])) {
        echo "<script>window.location.replace('http://localhost/stackoverflow/')</script>";
    }

    $url = 'http://localhost/stackoverflow/api/profile-stastics.php';
    $data = [
        'uid' => $user->uid,
    ];
    $stastics = get_request_withcontext($url, $data);
?>
<?php
    include "includes/aside.php";
?>
    <main id="main" class="main">
        <!-- page title -->
        <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
        </div>
        <!-- end page title -->
        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <h1><i class="bi bi-person-circle"></i></h1>
                        <h2><?= $user->name ?></h2>
                        <h3>Welcome Back!</h3>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Questions</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-qnswers">Answers</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-rating">Ratings</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <div class="row">
                                        <div class="col-sm col-md-5">
                                            <div class="card bg-primary">
                                                <div class="card-body text-white">
                                                    <h5 class="card-title text-white p-3">Quesstions: <?= $stastics->total_question?></h5>
                                                    <div class="d-flex fs-1 align-items-center justify-content-center">
                                                        <i class="bi bi-patch-question-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-qnswers">
                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                        <div class="row">
                                            <div class="col-sm-5 col-md-5">
                                                <div class="card bg-primary">
                                                    <div class="card-body text-white">
                                                        <h5 class="card-title text-white p-3">Answers: <?= $stastics->total_answer?></h5>
                                                        <div class="d-flex fs-1 align-items-center justify-content-center">
                                                            <i class="bi bi-chat-left-text-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-rating">
                                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-5">
                                                <div class="card bg-primary">
                                                    <div class="card-body text-white">
                                                        <h5 class="card-title text-white p-3">Ratings: <?= $stastics->ratings?></h5>
                                                        <div class="d-flex fs-1 align-items-center justify-content-center">
                                                            <i class="bi bi-star-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Bordered Tabs -->
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
<?php
    include "includes/footer.php";
?>