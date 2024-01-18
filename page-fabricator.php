<?
/*
Template Name: Производители
Template Post Type: page
*/
?>
<?get_header();?>
<?woocommerce_breadcrumb();?>
<?
$tax = 'pa_proizvoditel';
//желательно проставить hide_empty в значение true, чтобы показать только тех производителей, к которым есть привязанные товары
$terms = get_terms($tax, array('hide_empty' => false,'orderby' => 'name','order' => 'ASC'));
if ($terms && ! is_wp_error($terms)) {
    $title_page = get_the_title();
    echo '<div class="fabricator"><h1 class="fabricator__title">'.$title_page.'</h1><div class="container"><div class="four-cards">';
    foreach($terms as $attr){
        if ($attr) {
            $id = $attr->term_id;
            $title = $attr->name;
            $url = get_term_link($id);
            $img_url = get_field('fabricator-img', $tax . '_' . $id);
            echo '<a href="'.$url.'" class="fabricator__img">
                <img src="'.$img_url.'" alt="Производитель '.$title.'">
            </a>';
        }
    }
    echo '</div></div></div>';
}
?>
<?get_footer();?>