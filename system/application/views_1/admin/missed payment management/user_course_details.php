<?php echo form_open_multipart($this->current_controller, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
                    <div class="admininnercontentdiv">
			<div class="listdata">
			<?php if(count($coursedetails)>0){ ?>
				<div class="addressdivisionleft"><strong>Course details of <?php echo $username->firstname. " ".$username->lastname ?> </strong></div>
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:10%; text-align:center">Sl.No</div>
					<div class="adminlistheadings" style="width:30%">Course</div>
					<div class="adminlistheadings" style="width:20%;text-align:center">Edition</div>
					<div class="adminlistheadings" style="width:20%">&nbsp;</div>
					<div class="adminlistheadings" style="width:20%">Enrolled/Renew/Reenroll Date</div>
				</div>
				<div class="clearboth"></div>
				<?php 
                                    $count=1;
                                    foreach($coursedetails as $data){
					$r_text 	= '';
					$r_class	= '';
				 	$editions = get_editions($data->course_id);
				 	$bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';	
                                        
				?>
				  <div class="<?php print($bg_color);?>">
					<div class="adminlistheadings" style="width:10%; text-align:center"><?php echo $count;?></div>					
					<div class="adminlistheadings" style="width:30%"><?php echo $data->course_name; ?></div>
					<div class="adminlistheadings" style="width:20%; text-align:center;">
                                        <?php 
                                            foreach ($editions as $ed_no){
                                                if($ed_no['id']==$data->edition){echo $ed_no['edition_no'];}
                                            }
                                        ?>
					</div>
                                        <div class="adminlistheadings" style="width:20%">&nbsp;</div>
					<div class="adminlistheadings" style="width:20%">
						<?php 
                                                if("" != $data->enrolled_date){
                                                    if('0000-00-00' == $data->enrolled_date) {
                                                        echo "";
                                                    } else { 
                                                        echo formatDate($data->enrolled_date);
                                                    }  
                                                }else{
                                                    if('0000-00-00' == $data->renew_reenroll_date) {
                                                        echo "";
                                                    } else { 
                                                        echo formatDate($data->renew_reenroll_date);
                                                    }  
                                                }
                                                ?>
					</div>
                                        <div class="clearboth"></div>
				</div>
				 <?php $count++; 
				 }		
                                }else{ echo "No details captured"; }?>
		</div>
		<div class="backtolist">
			<?php echo anchor($this->current_controller.'/list_renew_reenroll_details', '<< Back to users list');?>
		</div>
	</div>
</div>
<input type="hidden" id="hidcount" name="hidcount"  value="<?php if(isset($_POST['hidcount'])){echo $_POST['hidcount'];}?>" />


<?php echo form_close();?>
<style>
.updat_btn{width:53px;margin:0px 0 0 0;border:1px solid #ccc; 
				background-color:#6E6E6E;color:#FFF;
				text-align:center;
-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	cursor:pointer;
	padding:2px;
}
.action_icon{margin-bottom:6px;float:left;}
a.action_icon{color:#000;}
</style>
<script>
    function gotoMissedlist(a){
        a?$("frmadhischool").action=base_url+"index.php/admin_missed_user/list_renew_reenroll_details/"+a:$("frmadhischool").action=base_url+"index.php/admin_missed_user/list_renew_reenroll_details/";
        $("frmadhischool").submit()
    }
</script>
