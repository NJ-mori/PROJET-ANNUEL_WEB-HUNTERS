const monBouton = document.querySelector('#mon-super-btn');
const monTitre = document.querySelector('h1');

monBouton.addEventListener('click', function() {
    monTitre.classList.toggle('titre-actif');
})
