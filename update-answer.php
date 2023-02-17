<?php
    include "includes/header.php";
    if(!isset($_GET['aid']) || $_GET['aid'] == null) {
        echo "<script>window.location.replace('http://localhost/stackoverflow/')</script>";
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
            <li class="breadcrumb-item active">Update Qustions</li>
            </ol>
        </nav>
    </div>
    <!-- end page title -->
    <section>
        <div class="row">
            <div class="col-12">
                <form onsubmit="editFormHandler(event)" class="card needs-validation" novalidate>
                    <input type="hidden" name="aid" id="aid" value="<?= $_GET['aid'] ?>">
                    <div class="card-header">
                        <h2 class="card-title fs-3 ">Edit Your Answer!</h2>
                    </div>
                    <div class="card-body py-3">
                        <div class="mt-2 col-sm-12 col-md-12 align-items-center justify-content-center">
                            <div class="form-label">
                                <label for="answer">Answer</label>
                            </div>
                            <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-patch-question-fill"></i></span>
                            <textarea type="text" id="answer"  name="answer" class="form-control py-3" placeholder="anter answer" required> </textarea>
                            <div class="invalid-feedback">Please enter answer.</div>
                        </div>
                        <div class="mt-3 col-12 d-flex justify-content-end">
                            <button class="btn btn-primary px-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<!-- end main section -->

<?php
    include "includes/footer.php";
?>

<script>
    setFormData();
    function setFormData(){
        $(document).ready(function() {
            $.ajax({
                url: "http://localhost/stackoverflow/api/answer.php",
                method: "POST",
                data: {
                    aid: <?= $_GET['aid'] ?>
                },
                success: function(data) {
                    $("#answer").val(data.answer);
                },
                error: function(error) {
                    swal("Error!", "Something went wrong!", "error");
                }
            });
        });
    }
    function editFormHandler(event) {
        event.preventDefault();
        const data = {
            aid: $("#aid").val(),
            answer: $("#answer").val(),
        }
        $.ajax({
            url: "http://localhost/stackoverflow/api/update-answer.php",
            method: "POST",
            data: data,
            success: function(data) {
                if(data.status) {
                    setFormData();
                    swal("Updated!", data.message, "success");
                }else {
                    swal("Error!", data.message, "error");
                }
            },
            error: function(error) {
                console.log(error)
                swal("Error!", "Something went wrong!", "error");
            }
        });
    }
</script>