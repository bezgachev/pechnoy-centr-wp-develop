<?get_header();?>
<?woocommerce_breadcrumb();?>
<div class="container full-paper">
    <h1><?the_title();?></h1>
    <div>
        <?$img_gallery = get_field('post-article-img');
        echo '<img src="'.$img_gallery.'" alt="img-article">';
        ?>
    </div>
    <?the_content();?>
</div>
<?get_footer();?>