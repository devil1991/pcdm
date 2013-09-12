<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
get_header();
?>



<section class="press js-filtered-grid">
  <header class="header-press">
    <h1 class="title">/<?php echo _e('Press Coverage')?></h1>
    <a class="clear"><?php echo _e('Clear all filters')?></a>
    <div class="filter-content">
      
      <?php foreach (PcdmPress::getDefinedTaxonomies() as $tax_identifier):?>
      <?php $tax_obj = get_taxonomy($tax_identifier)?>
      <div class="wrap-filter" data-filter="<?php echo $tax_identifier?>">
        <h2 class="filter-title"><?php echo $tax_obj->label?></h2>
        <dl id="" class="filter">
          <dt class="label"><span>All</span></dt>
          <dd data-filter-reset="">
            <ul>
              <?php foreach(get_terms($tax_identifier) as $term):?>
              <li class="">
                <a href="#" data-value="<?php echo $term->term_id?>"><?php echo $term->name?></a>
              </li>
              <?php endforeach;?>
            </ul>
          </dd>
        </dl>
      </div>
      <?php endforeach;?>
    </div>
  </header>
  <ul class="press-list js-grid">
    <?php foreach (pcdm_get_press_archive() as $press_block): ?>
    <?php $img = wp_get_attachment_image_src($press_block[PcdmPress::TYPE_PREFIX . 'wall_image_id'],PcdmPress::TYPE_PREFIX .'wall_image' );?>
    <li class="item" data-id="<?php echo $press_block['ID']?>">
      <?php if(isset($press_block[PcdmPress::TYPE_PREFIX . 'pdf_file'])):?>
      <a href="<?php echo $press_block[PcdmPress::TYPE_PREFIX . 'pdf_file'] ?>" target="_blank">
      <?php endif;?>
      <img src="<?php echo $img[0] ?>" alt="">
      <?php if(isset($press_block[PcdmPress::TYPE_PREFIX . 'pdf_file'])):?>
      </a>
      <?php endif;?>
    </li>
    <?php endforeach;?>
  </ul>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>