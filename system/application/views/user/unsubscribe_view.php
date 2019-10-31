<html>
    <body>
            <div class="floatleft s">
                          <div class="left_cntnr pos_rel">
                                <?php $this ->load->view('left_content_home.php');?>
                        </div>
                        <div class="right_cntnr">
                            <div class="right_cntnr_bg">
                                    <div id="sitepagehead" style="color: #a5ce34;text-align:center;padding-top:28%;">
                                        <h2>
                                         <?php
                                            if(isset($status)){
                                              if($status){
                                                  echo 'You have successfully unsubscribed';
                                              } else{
                                                  echo 'You have failed to unsubscribe, please try later';
                                              }
                                            }
                                            ?>
                                        </h2>    
                                    </div>
                               </div>
                        </div>
            </div>         
    </body>
    <style>
    body{
        background: url("<?php echo base_url(); ?>images/bg_01.jpg") no-repeat scroll center top #000000;
        font-family: Arial,Helvetica,sans-serif;
        height: auto;
        margin-top: 0;
        padding: 0;
        text-align: left;
     }
    </style> 
</html>