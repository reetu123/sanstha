jQuery(document).ready(function($){
  $('.slider-for').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: true,
    dots:false,
    autoplay:true,
    centerMode: false,
    speed: 500,
    responsive: [
    {
      breakpoint: 1200,
      settings: {
       slidesToShow: 4,
       slidesToScroll: 1
   }
},
{
    breakpoint: 767,
    settings: {
      speed: 400,
      slidesToShow: 3,
      slidesToScroll: 1
  }
},
{
    breakpoint: 575,
    settings: {
      speed: 400,
      slidesToShow: 2,
      slidesToScroll: 1
  }
},
{
    breakpoint: 399,
    settings: {
      speed: 400,
      slidesToShow: 1,
      slidesToScroll: 1
  }
}
]
});
});

jQuery(document).ready(function(){
    jQuery("#user_phone").mask('(000) 000-0000',{clearIfNotMatch:true});
    jQuery("#postcode").mask('000 000', {
        translation: {
            '0': {
                pattern: /[A-Za-z0-9]/, optional: false
            }
        }
    });
});

// jQuery(document).ready(function(){
//   var searchId = document.getElementById('search_location');
//   if(searchId){
//     alert(searchId);
//     initSearchAutocomplete();
// //    google.maps.event.addDomListener(searchId, 'keydown', function (event) {
// //      alert("here");
// //      initSearchAutocomplete();
// //    });
// }
// });


// jQuery(document).on('click','.other_text',function(){
//   if(jQuery('.other_text').is(":checked")){
//    jQuery(".additional_information").show();
// }
// else{
//    jQuery(".additional_information").hide();
// }
// });


/*jQuery(document).on('pagebeforeshow', '#index', function(){     
  jQuery(document).on('click', '.review a',function(e) {
        if(e.handled !== true) // This will prevent event triggering more then once
        {
          alert('Clicked');
          event.handled = true;
        }
      }); 
  });*/

  jQuery(document).on('click','.customReviewButton',function(){
      jQuery(".reviewForm").show();

  });


    /*jQuery(".my-rating-9").starRating({            
        initialRating: 1,
        minRating:1,
        disableAfterRate: false,
        onHover: function(currentIndex, currentRating, $el){
          jQuery('.live-rating').text(currentIndex);
      },
      onLeave: function(currentIndex, currentRating, $el){
          jQuery('.live-rating').text(currentRating);
      }
  });*/
 /*   jQuery(document).on('submit','form.submitReviews',function(e){
      alert("submit");
    // e.preventDefault();
    var raiting = jQuery(".live-rating").text();
    // alert(raiting);
    // var title= jQuery(".reviewHeading").val();
    var desc= jQuery(".add_reviews").val();
    alert(desc);
    $.ajax({
      url: admin_ajax,
      type: 'post',
      data: {
        action: 'km_add_raiting',
        raiting: raiting,
        title: title,
        desc: desc
      },
      success: function (res) {
        if (res != '') {
          window.location.replace(window.location.href);
                // jQuery(".thanksReview").append("Thanks for your reviews");
              }
            }
          });
      });*/










