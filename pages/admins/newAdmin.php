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
      Add Admin
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="./"> Admins </a></li>
      <li class="active">Add Admin</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
<div class="row">
    <!-- Your Page Content Here -->
    <div class="col-md-6">
    <div class="box">

            <!-- /.box-header -->
            <form role="form" method="post" action="./submitAddAdmin.php">
              <div class="box-body">

                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="nameField" required>
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="emailField" required>
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="passwordField" required>
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

