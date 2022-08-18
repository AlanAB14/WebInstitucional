console.log('hola');

function compressImage(e) {
    console.log('holaNuevo')
    const imagePreview = document.getElementById(`image-${e.target.id}`);

    var file = e.target.files[0];
    var reader = new FileReader();
    reader.onload = (e) => {
    var img = document.createElement("img");
    img.onload = () => {
      var canvas = document.createElement('canvas');
      var ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0);

      var MAX_WIDTH = 500;
      var MAX_HEIGHT = 300;
      var width = img.width;
      var height = img.height;

      if (width > height) {
        if (width > MAX_WIDTH) {
          height *= MAX_WIDTH / width;
          width = MAX_WIDTH;
        }
      } else {
        if (height > MAX_HEIGHT) {
          width *= MAX_HEIGHT / height;
          height = MAX_HEIGHT;
        }
      }
      canvas.width = width;
      canvas.height = height;
      var ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0, width, height);
      var dataurl = canvas.toDataURL("image/png");
        imagePreview.src = dataurl; 

    }
    img.src = e.target.result;
    
  }
  reader.readAsDataURL(file);

    // if (window.File && window.FileReader && window.FileList && window.Blob) {
    //     console.log(e)
    //     const imagePreview = document.getElementById(`image-${e.target.id}`);
    //     var filesToUploads = document.getElementById(e.target.id).files;
    //     var file = filesToUploads[0];
    //     if (file) {

    //         var reader = new FileReader();
    //         // Set the image once loaded into file reader
    //         reader.onload = function(e) {

    //             var img = document.createElement("img");
    //             img.src = e.target.result;

    //             var canvas = document.createElement("canvas");
    //             var ctx = canvas.getContext("2d");
    //             ctx.drawImage(img, 0, 0);

    //             var MAX_WIDTH = 400;
    //             var MAX_HEIGHT = 400;
    //             var width = img.width;
    //             var height = img.height;

    //             if (width > height) {
    //                 if (width > MAX_WIDTH) {
    //                     height *= MAX_WIDTH / width;
    //                     width = MAX_WIDTH;
    //                 }
    //             } else {
    //                 if (height > MAX_HEIGHT) {
    //                     width *= MAX_HEIGHT / height;
    //                     height = MAX_HEIGHT;
    //                 }
    //             }
    //             canvas.width = width;
    //             canvas.height = height;
    //             var ctx = canvas.getContext("2d");
    //             ctx.drawImage(img, 0, 0, width, height);

    //             dataurl = canvas.toDataURL(file.type);
    //             console.log(dataurl);
    //             console.log(imagePreview);
    //             imagePreview.src = dataurl;
                
                
    //         }
    //         reader.readAsDataURL(file);

    //     }

    // } else {
    //     alert('The File APIs are not fully supported in this browser.');
    // }
} 