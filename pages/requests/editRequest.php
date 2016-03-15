<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../../login/');
}

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
include_once($projectRoot."/includes/functions.php");

$request = getRequest($_GET["id"]);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Edit Request
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="./"> Requests </a></li>
      <li class="active">Edit Request</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
<div class="row">
    <!-- Your Page Content Here -->
    <div class="col-md-6">
    <div class="box">

            <!-- /.box-header -->
            <form role="form" method="post" action="./submitEditRequest.php">
              <div class="box-body">

                <input type="hidden" class="form-control" name="idField" value=<?php print_r($request["Item"]["RequestID"]["S"]) ?> required>

                <div class="form-group">
                  <label>Status</label>
                  <input type="text" class="form-control" name="statusField" value=<?php print_r($request["Item"]["Status"]["S"]) ?> required>
                </div>

                <div class="form-group">
                  <label>Handeled</label>
                  <input type="checkbox" name="handeledField" <?php if($request["Item"]["Handeled"]["BOOL"]) : ?> checked="checked" <?php endif; ?>>
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

<?php

include_once($projectRoot."/template/footer.php");
?>