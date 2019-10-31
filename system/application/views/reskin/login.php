<div class="row">
    <div class="col-md-12 popup-logo"><img class="img-responsive" src="<?php echo base_url()?>images/reskin/logo1.svg"></div>
</div>
<div class="row login">
	<?php echo form_open("user/login", array('name'=>'loginform','id' => 'loginform'));?>
		<div class="col-md-12"><h4>Hello, Welcome Back!</h4></div>
		<div class="col-md-12">
			 <div  class="alert alert-danger" id="login_error" style="display:none"></div>
				                
		</div>
		<div class="col-md-12 form-group">
			<input id="username" class="form-control" type="email" placeholder="Email Address"   autocomplete="off"  name="username" maxlength="50" required autofocus />
		</div>
		<div class="col-md-12 form-group">
			<input id="password" class="form-control" type="password" placeholder="Password"   autocomplete="off" name="password" required />
		</div>
		<div class="col-md-12" id="forcelogin" style="display: none">
	 		<div class="checkbox  checkbox-info" >
	 			<input type="checkbox" name="forced_login" id="forced_login">
		        <label class="logintext" for="forced_login">Force Login</label>
		    </div>
	 	</div>
	 	<div class="col-md-12 margin30">
	 		<button class="btn btn-login">Login</button>	 		 
	 		<input class="btn btn-login clear" type="reset" value="Cancel"/>
	 	</div>
	 	<div class="col-md-12">
	 		<a class="loginlinks" data-sec="login" href="#">Lost Your Password ?</a>
	 	</div>
 	</form>
</div>
<div class=" row lostpassword">
	<?php echo form_open("forgot-password", array('name'=>'forgot_password_form_adhi','id' => 'forgot_password_form_adhi'));?>
	<div class="col-md-12"><h4>Forgot your password?</h4></div>
	<div class="col-md-12">			 
		<div  class="alert alert-danger" id="fgetpass_error" style="display:none"></div>				                
	</div>
	<div class="col-md-12 margin10">Enter your login email below. We will send you an email with password.</div>
	<div class="col-md-12 form-group">
		<input type="forgot_email" id="forgot_email" class="form-control" type="email" placeholder="Email Address"   autocomplete="off"  name="email" maxlength="50" required/>
	</div>
	<div class="col-md-12 margin30">
 		<button class="btn btn-login">Submit</button>
 		<input class="btn btn-login clear" type="reset" value="Cancel"/>
 	</div>
 	<div class="col-md-12">
 		<a class="loginlinks" data-sec="lp" href="#">Return to Login</a>
 	</div>
 	</form>
</div>