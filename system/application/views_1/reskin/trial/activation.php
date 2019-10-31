<?php page_heading('Guest Account Activation', '');?>
<section class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm12 col-md-offset-1 text-right reg_needhelp">
                <i class="fa fa-phone"></i> Need help? Call 888 768 5285
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-sm12 col-md-offset-1 wtbg">
                <div class="divide40"></div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center msg-container">
                        <?php
                            $type       = '';
                            $message    = '';
                            if(isset($this->message['info'])){
                                $type       = 'info';
                                $message    = $this->message['info'];
                                $icon       = 'fa-info';
                                $class      = 'text-info';
                            }else if(isset($this->message['error'])){
                                $type       = 'error';
                                $message    = $this->message['error'];
                                $icon       = 'fa-times';
                                $class      = 'text-danger';
                            }else if(isset($this->message['success'])){
                                $type       = 'success';
                                $message    = $this->message['success'];
                                $icon       = 'fa-check';
                                $class      = 'text-success';
                            }
                        ?>
                        <h3 class="margin70 <?php echo $class;?>">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle-thin fa-stack-2x"></i>
                                <i class="fa <?php echo $icon;?> fa-stack-1x"></i>
                            </span>
                            <b class="display-block"><?php echo $message;?></b>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>