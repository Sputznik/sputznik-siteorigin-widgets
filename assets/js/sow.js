jQuery('.sp-floating-btn').each( function(){

  var $btn      = jQuery( this ),
    row_id      = jQuery( $btn ).data( 'popup' ),
    scroll_top  = 400;

  function display(){
    if( window.pageYOffset >= scroll_top ){ jQuery( $btn ).fadeIn(); }
    else{ jQuery( $btn ).fadeOut(); }
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

jQuery("[data-behaviour~=inline-modal]").each( function(){

  var $modal = jQuery( this ),
    $overlay = $modal.find( '.inline-overlay' ),
    $closeBtn = $modal.find( 'button.close' );

    $overlay.click( function( ev ){
      hideModal();
    });

    $closeBtn.click( function( ev ){
      ev.preventDefault();
      hideModal();
    });

    function hideModal(){
      $modal.removeClass('show-modal');
    }

});

jQuery("[data-toggle~=modal]").each( function(){

  var $button = jQuery( this );

  $button.click( function( ev ){
    ev.preventDefault();

    var $modal = jQuery( $button.attr( 'href' ) );


    $modal.addClass('show-modal');
  });

});
