<?php if($success != '') { ?>
    <div class="alert alert-success alert-dismissable success_block" style="">
        <b id="success_msg"><?php echo $success; ?></b>
        <!--<a class="float_r" href="javascript:removeAlert();" title="close">×</a>-->
    </div>
<?php } ?>

<?php if($error != '') { ?>
<div class="alert alert-danger alert-dismissable error_block" style="">
    <b id="error_msg"><?php echo $error; ?></b>
    <!--<a class="float_r" href="javascript:removeAlert();" title="close">×</a>-->
</div>
<div class="clear"> </div>
<?php } ?>


<form name="contactForm" id="contactForm" method="post" class="contactForm" action="<?php echo base_url().'iframe_user/contact/'.$site;?>" >

        <div class="margin_t_25 white">
            <input type="text" required   id="first_name" class="myBox" name="first_name" value="" placeholder="First Name*"/>
        </div>

        <div class="margin_t_25 white">
            <input type="text" required   id="last_name" class="myBox" name="last_name" value="" placeholder="Last Name*"/>
        </div>

        <div class="margin_t_25 white">
            <input type="email" required  id="email" class="myBox" name="email" value="" placeholder="Email*"/>
        </div>

        <div class="margin_t_25 white">
            <input type="text" required id="phone_number" class="myBox" name="phone_number" value="" placeholder="Phone Number*" pattern="[0-9]{10}"/>
        </div>

        <input type="submit" id="button_pressed" name="button_pressed" value="CONTACT ME" class="btn_send_msg btn_landing btn_landing_new margin_t_25"/>
</form>

<style>
@font-face {	
	font-family: 'myriad-pro-regular';
	src: url('./../fonts/myriad_pro_regular/MyriadPro-Regular.eot'); /* IE9 Compat Modes */
	src: url('./../fonts/myriad_pro_regular/MyriadPro-Regular.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
	     url('./../fonts/myriad_pro_regular/MyriadPro-Regular.woff') format('woff'), /* Modern Browsers */
	     url('./../fonts/myriad_pro_regular/MyriadPro-Regular.ttf')  format('truetype'), /* Safari, Android, iOS */
	     url('./../fonts/myriad_pro_regular/MyriadPro-Regular.svg#svgFontName') format('svg'); /* Legacy iOS */	     
}

@font-face {
	font-family: 'myriad-pro-bold';
	src: url('./../fonts/myriad_pro_bold/MyriadPro-Bold.eot'); /* IE9 Compat Modes */
	src: url('./../fonts/myriad_pro_bold/MyriadPro-Bold.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
	     url('./../fonts/myriad_pro_bold/MyriadPro-Bold.woff') format('woff'), /* Modern Browsers */
	     url('./../fonts/myriad_pro_bold/MyriadPro-Bold.ttf')  format('truetype'), /* Safari, Android, iOS */
	     url('./../fonts/myriad_pro_bold/MyriadPro-Bold.svg#svgFontName') format('svg'); /* Legacy iOS */
}

@font-face {
	font-family: 'myriad-pro-semibold';
	src: url('./../fonts/myriad_pro_semibold/MyriadPro-Semibold.eot'); /* IE9 Compat Modes */
	src: url('./../fonts/myriad_pro_semibold/MyriadPro-Semibold.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
	     url('./../fonts/myriad_pro_semibold/MyriadPro-Semibold.woff') format('woff'), /* Modern Browsers */
	     url('./../fonts/myriad_pro_semibold/MyriadPro-Semibold.ttf')  format('truetype'), /* Safari, Android, iOS */
	     url('./../fonts/myriad_pro_semibold/MyriadPro-Semibold.svg#svgFontName') format('svg'); /* Legacy iOS */
}

@font-face {
	font-family: 'myriad-pro-light';
	src: url('./../fonts/myriad_pro_light/MyriadPro-Light.eot'); /* IE9 Compat Modes */
	src: url('./../fonts/myriad_pro_light/MyriadPro-Light.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
	     url('./../fonts/myriad_pro_light/MyriadPro-Light.woff') format('woff'), /* Modern Browsers */
	     url('./../fonts/myriad_pro_light/MyriadPro-Light.ttf')  format('truetype'), /* Safari, Android, iOS */
	     url('./../fonts/myriad_pro_light/MyriadPro-Light.svg#svgFontName') format('svg'); /* Legacy iOS */
}

.alert-success{color:#3c763d;background-color:#dff0d8;border-color:#d6e9c6; padding:10px; }
.alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1; padding:10px; }

input{
    color:white;
}
/* NEW STYLE */
.new_grey{
    color:grey;
}
.grey_text{
    color:grey;
    font-size:15px;
}
.margin_t_30{
    margin-top:30px;
}
.margin_t_25{
    margin-top:25px;
}
.margin_b_20{
    margin-bottom:20px;
}
.img_link{
    margin-right:8px;
    font-size:18px ! important;
    padding:7px 4px;
    margin: 20px 3px;
}
.item {
    position:relative;
    padding-top:20px;
    display:inline-block;
}
.notify-badge{
    position: absolute;
    left:20.5%;
    top:70%;
}
.btn_landing_new{
   background-color:  #F4004E;
   border-radius: 0px;
   font-weight: 600;
}
.btn_small{
    font-size: 8px;
    height: 25px;
    width: 110px;
    margin-top:3px;
}
input[type="submit"]{
    cursor: pointer ! important;
}
.pink{
    color:#F4004E;
    font-size:40px;
    font-weight: lighter ! important;
}
.pink_2{
    color:#D73542;
    font-size:40px;
    font-weight: lighter ! important;
}
.lighter{
    font-weight: 400 ! important;
}
.btn_smalls{
    font-size: 9px;
    height: 25px;
    width: 110px;
    margin: 0 auto;
    margin-top:30px;
}
.blog_img{
    background:url(../images/social/blog.png); 
    background-repeat: no-repeat;
}
.black{
    color:black;
}

.margin_t_70{
    margin-top:70px;
}

.grey_texts{
    color:grey;
    font-size:13px;
    margin:0px 20px;
}

.heads_text{
    font-size:17px;
}

.new_main_head{
    width:100px;
}

.sub_heads{
    margin-right:60px;
}

.white{
    color:white;
}
        
.notify-badges{
    position: absolute;
    top:20%;
}

.margin_t_50{
    margin-top:50px;
}

.bg_black{
    background-color: black;
}

.btn_landing_new_small{
   background-color:  #F4004E;
   border-radius: 0px;
   font-weight: 600;
}
.margin_b_30{
    margin-bottom: 30px;
}
.notify-badge-new{
    position: absolute;
    top:10%;
    left:20%;
}
.items {
    position:relative;
    display:inline-block;
}
input.myBox
{
    border: 0px solid #FFFFFF;
    border-bottom-width: 1px;
    background-color: transparent;
    width:100%;
}
input::placeholder {
  color: white;
  font-weight: 600;
}

.btn_send_msg{
    //background: url(../images/new/sen.png) no-repeat;
    width: 140px;
    height:36px;
    color:white;
}
.bg_grey{
    background-color: grey;
}

.sizes{
    font-size: 24px;
    height: 24px;
    margin-bottom: 15px;
}

.no_margin{
    margin:0px;
}

.nopadding{
    padding:0px;
}

.notify-header-badge{
    position: absolute;
    background-color: white;
    opacity: 0.7;
}

.padding_t_5{
    padding:3px 0px;
}

.black_1{
    color:#454346;
}

.ash{
    color:#D1D1D1;
}
</style>

<script type="text/javascript">
    function removeAlert(){
        $('.success_block,.error_block').hide();
    }
</script>
        