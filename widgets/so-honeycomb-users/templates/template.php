
<!-- HONEYCOMB USER POPUP -->
<div class="sp-honeycomb">

  <div class="honeycomb-users">
    <?php foreach( $instance['honeycomb_users'] as $item ): $image_url = wp_get_attachment_url( $item['user_image'] ); ?>
      <?php
        $image = !empty( $image_url ) ? true : false;
        $name = !empty( $item['user_name'] ) ? true : false;
        $bio  = !empty( $item['user_bio'] ) ? true :  false;
      ?>
      <div class="honeycomb-user-card">
        <a data-target="#honeycomb-user-modal" data-behaviour="honeycomb-user-popup">
          <div class="honeycomb-user-body">
            <div class="user-thumbnail-bg" style="position: relative;">
              <?php if( $image ): ?>
                <img src="<?php _e( $image_url );?>" alt="Profile Picture">
              <?php endif; ?>
              <div class="overlay">
                <?php if( $name ): ?>
                  <h5 class="name"><?php _e( $item['user_name'] );?></h5>
                <?php endif; ?>
              </div>
            </div>
            <?php if( $bio ):?>
              <div class="bio" style="display:none;height:0;">
                <?php echo $item['user_bio'];?>
              </div>
            <?php endif; ?>
          </div>
        </a>
      </div>
      <div class="user-meta-sm">
        <?php if( $name ): ?>
				  <h5 class="name"><?php _e( $item['user_name'] );?></h5>
        <?php endif; ?>
        <?php if( $bio ): ?>
          <div class="bio">
            <?php echo $item['user_bio'];?>
          </div>
        <?php endif; ?>
		  </div>
    <?php endforeach;?>
  </div>
</div>
<!-- HONEYCOMB USER POPUP -->
