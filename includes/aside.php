<?php
    if($isLogin) {
?>
    <!-- sidebar section loggedin user-->
    <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-heading">Pages</li>
        <!-- nav profile -->
        <li class="nav-item sidebar-nav">
        <a class="nav-link collapsed" href="index.php">
            <i class="bi bi-person"></i>
            <span>Home</span>
        </a>
        </li>
        <!-- end nav profile -->
        <!-- nav profile -->
        <li class="nav-item sidebar-nav">
        <a class="nav-link collapsed" href="profile.php">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
        </li>
        <!-- end nav profile -->
        <li class="nav-item">
        <a class="nav-link collapsed" href="user-question.php">
            <i class="bi bi-question-circle"></i>
            <span>Questions</span>
        </a>
        </li>
        <!-- nav answer -->
        <li class="nav-item">
        <a class="nav-link collapsed" href="user-answer.php">
            <i class="bi bi-question-circle"></i>
            <span>Answers</span>
        </a>
        </li>
        <!-- end nav answer -->
    </ul>
    </aside>
    <!-- end sidebar section -->
<?php }else { ?>
    <!-- sidebar section guest user-->
    <aside class="sidebar" id="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="dropdown" href="index.html">
            <i class="bi bi-funnel"></i>
            <span>Filter</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
                <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
        </li>
        <li class="nav-item mt-3 bg-primary rounded text-light py-2">
            <h4 class="text-center fw-bold">Join with Our Community</h4>
        </li>
        <li class="nav-item">
            <img class="rounded" src="assets/img/download.jpg" width="100%" alt="">
        </li>
        </ul>
    </aside>
<?php } ?>
