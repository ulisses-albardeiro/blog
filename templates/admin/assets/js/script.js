// Menu hamburger do Sidebar
const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});

//Seta do menu usuário
document.addEventListener("DOMContentLoaded", function () {
  const dropdownToggles = document.querySelectorAll('.nav-item.dropdown .nav-link');

  dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', function () {
      const icon = this.querySelector('i');
      icon.classList.toggle('bi-chevron-down');
      icon.classList.toggle('bi-chevron-up');
    });
  });
});


//Preview de imagem no input file
function readImage() {
  if (this.files && this.files[0]) {
    var file = new FileReader();
    file.onload = function (e) {
      document.getElementById("preview").src = e.target.result;
    };
    file.readAsDataURL(this.files[0]);
  }
}
document.getElementById("tumb").addEventListener("change", readImage, false);


