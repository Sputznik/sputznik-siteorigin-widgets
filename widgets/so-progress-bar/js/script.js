jQuery(document).ready( function(){
  jQuery('[data-behaviour="so-sp-progress"]').each( function(){
    var $widget = jQuery(this);

    var $progressBar = $widget.find('.so-sp-progress');
    var $fill = $widget.find('.so-sp-progress-fill');

    var current = parseFloat($progressBar.attr('aria-valuenow')) || 0;
    var max = parseFloat($progressBar.attr('aria-valuemax')) || 100;

    // CALCULATE PERCENTAGE
    var percentage = 0;
    if( max > 0 ){
      percentage = (current / max) * 100;
      percentage = Math.max(0, Math.min(100, percentage));
    }

    $fill.css('width', percentage + '%');

  });
});
