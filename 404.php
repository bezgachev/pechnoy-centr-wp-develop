<?
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package weblitex
 */
get_header();?>
<section class="page-error">
	<h1>Страница не найдена</h1>
	<p>Воспользуйтесь поиском или вернитесь на главную страницу</p>
	<div class="page-error__background">
		<i class="fly-not"></i>
	</div>
	<a href="<?echo get_site_url();?>" class="btn">Вернуться на главную</a>
</section>
<?get_footer();?>