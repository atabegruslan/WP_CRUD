<?php
/**

if(is_single()){
	get_template_part( 'template-parts/posts/single');
	comments_template( string $file = '/comments.php', bool $separate_comments = false )

 */
if ( post_password_required() ) {
	return;
}
?>

<div>

	<?php if ( have_comments() ) : ?>

		<h3>
			<?php
				printf( // WPCS: XSS OK.
					esc_html(
						_nx( 
							'One thought on &ldquo;%2$s&rdquo;', 
							'%1$s thoughts on &ldquo;%2$s&rdquo;', 
							get_comments_number(), 
							'comments title'
						) 
					),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h3>

		<ol>
			<?php
				wp_list_comments();
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

			<nav>
				<h2>
					<?php esc_html_e( 'Comment navigation' ); ?>
				</h2>

				<div>
					<div><?php previous_comments_link( esc_html__( 'Older Comments' ) ); ?></div>
					<div><?php next_comments_link( esc_html__( 'Newer Comments' ) ); ?></div>
				</div>
			</nav>

		<?php endif; ?>

	<?php endif; ?>


	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p><?php esc_html_e( 'Comments are closed.' ); ?></p>
	<?php endif; ?>


	<?php comment_form(); ?>

</div>
