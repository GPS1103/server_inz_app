require('./bootstrap');

Echo.channel(`frames`)
.listen('.frame', (e) => {

      document.getElementById("img").src =e.image + "?" + new Date().getTime();

     console.log(e.image);
});