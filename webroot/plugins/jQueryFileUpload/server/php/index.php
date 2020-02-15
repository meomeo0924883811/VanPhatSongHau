<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
$options = array(
    'upload_url' => 'files/upload/temp/',
    'upload_dir' => '../../../../files/upload/temp/',
    'image_versions' => array(
        'thumbnail' => array(
            'max_width' => 150,
            'max_height' => 150
        )
    )
);
$upload_handler = new UploadHandler($options);

/*
    //ADD CODE IN FUNCTION protected function get_file_name() - Line 529
    $name = clean($name);
*/

function clean($name) {
    $path_parts = pathinfo($name);
    $img_name = $path_parts['filename'];
    $img_name = str_replace(' ', '-', $img_name); // Replaces all spaces with hyphens.
    $img_name = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $img_name)); // Removes special chars.
    $img_name = $img_name.'_'.date('Ymd').'_'.rand(1000,9999);
    $name = $img_name .'.'. $path_parts['extension'];
    return $name;
}