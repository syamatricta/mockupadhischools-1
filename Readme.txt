//FIRST THING TO DO

1)/////////CREATE FOLDERS
    mkdir cache js/parsed  style/parsed uploads uploads/conversations uploads/dictionary uploads/staff uploads/supplements uploads/tinymceimages tmp image_uploads image_uploads/thumbs image_uploads/banners image_uploads/banners/thumbs captcha bp_image crone/logs logs logs/fedex

2)/////////GIVE PERMISSION TO FOLDERS
    chmod 777 -R js/parsed style/parsed tmp image_uploads captcha bp_image uploads crone/logs logs

3)/////////Take a copy of database.php from database.php.dist and give proper details
    cp system/application/config/database.php.dist system/application/config/database.php

4)/////////Take a copy of db.php details from db.php.dist and give proper details
    cp crone/db.php.dist crone/db.php

5)/////////Take a copy of config.php details from config.php.dist and give proper details
    cp crone/config.php.dist crone/config.php

6)/////////Take a copy of .htaccess from .htaccess.dist and give proper details
    cp .htaccess.dist .htaccess