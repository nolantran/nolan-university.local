<?php

/*
Plugin Name: My First Amazing Plugin
Description: This plugin will change your life. 
*/


function amazingContentEdits($content) {
    $content = $content . '<p>All content belongs to Fictional University</p>';
    return $content;
}

add_filter('the_content', 'amazingContentEdits');