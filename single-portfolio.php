<?get_header();?>
<div class="works">
	<?
    $title = get_the_title();
    $id_url_portfolio = 532;
    $icon_home = '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.65 6.08932C13.6496 6.089 13.6492 6.08858 13.6489 6.08826L7.93803 0.377579C7.69461 0.134048 7.37097 0 7.02672 0C6.68246 0 6.35882 0.134048 6.11529 0.377579L0.407394 6.08537C0.405471 6.0873 0.403441 6.08932 0.401626 6.09125C-0.0982522 6.59401 -0.0973977 7.40973 0.404082 7.91121C0.633193 8.14043 0.935683 8.27309 1.25922 8.28708C1.27246 8.28836 1.2857 8.289 1.29906 8.289H1.52656V12.4916C1.52656 13.3233 2.20332 14 3.03506 14H5.26935C5.49589 14 5.6795 13.8163 5.6795 13.5898V10.2949C5.6795 9.91542 5.9883 9.60674 6.3678 9.60674H7.68564C8.06514 9.60674 8.37382 9.91542 8.37382 10.2949V13.5898C8.37382 13.8163 8.55743 14 8.78398 14H11.0183C11.8501 14 12.5268 13.3233 12.5268 12.4916V8.289H12.7378C13.082 8.289 13.4056 8.15495 13.6492 7.91132C14.1513 7.40909 14.1515 6.59187 13.65 6.08932ZM13.0692 7.33133C12.9806 7.41988 12.8629 7.46869 12.7378 7.46869H12.1166C11.8901 7.46869 11.7065 7.6523 11.7065 7.87885V12.4916C11.7065 12.871 11.3978 13.1797 11.0183 13.1797H9.19414V10.2949C9.19414 9.46318 8.51749 8.78642 7.68564 8.78642H6.3678C5.53595 8.78642 4.85919 9.46318 4.85919 10.2949V13.1797H3.03506C2.65567 13.1797 2.34688 12.871 2.34688 12.4916V7.87885C2.34688 7.6523 2.16327 7.46869 1.93672 7.46869H1.32619C1.31978 7.46826 1.31348 7.46794 1.30696 7.46783C1.18477 7.4657 1.07016 7.41721 0.984283 7.33122C0.801635 7.14857 0.801635 6.85132 0.984283 6.66856C0.984389 6.66856 0.984389 6.66846 0.984496 6.66835L0.984817 6.66803L6.69549 0.957565C6.78393 0.869019 6.90153 0.820312 7.02672 0.820312C7.15179 0.820312 7.26939 0.869019 7.35794 0.957565L13.0673 6.66685C13.0682 6.66771 13.0692 6.66856 13.07 6.66942C13.2517 6.85239 13.2514 7.149 13.0692 7.33133Z" fill="#2E2C2C" /></svg>';
	echo '<div class="bread-crumb container">';
	echo '<a href="' . get_site_url() . '">'.$icon_home.'</a>';
    echo '<a href="' . get_permalink($id_url_portfolio)  . '">'.get_the_title($id_url_portfolio).'</a>';
    echo '<span>'.$title.'</span>';
	echo '</div>';
    ?>
    <div class="container">
        <div class="work">
            <div class="work__descr">
                <h1 class="work__descr_title"><?echo $title;?></h1>
				<div class="work__descr_text">
					<?=the_content();?>
				</div>
            </div>
            <div class="work__slider swiper">
                <div class="swiper-wrapper">
                    <?$img_gallery = get_field('portfolio-imgs');
                    foreach ($img_gallery as $img) {
                        if ($img) {
                            echo '<div class="card-work__swiper_slide swiper-slide"><img src="'.$img.'" alt="img-portfolio"></div>';
                        }
                    }?>
                </div> <span class="work__slider_bg"></span>
                <div class="work__slider_btn">
                    <div class="work-prev"></div>
                    <div class="work-next"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?get_footer();?>