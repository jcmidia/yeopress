<?php 
get_header(); 

$post_slug=get_post_type();
$page = get_page_by_title($post_slug);
$image = wp_get_attachment_image_src( get_post_thumbnail_id($page->ID), 'full' ); 
?>

<article id="page-<?php echo $post_slug ?>" class="page-content">
	<header class="header-default bg-parallax" data-speed="15" style="background-image:url('<?php echo $image[0] ?>');">
		<div class="content-cell">
			<h1 class="title-h1"><?php echo $post_slug ?></h1>
		</div>
	</header>
	<?php get_template_part('parts/content', $post_slug); ?>
	<?php get_template_part("parts/template", "otherlinks"); ?>
</article>
<?php get_footer(); ?>
