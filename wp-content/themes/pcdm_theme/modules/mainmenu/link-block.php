<?php
  $link_type = get_sub_field('link_type');
  $link = "#";
  switch ($link_type) {
    case 'season':
      $tax = get_sub_field('link_href');
      if($tax)
        $link = get_term_link(get_sub_field('link_href'));
      break;
    case 'external':
      $link = get_sub_field('external_link');
      break;
  }
?>

<a
  href="<?php echo $link;?>"
  class="links-block__link"
  data-image="<?php $img=wp_get_attachment_image_src( get_sub_field('link_hover_image'), 'full'); echo $img[0]; ?>">
  <span>
    <?php the_sub_field('link_label');?>
  </span>
</a>