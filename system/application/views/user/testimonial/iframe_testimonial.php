<style type="text/css">
.testimonial_bg{width:900px;background:none;height:350px;}
.testimonial_content_main{background-color:transparent;color:#000;}
.npn_next, .npn_prev{
	float:left;
	background-image: url("<?php echo $this->config->item('images');?>nex-prev-sprite.png") !important;
	height: 34px;
    width: 97px;
}
.npn_next {background-position:left top;}
.npn_next:hover { background-position:left -34px;}
.npn_prev {background-position:left -68px;}
.npn_prev:hover { background-position:left -102px;}
.testimonial_content_inner{padding-top:5px;}
</style>

<div class="" style="position:relative;">	
	<?php echo form_open("testimonial/iframe",array('name'=>'testimonial','id'=>'testimonial'));?>
			<div style="float: left; position: absolute; z-index: 2; top: 293px; left: 51px; width: 88%;">
				<div style="float:left">
				<a class="npn_prev" rel="nofollow" href="javascript: void(0);"  onclick="javascript: fncGettestimonial(document.getElementById('hidTestmId').value,'prev');">
				
				</a>
				</div>
				<div style="float:right">
				<a class="npn_next" rel="nofollow" href="javascript: void(0);" title="" onclick="javascript: fncGettestimonial(document.getElementById('hidTestmId').value,'next');">
				
				</a>
				</div>
			</div>  

             	<div class="cb">&nbsp;</div>
             	
            	<div class="testimonial_content_main"  style="margin:0;width:900px" >
            	<?php if($testimonial){?>
            		<div class="testimonial_content_inner">
	            		<div class="testmonial_title" id="testimonial_name"><?php echo $testimonial[0]['testimonial_name'];?></div>
	            		<div class="testimonial_content" id="testimonial_content" style="height:211px;">
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
