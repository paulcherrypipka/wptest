<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		twentyfifteen_post_thumbnail();
	?>

	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php $field_poster = get_field('films_poster', $id); if(!empty($field_poster)): ?>
			<img src="<?php print $field_poster['url']; ?>" alt="<?php print $field_poster['alt']; ?>" title="<?php print $field_poster['title']; ?>"/>
		<?php endif; ?>
		<?php if (get_field('films_genre', $id)): ?>
			<p><label>Genre:&nbsp</label><span><?php the_field('films_genre', $id); ?></span></p>
		<?php endif; ?>
		<?php if (get_field('films_author', $id)): ?>
				<p><label>Author:&nbsp</label><span><?php the_field('films_author', $id); ?></span></p>
		<?php endif; ?>
		<?php if(get_field('films_postlink', $id)): ?>
			<?php
			$post_url = get_field('films_postlink', $id);
			$post_id_linked = url_to_postid($post_url);
			$post_linked = get_post($post_id_linked);
			?>
			<p><label>Post:&nbsp</label><span><a href="<?php print $post_url; ?>"><?php print $post_linked->post_title; ?></a></span></p>
		<?php endif; ?>
		<?php if(get_field('films_rubric', $id)): ?>
		<?php $field_rubric_ids = get_field('films_rubric', $id); ?>
		<ul>
		<?php foreach($field_rubric_ids as $rubric_id): ?>
			<li>
			<?php
			$rubric_term = get_term($rubric_id);
			$rubric_link = get_term_link($rubric_id);
			?>
				<a href="<?php print $rubric_link; ?>"><?php print $rubric_term->name; ?></a>
			</li>
		<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'twentyfifteen' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
		<?php twentyfifteen_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
