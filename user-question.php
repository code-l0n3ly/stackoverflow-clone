<?php
    include "includes/header.php";
    if(!isset($_SESSION['user'])){
        echo "<script>window.location.replace('http://localhost/stackoverflow/')</script>";
    }
    $url = "http://localhost/stackoverflow/api/user-questions.php";
    $data = [
        'uid' => $_SESSION['user']->uid,
    ];

    if(isset($_GET['question'])) {
        $pattern = $_GET['question'];
    }else{
        $pattern = "";
    }

    $questions = get_request_withcontext($url, $data);
    if(!empty($questions) && is_countable($questions)){
        $questions = array_filter($questions, function($question, $key) {
            global $pattern;
            return (preg_match('/'.strtolower($pattern).'/', strtolower($question->title))) || (preg_match('/'.strtolower($pattern).'/', strtolower($question->description)));
        }, ARRAY_FILTER_USE_BOTH);
    }

    if(is_countable($questions) > 0) {
        uasort($questions, 'sort_questions_by_answer');

        // Determine the number of rows per page
        $rows_per_page = 10;
        // Determine the total number of rows
        $total_rows = count($questions);
        // Determine the number of pages
        $num_pages = ceil($total_rows / $rows_per_page);
        // Determine the current page number
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        // Calculate the starting row
        $start = ($page - 1) * $rows_per_page;
        // Create a new array of data for the current page
        $current_page_data = array_slice($questions, $start, $rows_per_page);
    }
?>
<?php
    include "includes/aside.php";
?>
    <!-- main section -->
    <main id="main" class="main">
        <!-- page title -->
        <div class="pagetitle">
            <h1>Qustions</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Your Qustions</li>
                </ol>
            </nav>
        </div>
        <!-- end page title -->

        <!-- question area section -->
        <section class="section dashboard">
            <div class="row">
                <?php
                     if(empty($questions) || !is_countable($questions)) {
                ?>
                    <div class="alert alert-danger">
                        Questions not found!
                    </div>
                <?php
                    }else {
                    if(!empty($questions) && is_countable($questions)){
                    foreach ($current_page_data as $question) {
                ?>
                <div class="col-xxl-4 col-xl-12 mb-1">
                    <!-- question card -->
                    <div class="card info-card customers-card mb-1">
                        <?php 
                            if($isLogin && $user->uid == $question->uid) {
                        ?>
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                <h6>Action</h6>
                                </li>
                                <li><a class="dropdown-item d-flex gap-2" href="update-question.php?qid=<?=$question->qid?>" ><i class="bi bi-pencil-square"></i> Edit</a></li>
                                <li><a class="dropdown-item d-flex gap-2" onclick="deleteQuestion(<?=$question->qid ?>)" href="#"><i class="bi bi-trash3"></i> Delete</a></li>
                            </ul>
                        </div>
                        <?php } ?>
                        <div class="card-body">
                        <h5 class="card-title">
                            Asked: <?php if(isset($_SESSION['user']) && $_SESSION['user']->uid == $question->uid){echo 'You';}else{ echo $question->user_info->name; } ?> 
                            <span class="text-black"> | Posted At: <?= time_elapsed_string($question->asked_at) ?></span>
                        </h5>

                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column gap-2 justify-content-center">
                            <div class="card-icon rounded-circle d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-patch-question-fill"></i>
                            </div>
                            <p class="text-danger small pt-1 fw-bold text-center"><?= $question->answers ?> Answer</p>
                            </div>
                            <div class="ps-4">
                            <a href="answer.php?qid=<?= $question->qid?>" rel="noopener noreferrer">
                                <h6><?= $question->title ?></h6>
                            </a>
                            <p class="mt-3"><?= $question->description ?></p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <?php }}} ?>
            </div>
            <!-- pagination -->
            <?php
                if(!empty($questions) && is_countable($questions)){
            ?>
            <div class="col-12 d-flex justify-content-end">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href='index.php?page=<?php if($page > 1){echo ($page - 1);}else{echo $page;}?>' >Previous</a></li>
                        <?php
                            for ($i = 1; $i <= $num_pages; $i++) {
                        ?>
                        <li class="page-item <?php if($page == $i){echo 'active';} ?>"><a class="page-link" href="index.php?page=<?= $i?>"><?=$i?></a></li>
                        <?php
                            } 
                        ?>
                        <li class="page-item"><a class="page-link" href='index.php?page=<?php if($page < $num_pages){echo ($page + 1);}else{echo $page;}?>'>Next</a></li>
                    </ul>
                
                </nav>
            </div>
            <?php } ?>
        </section>
    </main>
    <!-- end main section -->

<?php
    include "includes/footer.php";
?>
<script>
    var uid;
    function setUid(id) {
        uid = id;
    }
    function getUid() {
        return uid;
    }

    $("#askquestion-submit-btn").click(function(event) {
        event.preventDefault();
        const question = $("#question").val();
        const description = $("#description").val();
        
        const uid = getUid();
       
        if(uid == 0) {
            swal("Error!", "Please login first!", "error");
            $("#questionPostModal").modal('toggle');
            setTimeout(function(){
                window.location.replace('http://localhost/stackoverflow/login.php');
            },1000);
        }
        else if(question =="" || description == "") {
            swal("Error!", "Please fillup all information!", "error");
        }else if(checkIsAllWhiteSpace(question, description)){
            swal("Error!", "Please fillup all information!", "error");
        }else {
            $.ajax({
                url: "http://localhost/stackoverflow/api/post-question.php",
                method: "POST",
                data: {
                    uid: uid,
                    question: question,
                    description: description 
                },
                success: function(data) {
                    if(data.status) {
                        swal("Success", data.message, "success");
                        setTimeout(function() {
                            window.location.reload();
                        },1000);

                    }else {
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(error) {
                    swal("Error!", "Something went wrong!", "error");
                }
            })
        }
    })

    function checkIsAllWhiteSpace(question, description, ) { 
        return (question.trim().length === 0 || description.trim().length === 0);
    }

    function deleteQuestion(qid) {
        $.ajax({
            url: "http://localhost/stackoverflow/api/delete-question.php",
            method: "POST",
            data: {
                qid: qid
            },
            success: function(data) {
                if(data.status) {
                    swal("Deleted!", data.message, "success");
                    setTimeout(function(){
                        window.location.reload();
                    },1000);
                }else {
                    swal("Deleted!", data.message, "error");
                }
            },
            error: function(error) {
                swal("Error!", "Something wen wrong!", "error");
            }
        })
    }

    $("#search-btn").click(function(){
        const searchKey = $("#search-key").val();
        window.location.replace('http://localhost/stackoverflow/user-question.php?question='+searchKey);
    })


</script>
