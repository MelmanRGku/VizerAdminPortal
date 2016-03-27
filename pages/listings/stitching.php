<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../login/');
}

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="./threejs/three.js"></script>
<script src="./threejs/StereoEffect.js"></script>
<script src="./threejs/DeviceOrientationControls.js"></script>
<script src="./threejs/OrbitControls.js"></script>
<script src="./threejs/Detector.js"></script> 
<script src="./threejs/RoomObjs.js"></script>  

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      VR Tour Editor
      <small>Adding and Linking 360 Pictures</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="./">Listings</a></li>
      <li><a href="./newListing.php">New Listing</a></li>
      <li class="active">VR Tour Editor</li>
    </ol>
  </section>


  <!-- Main content -->
    <!-- Your Page Content Here -->
  <section class="content">


    <div class="row">
      <div class="col-md-8">

      <div class="box box-default color-palette-box">
        <div class="box-header">
          <h2 id="roomName" class="box-title">Upload Images First !</h2> 
          <i onclick="nameEditClick()" style="cursor:pointer" class="fa fa-fw fa-edit"></i>
          <label class="checkbox-inline"><input id="firstRoomCheckBox" type="checkbox" onclick='setFirstRoomClick(this)'; value="">Set as first room</label>
        </div>

        <!-- /.box-header -->
        <div class="box-body">

          <div id="vrElement" onmousemove="vrViewerMouseMove(event)" onmousedown="vrViewerMouseDown(event)" onmouseup="vrViewerMouseUp(event)" onmouseleave="vrViewerMouseUp(event)" style="width=200px; height:500px;"></div>
        </div>
        <!-- /.box-body -->
      </div>
      <div class="box box-default color-palette-box">
        <!-- /.box-header -->
        <div class="box-body">
          <div style="height:0px;overflow:hidden">
            <input type="file" id="fileInput" accept="image/*" multiple/>
          </div>
          <input type="button" class="btn btn-primary" onclick="uploadButtonClicked()" value="Upload Images"></input>
          <div class="btn-group dropup">
            <a type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" onclick="addLinkClick()">Add Link <span class="caret"></span></a>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul id="linkDropDownMenu" class="dropdown-menu" >
            </ul>
          </div>
          <button type="button" class="btn btn-primary" onclick="addBubbleClick()">Add Bubble</button>
          <button type="button" class="btn btn-primary" onclick="removeItemClick()">Remove Item</button>
          <button type="button" class="btn btn-success" onclick="doneClick()">Done</button>
        </div>
        <!-- /.box-body -->
      </div>   

    </div>

    <div class="col-md-4">
      <div class="box box-default color-palette-box">

        <!-- /.box-header -->
        <div class="box-body">
          <div class="pre-scrollable" id='imageList' style="max-height:600px;">

            <!-- /.box-body -->
          </div>
          </div>
        </div>
      </div>


  </div>

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script src="./stitchingJS.js"></script>

<?php

include_once($projectRoot."/template/footer.php");
?>

