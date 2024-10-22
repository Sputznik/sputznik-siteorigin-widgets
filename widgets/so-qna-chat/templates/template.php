<?php
$user_one_image_title = $instance['user_one_image_title'] ? $instance['user_one_image_title'] : "User One";
$user_two_image_title = $instance['user_two_image_title'] ? $instance['user_two_image_title'] : "User Two";
?>
<div class="sp-qna-chat">
  <div class="">
    <?php foreach( $instance['messages'] as $item ): $user_one_msg = $item['user_one_msg']; $user_two_msg = $item['user_two_msg']; ?>
      <?php if( $user_one_msg ): ?>
        <div class="question">
          <?php if( $instance['user_one_image'] ): $user_one_image = wp_get_attachment_image_src( $instance['user_one_image'], 'full' )[0]; ?>
            <div class="user-img" style="background-image:url(<?php _e( $user_one_image ); ?>);" title="<?php _e( $user_one_image_title ); ?>"></div>
          <?php endif; ?>
          <div class="message">
            <?php _e( $user_one_msg ); ?>
          </div>
        </div>
      <?php endif; ?>
      <?php if( $user_two_msg ): ?>
        <div class="answer">
          <?php if( $instance['user_two_image'] ): $user_two_image = wp_get_attachment_image_src( $instance['user_two_image'], 'full' )[0]; ?>
            <div class="user-img" style="background-image:url(<?php _e( $user_two_image ); ?>);" title="<?php _e( $user_two_image_title ); ?>"></div>
          <?php endif; ?>
          <div class="message">
            <?php _e( $user_two_msg ); ?>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach;?>
  </div>
</div>
