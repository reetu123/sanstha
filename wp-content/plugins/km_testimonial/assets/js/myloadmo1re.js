// loadmore ajax
jQuery(function($){
    $('#load_more_posts').on('click', function(e){
        button = $('.misha_loadmore');
        
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
                    button.text( 'More posts' ).prev().after(response.data.post); // insert new posts

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




// jQuery(function($){

//     //alert($(location).attr('href'));
//     $('.misha_loadmore').click(function(){
//     //alert("clicked");
//     // var offset =jQuery('.offfset').last().text();
//     // alert(offset);
//     //var ppp = 1;
//     var offset_value = 0;
//     var button = $(this),

//     data = {
//         'action': 'loadmore',
//                 'query': misha_loadmore_params.posts, // that's how we get params from wp_localize_script() function
//                 'page' : misha_loadmore_params.current_page,
//                 'offset' : offset_value
//             };

//             $.ajax({
//             url : misha_loadmore_params.ajaxurl, // AJAX handler
//             data : data,
//             type : 'POST',
//             // ppp: ppp,
//             // offset: offset,
//             beforeSend : function ( xhr ) {
//                 button.text('Loading...'); // change the button text, you can also add a preloader image
//             },
//             success : function( data ){
//                 if( data ) {
//                     //offset += ppp;
//                    //$('.misha_loadmore').data('offset',parseInt(data.data.offset));
//                     button.text( 'More posts' ).prev().after(data); // insert new posts
//                     misha_loadmore_params.current_page++;

//                     if ( misha_loadmore_params.current_page == misha_loadmore_params.max_page )
//                         button.remove(); // if last page, remove the button

//                     // you can also fire the "post-load" event here if you use a plugin that requires it
//                     // $( document.body ).trigger( 'post-load' );
//                 } else {
//                     button.remove(); // if no data, remove the button as well
//                 }
//               offset_value +=5;   
//               alert(offset_value);
//             }

//         });
//         });
// });