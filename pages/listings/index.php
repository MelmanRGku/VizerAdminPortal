<?php

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
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
              <div class="col-sm-5">
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Address, city, etc.">
              </div>
              <button type="button" class="btn btn-primary">Search</button>
              <button type="button" class="btn btn-success">New Listing</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Address</th>
                  <th>City</th>
                  <th style="width: 40px">Details</th>
                </tr>
                <tr>
                  <td>21</td>
                  <td>Blah blah street</td>
                  <td>Blah Town</td>
                  <td><button type="button" class="btn btn-block btn-warning">Edit</button></td>
                </tr>
                <tr>
                  <td>323</td>
                  <td>Blah blah street</td>
                  <td>Blah Town</td>
                  <td><button type="button" class="btn btn-block btn-warning">Edit</button></td>
                </tr>
                <tr>
                  <td>932</td>
                  <td>Blah blah street</td>
                  <td>Blah Town</td>
                  <td><button type="button" class="btn btn-block btn-warning">Edit</button></td>
                </tr>
                
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

