
$(".imgThumb").live("click", function(e){
    console.log(e.target);
    $("#VRview").attr("src",e.target.src);
});


function uploadButtonClicked()
{
  $("#fileInput").click();
}

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
        <div class="col-md-3"> <p style="text-align:center"> \
        <img src="'+ e.target.result + '"alt="..." style="max-width:200px"> \
        Living Room </p> \
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
