<?php

$projectRoot = "../../";
include_once($projectRoot."/template/header.php");
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
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
      <small>Adding and Connecting 360 Pictures</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="active">Here</li>
    </ol>
  </section>

  <!-- Main content -->
    <!-- Your Page Content Here -->
  <section class="content">
    <div class="row">
      <div class="col-md-8">

      <div class="box box-default color-palette-box">
        <div class="box-header">
          <!-- <input type="text" class="form-control" id="roomNameField" placeholder="Room name"> -->
          <h2 id="roomName" class="box-title">asd </h2> <i onclick="nameEditClick()" style="cursor:pointer" class="fa fa-fw fa-edit"></i>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <!-- <img  id="VRview" src="./images/frontdoor.JPG" alt="Mountain View" style="max-width:100%;max-height:100%;"> -->
          <div id="vrElement" style="width=200px; height:500px;"></div>
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
          <button type="button" class="btn btn-primary">Add Link</button>
          <button type="button" class="btn btn-primary">Remove Link</button>
          <button type="button" class="btn btn-primary">Add Bubble</button>
          <button type="button" class="btn btn-primary">Remove Bubble</button>
        </div>
        <!-- /.box-body -->
      </div>   

    </div>

    <div class="col-md-4">
      <div class="box box-default color-palette-box">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="pre-scrollable" id='imageList' style="max-height:600px;">

<!--         <div class="imgThumb">
          <div class="col-md-9" >
            <img src="./images/hallway.JPG" alt="..." style="max-width:200px">
            <center>Living Room</center>
          </div>
        </div>

                <div class="imgThumb">
          <div class="col-md-9" >
            <img src="./images/hallway.JPG" alt="..." style="max-width:200px">
            <center>Living Room</center>
          </div>
        </div> -->
<!--           <div class="col-sm-4 col-md-2"  style="margin-top:10px; margin-right:20px; margin-left:20px" >
            <img src="./images/hallway.JPG" alt="..." style="max-width:200px">
            <center>Living Room</center>
          </div>
          <div class="col-sm-4 col-md-2" style="margin-top:10px; margin-right:20px; margin-left:20px">
            <img src="./images/hallway.JPG" alt="..." style="max-width:200px">
            <center>Living Room</center>
          </div>
          <div class="col-sm-4 col-md-2" style="margin-top:10px; margin-right:20px; margin-left:20px">
            <img src="./images/hallway.JPG" alt="..." style="max-width:200px">
            <center>Living Room</center>
          </div> -->
<!--           <div class="col-sm-4 col-md-2" style="margin-top:10px; margin-right:20px; margin-left:20px">
            <img src="./images/hallway.JPG" alt="..." style="max-width:200px">
            <center>Living Room</center>
          </div> -->

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
