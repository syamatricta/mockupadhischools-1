<?php
    function whitePressAct(){
        global $tema;
        add_theme_page($tema, "$tema", 'edit_themes', basename(__FILE__), 'whitePressTheme');
    }
    
    function whitePressTheme(){
        global $tema, $ozellik;
        if($_POST):
            foreach($ozellik as $var):
                    update_option($var['id'], stripslashes($_POST[$var['id']]));                                         
            endforeach;                    
            ?>
            <div class="updated"><p><strong>Options Saved!</strong></p></div>
            <?php
        endif;

        ?>
        <div class="wrap">
        <h2><?php echo $tema; ?> Options</h2>
        <form method="POST">
            <div id="poststuff">
            <?php foreach($ozellik as $var): ?>
                <?php if($var['type'] == "bolum_ac" ): ?>
                <div style="width: 49%; margin-right: 2px;" class="postbox-container">
                <?php elseif($var['type'] == "kutu_ac"): ?>
                <div class="postbox">
                <h3><?php echo $var['name']; ?></h3>
                <div class="inside">
                <table width="100%" cellpadding="10" cellspacing="10">                                
                <?php elseif($var['type'] == "bolum_kapa" ): ?>
                </div>
                <?php elseif($var['type'] == "kutu_kapa" ): ?>
                </table>
                <p class="submit">
                <input type="submit" name="Submit" value="Update Options" />
                </p>                 
                </div>                
                </div>
                <?php elseif($var['type'] == "select"):?>
                <tr><td valign="top" style="width:25%;padding-top:5px"><strong><?php echo $var['name']; ?>:</strong></td><td>
                <select name="<?php echo $var['id']; ?>" id="<?php echo $var['id']; ?>">
                    <?php foreach($var['option'] as $cat): ?>
                    <option <?php if(get_option($var['id']) == $cat) echo "selected=\"selected\""; ?>><?php echo $cat; ?></option>                    
                    <?php endforeach;?>                                    
                </select>
                <p><?php echo $var['help']; ?></p></td></tr>                                                 
                <?php elseif($var['type'] == "radio_ac"):?>
                <tr><td valign="top" style="width:25%;padding-top:5px"><strong><?php echo $var['name']; ?>:</strong></td>
                <?php elseif($var['type'] == "radio"):?>
                <td style="display: block; margin: 4px 0px;">
                <input name="<?php echo $var['id']; ?>" <?php if($var['default'] == get_option('wpt_image_crop')): echo "checked"; endif; ?> id="<?php echo $var['id']; ?>" type="<?php echo $var['type']; ?>" value="<?php echo $var['default']; ?>" />
                <?php echo $var['help']; ?></td>
                <?php elseif($var['type'] == "radio_kapa"):?>
                </tr> 
                <?php elseif($var['type'] == "text"):?>
                <tr><td valign="top" style="width:25%;padding-top:5px"><strong><?php echo $var['name']; ?>:</strong></td><td>
                <input style="width:90%" name="<?php echo $var['id']; ?>" id="<?php echo $var['id']; ?>" type="<?php echo $var['type']; ?>" value="<?php if(get_option($var['id']) != ""): echo get_option($var['id']); else: echo $var['default']; endif; ?>" />
                <p><?php echo $var['help']; ?></p></td></tr>  
                <?php elseif($var['type'] == "textarea"): ?>  
                <tr><td valign="top" style="width:25%;padding-top:5px"><strong><?php echo $var['name']; ?>:</strong></td><td>
                <textarea style="width:90%;height:150px;" name="<?php echo $var['id']; ?>" id="<?php echo $var['id']; ?>"><?php echo get_option($var['id']); ?></textarea>
                <p><?php echo $var['help']; ?></p></td></tr>                                              
                <?php endif; ?>
                        
                            


                <?php endforeach; ?>
            </div>
            <input type="hidden" name="action" value="save" />
        </form>
        </div>
        <?php
    }
    add_action('admin_menu', 'whitePressAct');
?>