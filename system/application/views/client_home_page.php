<?php /* main division for twitter, face book, you tube, login and flash starts here */ ?>
		<div class="flashtwittermain">
			<div class="twitterfacebook">
				<div class="homebuttons"><img  src="<?php  echo $this->config->item('images');?>facebook.jpg" /></div>
				<div class="clearboth"></div>
				<div class="homebuttons"><img  src="<?php  echo $this->config->item('images');?>twitter.jpg" /></div>
				<div class="clearboth"></div>
				<div class="homebuttons"><img  src="<?php  echo $this->config->item('images');?>youtube.jpg" /></div>
			</div>
			<div class="clientlogin">
				<div class="logindet">
					<div class="loginhead">Current Student Login</div>
					<div class="clearboth"></div>
					<div class="logintext">Username</div>
					<div class="logintextbox"><input type="text" class="textbox" name="username" id="username" size="25" value="username" /></div>
					<div class="clearboth"></div>
					<div class="logintext">Password</div>
					<div class="logintextbox" ><input type="text" class="textbox" name="txtPassword" id="txtPassword" size="25" value="password"/></div>
					<div class="clearboth"></div>
					<div class="logintext">&nbsp;</div>
					<div class="homebuttons"><img  src="<?php  echo $this->config->item('images');?>login.jpg" /></div>
					<div class="clearboth"></div>
					<div class="logintext">&nbsp;</div>
					<div class="forgotpassword">Forgot Password?</div>
				</div>
			</div>
			<div class="flashplayer">
				<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="468" height="209">
			        <param name="movie" value="images/BannnerFlash0.swf">
			        <param name="quality" value="high">
			        <param name="wmode" value="transparent">
			        <embed src="<?php  echo $this->config->item('images');?>BannnerFlash0.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" width="468" height="209"></embed>
			    </object>
			</div>
		</div>
		<!--<div class="clearboth"></div>-->
<!-- main division for twitter, face book, you tube, login and flash ends here-->
<!-- main division for Real Estate and Questions starts  here-->
		<div class="flashtwittermain">
			<div class="homerealestate">
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>realeatate_left.jpg" /></div>
				<div class="realestatemiddle">
					<div class="realestateimg"><img  src="<?php  echo $this->config->item('images');?>realestate.jpg" /></div>
						<div class="realestatetextmain">
							<div class="floatleft" ><span class="thinkabout">Thinking About</span><span class="realestate"> Real Estate</span></div>
							<div class="realestatecontent">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</div>
							<div class="realestateclick">Click Here</div>
						</div>
					</div>
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>realeatate_right.jpg" /></div>
			</div>
			<div class="homequestions">
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>realeatate_left.jpg" /></div>
				<div class="realestatemiddle">
					<div class="qaimg"><img  src="<?php  echo $this->config->item('images');?>questionAnswer.jpg" /></div>
						<div class="realestatetextmain">
							<div class="question"><span class="gotquestion">Got</span><span class="realestate"> Questions</span></div>
							<div class="realestatecontent">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</div>
							<div class="realestateclick">Click Here</div>
						</div>
					</div>
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>realeatate_right.jpg" /></div>
			</div>
		</div>
<!-- main division for Real Estate and Questions ends  here-->