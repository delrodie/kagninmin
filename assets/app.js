/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
//import './bootstrap';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

global.$ = global.jQuery = $;

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

document.addEventListener("DOMContentLoaded", function(){
    let topBtn = document.getElementById('btnToTop');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            document.getElementById('navbar_top').classList.add('fixed-top');
            // add padding top to show content behind navbar
            navbar_height = document.querySelector('.navbar').offsetHeight;
            document.body.style.paddingTop = navbar_height + 'px';
            document.getElementById('navbar_top').classList.remove('bg-menu');
            document.getElementById('navbar_top').classList.add('bgmenu-scrol');
            topBtn.style.display = "block";
        } else {
            document.getElementById('navbar_top').classList.remove('fixed-top');
            // remove padding top from body
            document.body.style.paddingTop = '0';
            document.getElementById('navbar_top').classList.add('bg-menu');
            document.getElementById('navbar_top').classList.remove('bgmenu-scrol');
            topBtn.style.display = "none";
        }
    });

    if (window.innerWidth > 992) {

        document.querySelectorAll('.navbar .nav-item').forEach(function(everyitem){

            everyitem.addEventListener('mouseover', function(e){

                let el_link = this.querySelector('a[data-bs-toggle]');

                if(el_link != null){
                    let nextEl = el_link.nextElementSibling;
                    el_link.classList.add('show');
                    nextEl.classList.add('show');
                }

            });
            everyitem.addEventListener('mouseleave', function(e){
                let el_link = this.querySelector('a[data-bs-toggle]');

                if(el_link != null){
                    let nextEl = el_link.nextElementSibling;
                    el_link.classList.remove('show');
                    nextEl.classList.remove('show');
                }


            })
        });

    }
});

$(document).ready(function(){
    $('.logo-partenaires').slick({
        slidesToShow: 9,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false,
        responsive:[
            {
                breakpoint:1024,
                settings:{
                    slidesToShow: 6,
                    slidesToScroll:1,
                    Infinite: true,
                }
            },
            {
                breakpoint:768,
                settings:{
                    slidesToShow: 4,
                    slidesToScroll:1,
                    Infinite: true,
                }
            },
            {
                breakpoint:480,
                settings:{
                    slidesToShow: 3,
                    slidesToScroll:1,
                    Infinite: true,
                }
            },
        ]
    });
});

$(document).ready(function () {
    $("#btnToTop").on('click', function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    })
})

$(document).ready(function () {
    if (window.matchMedia("(max-width: 425px)").matches) {
        document.getElementById('inputGroup').classList.add('input-group-sm');
    } else {
        /* the view port is less than 400 pixels wide */
    }

})
AOS.init();
