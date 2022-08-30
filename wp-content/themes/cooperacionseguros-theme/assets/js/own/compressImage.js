console.log('hola');

function compressImage(e) {
    console.log('holaNuevo')
    const imagePreview = document.getElementById(`image-${e.target.id}`);

    var file = e.target.files[0];
    var extension = e.target.files[0].type;

    if (extension === "image/jpg" || extension === "image/jpeg" || extension === "image/png" || extension === "image/jfif" || extension === "image/bmp") {

      var reader = new FileReader();
      reader.onload = (e) => {
      var img = document.createElement("img");
      img.onload = () => {
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
  
        var MAX_WIDTH = 600;
        var MAX_HEIGHT = 400;
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
      
    }else {
      const reader = new FileReader();
        reader.onloadend = () => {
            imagePreview.src = reader.result;
        };
        reader.readAsDataURL(file);
    }

   
} 