<?get_header();?>
<div class="video">
	<?woocommerce_breadcrumb();?>
	<h1 class="page__title"><?echo wp_title('',false);?></h1>
	<div class="container">
		<div class="four-cards">
			<?
			$my_posts = get_posts(array(
				'numberposts' => 5,
				'category'    => 122,
				'orderby'     => 'date',
				'order'       => 'DESC',
				'include'     => array(),
				'exclude'     => array(),
				'meta_key'    => '',
				'meta_value'  =>'',
				'post_type'   => 'post',
				'suppress_filters' => true,
			));
			global $post;
			foreach($my_posts as $post){
				setup_postdata($post);
				$video_id = get_field('post-video-id');
				$video_bgc_max = 'https://i.ytimg.com/vi/'.$video_id.'/maxresdefault.jpg';
				$video_bgc_sd = 'https://i.ytimg.com/vi/'.$video_id.'/sddefault.jpg';
				if (@getimagesize($video_bgc_max)) {
					$url_bgc = $video_bgc_max;
				}
				else if (@getimagesize($video_bgc_sd)) {
					$url_bgc = $video_bgc_sd;
				}
				else {
					$url_bgc = ''.get_template_directory_uri().'/assets/img/bg/preview-video.jpg';
				}
				?>
				<div class="video-card btn-play" data-id="<?echo $video_id;?>">
					<div class="video-card__video" style="background-image: url('<?echo $url_bgc;?>')"></div>
					<div class="video-card__btn">
						<h2 class="video-card__title"><?the_title();?></h2>
					</div>
				</div>
				<?
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</div>
<div class="player__video popup-video" data-loaded="false">
	<button class="close-button"></button>
	<div class="video" data-params="color=white&enablejsapi=1">
	</div>
	<div class="block__video-error loader-error">
		<span>
			<svg width="50" height="45" viewBox="0 0 50 45" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1221_26932)"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.5607 44.5175C9.03165 40.1163 16.8458 37.5915 25.0001 37.5915C33.1544 37.5915 40.9686 40.1163 46.4396 44.5175C46.8438 44.8435 47.3292 45.0013 47.8112 45.0013C48.4495 45.0013 49.0836 44.7232 49.516 44.1873C50.274 43.2479 50.1253 41.8724 49.1844 41.1155C42.9504 36.1 34.1346 33.2227 25.0001 33.2227C15.8656 33.2227 7.04991 36.1 0.815826 41.1155C-0.125909 41.8724 -0.27375 43.2479 0.484253 44.1873C1.24226 45.1259 2.61982 45.2752 3.5607 44.5175Z" fill="#EE523F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M49.3588 0.639956C48.5051 -0.213319 47.1198 -0.213319 46.2653 0.639956L41.3216 5.57615L36.377 0.639956C35.5233 -0.213319 34.1381 -0.213319 33.2835 0.639956C32.4289 1.49237 32.4289 2.87553 33.2835 3.72881L38.2272 8.665L33.2835 13.602C32.4289 14.4544 32.4289 15.8376 33.2835 16.6909C34.1372 17.5442 35.5225 17.5442 36.377 16.6909L41.3216 11.7547L46.2653 16.6909C46.6926 17.1175 47.2523 17.3308 47.812 17.3308C48.3718 17.3308 48.9315 17.1175 49.3588 16.6909C50.2134 15.8376 50.2134 14.4544 49.3588 13.602L44.4151 8.665L49.3588 3.72881C50.2134 2.87553 50.2134 1.49237 49.3588 0.639956Z" fill="#EE523F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M0.641415 16.6918C1.49513 17.5442 2.88039 17.5442 3.73496 16.6909L8.67864 11.7547L13.6223 16.6909C14.0496 17.1175 14.6094 17.3309 15.1691 17.3309C15.7289 17.3309 16.2895 17.1175 16.7159 16.6909C17.5705 15.8385 17.5705 14.4553 16.7167 13.6021L11.7731 8.66586L16.7167 3.72881C17.5705 2.87639 17.5705 1.49323 16.7159 0.639956C15.8622 -0.212465 14.4769 -0.213319 13.6223 0.639956L8.67864 5.57615L3.73496 0.639956C2.88039 -0.213319 1.49513 -0.213319 0.641415 0.639956C-0.213154 1.49323 -0.213154 2.87639 0.641415 3.72881L5.5851 8.66586L0.641415 13.6021C-0.213154 14.4553 -0.213154 15.8385 0.641415 16.6918Z" fill="#EE523F"/></g><defs><clipPath id="clip0_1221_26932"><rect width="50" height="45" fill="white"/></clipPath></defs></svg>
		</span>
		<div class="page-reload btn">Перезагрузить</div>
	</div>
	<div class="play__btn play-btn-popup-video"></div>
</div>
<?get_footer();?>