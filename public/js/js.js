$(document).ready(function(){


    // Title Dots 

    function truncateText(selector, maxLength) {
        $(selector).each(function() {
            var text = $(this).text();
            if (text.length > maxLength) {
                var truncated = text.substr(0, maxLength) + '...';
                $(this).text(truncated);
            }
        });
    }


    truncateText('.sliderTitle', 15); 




    // OM Toggle

    $('.open-om').click(function(){
        $('.modal-om').addClass('open-om-modal');
        $('body').addClass('offBody');
        $('.header-main').css('z-index', '0');
    });

    $('.close').click(function(){
        $('.modal-om').removeClass('open-om-modal');
        $('body').removeClass('offBody');
        $('.header-main').css('z-index', '1');
    });




    

    $('.menu-toggle').click(function(){
        $('.nav-menu').toggleClass('open');
        $(this).toggleClass('open');
    });


    $('.menuList').click(function(){
        $('.menu-dropdown').toggleClass('menuDP-Mobile');
    });


   

    $('#grid').click(function() {
        $('.list').css('display', 'none');
        $('.grid').css('display', 'block');
        $('.listing-map').css('width', '35%');
        $('.list-items').css('display', 'flex');
        $('.map-toggle img').css('display', 'block');
        $('.pagination').css('display', 'flex');
    });

    $('#list').click(function() {
        $('.grid').css('display', 'none');
        $('.list').css('display', 'block');
        $('.listing-map').css('width', '35%');
        $('.list-items').css('display', 'flex');
        $('.map-toggle img').css('display', 'block');
        $('.pagination').css('display', 'none');
    });

    $('#mapSection').click(function() {
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






    


    const itemsPerPage = 6;
const $items = $('.list-item');
const totalItems = $items.length;
const totalPages = Math.ceil(totalItems / itemsPerPage);

function showPage(pageNumber) {
    $items.hide();
    $items.slice((pageNumber - 1) * itemsPerPage, pageNumber * itemsPerPage).show();
}

function createPagination() {
    const $pagination = $('.pagination');
    $pagination.empty(); // Clear existing pagination
    for (let i = 1; i <= totalPages; i++) {
        const $btn = $('<button>')
            .addClass('pagination-btn')
            .attr('data-page', i)
            .text(i);
        $pagination.append($btn);
    }
}

function updatePagination(currentPage) {
    $('.pagination-btn').removeClass('active');
    $(`.pagination-btn[data-page="${currentPage}"]`).addClass('active');
}

// Initialize pagination
createPagination();
showPage(1); // Show first page initially

// Handle pagination button clicks
$(document).on('click', '.pagination-btn', function() {
    const pageNumber = $(this).data('page');
    showPage(pageNumber);
    updatePagination(pageNumber);
    
    // Scroll to the first item of the current page
    const $firstItem = $items.filter(':visible').first();
    $('html, body').animate({
        scrollTop: $firstItem.offset().top
    }, 500); // Adjust the duration as needed
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