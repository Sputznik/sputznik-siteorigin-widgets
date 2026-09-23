<?php
/**
 * Widget Layout Name: Default Layout
 *
 * @var array $instance
 * @var SP_PROGRESS_BAR $this
 */
$data = $this->get_layout_data( $instance );
?>
<div class="so-sp-progress-wrap layout-default" data-behaviour="so-sp-progress">
	<div
		class="so-sp-progress"
		role="progressbar"
		aria-valuenow="<?php echo esc_attr( $data['current']['value'] ); ?>"
		aria-valuemin="0"
		aria-valuemax="<?php echo esc_attr( $data['max']['value'] ); ?>"
		aria-valuetext="<?php echo esc_attr( $data['aria_value_text'] ); ?>"
	>
		<div class="so-sp-progress-track" style="background-color: <?php echo $data['track']['bg_color']; ?>;">
			<div class="so-sp-progress-fill" style="background-color: <?php echo $data['track']['fg_color']; ?>;"></div>
		</div>
	</div>
	<div class="so-sp-progress-labels" aria-hidden="true">
		<span class="so-sp-current-label">
			<?php echo $data['current']['prefix'] . $data['current']['percentage'] . $data['current']['suffix']; ?>
		</span>
		<span class="so-sp-max-label">
			<?php echo $data['max']['prefix'] . $data['max']['value'] . $data['max']['suffix']; ?>
		</span>
	</div>
</div>
