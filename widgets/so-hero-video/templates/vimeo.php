<?php if( !empty( $instance['video_id'] ) ):?>
  <iframe src="https://player.vimeo.com/video/<?php _e( $instance['video_id'] );?>?background=1&autoplay=1&loop=1&byline=0&title=0"
       frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
<?php endif;?>
