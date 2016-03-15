<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../../login/');
}

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
include_once($projectRoot."/includes/functions.php");

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Change Password
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Change Password</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
<div class="row">
    <!-- Your Page Content Here -->
    <div class="col-md-6">
    <div class="box">
            <!-- /.box-header -->
            <form role="form" method="post" action="./submitEditAdmin.php">

            <?php if(isset($_SESSION['passwordmismatch'])) : ?>
              <div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> Error</h4>
                Passwords do not match
              </div>
            <?php endif; ?>

              <div class="box-body">

                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" class="form-control" name="passField1" required>
                </div>

                <div class="form-group">
                  <label>Retype New Password</label>
                  <input type="password" class="form-control" name="passField2" required>
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