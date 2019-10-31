<?php echo form_open("login");?>
	<div>
		<div class="form-fields"  style="height:20px">
			<div class="display_error" id="display_error">

				<?php if(validation_errors()){
						echo validation_errors();
					}
					if(isset($msg) && $msg!='' ){
							if($msg=='4')
								echo 'You Are Already Logged In ';	
							else 	
								echo $msg;
						
					}

				?>
			</div>
		</div>
			<div  id="error"  class="display_error" id="display_error"></div>		
			
		<div class="form-fields"  style="height:20px">
			<div class="filed">Email</div>
			<div class="filed"><input type="text" name="username"  maxlength="100"  value="<?php echo set_value('username')?>" id="username">
			</div>
		</div>
	
		<div class="form-fields"  style="height:20px">
			<div class="filed">Password</div>
			<div class="filed"><input type="password"  maxlength="100"  name="password" value="" id="password">

			</div>
		</div>
		<div class="form-fields"  style="height:50px">
			<div class="filed">&nbsp;</div>
			<div class="filed"><input type="submit" value="Login" onclick="javascript:return validate_user_Login();"></div>
		</div>
		
		<div class="form-fields"  style="height:10px">
			<div class="filed">&nbsp;</div>
			<div class="filed"><a href>Forget Password</a></div>
		</div>
	</div>
</form>
