<?get_header();?>
<div class="news page">
	<?woocommerce_breadcrumb();?>
	<h1 class="page__title"><?echo wp_title('',false);?></h1>
	<div class="container">
		<div class="four-cards">
			<?
			$my_posts = get_posts(array(
				'numberposts' => 5,
				'category'    => 1,
				'orderby'     => 'date',
				'order'       => 'DESC',
				'include'     => array(),
				'exclude'     => array(),
				'meta_key'    => '',
				'meta_value'  =>'',
				'post_type'   => 'post',
				'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
			));
			global $post;
			foreach($my_posts as $post){
				setup_postdata($post);
				?>
				<a href="<?the_permalink();?>" class="page-card">
					<div class="page-card__img">
						<?$img_gallery = get_field('post-news-imgs');
						foreach ($img_gallery as $index => $img) {
							if ($img) {
								if ($index === 0) {
									echo '<img src="'.$img_gallery[$index].'" alt="img-news">';
								}
							}
						}
						?>
					</div>
					<div class="page-card__body">
						<h2 class="page-card__body_title"><?the_title();?></h2>
						<div class="page-card__body_text">
							<?
							$desc_content = get_the_content();
							$desc_content_text = mb_strimwidth(strip_tags($desc_content), 0, 238, '...'); 
							echo $desc_content_text;
							?>
					</div>
						<div class="page-card__body_data"><?echo date_i18n('j F Y', false);?></div>
					</div>
				</a>
			<?
			}
			wp_reset_postdata(); // сброс
			?>
		</div>
	</div>
</div>
<?get_footer();?>