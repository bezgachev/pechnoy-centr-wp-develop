<?
/*
Template Name: Монтажные услуги
Template Post Type: page
*/
?>
<?get_header();?>
<div class="mounting-page">
<?woocommerce_breadcrumb();?>
<section class="mounting" style="background-image: url(<?echo the_post_thumbnail_url($id, 'full');?>)">
	<div class="container">
		<div class="mounting__wrapper">
			<h1 class="mounting__title"><? echo get_field('services-h1');?></h1>
			<p class="mounting__subtitle"><? echo get_field('services-p');?></p>
			<div class="mounting__text"><? echo get_field('services-descr');?></div>
		</div>
	</div>
</section>
<section class="mounting-work">
	<h2 class="mounting-work__title">Этапы выполнения монтажных работ</h2>
	<div class="container mounting-work__items content-three-col">
    <?services_stages();?>
</section>
<?portfolio_block();?>
</div>
<?get_footer();?>