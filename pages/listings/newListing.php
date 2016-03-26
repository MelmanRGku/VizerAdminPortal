<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../../login/');
}

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
include_once($projectRoot."/includes/functions.php");

?>

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      New Listing
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="./">Listings</a></li>
      <li class="active">New Listing</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

<div class="row">
    <!-- Your Page Content Here -->
    <div class="col-md-6">
    <div class="box">

            <!-- /.box-header -->
            <!-- <form role="form" id="newListingForm" method="post" action="./submitNewListing.php"> -->
            <form role="form" id="newListingForm" action="javascript:formSubmit();">
              <div class="box-body">

              <div id="imageHolder">
                <img class="img-responsive pad" width="400"  id="imgPreview"></img>
              </div>

                <div class="form-group">
                  <label>Main Image</label>
                  <input type="file" name="imgUpload" id="imgUpload" accept="image/*" required>
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" name="addressField" id="addressField" required>
                </div>

                <div class="form-group">
                  <label>City</label>                  
                  <select class="form-control" name="cityField" id="cityField" required>
                    <option value="Calgary" selected>Calgary</option>
                    <option>Edmoton</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Price</label>
                  <input type="number" class="form-control" name="priceField" id="priceField" required>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name = "descriptionField" id="descriptionField" required></textarea>
                </div>

                <div class="form-group">
                  <label>User Email</label>
                  <input type="email" class="form-control" name="emailField" id="emailField" required>
                </div>

                <div class="form-group">
                  <label>User Name</label>
                  <input type="test" class="form-control" name="nameField" id="nameField">
                </div>

                <div class="form-group">
                  <label>User Phone Number</label>
                  <input type="test" class="form-control" name="phoneField" id="phoneField">
                </div>

                <div class="form-group">
                  <label>URL</label>
                  <input type="text" class="form-control" name="urlField" id="urlField" required>
                </div>

                <div class="form-group">
                  <input type="checkbox" value="private" name="privateField" id="privateField">
                  <label>Private?</label>
                </div>

                <button  class="btn btn-success">Next</button>
              </div>
            </form>
         

          </div>
        </div>
      </div>
    </div>

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgPreview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgUpload").change(function(){
    readURL(this);
});

function formSubmit()
{
   localStorage.setItem("coverPhoto", $("#imgPreview").attr('src') );
   localStorage.setItem("address", $("#addressField").val() );
   localStorage.setItem("city", $("#cityField option:selected").text());
   localStorage.setItem("price", $("#priceField").val());
   localStorage.setItem("description", $("#descriptionField").val());
   localStorage.setItem("email", $("#emailField").val());
   localStorage.setItem("name", $("#nameField").val());
   localStorage.setItem("phone", $("#phoneField").val());
   localStorage.setItem("url", $("#urlField").val());
   localStorage.setItem("private", $("#privateField").prop('checked'));

   window.location.replace("./stitching.php");
}

</script>

<?php

include_once("../../template/footer.php");
?>

