<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../login/');
}
  
$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
include_once($projectRoot."/includes/functions.php");

$allRequestsSorted =  getAllRequestsSorted('Timestamp-index');

if(isset($_SESSION['searchRequests'])) {
  $allUserRequests = getUsersRequests($_SESSION['searchRequests']);
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Requests
      <small>Manage Vizer Requests</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Requests</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

<div class="row">
    <!-- Your Page Content Here -->
    <div class="col-md-10">
    <div class="box">
            <div class="box-header with-border">
              <form action="./searchRequest.php" method="post">
                <div class="col-sm-5">
                  <input type="email" class="form-control" placeholder="Email" name="emailField" required>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
              </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <tbody><tr>
                  <th>Email</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Handled</th>
                  <th>Status</th>
                  <th>Timestamp</th>
                  <th>LastEditedBy</th>
                  <th>LastEditedOn</th>
                  <th style="width: 40px">Details</th>
                </tr>

                <?php

                if(isset($_SESSION['searchRequests']))
                {
                  foreach($allUserRequests["Items"] as $request)
                  {
                    echo "<tr>";
                    echo "<td>".$request["Email"]["S"]."</td>";
                    echo "<td>".$request["Name"]["S"]."</td>";
                    echo "<td>".$request["Phone"]["S"]."</td>";
                    echo "<td>".$request["Address"]["S"]."</td>";
                    if($request["Handeled"]["BOOL"]) {
                      echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                    }
                    else {
                      echo '<td><span class="glyphicon glyphicon-remove"></span></td>';
                    }
                    echo "<td>".$request["Status"]["S"]."</td>";
                    echo "<td>".$request["Timestamp"]["S"]."</td>";
                    echo "<td>".$request["LastEditedBy"]["S"]."</td>";
                    echo "<td>".$request["LastEditedOn"]["S"]."</td>";
                    echo '<td><a type="button" href="./editRequest.php?id='.$request["RequestID"]["S"].'" class="btn btn-block btn-warning">Edit</a></td>';
                    echo "</tr>";
                  }
                  unset($_SESSION['searchRequests']);
                }
                else
                {
                  foreach($allRequestsSorted as $request)
                  {
                    echo "<tr>";
                    echo "<td>".$request["Email"]["S"]."</td>";
                    echo "<td>".$request["Name"]["S"]."</td>";
                    echo "<td>".$request["Phone"]["S"]."</td>";
                    echo "<td>".$request["Address"]["S"]."</td>";
                    if($request["Handeled"]["BOOL"]) {
                      echo '<td><span class="glyphicon glyphicon-ok"></span></td>';
                    }
                    else {
                      echo '<td><span class="glyphicon glyphicon-remove"></span></td>';
                    }
                    echo "<td>".$request["Status"]["S"]."</td>";
                    echo "<td>".$request["Timestamp"]["S"]."</td>";
                    echo "<td>".$request["LastEditedBy"]["S"]."</td>";
                    echo "<td>".$request["LastEditedOn"]["S"]."</td>";
                    echo '<td><a type="button" href="./editRequest.php?id='.$request["RequestID"]["S"].'" class="btn btn-block btn-warning">Edit</a></td>';
                    echo "</tr>";
                  }
                }

                ?>
                
              </tbody></table>

            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
              </ul>
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

