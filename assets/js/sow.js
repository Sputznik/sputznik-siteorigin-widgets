jQuery('.sp-floating-btn').each( function(){

  var $btn      = jQuery( this ),
    row_id      = jQuery( $btn ).data( 'popup' ),
    scroll_top  = 400;

  function display(){
    if( window.pageYOffset >= scroll_top ){ console.log('show');jQuery( $btn ).fadeIn(); }
    else{ jQuery( $btn ).fadeOut(); console.log('hide');}
  }

  if( row_id ){
    rowOffset = jQuery( '#'+ row_id ).offset();
    scroll_top =  rowOffset.top + 145;
  }

  display();

  jQuery( window ).scroll( function(){
    display();
  });

});
