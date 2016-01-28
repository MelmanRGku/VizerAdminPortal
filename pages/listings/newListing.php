<?php

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
include_once($projectRoot."/includes/function.php");

?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

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
      <li class="active"><a href="./">Listings</a></li>
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
            <form role="form" method="post" action="./submitNewListing.php">
              <div class="box-body">

              <div id="imageHolder">
              </div>

                <div class="form-group">
                  <label>Main Image</label>
                  <input type="file" id="imgInp">
                </div>

                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control" name="addressField">
                </div>

                <div class="form-group">
                  <label>City</label>                  
                  <select class="form-control" name="cityField" required>
                    <option value="Calgary" selected>Calgary</option>
                    <option>Edmoton</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Price</label>
                  <input type="number" class="form-control" name="priceField">
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" name = "descriptionField"></textarea>
                </div>

                <div class="form-group">
                  <label>User Email</label>
                  <input type="email" class="form-control" name="emailField">
                </div>

                <div class="form-group">
                  <label>URL</label>
                  <input type="text" class="form-control" name="urlField">
                </div>

                <div class="form-group">
                  <input type="checkbox" value="private" name="privateField">
                  <label>Private?</label>
                </div>

                <button type="submit" class="btn btn-success">Submit</button>
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

            if( $('#imgPreview').length ){
              $('#imgPreview').attr('src', e.target.result);
            }
            else{
              $('#imageHolder').prepend('<img class="img-responsive pad" width="400" id="imgPreview" src="'+ e.target.result+'" alt="your image" />')
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});
</script>

<?php

include_once("../../template/footer.php");
?>

