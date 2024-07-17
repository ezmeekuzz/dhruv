$(document).ready(function(){
    $('.menu-toggle').click(function(){
        $('.nav-menu').toggleClass('open');
    });




    // $('.prop-type').click(function(){
    //     $('.prop-list').addClass('active');
    //     $('.prop-type').addClass('prop-type-active');
    // });


    // $('.prop-type').click(function(event){
    //     event.stopPropagation(); // Prevent the click event from propagating to the document
    //     $('.prop-list').addClass('active');
    //     $('.prop-type').addClass('prop-type-active');
    // });

    // $(document).click(function(event) {
    //     if (!$(event.target).closest('.prop-type, .prop-list').length) {
    //         // Remove the .active and .prop-type-active classes
    //         $('.prop-list').removeClass('active');
    //         $('.prop-type').removeClass('prop-type-active');
    //     }
    // });


    $('#grid').click(function() {
        $('.list').css('display', 'none');
        $('.grid').css('display', 'flex');
        $('.listing-map').css('width', '35%');
        $('.list-items').css('display', 'flex');
    });

    $('#list').click(function() {
        $('.grid').css('display', 'none');
        $('.list').css('display', 'block');
        $('.listing-map').css('width', '35%');
        $('.list-items').css('display', 'flex');
    });

    $('#map').click(function() {
        $('.grid').css('display', 'none');
        $('.list').css('display', 'none');
        $('.listing-map').css('width', '100%');
        $('.list-items').css('display', 'none');
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