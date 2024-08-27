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
   var prods = document.querySelectorAll('.single-product-box');
   var prodsAdmin = document.querySelectorAll('.single-product-box');
   var tests = document.querySelectorAll('.single-featured-cars');
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
   
   prods.forEach(function(prod) {
       var prodHeight = prod.offsetHeight;
       if (prodHeight > maxHeight) {
           maxHeight = prodHeight;
       }
   });

   prods.forEach(function(prod) {
       prod.style.height = maxHeight + 'px';
   });

   prodsAdmin.forEach(function(prodAdmin) {
       var prodAdminHeight = prodAdmin.offsetHeight;
       if (prodAdminHeight > maxHeight) {
           maxHeight = prodAdminHeight;
       }
   });

   prodsAdmin.forEach(function(prodAdmin) {
       prodAdmin.style.height = maxHeight + 'px';
   });

   tests.forEach(function(test) {
       var testHeight = test.offsetHeight;
       if (testHeight > maxHeight) {
           maxHeight = testHeight;
       }
   });

   tests.forEach(function(test) {
       test.style.height = maxHeight + 'px';
   });
}

window.onload = setEqualHeight;
window.onresize = setEqualHeight;
