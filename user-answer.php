<?php
    include "includes/header.php";
    if(!isset($_SESSION['user'])){
        echo "<script>window.location.replace('http://localhost/stackoverflow/')</script>";
    }
    $url = "http://localhost/stackoverflow/api/user-answers.php";
    $data = [
        'uid' => $_SESSION['user']->uid,
    ];

    if(isset($_GET['answer'])) {
        $pattern = $_GET['answer'];
    }else{
        $pattern = "";
    }
    
    $answers = get_request_withcontext($url, $data);
    if(!empty($answers) && is_countable($answers)) {
        $answers = array_filter($answers, function($answer, $key) {
            global $pattern;
            return preg_match('/^'.strtolower($pattern).'/', strtolower($answer->answer));
        }, ARRAY_FILTER_USE_BOTH);
    }


    if(is_countable($answers) > 0 && $answers != null) {

        // Determine the number of rows per page
        $rows_per_page = 10;
        // Determine the total number of rows
        $total_rows = count($answers);
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
        $current_page_data = array_slice($answers, $start, $rows_per_page);
    }
?>
<?php
    include "includes/aside.php";
?>
    <!-- main section -->
    <main id="main" class="main">
        <!-- page title -->
        <div class="pagetitle">
            <h1>Answers</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Your Answers</li>
                </ol>
            </nav>
        </div>
        <!-- end page title -->

        <!-- question area section -->
        <section class="section dashboard">
            <div class="row">
                <?php
                    if(empty($answers) || !is_countable($answers)) {
                ?>
                    <div class="alert alert-danger">
                        Answers not found!
                    </div>
                <?php
                    }else {
                    if(!empty($current_page_data)){
                        foreach ($current_page_data as $answer) {
                ?>
                <div class="col-xxl-4 col-xl-12 mb-1">
                    <!-- question card -->
                    <div class="card info-card customers-card mb-1">
                        <?php 
                            if($isLogin && $user->uid == $answer->uid) {
                        ?>
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                <h6>Action</h6>
                                </li>
                                <li><a class="dropdown-item d-flex gap-2" href="update-answer.php?aid=<?=$answer->aid ?>" ><i class="bi bi-pencil-square"></i> Edit</a></li>
                                <li><a class="dropdown-item d-flex gap-2" onclick="deleteQuestion(<?=$answer->aid ?>)" href="#"><i class="bi bi-trash3"></i> Delete</a></li>
                            </ul>
                        </div>
                        <?php } ?>
                        <div class="card-body">
                        <h5 class="card-title">
                            Asked: <?php if(isset($_SESSION['user']) && $_SESSION['user']->uid == $answer->question->uid){echo 'You';}else{ echo $answer->question->user_info->name; } ?> 
                            <span class="text-black"> | Answered At: <?= time_elapsed_string($answer->answered_at) ?></span>
                        </h5>

                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column gap-2 justify-content-center">
                            <div class="card-icon rounded-circle d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-patch-question-fill"></i>
                            </div>
                            <p class="text-danger small pt-1 fw-bold text-center"><?= $answer->rating ?> Rating</p>
                            </div>
                            <div class="ps-4">
                            <a href="answer.php?qid=<?= $answer->qid?>" rel="noopener noreferrer">
                                <h6><?= $answer->question->title ?></h6>
                            </a>
                            <p class="mt-3"><?= $answer->answer ?></p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <?php }}} ?>
            </div>
            <!-- pagination -->
            <?php
                if(!empty($answers) && is_countable($answers)){
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
  <!-- question modal -->
  <div class="modal fade" id="editAnswerModal" tabindex="-1" aria-labelledby="editAnswerModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="rting-form" class="needs-validation">
          <div class="modal-body p-0">
            <div class="card m-0">
              <div class="card-body">
                <h5 class="card-title">Post a new Question!</h5>
                  <div class="mt-2 col-sm-12 col-md-12 align-items-center justify-content-center">
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-patch-question-fill"></i></span>
                      <textarea type="text" id="answer"  name="answer" class="form-control" required> question description </textarea>
                    <div class="invalid-feedback">Please enter answer.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="question-update-btn"  type="submit" class="btn btn-primary">Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end question modal -->


<?php
    include "includes/footer.php";
?>
<script>
    $(document).ready(function(){
        var uid;
        function setUid(id) {
            uid = id;
        }
        function getUid() {
            return uid;
        }

        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var data = button.data('data');
            console.log(data);
            var modal = $(this);

            // Set the modal content
            modal.find('.modal-body').html(data);
        });

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

        


        $("#search-btn").click(function(){
            const searchKey = $("#search-key").val();
            window.location.replace('http://localhost/stackoverflow/user-answer.php?answer='+searchKey);
        })

    });

    function deleteQuestion(aid) {
        $.ajax({
            url: "http://localhost/stackoverflow/api/delete-answer.php",
            method: "POST",
            data: {
                aid: aid
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

    function editAnswer(aid, answer) {
        console.log(aid);
        $("#editAnswerModal").modal('show');
    }
    
</script>
