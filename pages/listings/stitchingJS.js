var camera, scene, renderer;
var effect, controls;
var element, container;
var sphere = null;
var selectedLink = null;
var currentRoom = null;
var mouse = new THREE.Vector2(-1, -1);
var raycaster = new THREE.Raycaster();
var sphereIntersect = null;
var rooms = [];

var clock = new THREE.Clock();

init();
// setScene("./images/kitchen.JPG");
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

function setScene(room){

  clearScene();

  sphere = new THREE.Mesh(
    new THREE.SphereGeometry(100, 60, 60),
    new THREE.MeshBasicMaterial({
    map: THREE.ImageUtils.loadTexture(room.image)
  })
  );
  sphere.material.side = THREE.DoubleSide

  sphere.scale.x = -1;
  scene.add(sphere);

  document.getElementById("roomName").innerHTML = room.name;
  currentRoom = room;

}

function clearScene()
{
  if(sphere != null){
    scene.remove(sphere);
    sphere.material.map.dispose();
    sphere.material.dispose();
    sphere.geometry.dispose();
    currentRoom = null;
  }
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
    // console.log(e.target.id);
    selectedRoom = getRoom(e.target.id);
    // console.log(selectedRoom);
    clearScene();
    setScene(selectedRoom);
});

function nameEditClick()
{
  console.log("room name edit button clicked");
  if(currentRoom != null){
    var newName = prompt("Enter new room name:", currentRoom.name);
    currentRoom.name = newName;
    document.getElementById('roomName').innerHTML = newName;
    document.getElementById('n'+ currentRoom.id).innerHTML = newName;
  }
}

function getRoom(id)
{
  for(var i = 0; i < rooms.length; i++)
  {
    if(rooms[i].id == id)
      return rooms[i];
  }
  return nil;
}

function uploadButtonClicked()
{
  $("#fileInput").click();
}

$("#fileInput").change(function () {
    imageUpload(this);
});

var roomCounter = 1;
function uploadedNewRoom(e)
{
  var r = new Room(roomCounter, "Room " + roomCounter , e.target.result );
  rooms.push(r);

  $('#imageList').prepend('<div class="col-md-12"> <p style="text-align:center"> \
    <img class="imgThumb" id="'+ r.id + '" src="'+ r.image + '"alt="..." style="max-width:100%; cursor:pointer"> \
    <div style="text-align:center" id="n'+ roomCounter +'"> '+ r.name +' </div> </p> \
    </div>');

  roomCounter++;
}

function imageUpload(input)
{
  if (input.files) {
    console.log(input.files)

    for(var i = 0; i < input.files.length; i++){
      var reader = new FileReader();

      reader.onload = function(e) {
        uploadedNewRoom(e);
     }

     reader.readAsDataURL(input.files[i])
    }
  }
}
