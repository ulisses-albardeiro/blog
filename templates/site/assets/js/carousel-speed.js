document.addEventListener('DOMContentLoaded', function() {
    var carouselElement = document.querySelector('#carouselExampleAutoplaying');
    var carouselInstance = new bootstrap.Carousel(carouselElement, {
      interval: 3000 // 3 segundos
    });
  });
  