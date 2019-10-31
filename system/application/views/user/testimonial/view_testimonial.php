<div class="floatleft">
      <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content_home.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
            <div class="floatleft" style="width:100%;">
				 <div class="sitepagehead"><h1>Testimonials</h1></div>
				 <div class="username"><?php disp_loggedin_username(); ?></div>
			 </div>
         </div>
        <div class="cb"></div>
         <div class="right_cntnr_bg">
            	<div class="testimonial_bg" style="position:relative;">
                    <?php echo form_open("testimonial",array('name'=>'testimonial','id'=>'testimonial'));?>
                                   	<div style="float: left; position: absolute; z-index: 2; top: 293px; left: 51px; width: 91%;">
	            			<div style="float:left">
	            				<a rel="nofollow" href="javascript: void(0);"  onclick="javascript: fncGettestimonial(document.getElementById('hidTestmId').value,'prev');">
									<div class="view_prev_year_img"></div>
								</a>
	            			</div>
	            			<div style="float:right">
	            				<a rel="nofollow" href="javascript: void(0);" title="" onclick="javascript: fncGettestimonial(document.getElementById('hidTestmId').value,'next');">
									<div class="view_next_year_img"></div>
								</a>
	            			</div>
	            		       </div>  
                    
             	<div class="cb">&nbsp;</div>
             	
            	<div class="testimonial_content_main"  >
            	<?php if($testimonial){?>
            		<div class="testimonial_content_inner">
	            		<div class="testmonial_title" id="testimonial_name"><?php echo $testimonial[0]['testimonial_name'];?></div>
	            		<div class="testimonial_content" id="testimonial_content">
	            			<div id='top'></div>
	            			<?php echo nl2br($testimonial[0]['testimonial']);?>
	            			<div id='bottom'></div>
	            		</div>
	            		<?php /* rightside scroll */?>
	            		<div style="float:right; width:36px;display:none" id="scroll">
	            			<div>
	            				<a rel="nofollow" href="javascript: void(0);"  onclick="javascript: fncGoBottom();">
									<div class="view_scroll_top"></div>
								</a>
	            			</div>
	            			<div class="view_scroll_middle"></div>
							<div>
	            				<a rel="nofollow" href="javascript: void(0);"  onclick="javascript: fncGoTop();">
									<div class="view_scroll_bottom"></div>
								</a>
	            			</div>
	            		</div>	
            		</div>
            		
            		<?php }?>
            		<input type="hidden" name="hidTestmId" id="hidTestmId" value="<?php echo $offset;?>"  />
					<input type="hidden" name="hidDirection" id="hidDirection" value="<?php echo $direction?>" />
            	</div>
            	<?php echo form_close();?>
            </div>
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

<script type="text/javascript">
/*var scrollheight = $('content').scrollHeight;
if(scrollheight >140){
	$('scroll').style.display = 'block';
}else{
	$('scroll').style.display = 'none';
}*/
</script>