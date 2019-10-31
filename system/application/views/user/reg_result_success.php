<div class="floatleft">
	<div class="left_cntnr" style="position: relative;">
		<?php $this ->load->view('left_content_home.php');?>
	</div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
           <div class="sitepagehead"><h1>Create Account</h1></div>
        </div>
        <div class="right_cntnr_bg">
        	<div style="width:100%; padding:100px 0; text-align:center; font-weight:bold; font-size:20px; color:#A5CE34">
        		Registration Completed Successfully
        	</div> 
        	<div class="clearboth">&nbsp;</div>
			<div class="editprofile">
				<?php #echo anchor('home','<< Return home to login');?>
			</div>      	
        </div>
	</div>
</div>
<style type="text/css">
    body {
    font-family: Arial, Helvetica, sans-serif;
    text-align: left;
    padding: 0px;
    margin-top:0px;
    background:url(<?php echo base_url().'images/bg_01.jpg'?>) #000000 no-repeat center top;
    height:auto;
    }
</style>