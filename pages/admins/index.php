<?php

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
include_once($projectRoot."/includes/functions.php");

$allAdmins = getAllAdmins();
// print_r($allAdmins);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admins
      <small>Manage Admins</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Admins</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
    <!-- Your Page Content Here -->
    <div class="col-md-8">
    <div class="box">
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <tbody><tr>
                  <th>Name</th>
                  <th>Email</th>
                </tr>

                <?php

                // foreach($allListings as $listing)
                // {
                //   echo "<tr>";
                //   echo "<td>".$listing["Address"]["S"]."</td>";
                //   echo "<td>".$listing["City"]["S"]."</td>";
                //   echo "<td>".$listing["UserEmail"]["S"]."</td>";
                //   echo '<td><button type="button" class="btn btn-block btn-warning">Edit</button></td>';
                //   echo "</tr>";
                // }

                ?>
                
              </tbody></table>

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a type="button" href="./newAdmin.php" class="btn btn-success">Add Admin</a>
            </div>
          </div>
        </div>
      </div>
    </div>


  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php

include_once($projectRoot."/template/footer.php");
?>

