<?php

class vBHook {
    
    function init() {
        
        $CI =& get_instance();
        $CI->vbulletin = $GLOBALS['vbulletin'];
        //$_POST['ajax']=1;
        unset($_POST['ajax']);
        //unset($GLOBALS['vbulletin']);
    }
} 