import $ from 'jquery';
document.addEventListener('DOMContentLoaded', function () {
    'use strict';
  
    var prevScrollPos = window.scrollY || window.pageYOffset;
    var navbar = $('.navbarv2-container');
    var navbarmobile = $('.navbarv2-mobile-container');
    var navbarHeight = navbar.height();
    var isScrollingUp = false;
  
    $(window).on('scroll', function () {
      var currentScrollPos = window.scrollY || window.pageYOffset;
  
      if (prevScrollPos > currentScrollPos) {
        isScrollingUp = true;
      } else {
        isScrollingUp = false;
      }
  
      if (isScrollingUp) {
        navbar.removeClass('scrollUp');
        navbarmobile.removeClass('scrollUp');
      } else if (currentScrollPos > navbarHeight) {
        navbar.addClass('scrollUp');
        navbarmobile.addClass('scrollUp');
      }
  
      prevScrollPos = currentScrollPos;
    });
  });
  
var Btn = document.getElementById("Btn-Menu-1");
var Btnx = document.getElementById("Btn-Menu-2");
var Btn2 = document.getElementById("Btn-Toggle");
var Left = document.getElementById("Left");
var Right = document.getElementById("Right");
var NavContainer = document.getElementById("NavContainer");
var NavTitle = document.getElementById("NavTitle");
var NavOther = document.getElementById("NavOther");
var NavBtn = document.getElementById("NavBtn");
var NavBtn2 = document.getElementById("NavBtn2");

var BtnMobile = document.getElementById("Btn-Menu-1-Mobile");
var BtnxMobile = document.getElementById("Btn-Menu-2-Mobile");
var Btn2Mobile = document.getElementById("Btn-Toggle-Mobile");
var NavTitleMobile = document.getElementById("NavTitle-Mobile");
var NavBtnMobile = document.getElementById("NavBtn-Mobile");
var NavBtn2Mobile = document.getElementById("NavBtn2-Mobile");
var NavContainerMobile = document.getElementById("NavContainer-Mobile");
var SideNavMobile = document.getElementById("SideNavMobile");



Btn2.addEventListener('click', ()=> {
    if (window.innerWidth > 1050){
    Btn.classList.toggle("activeToggle");
    Btnx.classList.toggle("activeToggle");
    Left.classList.toggle("activeToggle");
    Right.classList.toggle("activeToggle");
    NavContainer.classList.toggle("activeToggle");
    NavTitle.classList.toggle("activeToggle");
    NavOther.classList.toggle("activeToggle");
    NavBtn.classList.toggle("activeToggle");
    NavBtn2.classList.toggle("activeToggle");
}
});

Btn2Mobile.addEventListener('click', ()=>{
    if (window.innerWidth < 1050){
    BtnMobile.classList.toggle("activeToggle");
    BtnxMobile.classList.toggle("activeToggle");
    NavTitleMobile.classList.toggle("activeToggle");
    NavBtnMobile.classList.toggle("activeToggle");
    NavBtn2Mobile.classList.toggle("activeToggle");
    NavContainerMobile.classList.toggle("activeToggle");
    SideNavMobile.classList.toggle("activeToggle");
    }
});

var SubMenu = document.getElementById('SubMenuMobile');
var SubMenu2 = document.getElementById('SubMenuMobileContent');

SubMenu.addEventListener('click', ()=> {
    SubMenu2.classList.toggle("activeToggle");
})

var SubMenu3 = document.getElementById('SubMenuMobile2');
var SubMenu4 = document.getElementById('SubMenuMobileContent2');

SubMenu3.addEventListener('click', ()=> {
    SubMenu4.classList.toggle("activeToggle");
})

document.addEventListener('DOMContentLoaded', function () {
  const peanuts = document.getElementById('imagePeanuts');
  const peanutsImage = document.getElementById('peanutsImage');
  const closePeanuts = document.getElementById('closePeanuts');
  const imageLinks = document.querySelectorAll('a.image-link');

  imageLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const imageUrl = link.getAttribute('href');
      peanutsImage.setAttribute('src', imageUrl);
      peanuts.style.display = 'flex'; 
    });
  });

  closePeanuts.addEventListener('click', function () {
    peanuts.style.display = 'none'; 
  });

  peanuts.addEventListener('click', function (e) {
    if (e.target === peanuts) {
      peanuts.style.display = 'none';
    }
  });
});

var closeModalButton = document.getElementById('closeModal');
        closeModalButton.addEventListener('click', function() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        });