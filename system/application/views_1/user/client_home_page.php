<?php /* main division for twitter, face book, you tube, login and flash starts here*/?>
<div class="floatleft">
		<div class="flashtwittermain">
			<div class="twitterfacebook">
				<div class="homebuttons"><a href="https://facebook.com/adhischools/" target="_blank"><img  src="<?php  echo $this->config->item('images');?>facebook.jpg" /></a></div>
				<div class="clearboth"></div>
				<div class="homebuttons"><a href="https://twitter.com/adhischools/" target="_blank"><img  src="<?php  echo $this->config->item('images');?>twitter.jpg" /></a></div>
				<div class="clearboth"></div>
				<div class="homebuttons"><a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" target="_blank"><img  src="<?php  echo $this->config->item('images');?>youtube.jpg" /></a></div>
			</div>
			<div class="clientlogin">
			<?php echo form_open("user/login", array('name'=>'loginform','id' => 'loginform'));?>
				<div class="logindet">
					<div class="loginhead">Current Student Login</div>
					<div  id="error"  class="page_error login_error" id="display_error" style="width:179px;"> 
					<?php if(validation_errors()){echo validation_errors();	}
							if($this->session->flashdata('msg'))
								echo $this->session->flashdata('msg');	
						?>
					</div>	
					<div class="page_error login_error" id="server_error"></div>
					<div class="clearboth"></div>
					<div class="logintextbox"><input type="text" class="textbox" maxlength="50" name="username" id="username"  value="Email" onclick="javascript:clearusername();" /></div>
					<div class="logintextbox" ><input type="password" class="textbox" maxlength="20" name="password" id="password" value="Password" onfocus="javascript:clearpassword();"/></div>
					<div class="homeloginbuttons" ><img  src="<?php echo $this->config->item('images');?>login.jpg" onclick="javascript:return validate_user_Login();" style="cursor:pointer;"/></div>
					<div class="clearboth"></div>
					<?php if($msg==1){?>
						<div class="forcedlogin"><input type="checkbox" name="forced_login" id="forced_login"> Force Login</div>
					<?php }else{?>
						<div class="forcedlogin">&nbsp;</div>
					<?php }?>
					
					<div class="forgotpassword"><?php echo anchor('forgot-password','Forgot Password?');?></div>
					
				</div>
			<?php echo form_close();?>
			</div>
			<div class="flashplayer">
				<?php 
					if(is_array($banners) && count($banners) > 0) {
						if(count($banners) == 1) {
							echo '<div id="slideshow" style="visibility:visible;" >';									
									foreach($banners as $banner) {
										echo '<a href="'.base_url().'banners/'.$banner['banner_id'].'" title="'.$banner['banner_short_dec'].'"><img src="'.$this->config->item('banner_image_url').'thumbs/'.$banner['banner_image'].'" width="468" height="209"  title="'.$banner['banner_title'].'" alt="'.$banner['banner_title'].'" /></a>';
									}														
							echo '</div>
									<div id="indexBox">
						    			<p id="indexText" class="inBoxText"><a href="'.base_url().'banners/'.$banner['banner_id'].'"><h1>'.$banner['banner_title'].'</h1>'.$banner['banner_short_dec'].'</a></p>
						    		</div>
								';
						} else {
					?>
				<div id="slideshow" style="visibility:hidden;" >
					<?php 
						foreach($banners as $banner) {
							echo '<a href="'.base_url().'banners/'.$banner['banner_id'].'" title="'.$banner['banner_short_dec'].'"><img src="'.$this->config->item('banner_image_url').'thumbs/'.$banner['banner_image'].'" width="468" height="209"  title="'.$banner['banner_title'].'" alt="'.$banner['banner_title'].'" /></a>';
						}
					?>					
				</div>
<!--				<div id="playpause" onclick="onPausePlay()" onmouseover="onMouseOverPP()" onmouseout="onMouseOutPP()"><img id="playpauseimg" src="<?php echo $this->config->item('images').'pause-btn.png';?>" width="20" height="45" /></div>-->
		    	<div id="indexBox">
		    		<p id="indexText" class="inBoxText"></p>
		    		<div id="playpause" onclick="onPausePlay()" onmouseover="onMouseOverPP()" onmouseout="onMouseOutPP()"><img id="playpauseimg" src="<?php echo $this->config->item('images').'pause-btn.png';?>" width="20" height="45" /></div>
		    	</div>
		    	<?php 
						}
					} else { echo '<img src="'.$this->config->item('images').'home_banner.jpg" width="468" height="209" alt="Real Estate Classes Orange County" />';}
		    	?>
		    </div>
		</div>
	<?php /*main division for twitter, face book, you tube, login and flash ends here
main division for Real Estate and Questions starts  here */?>
		<div class="flashtwittermain" style=" width:900px;">
			<div class="homerealestate">
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>realeatate_left.jpg" /></div>
				<div class="realestatemiddle">
					<div class="realestateimg"><img  src="<?php  echo $this->config->item('images');?>realestate.jpg" /></div>
						<div class="realestatetextmain">
							<div class="floatleft" ><span class="thinkabout">Thinking About</span><span class="realestate"> Real Estate</span></div>
							<div class="realestatecontent">
								<?php 
									$thinkabout =  substr($thinkingabout->content,0,120);
									$last_space = strrpos($thinkabout," ");
									if(strlen($thinkingabout->content)>120){
										echo substr($thinkabout,0,$last_space). " ...";
									} else {
										echo substr($thinkabout,0,$last_space);
									}
									
								 ?>
							</div>
							<div class="realestateclick"><?php echo anchor(base_url().$siteurl[2]->name,'Click Here')?></div>
						</div>
					</div>
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>realeatate_right.jpg" /></div>
			</div>
			<div class="homequestions" >
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>realeatate_left.jpg" /></div>
				<div class="realestatemiddle">
					<div class="qaimg"><img  src="<?php  echo $this->config->item('images');?>questionAnswer.jpg" /></div>
						<div class="realestatetextmain">
							<div class="question"><span class="gotquestion">Got</span><span class="realestate"> Questions</span></div>
							<div class="realestatecontent">
								<?php 
									$gotquest 		=  substr($gotquestion->content,0,120);
									$last_got_space = strrpos($gotquest," ");
									if(strlen($gotquestion->content)>120){
										echo substr($gotquest,0,$last_got_space). " ...";
									} else {
										echo substr($gotquest,0,$last_got_space);
									}
								 ?>
							</div>
							<div class="realestateclick"><?php echo anchor(base_url().'faq','Click Here')?><?php //echo anchor(base_url().$siteurl[3]->name,'Click Here')?></div>
						</div>
					</div>
					<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>realeatate_right.jpg" /></div>
			</div>
	</div>
	<?php if(isset($arr_result) && !empty($arr_result)){
		    echo form_open("home/class_details", array('name'=>'tonightclassform','id' => 'tonightclassform'));?>
			<div class="clearboth paddingbottom">
				<input type="hidden" name="hdnSubregion" id="hdnSubregion" />
				<input type="hidden" name="hdnDated" id="hdnDated" onchange="javascript:$('classform').submit();" value="<?php echo date('m/d/Y');?>" />
			</div>
			<div id="divClass" class="flashtwittermain">
				<div id="divImageHead">Today's Classes</div>
				<div class="clearboth"></div>
				<div id="divShowRelatedImage">
					<?php $this->load->view('user/display_related_class');?>
				</div>
			</div>
	<?php 
			echo form_close();
		} ?>
</div>
<?php /* main division for Real Estate and Questions ends  here */?>
<script type="text/javascript">
	var browser = "";					// this is here to create the dots for picture navigation using the css for 'fancymenu'
	var Play = true;
	jQuery.noConflict();
</script>