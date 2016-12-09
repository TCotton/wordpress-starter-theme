<?php if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'sidebar.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( 'Please do not load this page directly. Thanks!' );
}
?>

<div class="sidebar clearfix">

	<?php //var_dump(dynamic_sidebar( 'sidebar1' )); ?>
	<?php dynamic_sidebar( 'primary' ); ?>

	<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar1' ); ?>
	<?php else : ?>

    <!-- This content shows up if there are no widgets defined in the backend. -->

    <div class="alert help">
      <p>Please activate some Widgets.</p>
    </div>
	<?php endif; ?>
</div>
