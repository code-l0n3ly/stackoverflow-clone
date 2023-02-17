<?php
    include "includes/header.php";

    if(!isset($_GET['qid']) || $_GET['qid'] == null) {
        echo "<script>window.location.replace('404.html');</script>";
    }

    $url = 'http://localhost/stackoverflow/api/single-question.php';
    $qid = trim($_GET['qid'], " ");
    $data = [
        'qid' => $qid,
    ];
    $question = get_request_withcontext($url, $data);

    if(empty($question) || isset($question->status)) {
        echo "<script>window.location.replace('404.html');</script>";
    }
?>
<?php
    include "includes/aside.php";
    
?>
<!-- main section -->
    <main id="main" class="main">
        <div class="pagetitle row">
            <div class="pagetitle col-sm-12 col-md-10 col-lg-10">
                <h1 class="text-truncate"><?= $question->question->title ?></h1>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
                <button onclick="setUid(<?php if(isset($user)){echo $user->uid;}else{echo '0';} ?>)" class="btn btn-primary py-2" data-bs-toggle="modal" data-bs-target="#questionPostModal">Ask Question</button>
            </div>
        </div>
        <!-- end page title -->

        <!-- question area section -->
        <section class="section dashboard">
        <div class="row">
            <!-- question card -->
            <div class="col-xxl-4 col-xl-12 mb-1">
                <div class="card info-card customers-card">

                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $question->user_info->name?>
                            <span class="text-black">| <strong>Posted At: </strong><?= time_elapsed_string($question->question->asked_at) ?></span>
                        </h5>

                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column gap-2 justify-content-center">
                            <div class="card-icon rounded-circle d-flex flex-column align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <p class="text-danger small pt-1 fw-bold text-center"><?= count($question->answers) ?> Answer</p>
                            </div>
                            <div class="ps-4">
                            <a rel="noopener noreferrer">
                                <h6><?= $question->question->title ?></h6>
                            </a>
                            <p class="mt-3"><?= $question->question->description ?></p>
                            
                            </div>
                        </div>
                        <?php
                            if(empty($question->answers)) {
                        ?>
                            <div class="alert alert-danger mt-3">Answers not found!</div>
                        <?php 
                            }else {
                            $commentId = 0;
                            foreach($question->answers as $answer) {
                                $commentId++;
                        ?>
                        <!-- answer card -->
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between align-items-center p-0 px-4 py-2">
                                <b class="card-title py-0 align-items-center">
                                <i class="bi bi-person-badge-fill"></i>
                                Answered: 
                                    <?php if(isset($_SESSION['user'])){
                                        if($user->uid == $answer->user_info->uid) {
                                            echo "You";
                                        }else {
                                            echo $answer->user_info->name;
                                        }
                                    }else {
                                        echo $answer->user_info->name;
                                    } ?>
                                </b>
                                <span class="text-black"> 
                                    <i class="bi bi-stopwatch"></i>
                                    <?= time_elapsed_string($answer->answered_at) ?>
                                </span>
                                <div class="d-flex gap-2">
                                    <p class="text-secondary">Rating: <?= $answer->rating ?></p>
                                    <a onclick="postRating(<?php if(isset($_SESSION['user'])){echo $user->uid;}else{echo '0';} ?> , <?= $answer->aid ?>, <?php if(isset($_SESSION['user'])){ echo ($user->uid == $answer->uid);}else { echo 'false';} ?>)" style="cursor: pointer; " data-bs-toggle="modal" data-bs-target="#ratingModal" onMouseOver="this.style.color='gold'" onMouseOut="this.style.color='gray'"><i class="bi bi-star-fill"></i></a>
                                </div>
                            </div>
                            <div class="card-body p-0 pt-3">
                                <div id="answers" class="px-4"><?= $answer->answer ?></div>
                                <hr>
                                <!-- comment card -->
                                <div class="card m-0 p-0">
                                    <div class="card-header p-0 px-4">
                                        <h5 class="fw-bold card-title p-0 py-2">Comments:</h5>
                                    </div>
                                    <!-- comment box -->
                                    <?php
                                        foreach($answer->comments as $comment){
                                    ?>
                                    <div class="row px-4 border-bottom">
                                        <div class="col-sm-12 col-md-6 mt-2 gap-2">
                                            <span>
                                                <i class="text-success mt-2 bi bi-person-badge-fill"></i>
                                                <strong class=""><?= $comment->name ?></strong>
                                            </span>
                                            <p class="small text-muted ps-4 pt-1"><?= date('F d, Y h:i:s A', strtotime($comment->commented_at))?></p>
                                        </div>
                                        <div class="col-sm-12 col-md-6 mt-2">
                                            <p><?= $comment->comment ?></p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <!-- comment box -->
                                    <div class="card-body p-0 pb-2 px-4">
                                        <!-- comment form -->
                                        <form onsubmit="commentFormHandler(event, <?php if(isset($_SESSION['user'])){echo $user->uid;}else{echo '0';} ?>, <?= $answer->aid ?> , <?= $commentId ?>)" class="row mt-2 needs-validation" novalidate>
                                            <div class="col-sm-12 col-md-10 align-items-center justify-content-center">
                                                <div class="input-group has-validation">
                                                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-chat-left-dots-fill"></i></span>
                                                    <input type="text" id="comment<?=$commentId?>"  name="comment<?=$commentId?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end mt-2">
                                                <button class="btn btn-primary px-3" type="submit">Comment</button>
                                            </div>
                                        </form>
                                        <!-- end comment form -->
                                    </div>
                                </div>
                                <!-- comment card -->
                            </div>
                        </div>
                        
                        <?php } } ?>
                        <!-- end answer card -->
                    </div>

                    <!-- write answer section -->
                    <div class="card">
                        <div class="card-header p-0 px-4">
                            <div class="card-title">Write Answer:</div>
                        </div>
                        <div class="card-body px-4 mt-2">
                            <form method="post"  method="post" class="row g-3 needs-validation" novalidate>
                                <input type="hidden" id="uid" name="uid" value="<?php if(isset($_SESSION['user'])){echo $user->uid;}else{echo '0';} ?>">
                                <input type="hidden" id="qid" name="qid" value="<?= $question->question->qid ?>">
                                <div class="col-12">
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-chat-left-text-fill"></i></span>
                                        <textarea type="text" name="answer" id="answer"  class="form-control" required></textarea>
                                        <div class="invalid-feedback">Please enter your answer!</div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end mt-2">
                                    <button id="answer-btn" class="btn btn-primary px-4" type="submit">Answer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--end write answer section -->
                </div>
            </div>
        </div>
        </section>
  </main>

  <!-- rating modal -->
  <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      <form method="post" id="rating-form" class="needs-validation">
        <div class="modal-body p-0">
          <div class="card m-0">
            <div class="card-body">
              <h5 class="card-title">Leave Your Review</h5>
                <div class="col-sm-12 col-md-12 align-items-center justify-content-center">
                  <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-star-fill"></i></span>
                      <input type="number" max="5" min="1" id="rating"  name="rating" class="form-control" required>
                      <div class="invalid-feedback">Please enter your rating.</div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="rating-submit-btn"  type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end rating modal -->
  
  <!-- end main section -->
     <!-- question modal -->
     <div class="modal fade" id="questionPostModal" tabindex="-1" aria-labelledby="questionPostModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="rting-form" class="needs-validation">
          <div class="modal-body p-0">
            <div class="card m-0">
              <div class="card-body">
                <h5 class="card-title">Post a new Question!</h5>
                  <div class="col-sm-12 col-md-12 align-items-center justify-content-center">
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-card-heading"></i></span>
                      <input type="text" id="question"  name="question" placeholder="question title" class="form-control" required>
                    <div class="invalid-feedback">Please enter question title.</div>
                  </div>
                  <div class="mt-2 col-sm-12 col-md-12 align-items-center justify-content-center">
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-patch-question-fill"></i></span>
                      <textarea type="text" id="description"  name="description" class="form-control" required> question description </textarea>
                    <div class="invalid-feedback">Please enter question description.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="askquestion-submit-btn"  type="submit" class="btn btn-primary">Post</button>
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
    var postData = {};
    var uid;
    var aid;

    function postRating(uid, aid, isOwner) {
        postData.uid = uid;
        postData.aid = aid;
        postData.isOwner = isOwner;
        console.log(postData.isOwner)
    }
    
    //post rating
    $("#rating-submit-btn").click(function(event) {
        event.preventDefault();

        const data = {
            uid: postData.uid,
            aid: postData.aid,
            rating: $("#rating").val(),
            isOwner: postData.isOwner,
        }

        if(data.uid == 0) {
            swal("Error", "Please login first!", "error");
            $('#ratingModal').modal('toggle'); 
        }else if(data.rating == null) {
            swal("Error", "Please enter rating!", "error");
        }else if(data.isOwner) {
            swal("Error", "You can't give on your answer!", "error");
        }else if(data.rating > 5 || data.rating <= 0){
            swal("Error", "Rating showld be 1-5 numbers!", "error");
        }else {
            $.ajax({
                url: "http://localhost/stackoverflow/api/post-rating.php",
                method: "POST",
                data: data,
                success: function(data) {
                    if(data.status) {
                        swal("Success", data.message, "success");
                        window.location.reload();
                    }else {
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(error) {
                    swal("Error!", error.statusText, "error");
                }
            })
        }
    });
    
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
        }else if(checkIsAllWhiteSpace(question) || checkIsAllWhiteSpace(description)){
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
                        },2000);
                    }else {
                        swal("Error!", data.message, "error");
                    }
                }
            })
        }
    })

    function checkIsAllWhiteSpace(data) { 
        return (data.trim().length === 0);
    }

    function commentHandler(uid, aid, inputId) {
        console.log(this);
        const data = {
            uid: uid,
            aid: aid,
            comment: $(`#comment${inputId}`).val(),
        }
        console.log(data);
        if(data.uid == 0) {
            swal("Error!", "Please login first!", "error");
        }else if(data.comment == "") {

        }else if(checkIsAllWhiteSpace(data.comment)) {

        }else {

        }
    }

    function commentFormHandler(event, uid, aid, inputId) {
        event.preventDefault();

        const data = {
            uid, uid,
            aid: aid,
            comment: $(`#comment${inputId}`).val(),
        }
        if(data.uid == 0) {
            swal("Authentication", "Please login first!", "error");
            setTimeout(function(){
                window.location.replace('http://localhost/stackoverflow/login.php');
            }, 1500);
        }else if(data.comment == '' || checkIsAllWhiteSpace(data.comment)) {
            swal("Required", "Please enter your comment!", "error");
        }else {
            $.ajax({
                url: "http://localhost/stackoverflow/api/post-comment.php",
                method: "POST",
                data: data,
                success: function(data) {
                    if(data.status) {
                        window.location.reload();
                    }else {
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(err) {
                    swal("Error!", err.statusText, "error");
                }
            })
        }
    }

    $("#answer-btn").click(function(event) {
        event.preventDefault();
        const uid = $("#uid").val();
        const qid = $("#qid").val();
        const answer = $("#answer").val();
        if(uid == 0){
            swal("Error!", "Please login first!", "error");
        }else if(answer == '') {
            swal("Error!", "Please enter your answer!", "error");
        }else if(checkIsAllWhiteSpace(answer)) {
            swal("Error!", "Please enter your answer!", "error");
        }else {
            const data = {
                'uid': uid,
                'qid': qid,
                'answer': answer,
            }
            console.log(data);
            $.ajax({
                url: "http://localhost/stackoverflow/api/post-answer.php",
                method: "POST",
                data: data,
                success: function(data) {
                    if(data.status) {
                        swal("Answered!", data.message, "success");
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }else {
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(error) {
                    swal("Error!", "Something went wrong!", "error");
                }
            })
        }
    });
</script>

