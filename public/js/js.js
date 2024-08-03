$(document).ready(function(){




    $('.menu-toggle').click(function(){
        $('.nav-menu').toggleClass('open');
        $(this).toggleClass('open');
    });


    $('.menuList').click(function(){
        $('.menu-dropdown').toggleClass('menuDP-Mobile');
    });


   

    $('#grid').click(function() {
        $('.list').css('display', 'none');
        $('.grid').css('display', 'flex');
        $('.listing-map').css('width', '35%');
        $('.list-items').css('display', 'flex');
        $('.listing-map iframe').css('position', 'absolute');
        $('.map-toggle img').css('display', 'block');
        $('.pagination').css('display', 'flex');
    });

    $('#list').click(function() {
        $('.grid').css('display', 'none');
        $('.list').css('display', 'block');
        $('.listing-map').css('width', '35%');
        $('.list-items').css('display', 'flex');
        $('.listing-map iframe').css('position', 'absolute');
        $('.map-toggle img').css('display', 'block');
        $('.pagination').css('display', 'none');
    });

    $('#map').click(function() {
        $('.grid').css('display', 'none');
        $('.list').css('display', 'none');
        $('.listing-map').css('width', '100%');
        $('.list-items').css('display', 'none');
        $('.listing-map iframe').css('position', 'relative');
        $('.map-toggle img').css('display', 'none');
        $('.pagination').css('display', 'none');
    });



    $('.map-toggle img').click(function(){
        $('.listing-map iframe').toggleClass('closeMap');
        $('.listing-map').toggleClass('closeMap');
        $('.list-items').toggleClass('list-itemmapClose');
        $('.list-item').toggleClass('list-itemMapClose');
        $('.map-toggle img').toggleClass('mapImg');
        $('.card-items.grid').toggleClass('card-items-grid-Active');
    });

    var navbar = $('#navbar');
    var sticky = navbar.offset().top;

    $(window).scroll(function() {
        if (window.pageYOffset >= sticky) {
            navbar.addClass('sticky');
        } else {
            navbar.removeClass('sticky');
        }
    });



});



// const dropdowns = document.querySelectorAll('.prop-type');


// dropdowns.forEach(dropdown => {
//     const select = dropdown.querySelector('.prop-name');
//     const chevo = dropdown.querySelector('.chevo');
//     const menuOpt = dropdown.querySelector('.prop-list');


//     select.addEventListener('click', () =>{
//         menuOpt.classList.toggle('prop-list-active');
//         chevo.classList.toggle('chevo-active');
//     })
// })



const dropdowns = document.querySelectorAll('.prop-type');

dropdowns.forEach(dropdown => {
    const select = dropdown.querySelector('.prop-name');
    const chevo = dropdown.querySelector('.chevo');
    const menuOpt = dropdown.querySelector('.prop-list');

    select.addEventListener('click', () => {
        // Close all active dropdowns
        dropdowns.forEach(dd => {
            if (dd !== dropdown) {
                dd.querySelector('.prop-list').classList.remove('prop-list-active');
                dd.querySelector('.chevo').classList.remove('chevo-active');
            }
        });

        // Toggle the current dropdown
        menuOpt.classList.toggle('prop-list-active');
        chevo.classList.toggle('chevo-active');
    });


});