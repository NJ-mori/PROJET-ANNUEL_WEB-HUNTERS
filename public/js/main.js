"use strict()";
const body = document.querySelector("body");
const header = document.querySelector("header");
const footer = document.querySelector("footer");
const bouton = document.querySelector("#darkMode");

const btnMenu = document.querySelector(".menu-toggle");
const btnProfile = document.querySelector(".profile-button");
const menu = document.querySelector(".menu-dropdown");
const profilec = document.querySelector(".profile-dropdown-connected");
const profiled = document.querySelector(".profile-dropdown-disconnected");

bouton.addEventListener("click", function () {
  body.classList.toggle("darkModeBody");
  header.classList.toggle("darkModeHeader");
  footer.classList.toggle("darkModeFooter");
});

btnMenu.addEventListener("click", function () {
  menu.classList.toggle("menu_active");
});
btnProfile.addEventListener("click", function () {
  profilec.classList.toggle("profile_active");
  profiled.classList.toggle("profile_active");
});
