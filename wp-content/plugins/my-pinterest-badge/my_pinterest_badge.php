<?php
/*
  Plugin Name: My Pinterest Badge
  Plugin URI: http://www.protechblog.com/tools/my-pinterest-badge.php
  Description: This plugin allows you to place a widget on your sidebar that fetches the most recent pins of a user's pinboard. You can choose whether to show the description below the image.It will also show the official "Follow me on PInterest" button.
  Version: 1.1.1
  Author: Guru
  Author URI: http://www.jafaloo.com
  License: GPL3
 */
/*  
* 	Copyright (C) 2012  Jafaloo.com
*	http://www.jafaloo.com
*	http://www.protechblog.com/tools/my-pinterest-badge.php
*
*	This program is free software: you can redistribute it and/or modify
*	it under the terms of the GNU General Public License as published by
*	the Free Software Foundation, either version 3 of the License, or
*	(at your option) any later version.
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*	GNU General Public License for more details.
*
*	You should have received a copy of the GNU General Public License
*	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
include('pinterestloader.php');

function myPinterestBadge($pinid, $pinsize, $pincounts, $devcredit,$board,$cache_time) {
    //include('pinterestloader.php');
    $helper = new myPinterestBadge($pinid, $pinsize, $pincounts, $devcredit,$board,$cache_time);
    $pinsdata = $helper->readCacheData();
    echo $pinsdata;
}

class MyPinterestBadgeWidget extends WP_Widget {

    //Constructer
    function MyPinterestBadgeWidget() {
        parent::WP_Widget(false, $name = 'My Pinterest Badge');
        $css = plugins_url() . '/my-pinterest-badge/css/mypinterest.css';
        wp_enqueue_style('myPinterestBadge', $css);
        $js = plugins_url() . '/my-pinterest-badge/js/mypinterest.js';
        wp_enqueue_script('myPinterestBadge', $js);
    }

    function form($instance) {
        $pinid = '';
        $title = 'My Recent Pins';
        if ($instance) {
            $pinid = esc_attr($instance['pinid']);
            $title = esc_attr($instance['title']);
            $pinsize = esc_attr($instance['pinsize']);
            $pincounts = esc_attr($instance['pincounts']);
            $credit = isset($instance['credit']) ? $instance['credit'] : false;
            $board = esc_attr($instance['board']);
            $pins_cache_time = esc_attr($instance['pins_cache_time']);
        } else {
            $defaults = array('pinid' => '', 'title' => 'My Recent Pins', 'credit' => false, 'pinsize' => 'small',
                'pincounts' => 3, 'board' => '','pins_cache_time'=>1.5);
            $instance = wp_parse_args((array) $instance, $defaults);
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" 
                   type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('pinid'); ?>">
        <?php _e('Pinterest User ID:'); ?>
            </label> 
            <label>
                <br/>For Example 
                <span style="color:red;">www.pinterest.com/xyz</span>, 
                the id is: <span style="color:red;">xyz</span>.
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('pinid'); ?>" 
                   name="<?php echo $this->get_field_name('pinid'); ?>" 
                   type="text" value="<?php echo $pinid; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('pinsize'); ?>"><?php _e('Image Size:'); ?></label> 
            <select class="select" id="<?php echo $this->get_field_id('pinsize'); ?>" 
                    name="<?php echo $this->get_field_name('pinsize'); ?>" >
                <option value="small" <?php if ($instance['pinsize'] == 'small') {
            echo 'selected="selected"';
        } ?>>Small</option>
                <option value="mid" <?php if ($instance['pinsize'] == 'mid') {
            echo 'selected="selected"';
        } ?>>Medium</option>
                <option value="big" <?php if ($instance['pinsize'] == 'big') {
            echo 'selected="selected"';
        } ?>>Big</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('pincounts'); ?>"><?php _e('Number Of Pins To Display:'); ?></label> 
            <select class="select" id="<?php echo $this->get_field_id('pincounts'); ?>" 
                    name="<?php echo $this->get_field_name('pincounts'); ?>" >
        <?php for ($i = 3; $i < 13; $i++) { ?>
                    <option value="<?php echo $i; ?>" <?php if ($instance['pincounts'] == $i) {
                echo 'selected="selected"';
            } ?>><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('board'); ?>">
                From Board(Optional) <abbr style="border-bottom: 1px dotted black; 
                                color:'red'; 
                                font-weight:bold;" 
                                title="From which pin board you would like to show the pins. Enter the board URL name. e.g: If your board URL is: http://www.pinterest.com/username/things-for-my-wall, then you need to enter things-for-my-wall in this box.">How to get it?</abbr>
            </label> 
            <input class="widefat" id="<?php echo $this->get_field_id('board'); ?>" 
                   name="<?php echo $this->get_field_name('board'); ?>" 
                   type="text" value="<?php echo $board; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('pins_cache_time'); ?>">
                Cache Time(Optional,Minimum 1.5 hr.)              
            <select class="select" id="<?php echo $this->get_field_id('pins_cache_time'); ?>" 
                    name="<?php echo $this->get_field_name('pins_cache_time'); ?>" >
                <option value="1.5" <?php if ($instance['pins_cache_time'] == '1.5') {
            echo 'selected="selected"';
        } ?>>1.5 hr</option>
                <option value="2" <?php if ($instance['pins_cache_time'] == '2') {
            echo 'selected="selected"';
        } ?>>2 hr</option>
                <option value="3" <?php if ($instance['pins_cache_time'] == '3') {
            echo 'selected="selected"';
        } ?>>3 hr</option>
                <option value="4" <?php if ($instance['pins_cache_time'] == '4') {
            echo 'selected="selected"';
        } ?>>4 hr</option>
                <option value="5" <?php if ($instance['pins_cache_time'] == '5') {
            echo 'selected="selected"';
        } ?>>5 hr</option>
                <option value="12" <?php if ($instance['pins_cache_time'] == '12') {
            echo 'selected="selected"';
        } ?>>12 hr</option>
                <option value="24" <?php if ($instance['pins_cache_time'] == '24') {
            echo 'selected="selected"';
        } ?>>24 hr</option>
            </select>
            <abbr style="border-bottom: 1px dotted black; 
                                color:'red'; 
                                font-weight:bold;" 
                                title="Select the cache time period. Minimum is 1.5hr. Its better keep it a bit higher between 1.5 hr to 3hrs as it will reduce the frequency of pinging Pinterest website.">What is it?</abbr>
            </label>
        </p>
        <p>
        <?php (isset($instance['credit']) && $instance['credit'] == true) ? $color = 'green' : $color = 'red'; ?>

            <input class="checkbox" type="checkbox" <?php checked((bool) $instance['credit'], true); ?> 
                   id="<?php echo $this->get_field_id('credit'); ?>" 
                   name="<?php echo $this->get_field_name('credit'); ?>" />
            <label for="<?php echo $this->get_field_id('credit'); ?>">
        <?php _e('Show developer credit. '); ?>
                <abbr style="border-bottom: 1px dotted black; color:<?php echo $color; ?>; 
                      font-weight:bold;" 
                      title="Shows the credit link to the developer. We appreciate if you Enable this.">What is this?</abbr>
            </label>
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = trim(strip_tags($new_instance['title']));
        $instance['pinid'] = trim(strip_tags($new_instance['pinid']));
        $instance['pinsize'] = trim(strip_tags($new_instance['pinsize']));
        $instance['pincounts'] = trim(strip_tags($new_instance['pincounts']));
        $instance['credit'] = ( isset($new_instance['credit']) ? true : false );
        $instance['board'] = trim(strip_tags($new_instance['board']));
        $instance['pins_cache_time'] = trim(strip_tags($new_instance['pins_cache_time']));
        $helper = new myPinterestBadge($instance['pinid'], $instance['pinsize'], $instance['pincounts'], $instance['credit'],$instance['board'],$instance['pins_cache_time']);
        $helper->initializeCache();
        return $instance;
    }

    function widget($args, $instance) {
        extract($args);
        $title = $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if ($title)
            echo $before_title . $title . $after_title;

        // WIDGET CODE GOES HERE
        myPinterestBadge($instance['pinid'], $instance['pinsize'], $instance['pincounts'], $instance['credit'],$instance['board'],$instance['pins_cache_time']);

        echo $after_widget;
    }

}

//Register the Widget
add_action('widgets_init', create_function('', 'return register_widget("MyPinterestBadgeWidget");'));
?>
