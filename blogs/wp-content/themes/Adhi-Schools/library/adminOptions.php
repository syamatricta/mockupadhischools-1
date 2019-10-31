<?php
$tema = "whitePress";
$kisa = "wpt";

$kategori = get_categories('hide_empty=0');
foreach ($kategori as $kat) {
	$kategoriler[$kat->cat_ID] = $kat->cat_name;
}

$ozellik = array(
    array("type" => "bolum_ac", "name" => $kisa."1"),
    array("name" => "Featured", "type" => "kutu_ac"),
    array("name" => "Number of Featured Content", "id" => $kisa."_featured_number", "help" =>"Maximum content of featured is showed", "type" => "text", "default" => "5"),
    array("name" => "Number of Sidebar Featured Content", "id" => $kisa."_featured_snumber", "help" =>"Maximum content of featured in sidebar is showed", "type" => "text", "default" => "3"),
    array("name" => "Number of Featured Content", "id" => $kisa."_featured_cat", "help" =>"Your featured content category", "type" => "select", "option" => $kategoriler),    
    array("type" => "kutu_kapa"),
    array("name" => "Image Crop", "type" => "kutu_ac"),
    array("name" => "Crop From", "type" => "radio_ac"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Bottom Left", "default" => "bottomleft"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Bottom Right", "default" => "bottomright"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Bottom Center", "default" => "bottomcenter"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Top Left", "default" => "topleft"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Top Right", "default" => "topright"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Top Center", "default" => "topcenter"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Middle", "default" => "middle"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Middle Left", "default" => "middleleft"),
    array("id" => $kisa."_image_crop", "type" => "radio","help" => "Middle Right", "default" => "middleright"),
    array("type" => "radio_kapa"),    
    array("type" => "kutu_kapa"),   
    array("name" => "Sponsors", "type" => "kutu_ac"),
    array("name" => "Link 1 Image", "id" => $kisa."_link1_url", "help" =>"Enter your sponsor URL", "type" => "text","default" => get_bloginfo('stylesheet_directory')."/images/sponsor.jpg"),
    array("name" => "Link 1 URL", "id" => $kisa."_link1_image", "help" =>"Enter your sponsor IMAGE", "type" => "text","default" => get_bloginfo('wpurl')),
    array("name" => "Link 2 Image", "id" => $kisa."_link2_url", "help" =>"Enter your sponsor URL", "type" => "text","default" => get_bloginfo('stylesheet_directory')."/images/sponsor.jpg"),
    array("name" => "Link 2 URL", "id" => $kisa."_link2_image", "help" =>"Enter your sponsor IMAGE", "type" => "text","default" => get_bloginfo('wpurl')),
    array("name" => "Link 3 Image", "id" => $kisa."_link3_url", "help" =>"Enter your sponsor URL", "type" => "text","default" => get_bloginfo('stylesheet_directory')."/images/sponsor.jpg"),
    array("name" => "Link 3 URL", "id" => $kisa."_link3_image", "help" =>"Enter your sponsor IMAGE", "type" => "text","default" => get_bloginfo('wpurl')),
    array("name" => "Link 4 Image", "id" => $kisa."_link4_url", "help" =>"Enter your sponsor URL", "type" => "text","default" => get_bloginfo('stylesheet_directory')."/images/sponsor.jpg"),    
    array("name" => "Link 4 URL", "id" => $kisa."_link4_image", "help" =>"Enter your sponsor IMAGE", "type" => "text","default" => get_bloginfo('wpurl')),
    array("type" => "kutu_kapa"),
    array("type" => "bolum_kapa"),
    array("type" => "bolum_ac", "name" => $kisa."2"),
    array("name" => "Feed", "type" => "kutu_ac"),
    array("name" => "Feed Url", "id" => $kisa."_feed_url", "help" =>"Your special feed url", "type" => "text"),
    array("name" => "Feedburner URI", "id" => $kisa."_feed_uri", "help" =>"Your feedburner URI", "type" => "text"),
    array("type" => "kutu_kapa"),
    array("name" => "Exclude", "type" => "kutu_ac"),
    array("name" => "Exclude Category", "id" => $kisa."_cat_ex", "help" =>"Enter Cat ID which is not shown in category widget. Ex: 1,3,17", "type" => "text"),
    array("name" => "Exclude Page", "id" => $kisa."_page_ex", "help" =>"Enter Page ID which is not shown in navigation bar. Ex: 1,3,17", "type" => "text"),
    array("type" => "kutu_kapa"),
    array("name" => "Social Media", "type" => "kutu_ac"),
    array("name" => "Twitter", "id" => $kisa."_twitter", "help" =>"Your twitter account", "type" => "text"),
    array("type" => "kutu_kapa"),
    array("name" => "Google Analytics", "type" => "kutu_ac"),
    array("name" => "Your Code", "id" => $kisa."_analytics", "help" =>"Your google analytics code", "type" => "textarea"),
    array("type" => "kutu_kapa"),
    array("name" => "About Me", "type" => "kutu_ac"),
    array("name" => "About Me Image", "id" => $kisa."_about_image", "help" =>"Enter your About Me Image (64x80)", "type" => "text","default" => get_bloginfo('stylesheet_directory')."/images/avatar.png"),
    array("name" => "About Me Text", "id" => $kisa."_about_text", "help" =>"Explain yourself shortly", "type" => "textarea"),
    array("type" => "kutu_kapa"),
    array("type" => "bolum_kapa")
);
?>