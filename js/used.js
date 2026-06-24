'use strict';

(function ($) {
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Car filter
        --------------------*/
        $('.filter__controls li').on('click', function () {
            $('.filter__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.car-filter').length > 0) {
            var containerEl = document.querySelector('.car-filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*--------------------------
        Car Filter
    ----------------------------*/
    $(".car__item__pic__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: false
    });

    $(document).ready(function(){
        var lastScrollTop = 0;
        $(window).scroll(function(event){
          var st = $(this).scrollTop();
          if (st > lastScrollTop){
            $('#navbar').addClass('hidden');
          } else {
            $('#navbar').removeClass('hidden');
          }
          lastScrollTop = st;
        });
      });
      

})(jQuery);


$(document).ready(function(){
    // Initially hide cars that are not 'new'
    $('.car-filter').children().not('.used').css('display', 'none');

    // When a filter is clicked
    $('.filter__controls li').on('click', function(){
        // Get the filter value
        var filterValue = $(this).attr('data-filter');

        // Show cars matching the selected filter
        $('.car-filter').children(filterValue).css('display', 'block');
    });
});