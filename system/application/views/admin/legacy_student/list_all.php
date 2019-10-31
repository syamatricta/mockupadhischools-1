<!--<form id="user_export_form">
    <input type="hidden" id="first_name" name="first_name" value="<?php echo $search['first_name'];?>" />
    <input type="hidden" id="last_name" name="last_name" value="<?php echo $search['last_name'];?>" />
    <input type="hidden" id="email_id" name="email_id" value="<?php echo $search['email_id'];?>" />
    <input type="hidden" id="phone" name="phone" value="<?php echo $search['phone'];?>" />
    <input type="hidden" id="address" name="address" value="<?php echo $search['address'];?>" />
</form>
-->
<?php 
echo form_open_multipart(base_url().'admin_legacy_student/list_all', array('name'=>'frmadhischool','id' => 'frmadhischool'));
if('' != $this->uri->segment(3)){
    $segment = $this->uri->segment(3); 
}else{
    $segment ='';
}?>

<div class="adminmainlist">
	<div class="clearboth"> </div>
        <div class="adminpagebanner">
            <div class="adminpagetitle"><?php echo $page_title?> <small>( <a href="<?php echo base_url().'admin_legacy_student/list_all';?>">List all</a> )</small></div>
            <div class="floatright" style="margin-right:10px;margin-top:5px;">No of records : <span style="color:#2196f3;"><?php echo $total_rows;?></span></div>
        </div>
        <!--<div class="page_success"><?php /*echo $success_message*/?></div>-->
        <div class="clearboth"> </div>
	<div class="admininnercontentdiv">
            <div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
                <div class="floatleft smallpaddingright">First Name : 
                    
                    <label class="container">NULL
                        <input type="checkbox" class="checkbox_null" value="1" <?php echo 1 == $search['first_name_null'] ? 'checked' : '';?> name="search[first_name_null]" id="first_name_null">
                        <span class="checkmark"></span>
                    </label>
                    <br/>
                    <input type="text" value="<?php echo $search['first_name'];?>" name="search[first_name]" id="first_name" style="width:110px;margin-top: 5px;" />
                </div>
                <div class="floatleft smallpaddingright">Last Name :  
                    
                    <label class="container">NULL
                        <input type="checkbox" class="checkbox_null" value="1" <?php echo 1 == $search['last_name_null'] ? 'checked' : '';?> name="search[last_name_null]" id="last_name_null">
                        <span class="checkmark"></span>
                    </label>
                    <br/>
                    <input type="text" value="<?php echo $search['last_name'];?>" name="search[last_name]" id="last_name" style="width:110px;margin-top: 5px;" />
                </div>
                <div class="floatleft smallpaddingright">Email :  
                    <label class="container">NULL
                        <input type="checkbox" class="checkbox_null" value="1" <?php echo 1 == $search['email_id_null'] ? 'checked' : '';?> name="search[email_id_null]" id="email_id_null">
                        <span class="checkmark"></span>
                    </label>
                    <br />
                    <input type="text" value="<?php echo $search['email_id'];?>" name="search[email_id]" id="email_id" style="width:130px;margin-top: 5px;" />
                </div>
                <div class="floatleft smallpaddingright">Phone :  
                    <label class="container">NULL
                        <input type="checkbox" class="checkbox_null" value="1" <?php echo 1 == $search['phone_null'] ? 'checked' : '';?> name="search[phone_null]" id="phone_null">
                        <span class="checkmark"></span>
                    </label>
                    <br />
                    <input type="text" value="<?php echo $search['phone'];?>" name="search[phone]" id="phone" style="width:90px;margin-top: 5px;" />
                </div>
                <div class="floatleft smallpaddingright">Address :  
                    <label class="container">NULL
                        <input type="checkbox" class="checkbox_null" value="1" <?php echo 1 == $search['address_null'] ? 'checked' : '';?> name="search[address_null]" id="address_null">
                        <span class="checkmark"></span>
                    </label>
                    <br />
                    <input type="text" value="<?php echo $search['address'];?>" name="search[address]" id="address" style="width:100px;margin-top: 5px;" />
                </div>
                <div class="floatleft smallpaddingright">Validation :  
                    <br />
                    <select name="search[validation]" id="validation" style="margin-top: 5px;width: 82px;" onchange="submitForm()">
                        <option <?php echo ('' == $search['validation']) ? 'selected' : '' ;?> value=""><small>ALL</small></option>
                        <option <?php echo (1 == $search['validation']) ? 'selected' : '' ;?> value="1"><small class="text-success">SUCCESS</small></option>
                        <option <?php echo (2 == $search['validation']) ? 'selected' : '' ;?> value="2"><small class="text-error">FAILED</small></option>
                    </select>
                </div>
                <div class="floatleft smallpaddingright">
                    <label class="container" style="margin-left:0;top:13px;line-height: 16px;">Course <br/>not in db
                        <input type="checkbox" class="" value="1" 
                            <?php echo 1 == $search['course_not_found'] ? 'checked' : '';?> 
                               name="search[course_not_found]" id="course_not_found">
                        <span class="checkmark"></span>
                    </label>                    
                </div>
                <div class="floatleft smallpaddingright">
                    <label class="container" style="margin-left:0;top:13px;line-height: 16px;">18 day <br/>Rule Failed
                        <input type="checkbox" class="" value="1" 
                            <?php echo 1 == $search['day_rule_failed'] ? 'checked' : '';?> 
                               name="search[day_rule_failed]" id="day_rule_failed">
                        <span class="checkmark"></span>
                    </label>                    
                </div>
                <div class="floatleft" style="margin-top: 10px;"> &nbsp;&nbsp;&nbsp; <br /><input type="submit" value="Search" style="margin-top: 5px;"/></div>
                <!--<div class="floatright" style="margin-top: 40px;margin-right: 10px;">No of records : <span style="color:#2196f3;"><?php echo $total_rows;?></span></div>-->
            </div>
            <?php 
            if(count($students) > 0){
                    /* list headings starts here*/		
            ?>
            <div class="listdata">				
                <div class="clearboth">&nbsp;</div>
                <div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
                <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
                <div class="clearboth"> </div>
                <div class="admintopheads">
                        <?php
                            $column1    = '5%';
                            $column2    = '15%';
                            $column3    = '20%';
                            $column4    = '10%';
                            $column5    = '25%';
                            $column6    = '10%';
                            $column7    = '15%';
                        ?>
                        <div class="adminlistheadings" style="width:<?php echo $column1;?>;text-align:center;">Sl. No</div>
                        <div class="adminlistheadings" style="width:<?php echo $column2;?>">Name</div>
                        <div class="adminlistheadings" style="width:<?php echo $column3;?>">Email Id</div>
                        <div class="adminlistheadings" style="width:<?php echo $column4;?>;">Phone</div>
                        <div class="adminlistheadings" style="width:<?php echo $column5;?>;">Address</div>
                        <div class="adminlistheadings" style="width:<?php echo $column6;?>;text-align:center;">Validation</div>
                        <div class="adminlistheadings" style="width:<?php echo $column7;?>;text-align:center;">Course</div>
                </div>
            </div>
            <div class="clearboth"> </div>
            <?php
            $count=1; 
            if ($this->uri->segment(3)){
                $count = $count+$this->uri->segment(3);
            } 
            foreach($students as $data){
                $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';	
            ?>
            <div class="<?php print($bg_color);?>">
                <div class="floatleft" style="width:<?php echo $column1;?>;  text-align:center;"><?php print $count;?></div> 
                <div class="floatleft" style="width:<?php echo $column2;?>;overflow: hidden">
                    <?php
                        $full_name = $data->first_name.' '.$data->last_name;
                        echo $full_name;
                    ?></div>
                <div class="floatleft" style="width:<?php echo $column3;?>;overflow: hidden;">
                    <?php if($data->email_id !='') {echo $data->email_id; } else { echo  '&nbsp' ;} ?></div> 
                <div class="floatleft" style="width:<?php echo $column4;?>;">
                    <?php if($data->phone !='') {echo $data->phone; } else { echo  '&nbsp' ;} ?></div> 
                <div class="floatleft" style="width:<?php echo $column5;?>;">
                    <?php if('' != $data->address){ echo $data->address;} else {echo "&nbsp";}	?>
                </div> 
                <div class="floatleft" style="width:<?php echo $column6;?>;text-align:center;">
                    <?php 
                    echo (TRUE == $data->validation_success) 
                        ? '<span class="text-success">SUCCESS</span>' 
                        : '<span class="text-error">FAILED</span> <br/>'
                            . '<a data-student="'.$full_name.'" class="show_error" onclick="showValidationErrors(this, '.$data->id.')"><u>Show Errors</u></a>';
                    if(FALSE == $data->validation_success){
                        $validation_errors  = json_decode($data->validation_errors, TRUE);
                        
                        echo '<div id="showValidationError_'.$data->id.'" style="display:none"><ol>';
                        if(count($validation_errors['fatal']) > 0){
                            foreach ($validation_errors['fatal'] as $error){
                                echo '<li><span class="text-error">'.$error.'</span></li>';
                            }
                        }
                        if(count($validation_errors['warning']) > 0){
                            foreach ($validation_errors['warning'] as $error){
                                echo '<li style="margin-bottom:5px;"><span class="text-warning">'.$error.'</span></li>';
                            }
                        }
                        echo '</ol></div>';
                    }
                    ?>
                </div> 
                <div class="floatleft" style="width:<?php echo $column7;?>;text-align:center;">
                    <a class="link" data-student="<?php echo $full_name;?>" onclick="showStudentCourses(this, <?php echo $data->id;?>)">View</a>
                </div>
            </div>
            <div class="clearboth"> </div>
            <?php $count++; 
            /* data list ends here */ 			
	}?>
        <div class="pagination"><?php  echo $paginate;?></div>
	<div style="clear:both">&nbsp;</div>
	<?php }else { ?>
        <div class="nodata" style="text-align:center;width:96%;padding:2%;background-color: lightgray;margin-top:10px;">No Legacy Students</div>
	<?php }?>
</div>		
</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if(isset($_POST['hiduserid'])){echo $_POST['hiduserid'];}?>" />
<?php echo form_close();?>

<style>
    .smallpaddingright{padding-right: 10px;margin-top:10px;}
    .text-success{color:#155724;}
    .text-error{color:#721c24;}
    .text-warning{color:#856404;}
    .show_error{cursor: pointer;color:blue;}
    .link{cursor: pointer;color:blue;}
    
    .overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
      }
  .overlay.show {
    visibility: visible;
    opacity: 1;
  }

  .popup {
    margin: 70px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    width: 30%;
    position: relative;
    /*transition: all 5s ease-in-out;*/
  }

  .popup h2 {
    margin-top: 0;
    color: #333;
    font-family: Tahoma, Arial, sans-serif;
  }
  .popup .close {
    position: absolute;
    top: 13px;
    right: 30px;
    transition: all 200ms;
    font-size: 30px;
    font-weight: bold;
    text-decoration: none;
    color: #333;
    cursor: pointer;
  }
  .popup .close:hover {
    color: #06D85F;
  }
  .popup .content {
    max-height: 30%;
    overflow: auto;
  }
  
  #popup.big .popup{width:60%;}
  
  
  
  th:hover{background-color: #e1e1e1;height: 45px;}
  
  
  
  
  /* The container */
    .container {
        display: inline;
        position: relative;
        padding-left: 20px;
        margin-left: 10px;
        margin-bottom: 0px;
        cursor: pointer;
        font-size: 12px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: -3px;
        left: 0;
        height: 15px;
        width: 15px;
        background-color: #eee;
        box-shadow: 0 0 2px grey inset;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 4px;
        top: 2px;
        width: 4px;
        height: 7px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
<script>
   function showValidationErrors(element, id){       
       $('popupHeading').innerHTML = element.getAttribute('data-student')+'\'s Validation Errors';
       $('popupContent').innerHTML = $('showValidationError_'+id).innerHTML;       
       $('popup').removeClassName('big');
       $('popup').addClassName('show');
   } 
   function hideValidationErrors(){
       $('popupContent').innerHTML = '';       
       $('popup').removeClassName('show');
   } 
   
   function showStudentCourses(element, id){
       $('popup').addClassName('big');
        $('popupContent').innerHTML = '<center>Please wait...</center>';
        $('popup').addClassName('show');
        $('popupHeading').innerHTML = element.getAttribute('data-student')+'\'s Courses';
        var url         = base_url+'admin_legacy_student/view_courses';
        var params 	= "id="+id;
	
	new Ajax.Request(url,
                    { 
                        method		: "post",
                        parameters      : params,
                        evalScripts     : true,
                        onSuccess	: function (obj){
                            $('popupContent').innerHTML = obj.responseText;
                        }
                    }
        );
       
       
   } 
   function hideValidationErrors(){
       $('popupContent').innerHTML = '';       
       $('popup').removeClassName('show');
   } 
   
   function initCheckboxClick() {       
        var checkboxes = document.getElementsByClassName("checkbox_null");
        console.log(checkboxes.length);
        for(i = 0; i < checkboxes.length; i++){
            checkboxes[i].addEventListener('click', checkNullCheckbox, false);
            checkOrUncheck(checkboxes[i].id);
        }
    }
    
    function checkNullCheckbox(){        
        checkOrUncheck(this.id);
    }
    function checkOrUncheck(checkbox_id){
        var input_id    = checkbox_id.replace('_null', '');
        var input       = document.getElementById(input_id);
        if(document.getElementById(checkbox_id).checked){
            input.value = '';
            input.disabled = true;
        }else{
            input.disabled = false;
        }
    }
    //initCheckboxClick();
    window.onload=function(){initCheckboxClick()}
    
    function submitForm(){
        $('frmadhischool').submit();
    }
    

</script>
<div id="popup" class="overlay">
    <div class="popup">
        <h2 id="popupHeading">Validation Errors</h2>
        <a class="close" onclick="hideValidationErrors()" >&times;</a>
        <div class="content" id="popupContent">
                Loading...
        </div>
    </div>
</div>