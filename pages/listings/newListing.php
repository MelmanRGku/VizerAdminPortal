<?php

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
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
            <form role="form">
              <div class="box-body">

              <div id="imageHolder">
              </div>

                <div class="form-group">
                  <label for="exampleInputFile">Main Image</label>
                  <input type="file" id="imgInp">
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <input type="email" class="form-control" id="exampleInputEmail1">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">City</label>
                  <input type="email" class="form-control" id="exampleInputEmail1">
                </div>

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

include_once($projectRoot."/template/footer.php");
?>

