var camera, scene, renderer;
var effect, controls;
var element, container;
var sphere;
var selectedLink = null;
var currentRoom = null;
var mouse = new THREE.Vector2(-1, -1);
var raycaster = new THREE.Raycaster();
var sphereIntersect = null;

var clock = new THREE.Clock();

init();
setScene("./images/kitchen.JPG");
animate();

function init() {

  // window.onkeyup = keyDownEvent;
  // window.onmousemove = mouseMoveEvent;

  renderer = new THREE.WebGLRenderer();

  element = renderer.domElement;
  container = document.getElementById('vrElement');
  container.appendChild(element);

  scene = new THREE.Scene();

  camera = new THREE.PerspectiveCamera(90, 1, 0.001, 700);
  camera.position.set(0, 0.01, 0);
  scene.add(camera);

  controls = new THREE.OrbitControls(camera, element);
  // controls.rotateUp(Math.PI / 4);
  controls.target.set(
    camera.position.x,
    camera.position.y,
    camera.position.z + 0.1
  );
  controls.noZoom = true;
  controls.noPan = true;
  controls.enabled = true;

  window.addEventListener('resize', resize, false);
  setTimeout(resize, 1);
}

function resize() {
  var width = container.offsetWidth;
  var height = container.offsetHeight;

  camera.aspect = width / height;
  camera.updateProjectionMatrix();

  renderer.setSize(width, height);
}

function setScene(imagePath){

  sphere = new THREE.Mesh(
    new THREE.SphereGeometry(100, 60, 60),
    new THREE.MeshBasicMaterial({
    map: THREE.ImageUtils.loadTexture(imagePath)
  })
  );
  sphere.material.side = THREE.DoubleSide

  sphere.scale.x = -1;
  scene.add(sphere);

}

function clearScene()
{
  scene.remove(sphere);
  sphere.material.map.dispose();
  sphere.material.dispose();
  sphere.geometry.dispose();
}

function update(dt) {
  resize();

  camera.updateProjectionMatrix();

  controls.update(dt);
}

function render(dt) {
  renderer.render(scene,camera);
  // effect.render(scene, camera);
}

function animate(t) {
  requestAnimationFrame(animate);

    //       raycaster.setFromCamera( mouse, camera ); 

    //  // calculate objects intersecting the picking ray
    // var intersects = raycaster.intersectObjects( scene.children );
    // console.log(intersects.length);

    // for ( var i = 0; i < intersects.length; i++ ) {
    //   console.log(i);
    //   if(intersects[ i ].object == sphere)
    //     console.log("hit");

    // }


  update(clock.getDelta());
  render(clock.getDelta());
}


$(".imgThumb").live("click", function(e){
    console.log(e.target);
    $("#VRview").attr("src",e.target.src);
    clearScene();
    setScene(e.target.src);
});


function uploadButtonClicked()
{
  $("#fileInput").click();
}

var roomCounter = 1;
function imageUpload(input)
{
  if (input.files) {
    console.log(input.files)


    for(var i = 0; i < input.files.length; i++){
      var reader = new FileReader();
      reader.onload = function(e) {
     //   $('#imageList').prepend('<div class="imgThumb" style="cursor:pointer"> \
     //    <div class="col-sm-4 col-md-2" style="margin-top:10px; margin-right:20px;margin-left:20px"> \
     //    <img src="'+ e.target.result + '"alt="..." style="max-width:200px"> \
     //    <center>Living Room</center> \
     //    </div>\
     //    </div>');
     // }

     $('#imageList').prepend('<div class="imgThumb" style="cursor:pointer"> \
        <div class="col-md-12"> <p style="text-align:center"> \
        <img src="'+ e.target.result + '"alt="..." style="max-width:100%"> \
        Room '+ roomCounter++ +' </p> \
        </div>\
        </div>');
     }
     reader.readAsDataURL(input.files[i])
    }
  }
}

$("#fileInput").change(function () {
    imageUpload(this);
});
