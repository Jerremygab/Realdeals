let mainImage = document.querySelector('.new-cars .container  .quickview-content-box .quickview-content-item .quickview-content-img .quickview-main-img img');
let subImages = document.querySelectorAll('.new-cars .container  .quickview-content-box .quickview-content-item .quickview-content-img .quickview-sub-img img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});
function setEqualHeight() {
   var items = document.querySelectorAll('.single-service-item');
   var maxHeight = 0;

   items.forEach(function(item) {
       var itemHeight = item.offsetHeight;
       if (itemHeight > maxHeight) {
           maxHeight = itemHeight;
       }
   });

   items.forEach(function(item) {
       item.style.height = maxHeight + 'px';
   });
}

window.onload = setEqualHeight;
window.onresize = setEqualHeight;
