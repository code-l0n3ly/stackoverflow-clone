<?php
    include "includes/header.php";
    if(!isset($_GET['qid']) || $_GET['qid'] == null) {
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
                    <input type="hidden" name="qid" id="qid" value="<?= $_GET['qid'] ?>">
                    <input type="hidden" id="uid" name="uid">
                    <div class="card-header">
                        <h2 class="card-title fs-3 ">Edit Your Question!</h2>
                    </div>
                    <div class="card-body py-4">
                        <div class="col-sm-12 col-md-12 align-items-center justify-content-center">
                            <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-card-heading"></i></span>
                            <input type="text" id="question"  name="question" placeholder="question title" class="py-2 form-control" required>
                            <div class="invalid-feedback">Please enter question title.</div>
                        </div>
                        <div class="mt-2 col-sm-12 col-md-12 align-items-center justify-content-center">
                            <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-patch-question-fill"></i></span>
                            <textarea type="text" id="description"  name="description" class="form-control py-3" placeholder="question description" required> </textarea>
                            <div class="invalid-feedback">Please enter question description.</div>
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
    $(document).ready(function() {
        $.ajax({
            url: "http://localhost/stackoverflow/api/question.php",
            method: "POST",
            data: {
                qid: <?= $_GET['qid'] ?>
            },
            success: function(data) {
                $("#question").val(data.title);
                $("#description").val(data.description);
                $("#uid").val(data.uid);
            },
            error: function(error) {
                swal("Error!", "Something went wrong!", "error");
            }
        });
    });
    function editFormHandler(event) {
        event.preventDefault();
        const data = {
            qid: $("#qid").val(),
            title: $("#question").val(),
            description: $("#description").val(),
        }
        $.ajax({
            url: "http://localhost/stackoverflow/api/update-question.php",
            method: "POST",
            data: data,
            success: function(data) {
                if(data.status) {
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