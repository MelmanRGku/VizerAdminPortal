<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../login/');
}
  
$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
include_once($projectRoot."/includes/functions.php");

$allListings = getAllListings();

if(isset($_SESSION['searchListings'])) {
  $allListings = getUsersListings($_SESSION['searchListings']);
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Listings
      <small>Manage Vizer Listings</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Listings</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

<div class="row">
    <!-- Your Page Content Here -->
    <div class="col-md-10">
    <div class="box">
            <div class="box-header with-border">
              <form action="./searchListings.php" method="post">
                <div class="col-sm-5">
                  <input type="email" class="form-control" placeholder="Email" name="emailField" required>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a type="button" href="./newListing.php" class="btn btn-success">New Listing</a>
              </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <tbody><tr>
                  <th>Address</th>
                  <th>City</th>
                  <th>User Email</th>
                  <th style="width: 40px">Details</th>
                </tr>

                <?php

                if(isset($_SESSION['searchListings']))
                {
                  foreach($allListings["Items"] as $listing)
                  {
                    echo "<tr>";
                    echo "<td>".$listing["Address"]["S"]."</td>";
                    echo "<td>".$listing["City"]["S"]."</td>";
                    echo "<td>".$listing["UserEmail"]["S"]."</td>";
                    echo '<td><a type="button"type="button" href="./editListing.php?id='.$listing["ListingID"]["S"].'" class="btn btn-block btn-warning">Edit</a></td>';
                    echo "</tr>";
                  }
                  unset($_SESSION['searchListings']);
                }
                else
                {
                foreach($allListings as $listing)
                  {
                    echo "<tr>";
                    echo "<td>".$listing["Address"]["S"]."</td>";
                    echo "<td>".$listing["City"]["S"]."</td>";
                    echo "<td>".$listing["UserEmail"]["S"]."</td>";
                    echo '<td><a type="button"type="button" href="./editListing.php?id='.$listing["ListingID"]["S"].'" class="btn btn-block btn-warning">Edit</a></td>';
                    echo "</tr>";
                  }
                }

                ?>
                
              </tbody></table>

            </div>
            <!-- /.box-body -->
<!--             <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
              </ul>
            </div> -->
          </div>
        </div>
      </div>
    </div>



  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php

include_once($projectRoot."/template/footer.php");
?>

