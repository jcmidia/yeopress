<?php 
get_header(); 

$post_slug=$post->post_name;

while (have_posts()) : the_post();

$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); 
?>

<article id="page-<?php echo $post_slug ?>" class="page-content">
	
	<section id="sobre-box-1" class="boxes-image">
		<?php if ($image): ?>
		<div class="col-image" style="background-image:url('<?php echo $image[0] ?>');"></div>
		<?php endif ?>
		<div class="col-text">
			<div class="container">
				<h2 class="title-h2 page-title"><?php the_title() ?></h2>
				<?php the_content() ?>
			</div>
		</div>
	</section>

</article>
<?php endwhile;?>
<?php get_footer(); ?>
