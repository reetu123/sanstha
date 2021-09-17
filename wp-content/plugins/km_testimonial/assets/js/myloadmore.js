// loadmore ajax
jQuery(function($){
    $('#load_more_posts').on('click', function(e){
        button = $('.misha_loadmore');
      //  alert("clickde");
      console.log('hi');
      e.preventDefault();
      var $offset = $(this).data('offset');
      console.log('var '+$offset);
      $.ajax({
        method: 'POST',
        url: ajax_object.ajax_url,
        type: 'JSON',
        data: {
            offset: $offset,
            action: 'load_more_posts',
            page : misha_loadmore_params.current_page,
        },
        beforeSend : function ( xhr ) {
                button.text('Loading...'); // change the button text, you can also add a preloader image
            },
            success:function(response){
                if(response.data.post != ''){

                    misha_loadmore_params.current_page++;

                    console.log(response.data.post);
                    $('#load_more_posts').data('offset', parseInt(response.data.offset));
                    button.html( '<a href="#" class="yellow-btn">More posts</a>' ).prev().after(response.data.post); // insert new posts
                    if ( misha_loadmore_params.current_page > misha_loadmore_params.max_page ){
                         button.remove(); // if last page, remove the button
                     }
                 }else{
                    button.remove();
                }
                

            }
        }); 
  })
});

