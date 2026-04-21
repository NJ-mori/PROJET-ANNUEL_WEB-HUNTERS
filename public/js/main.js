"use strict()";
const bouton = document.querySelector("#btn");
const DarkMode = ".darkMode";
const body = document.querySelector("body");

bouton.addEventListener("click", function () {
  body.classList.toggle("darkMode");
});
