jQuery(document).ready(function(){

  jQuery("[data-behaviour~=sp-typed-js]").each(function(){
    var $this = jQuery( this ),
        typewriter_name = $this.data("name"),
        loop = parseInt( $this.data('loop') ),
        input_id = `sp-typed-js-ip-${typewriter_name}`,
        output_id = `sp-typed-js-op-${typewriter_name}`;

    new Typed(`#${output_id}`,{
     stringsElement: `#${input_id}`,
     loop: loop ? true : false,
     loopCount: $this.data('loop-count'),
     typeSpeed: $this.data('typeSpeed'),
     startDelay:  $this.data('start-delay'),
     backSpeed:  $this.data('back-speed'),
     backDelay:  $this.data('back-delay')
    });

  });

});
