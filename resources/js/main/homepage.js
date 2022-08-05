//Select element function
const selectElement = function(element){
    return document.querySelector(element);
};

let menuToggler = selectElement('.menu-toggle'); /* Quero selecionar o menu-toggle */
let body = selectElement('body'); /* Quero selecionar o body */

menuToggler.addEventListener('click', function(){
    body.classList.toggle('open');
});


//Scroll reveal

window.sr = ScrollReveal();

sr.reveal('.animate-left',{
    origin: 'left',
    duration: 1000,
    distance: '25rem',
    delay: 300 //Quanto tempo demora a animacao a comecar
});

sr.reveal('.animate-right',{
    origin: 'right',
    duration: 1000,
    distance: '25rem',
    delay: 600 //Quanto tempo demora a animacao a comecar
});

sr.reveal('.animate-top',{
    origin: 'top',
    duration: 1000,
    distance: '25rem',
    delay: 600 //Quanto tempo demora a animacao a comecar
});

sr.reveal('.animate-bottom',{
    origin: 'bottom',
    duration: 1000,
    distance: '25rem',
    delay: 600 //Quanto tempo demora a animacao a comecar
});

