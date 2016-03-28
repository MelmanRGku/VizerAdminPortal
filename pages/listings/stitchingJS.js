var camera, scene, renderer;
var effect, controls;
var element, container;
var sphere = null;
var currentRoom = null;
var mouse = new THREE.Vector2(-1, -1);
var raycaster = new THREE.Raycaster();
var rooms = [];
var clock = new THREE.Clock();

var SelectedItemEnum = {
  RoomLink: 1,
  FeatureBubble: 2,
  None: 3,
};

var selectedItemType = SelectedItemEnum.None
var selectedItem = null;
var clickOnLink = false;

init();
animate();

function init() {

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

  if(room.firstRoom == true){
    $('#firstRoomCheckBox').prop('checked', true);
  }
  else
  {
    $('#firstRoomCheckBox').prop('checked', false);
  }

  for(var i = 0; i < room.links.length; i++){
    addLinkToScene(room.links[i]);
  }

  for(var i = 0; i < room.bubbles.length; i++){
    addBubbleToScene(room.bubbles[i]);
  }

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
      removeLink(currentRoom.links[i]);
    }

    for(i = 0; i < currentRoom.bubbles.length; i++)
    { 
      removeBubble(currentRoom.bubbles[i]);
    }

    currentRoom = null;
  }
}

function removeLink(link)
{
  scene.remove(link.linkSprite);
  link.linkSprite.geometry.dispose();  
  link.linkSprite.material.map.dispose();
  link.linkSprite.material.dispose();  
}

function removeBubble(fBubble)
{
  scene.remove(fBubble.backgroundSprite);
  fBubble.backgroundSprite.geometry.dispose();  
  fBubble.backgroundSprite.material.map.dispose();
  fBubble.backgroundSprite.material.dispose();  
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
  update(clock.getDelta());
  render(clock.getDelta());
}

$('body').on('click', '.imgThumb', function(e){
    selectedRoom = getRoom(e.target.id);
    clearScene();
    setScene(selectedRoom);
});

function updateLinkDropDownMenu()
{
  if(rooms.length > 0)
  {
    $("#linkDropDownMenu").empty();

    for (var i = 0; i < rooms.length; i++){
      if(rooms[i] != currentRoom)
        $("#linkDropDownMenu").append('<li><a id="r' + rooms[i].id + '" class="linkMenuItem">'+ rooms[i].name +'</a></li>');
    }
  }
}

function addLinkClick()
{
  updateLinkDropDownMenu();
}

function addBubbleClick()
{
  var bubbleText = prompt("Enter feature bubble text:", "");

  if(bubbleText != null){
    var cameraLookatVec = getCameraLookAtVec();
    cameraLookatVec.multiplyScalar(90);

    var sphericalPosition = cartesianToSpherical(cameraLookatVec);

    var fBubble = new FeatureBubble(sphericalPosition.x, sphericalPosition.y, bubbleText);
    currentRoom.bubbles.push(fBubble);
    addBubbleToScene(fBubble);
  }

}

function setFirstRoomClick(event){
  if( currentRoom != null){
      for(var i = 0; i < rooms.length; i++){
        rooms[i].firstRoom = false;
      }

      currentRoom.firstRoom = true;
  }
}

$('body').on('click', '.linkMenuItem', function(e){
  roomID = event.target.id.replace(/\D/g,''); //remove letters to get id
  room = getRoom(roomID);

  var cameraLookatVec = getCameraLookAtVec();
  cameraLookatVec.multiplyScalar(90);

  var sphericalPosition = cartesianToSpherical(cameraLookatVec);
  
  link = new RoomLink(roomID, sphericalPosition.x, sphericalPosition.y);

  currentRoom.links.push(link);
  addLinkToScene(link);
});

function nameEditClick()
{
  console.log("room name edit button clicked");
  if(currentRoom != null){
    var newName = prompt("Enter new room name:", currentRoom.name);

    if(newName != null){
      currentRoom.name = newName;
      document.getElementById('roomName').innerHTML = newName;
      document.getElementById('n'+ currentRoom.id).innerHTML = newName;
    }
  }
}

function doneClick(){

  $("#myModal").modal();

  for(var i = 0; i < rooms.length; i++)
  {
    $.post( "uploadImageToS3.php", {id: rooms[i].id, image: rooms[i].image})
      .done(function( retData ) {

        console.log( "Image Uploaded: " + retData.id + " " + retData.UUID );

        var room = getRoom(retData.id );
        room.imageUUID = retData.UUID;
        if(allImagesUploaded() == true)
        {
          uploadDatatoServer();
        }
      }, "json"); 
    }


}


function uploadDatatoServer()
{
  var data = {};
  var roomsArr = [];

  for(var i = 0; i < rooms.length; i++)
  {
    roomsArr.push(rooms[i].getDict());
  }

  data['rooms'] = roomsArr;
  data['address'] = localStorage.getItem("address");
  data['city'] = localStorage.getItem("city");
  data['price'] = localStorage.getItem("price");
  data['description'] = localStorage.getItem("description");
  data['email'] = localStorage.getItem("email");
  data['url'] = localStorage.getItem("url");
  data['name'] = localStorage.getItem("name");
  data['phone'] = localStorage.getItem("phone");
  data['private'] = localStorage.getItem("private");
  data['coverPhoto'] = localStorage.getItem("coverPhoto");

  $.post( "submitNewListing.php", data)
  .done(function( retData ) {
    // alert( "Data Loaded: " + retData );
    // console.log( "Data Loaded: " + retData );
    window.location.replace("./");
  }); 

}

function allImagesUploaded()
{
  for(var i = 0; i < rooms.length; i++)
  {
    if(rooms[i].imageUUID == null){ 
      return false;
    }
  }

  return true;
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

function removeItemClick()
{
  if(selectedItem != null)
  {
    if(selectedItemType == SelectedItemEnum.RoomLink){
      removeLink(selectedItem);
      index = currentRoom.links.indexOf(selectedItem);
      currentRoom.links.splice(index, 1);
    }
    else if(selectedItemType == SelectedItemEnum.FeatureBubble){
      removeBubble(selectedItem);
      index = currentRoom.bubbles.indexOf(selectedItem);
      currentRoom.bubbles.splice(index, 1);
    }

    selectedItem = null;
    selectedItemType = SelectedItemEnum.None;
  }
}

var roomCounter = 1;
var firstImageUploaded = false;
function uploadedNewRoom(e)
{
  var r = new Room(roomCounter, "Room " + roomCounter , e.target.result );
  rooms.push(r);

  $('#imageList').prepend('<div class="col-md-12"> <p style="text-align:center"> \
    <img class="imgThumb" id="'+ r.id + '" src="'+ r.image + '"alt="..." style="max-width:100%; cursor:pointer"> \
    <div style="text-align:center" id="n'+ roomCounter +'"> '+ r.name +' </div> </p> \
    </div>');

  if(firstImageUploaded == false){
    firstImageUploaded = true;
    setScene(r);
  }

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

function generateLinkSprite2(roomName, isHighlighted)
{
  var canvas = document.createElement( 'canvas' );
  canvas.width = 400;
  canvas.height = 400;
  var context = canvas.getContext( '2d' );
  var width    = 400;
  var height   = 100;
  var arrowW   = 0.20 * width;
  var arrowH   = 0.75 * height;
  var p1       = {x: (width-arrowW)/2,              y: arrowH};
  var p2       = {x: (width-arrowW)/2, y: (height-arrowH)*2};
  var p3       = {x: width/3, y: (height - arrowH)*2};
  var p4       = {x: width/2,          y: 0};
  var p5       = {x: width * (2/3), y: (height-arrowH)*2};
  var p6       = {x: width-((width-arrowW)/2), y: (height-arrowH)*2};
  var p7       = {x: width-((width-arrowW)/2),              y: arrowH};
  context.clearRect(0, 0, canvas.width, canvas.height);
  context.fillStyle = '#F0C400';
  var fontface = "Arial";
  var fontsize = 36;
  var textColor = { r:0, g:0, b:0, a:1.0 };
  var borderThickness;
  var borderColor;
  var backgroundColor = { r:255, g:255, b:255, a:0.8 };
  if(isHighlighted)
  {
    borderColor = { r:255, g:0, b:0, a:1.0 };
    borderThickness = 10;
  }
  else
  {
    borderColor = { r:0, g:0, b:0, a:1.0 };
    borderThickness = 4;
  }
  context.beginPath();
  context.moveTo(p1.x, p1.y);
  context.lineTo(p2.x, p2.y); // end of main block
  context.lineTo(p3.x, p3.y); // topmost point     
  context.lineTo(p4.x, p4.y); // endpoint 
  context.lineTo(p5.x, p5.y); // bottommost point 
  context.lineTo(p6.x, p6.y); // end at bottom point 
  context.lineTo(p7.x, p7.y);
  context.closePath();
  context.fill();
  context.lineWidth = borderThickness;
  context.strokeStyle = "rgba(" + borderColor.r + "," + borderColor.g + "," + borderColor.b + "," + borderColor.a + ")";
  context.stroke();
    context.font = "Bold " + fontsize + "px " + fontface;
    var maxWidth = 300;
    var metrics = context.measureText( roomName );
    var textWidth = metrics.width;
    context.fillStyle   = "rgba(" + backgroundColor.r + "," + backgroundColor.g + "," + backgroundColor.b + "," + backgroundColor.a + ")";
    context.strokeStyle = "rgba(" + borderColor.r + "," + borderColor.g + "," + borderColor.b + "," + borderColor.a + ")";
    context.lineWidth = borderThickness;
    roundRect(context,  ((width/2) -(textWidth/2)) - borderThickness, arrowH + borderThickness, (textWidth + borderThickness) * 1.1, fontsize * 1.6 + borderThickness, 8);
    context.fillStyle = "rgba("+textColor.r+", "+textColor.g+", "+textColor.b+", 1.0)";
    wrapText(context, roomName, ((width/2) -(textWidth/2)) - borderThickness + 5, (fontsize) + arrowH + borderThickness, maxWidth, fontsize + 10);
  return canvas; 
}

function generateFeatureBubbleBackground(featureText)
{
    var fontface = "Arial";
    var fontsize = 28;
    var borderThickness = 4;
    var borderColor = { r:0, g:0, b:0, a:1.0 };
    var backgroundColor = { r:255, g:255, b:255, a:0.8 };
    var textColor = { r:0, g:0, b:0, a:1.0 };
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    context.font = "Bold " + fontsize + "px " + fontface;
    var maxWidth = 256;
    var metrics = context.measureText( featureText );
    var textWidth = metrics.width;
  var numberOfLines = NumberOfLines(context, featureText, (canvas.width - maxWidth) / 2, 60, maxWidth, fontsize + 10);
  if (numberOfLines > 1) 
  {
    textWidth = maxWidth;
  };
    context.fillStyle   = "rgba(" + backgroundColor.r + "," + backgroundColor.g + "," + backgroundColor.b + "," + backgroundColor.a + ")";
    context.strokeStyle = "rgba(" + borderColor.r + "," + borderColor.g + "," + borderColor.b + "," + borderColor.a + ")";
    context.lineWidth = borderThickness;
    roundRect(context, borderThickness/2, borderThickness/2, (textWidth + borderThickness) * 1.1, fontsize * numberOfLines * 1.6 + borderThickness, 8);
    context.fillStyle = "rgba("+textColor.r+", "+textColor.g+", "+textColor.b+", 1.0)";
    wrapText(context, featureText, borderThickness + 5, (fontsize) + borderThickness, maxWidth, fontsize + 10);
    // context.fillText( featureText, borderThickness, (fontsize) + borderThickness);
    var texture = new THREE.Texture(canvas) 
    texture.needsUpdate = true;
    var spriteMaterial = new THREE.SpriteMaterial( { map: texture, useScreenCoordinates: false } );
    var sprite = new THREE.Sprite( spriteMaterial );
    sprite.scale.set(0.5 * fontsize, 0.25 * fontsize, 0.75 * fontsize);
    return sprite;  
}

function NumberOfLines(context, text, x, y, maxWidth, lineHeight) 
{
    var words = text.split(' ');
    var line = '';
    var numberoflines = 1;
    for(var n = 0; n < words.length; n++) 
    {
      var testLine = line + words[n] + ' ';
      var metrics = context.measureText(testLine);
      var testWidth = metrics.width;
      if (testWidth > maxWidth && n > 0) 
      {
        line = words[n] + ' ';
        y += lineHeight;
        numberoflines = numberoflines + 1;
      }
      else 
      {
        line = testLine;
      }
    }
    return numberoflines;
}

function roundRect(ctx, x, y, w, h, r) { 
  ctx.beginPath(); ctx.moveTo(x + r, y); 
  ctx.lineTo(x + w - r, y); 
  ctx.quadraticCurveTo(x + w, y, x + w, y + r);
  ctx.lineTo(x + w, y + h - r);
  ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
  ctx.lineTo(x + r, y + h);
  ctx.quadraticCurveTo(x, y + h, x, y + h - r); ctx.lineTo(x, y + r);
  ctx.quadraticCurveTo(x, y, x + r, y);
  // ctx.fillStyle = "rgba(127, 255, 0, 0.5)";
  // ctx.fill();
  // ctx.lineWidth = 2.5;
  // ctx.strokeStyle = '#000000'; 
  ctx.closePath(); ctx.fill(); ctx.stroke(); 
}

function wrapText(context, text, x, y, maxWidth, lineHeight) 
{
    var words = text.split(' ');
    var line = '';
    for(var n = 0; n < words.length; n++) 
    {
      var testLine = line + words[n] + ' ';
      var metrics = context.measureText(testLine);
      var testWidth = metrics.width;
      if (testWidth > maxWidth && n > 0) 
      {
        context.fillText(line, x, y);
        line = words[n] + ' ';
        y += lineHeight;
      }
      else 
      {
        line = testLine;
      }
    }
    context.fillText(line, x, y);
}

function getCameraLookAtVec()
{
  var cameraLookatVec = new THREE.Vector3( 0, 0, -1 );
  cameraLookatVec.applyQuaternion( camera.quaternion );
  cameraLookatVec.normalize();

  return cameraLookatVec;
}

function addLinkToScene(link)
{
  var toRoomName = getRoom(link.toId).name
  var texture = new THREE.Texture( generateLinkSprite2(toRoomName, false) );
  texture.needsUpdate = true; // important!

  var material = new THREE.SpriteMaterial( { map: texture } );
  link.linkSprite = new THREE.Sprite( material );
  link.linkSprite.scale.set(40,40,40);

  cartesianPosition = sphericalToCartesian(90, link.theta, link.phi);

  link.linkSprite.position.set(cartesianPosition.x, cartesianPosition.y, cartesianPosition.z);
  scene.add(link.linkSprite);

}

function addBubbleToScene(fBubble)
{
  fBubble.backgroundSprite = generateFeatureBubbleBackground(fBubble.informationText);
  fBubble.backgroundSprite.scale.set(30,30,30);

  cartesianPosition = sphericalToCartesian(90, fBubble.theta, fBubble.phi);
  fBubble.backgroundSprite.position.set(cartesianPosition.x, cartesianPosition.y, cartesianPosition.z);
  scene.add(fBubble.backgroundSprite);
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
        selectedItem = currentRoom.links[j];
        selectedItemType = SelectedItemEnum.RoomLink;
        // controls.noRotate = true;
        clickOnLink = true;
      }
    }

    for ( var j = 0; j < currentRoom.bubbles.length; j++)
    {
      if(intersects[ i ].object == currentRoom.bubbles[j].backgroundSprite){
        selectedItem = currentRoom.bubbles[j];
        selectedItemType = SelectedItemEnum.FeatureBubble;
        // controls.noRotate = true;
        clickOnLink = true;
      }
    }
  }
}

function vrViewerMouseUp(event){
  clickOnLink = false;
  // controls.noRotate = false;
}

function vrViewerMouseMove(event){

  var sphereIntersect = null;

  if(clickOnLink == true && selectedItem != null)
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

    selectedItem.theta = theta;
    selectedItem.phi = phi;
    var cartesianPosition = sphericalToCartesian(distRadius, theta,phi);

    if(selectedItemType == SelectedItemEnum.RoomLink){
      selectedItem.linkSprite.position.set(cartesianPosition.x,cartesianPosition.y,cartesianPosition.z);
    }
    else if(selectedItemType == SelectedItemEnum.FeatureBubble){
      selectedItem.backgroundSprite.position.set(cartesianPosition.x,cartesianPosition.y,cartesianPosition.z);
    }

  }
}

