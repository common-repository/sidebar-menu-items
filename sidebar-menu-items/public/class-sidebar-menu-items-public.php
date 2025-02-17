<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/public
 * @author     Your Name <email@example.com>
 */
class Sidebar_Menu_Items_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $sidebar_menu_items    The ID of this plugin.
     */
    private $sidebar_menu_items;

    /**
     * The version of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.1.0
     * @param      string    $sidebar_menu_items       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($sidebar_menu_items, $version)
    {
        $this->sidebar_menu_items = $sidebar_menu_items;
        $this->version = $version;
    }

    public function replace_anchor($item_output, $item, $depth, $args)
    {
        if($this->is_sidebar_menu_object($item)) {
            $class = "{$this->sidebar_menu_items}-{$item->post_name}";
            $item_output = str_replace('<a', '<div class="' . $class . '"',
                str_replace('</a>', '</div>', $item_output)
            );
        }

        return $item_output;
    }

    public function add_sidebar($title, $item, $args, $depth)
    {
        if($this->is_sidebar_menu_object($item)) {
            ob_start();
            dynamic_sidebar($this->get_sidebar_id($item));
            $sidebar = ob_get_contents();
            ob_end_clean();
            $title = $sidebar;
        }
        
        return $title;
    }

    private function is_sidebar_menu_object($item)
    {
        return $this->sidebar_menu_items == $item->type;
    }

    private function get_sidebar_id( $item )
    {   
        return $item->object;
    }
}
