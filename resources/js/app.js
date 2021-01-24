require('./bootstrap');
var imageSrc;
$(document).ready(function(){
  imageSrc = document.getElementById("image");
});

Echo.channel(`frames`)
.listen('.frame', (e) => {
  e.image.forEach(function(img, index){
    setTimeout(function(){
      imageSrc.src = img;
    },
    40 * index);
  });

})