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
var selectedLink = null;
var clickOnLink = false;

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
  camera.position.set(0, 0.0, 0);
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
  // controls.noRotate = true;

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
  currentRoom = room;

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

}

function clearScene()
{
  if(currentRoom != null){
    scene.remove(sphere);
    sphere.material.map.dispose();
    sphere.material.dispose();
    sphere.geometry.dispose();
    
    for(i = 0; i < currentRoom.links.length; i++)
    { 
      scene.remove(currentRoom.links[i].linkSprite);
      currentRoom.links[i].linkSprite.geometry.dispose();  
      currentRoom.links[i].linkSprite.material.map.dispose();
      currentRoom.links[i].linkSprite.material.dispose();  
    }

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

function generateLinkSprite()
{
  var canvas = document.createElement( 'canvas' );
  canvas.width = 120;
  canvas.height = 120;

  var context = canvas.getContext( '2d' );

  var centerX = canvas.width / 2;
  var centerY = canvas.height / 2;
  var radius = 50;

  context.beginPath();
  context.arc(centerX, centerY, radius, 0, 2 * Math.PI, false);
  context.fillStyle = '#F0C400';
  context.fill();
  context.lineWidth = 10;
  context.strokeStyle = '#000000'; 
  context.stroke();

  return canvas; 
}

function getCameraLookAtVec()
{
  var cameraLookatVec = new THREE.Vector3( 0, 0, -1 );
  cameraLookatVec.applyQuaternion( camera.quaternion );
  cameraLookatVec.normalize();

  return cameraLookatVec;
}

function addLinkClick2()
{
  // console.log(getCameraLookAtVec());
  var cameraLookatVec = getCameraLookAtVec();

  var texture = new THREE.Texture( generateLinkSprite() );
  texture.needsUpdate = true; // important!

  var material = new THREE.SpriteMaterial( { map: texture } );
  var linkSprite = new THREE.Sprite( material );
  linkSprite.scale.set(10,10,10);

  cameraLookatVec.multiplyScalar(90);

  linkSprite.position.set(cameraLookatVec.x, cameraLookatVec.y, cameraLookatVec.z);
  scene.add(linkSprite);

  var sphericalPosition = cartesianToSpherical(cameraLookatVec);
  
  var link = new RoomLink(0, sphericalPosition.y, sphericalPosition.z);
  link.linkSprite = linkSprite;

  currentRoom.links.push(link);
}

function addLinkClick()
{
  // console.log(getCameraLookAtVec());
  var cameraLookatVec = getCameraLookAtVec();
  cameraLookatVec.multiplyScalar(90);
  console.log(cameraLookatVec);

  var sphericalPosition = cartesianToSpherical(cameraLookatVec);
  
  link = new RoomLink(0, sphericalPosition.x, sphericalPosition.y);

  currentRoom.links.push(link);
  addLinkToScene(link);
}


function addLinkToScene(link)
{
  var texture = new THREE.Texture( generateLinkSprite() );
  texture.needsUpdate = true; // important!

  var material = new THREE.SpriteMaterial( { map: texture } );
  link.linkSprite = new THREE.Sprite( material );
  link.linkSprite.scale.set(10,10,10);

  cartesianPosition = sphericalToCartesian(90, link.theta, link.phi);

  link.linkSprite.position.set(cartesianPosition.x, cartesianPosition.y, cartesianPosition.z);
  scene.add(link.linkSprite);

}

function sphericalToCartesian(radius, theta, phi)
{
  var xPos = radius * Math.sin(phi) * Math.cos(theta);
  var yPos = radius * Math.sin(theta) * Math.sin(phi);
  var zPos = radius * Math.cos(phi);

  return new THREE.Vector3(xPos,yPos,zPos);
}


function cartesianToSpherical(vec)
{
  var r = vec.distanceTo( new THREE.Vector3(0.0, 0.0, 0.0) ) ;
  var phi = Math.acos(vec.z / r);
  var theta = Math.atan2(vec.y, vec.x);

  return new THREE.Vector2(theta , phi);
}

function toRadians (angle) {
  return angle * (Math.PI / 180);
}

function toDegrees (radians) {
  return radians * 180 / Math.PI;
}

function getIntersectedObjects(event)
{
  var offset = $('#vrElement').offset();
  mouse.x = ( ( event.clientX - offset.left + $(window).scrollLeft() ) / $('#vrElement').width() ) * 2 - 1;
  mouse.y = - ( ( event.clientY - offset.top + $(window).scrollTop() ) / $('#vrElement').height() ) * 2 + 1;

  raycaster.setFromCamera( mouse, camera ); 

  // calculate objects intersecting the picking ray
  var intersects = raycaster.intersectObjects( scene.children );

  return intersects;
}

function vrViewerMouseDown(event){

  var intersects = getIntersectedObjects(event);
  
  for ( var i = 0; i < intersects.length; i++ ) {
    for ( var j = 0; j < currentRoom.links.length; j++){
      
      if(intersects[ i ].object == currentRoom.links[j].linkSprite){
        selectedLink = currentRoom.links[j];
        // controls.noRotate = true;
        clickOnLink = true;
      }

    }
  }
}

function vrViewerMouseUp(event){
  clickOnLink = false;
  // console.log(controls.norotate);
  // controls.noRotate = false;
}

function vrViewerMouseMove(event){

  if(clickOnLink == true && selectedLink != null)
  {
    var intersects = getIntersectedObjects(event);
    
    for ( var i = 0; i < intersects.length; i++ ) {
      if(intersects[ i ].object == sphere){
        sphereIntersect = cartesianToSpherical(intersects[i].point);
      }
    }

    var distRadius = 90;
    var theta = sphereIntersect.x;
    var phi = sphereIntersect.y;

    selectedLink.theta = theta;
    selectedLink.phi = phi;

    var cartesianPosition = sphericalToCartesian(distRadius, theta,phi);

    // console.log(cartesianPosition);
    selectedLink.linkSprite.position.set(cartesianPosition.x,cartesianPosition.y,cartesianPosition.z);
  }
}