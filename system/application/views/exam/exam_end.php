<?php echo  form_open ('exam/examination/', array('name'=>'examination_form_end','id' => 'examination_form_end', 'class' => '') ); ?>
<div id="maindiv">
	<div id="examresultviewmain" >
		<div class="clearboth"></div>
		<div class="examsuccessinnercontentdiv" >
				<?php 
                                if($grade)
                                {
                                    $banner_path = "pass/success_banner.png";
                                }
                                else
                                {
                                    $banner_path = "fail/fail_banner.png";
                                }
                                ?>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="exam-success-table">
                                    <tr>
                                        <td>
                                            <?php if($grade) { ?>
                                            <img border="0" src="<?php  echo $this->config->item('images');?>result/<?php echo $banner_path;?>" width="673" height="55" />
                                            <?php } else { ?>
                                            <table cellpadding="0" border="0" cellspacing="0">
                                                <tr>
                                                    <td height="53"><img style="float:left" border="0" height="53" src="<?php  echo $this->config->item('images');?>result/fail/failleft.png"  /></td>
                                                    <!-- valign="middle" -->
                                                    <td width="90%" align="top" height="53">
                                                        <div class="fail_banner">
                                                            Sorry. You only answered <?php echo $right_count;?> questions correctly
                                                        </div>
                                                    </td>
                                                    <td valign="top"  height="53"><img  style="float:left" border="0" height="53" src="<?php  echo $this->config->item('images');?>result/fail/fail_right.png"  /></td>
                                                </tr>
                                            </table>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <td class="success-table-data">
                                            <table width="100%" cellspacing="0" cellpadding="6" border="0" >
                                                <tr>
                                                    <td width="18%">Name </td>
                                                    <td width="1%"> : </td>
                                                    <td width="35%" style="color:#000000;"><?php echo $this->session->userdata('USER_NAME')." ".$this->session->userdata('LAST_NAME');?></td>
                                                    
                                                    <td width="10%">Score</td>
                                                    <td width="1%"> : </td>
                                                    <td style="color:#000000;"><?php echo ($right_count)?$right_count:0;  ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="18%">Course </td>
                                                    <td width="1%"> : </td>
                                                    <td  width="35%" style="color:#000000;"><?php echo $data_exam[0]['course_name'];?></td>
                                                    
                                                    <td width="10%">Status </td>
                                                    <td width="1%"> : </td>
                                                    <td><?php if($grade){ echo "<span style='color:#ABB95E'><b>Passed</b></span>";} else { echo "<span style='color:#FF0000'><b>Failed</b></span>";}?></td>
                                                </tr>
                                                <tr>
                                                    <td width="18%">Date attended</td>
                                                    <td width="1%"> : </td>
                                                    <td  width="35%" style="color:#000000;"><?php echo $data_exam_completed;?></td>
                                                    <td colspan="3"><?php echo $reenroll_message;?></td>
                                                </tr>
                                                <tr><td colspan="6">&nbsp;</td></tr>
                                            </table>
                                            
                                            <table  width="100%" cellspacing="0" cellpadding="6" border="0">
                                                <tr>
                                                    <td width="35%">Number of Questions & Answers </td>
                                                    <td width="1%"> : </td>
                                                    <td><?php echo ($total)?$total:0;  ?></td>
                                                    <td rowspan="4" align="right" width="69%">
                                                        <?php if($grade){ ?>
                                                        <img style="float:right;" src="<?php  echo $this->config->item('images');?>result/pass/results_08.png" width="155" height="135" />
                                                        <?php } else { ?>&nbsp;<?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Number of Right Answers </td>
                                                    <td width="1%"> : </td>
                                                    <td><?php echo ($right_count)?$right_count:0;  ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Number of Wrong Answers</td>
                                                    <td width="1%"> : </td>
                                                    <td><?php echo ($wrong_count)?$wrong_count:0;  ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Number of Unanswered Questions</td>
                                                    <td width="1%"> : </td>
                                                    <td><?php echo ($not_attend_count)?$not_attend_count:0;  ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>  
                                    
                                    <?php if($grade){?>
                                        <tr>
                                            <td class="success-table-data" style="color:red;font-size:12px; padding:20px 30px;">
                                                <div style="float:left;width:7%"> <b> <u> Note </u> </b>: &nbsp; &nbsp;</div>
                                                <div>
                                                    This is not your official certificate. Please download this by clicking the below link.  Do not submit this image to the state.
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="floatleft" style="width:100%;margin-left:25px;">      
                                                    <a class="bluelink" href="<?php echo base_url().'exam/pdf_create/'.$course_id ?>">View Certificate</a>
                                                </div>
                                            </td>
                                        </tr>   
                                    <?php }?>
                                    
                                    <tr>
                                        <td>
                                            <img src="<?php  echo $this->config->item('images');?>result/pass/results_10.png" width="673" height="45" />
                                        </td>
                                    </tr>
                                </table>                               
                                <!-- NEW TEMPLATE  -->
                                
				
		</div>
                                
                
	</div>
</div>
<?php echo form_close();?>

<script type="text/javascript" language="javascript">
	disable_ctrl(this);
	disable_rightClick(this);


</script>
<style>
    .fail_banner {
        height:27px;
        /*margin-bottom:1px !important;*/
        background-color: #CC3336;
        padding:15px 0 0;
        color:#FFFFFF;
        text-align: left;
        font-weight:bold;
        vertical-align: middle;
        border:0;
        /*float: left;*/
        
    }

    </style>