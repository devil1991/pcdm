<?php

class PcdmNews {
    /**
     * Definisce il nome del tipo di dato che utilizziamo
     */

    const TYPE_IDENTIFIER = 'pcdm_news';
    const TPL_LARGE = 'news_big';
    const TPL_SMALL = 'news_small';
    
    /**
     * Definisce il prefisso per i capi per questo tipo di dato
     */
    const TYPE_PREFIX = 'pcdm_news_';

    protected $do_not_translate;

    public function __construct() {
        $this->do_not_translate = array(
            'abstract',
            'seo_title',
            'seo_description'
        );
        add_action('init', array(&$this, 'defineType'));
        add_filter('cmb_meta_boxes', array(&$this, 'defineFields'));
        add_filter('pll_copy_post_metas', array(&$this, 'avoidTranslation'));
        //aggiunta delle dimensioni delle varie immagini
        add_image_size( 'pcdm_news_wall_image_big', 610, 676, FALSE );
        add_image_size( 'pcdm_news_wall_image_small', 293, 325, FALSE );
        add_image_size( 'pcdm_news_detail_image', 923, 761, FALSE );
        
    }

    /**
     * Per evitare la sincronizzazione di alcuni campi
     * 
     * @param type $metas
     * @return type
     */
    public function avoidTranslation($metas) {
        foreach ($this->do_not_translate as $key) {
            $key = array_search(self::TYPE_PREFIX . $key, $metas);
            if (!($key === FALSE)) {
                unset($metas[$key]);
            }
        }
        return $metas;
    }

    /**
     * Definisce il tipo di dato Prodotto da console di amministrazione         
     */
    public function defineType() {

        $labels = array(
            'name' => _x('News', 'post type general name'),
            'singular_name' => _x('News', 'post type singular name'),
            'add_new' => _x('Add New', 'home item'),
            'add_new_item' => __('Add News'),
            'edit_item' => __('Edit News Item'),
            'new_item' => __('New News Item'),
            'view_item' => __('View News Item'),
            'search_items' => __('Search News'),
            'not_found' => __('Nothing found'),
            'not_found_in_trash' => __('Nothing found in Trash'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'news',
                'with_front' => false
            ),
            'capability_type' => 'post',
            'hierarchical' => false, //non presenta gerarchia
            'menu_position' => null,
            'has_archive' => true,
            'supports' => array('title', 'editor')
        );

        register_post_type(self::TYPE_IDENTIFIER, $args);
    }

    public function defineFields($meta_boxes) {

        $meta_boxes[] = array(
            'id' => self::TYPE_PREFIX . 'fieldset_1',
            'title' => 'Abstract',
            'pages' => array(self::TYPE_IDENTIFIER),
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => false,
            'fields' => array(
                array(
                    'name' => 'Abstract',
                    'desc' => 'Specify an abstract for this news. It will be rendered on the news wall',
                    'id' => self::TYPE_PREFIX . 'abstract',
                    'type' => 'textarea_small'
                )
            )
        );
        
            $meta_boxes[] = array(
        'id' => self::TYPE_PREFIX . 'fieldset_6',
        'title' => 'Seo Title & Description',
        'pages' => array(self::TYPE_IDENTIFIER),
        'context' => 'normal',
        'priority' => 'low',
        'show_names' => true,
        'fields' => array(
            array(
                'name' => 'Seo Title',
                'desc' => 'Insert a seo title for this product',
                'id' => self::TYPE_PREFIX . 'seo_title',
                'type' => 'text'
            ),
            array(
                'name' => 'Seo Description',
                'desc' => 'Insert a seo description for this product',
                'id' => self::TYPE_PREFIX . 'seo_description',
                'type' => 'textarea_small'
            ),
        ),
    );
        
        $meta_boxes[] = array(
            'id' => self::TYPE_PREFIX . 'fieldset_2',
            'title' => 'Template',
            'pages' => array(self::TYPE_IDENTIFIER),
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => false,
            'fields' => array(
                array(
                    'name' => 'Template',
                    'desc' => 'Choose element template',
                    'id' => self::TYPE_PREFIX . 'hp_template',
                    'type' => 'radio_inline',
                    'options' => array(
                        array('name' => 'Big', 'value' => self::TPL_LARGE),
                        array('name' => 'Small', 'value' => self::TPL_SMALL),
                    )
                )
            )
        );



        $meta_boxes[] = array(
            'id' => self::TYPE_PREFIX . 'fieldset_3',
            'title' => 'Appearance',
            'pages' => array(self::TYPE_IDENTIFIER),
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => true,
            'fields' => array(
                array(
                    'name' => 'Color',
                    'desc' => 'Pick a color for the hover',
                    'id' => self::TYPE_PREFIX . 'hover_color',
                    'type' => 'colorpicker'
                ),
            ),
        );

        $meta_boxes[] = array(
            'id' => self::TYPE_PREFIX . 'fieldset_4',
            'title' => 'Images',
            'pages' => array(self::TYPE_IDENTIFIER),
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => true,
            'fields' => array(
                array(
                    'name' => 'Wall Image',
                    'desc' => 'Upload an image or enter an URL.',
                    'id' => self::TYPE_PREFIX . 'wall_image',
                    'type' => 'file',
                    'save_id' => true, // save ID using true
                    'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                ),array(
                    'name' => 'Detail image',
                    'desc' => 'Upload an image or enter an URL.',
                    'id' => self::TYPE_PREFIX . 'detail_image',
                    'type' => 'file',
                    'save_id' => true, // save ID using true
                    'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                ),
            ),
        );
        
        $meta_boxes[] = array(
            'id' => self::TYPE_PREFIX . 'fieldset_5',
            'title' => 'Slideshow',
            'pages' => array(self::TYPE_IDENTIFIER),
            'context' => 'normal',
            'priority' => 'low',
            'show_names' => true,
            'fields' => array(
                            array(
                                'name' => 'Slideshow 1',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_1',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),array(
                                'name' => 'Slideshow 2',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_2',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),array(
                                'name' => 'Slideshow 3',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_3',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),array(
                                'name' => 'Slideshow 4',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_4',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),array(
                                'name' => 'Slideshow 5',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_5',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),array(
                                'name' => 'Slideshow 6',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_6',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),array(
                                'name' => 'Slideshow 7',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_7',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),array(
                                'name' => 'Slideshow 8',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_8',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),array(
                                'name' => 'Slideshow 9',
                                'desc' => 'Upload an image or enter an URL.',
                                'id' => self::TYPE_PREFIX . 'slide_image_9',
                                'type' => 'file',
                                'save_id' => true, // save ID using true
                                'allow' => array('attachment') // limit to just attachments with array( 'attachment' )
                            ),
            ),
        );
        
        return $meta_boxes;
    }

}