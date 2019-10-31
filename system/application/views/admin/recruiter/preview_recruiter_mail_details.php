<div class="clearboth"></div>
<form name="frmPreviewmail" id="frmPreviewmail" method="post" action="">
	<div id="maindiv" style="width:1023px;">
		<div id="registerviewmain">
			<div class="stmain">
				<div class="floatleft"><span class="registerredheading" style="color:black;"> Preview Mail </span></div>
				<div class="clearboth"></div>
				<div class="registerinnerregistercontentdiv" >
                                        <div  class="page_error" id="errordiv" ><?php echo $this->session->flashdata("fail_mail"); ?></div>
					<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success_mail");   ?></div>
                                        <?php $display = ($this->session->flashdata("success_mail") != '') ? 'none' : ''; ?>
					<div class="clearboth"></div>
						<div class="listregistermain" style="margin-bottom:30px;">
							<div>
								<div class="contents_registermain" >
									<div class="clearboth">&nbsp;</div>
                                                                        
									<div class="leftside_register padding_r">From :</div>
									<div class="middlecolon_register">&nbsp;</div>
									<?php echo ucfirst($mail_template[0]['mail_from_name']).'  ('; ?> <span style="color:blue;"> <?php echo $mail_template[0]['mail_from'].' )'; ?> </span>
                                                                        <div class="clearboth"></div>
                                                                        
                                                                        <div class="leftside_register padding_r">To :</div>
									<div class="middlecolon_register">&nbsp;</div>
								        <?php echo ucfirst($data['recruiter_name']).' '.ucfirst($data['recruiter_last_name']).'  ('; ?> <span style="color:blue;"> <?php echo $data['recruiter_mail'].' )'; ?> </span>
									<div class="clearboth"></div>
                                                                        
                                                                        <?php //if($mail_template[0]['mail_cc'] != ''){ ?>
									<div class="leftside_register padding_r">Cc :</div>
									<div class="middlecolon_register">&nbsp;</div>
								        <?php echo ucfirst($data['student_first_name']).' '.ucfirst($data['student_last_name']).' ( '; ?> <span style="color:blue;"><?php echo $data['student_mail_id'].' ) '; echo ($mail_template[0]['mail_cc'] != '') ?  ','. $mail_template[0]['mail_cc'] : ''; ?></span>
									<div class="clearboth"></div>
                                                                        <?php //} ?>
                                                                        
                                                                        <?php if($mail_template[0]['mail_bcc'] != ''){ ?>
									<div class="leftside_register padding_r">Bcc :</div>
									<div class="middlecolon_register">&nbsp;</div>
									<span style="color:blue;"> <?php echo $mail_template[0]['mail_bcc']; ?> </span>
									<div class="clearboth"></div>
                                                                        <?php } ?>
                                                                        
                                                                        <div class="leftside_register padding_r">Copy mail :</div>
									<div class="middlecolon_register">&nbsp;</div>
									<span style="color:blue;"> <?php echo ($data['recruiter_copy_mail'] != "") ? $data['recruiter_copy_mail'] : '-';  ?> </span>
									<div class="clearboth"></div>
                                                                        
                                                                        
                                                                        
									<div class="leftside_register padding_r">Subject :</div>
                                                                        <div class="middlecolon_register">&nbsp;</div>
									<?php echo $mail_template[0]['mail_subject']; ?>
									<div class="clearboth"></div>
			
									<div class="leftside_register padding_r">Body :</div>
									<div class="middlecolon_register">&nbsp;</div>
									<div style="padding-left:32%;"><?php echo $mail_template[0]['mail_body']; ?></div>
									<div class="clearboth"></div>
								</div>
							<?php /*content recruiter mail end*/?>
                                                                <div class="row padding_long">
                                                                      <div class="clearboth">&nbsp;</div>
                                                                      <input class="btn red"  id="mail_btn_send" type="button" value="Send" onclick ="javascript : fncSendRecruiterMail();" style="display:<?php echo isset($display) ? $display : ''; ?>"/>
                                                                      <input class="btn red"  id="mail_btn_edit" type="button" value="Edit" onclick ="javascript : fncEditRecruiterMail();" style="display:<?php echo isset($display) ? $display : ''; ?>"/>
                                                                      <?php /*<div id="loader" style="display:none;"> </div> */ ?>
                                                                      <div class="backtolist" id="mail_btn_back" style="display:<?php echo (isset($display) && $display == 'none') ? 'block' : 'none'; ?>"><?php echo anchor('admin_recruiter/recruiter_mail/','<< Back')?></div>
                                                                </div>
                                                                       <input type="hidden" name="hidmailid" id="hidmailid" value="<?php echo $data['adhi_recruiter_send_mail_id']; ?>"/>
                                                                       <input type="hidden" name="hidrecruiterid" id="hidrecruiterid" value="<?php echo $data['recruiter_referred']; ?>"/>
                                                                       <input type="hidden" name ="from" value ="<?php echo $mail_template[0]['mail_from']; ?>"/>
                                                                       <input type="hidden" name ="from_name" value ="<?php echo ucfirst($mail_template[0]['mail_from_name']); ?>"/>
                                                                       <input type="hidden" name ="to_name" value ="<?php echo ucfirst($data['recruiter_name']).' '.ucfirst($data['recruiter_last_name']); ?>"/>
                                                                       <input type="hidden" name ="to" value ="<?php echo $data['recruiter_mail']; ?>"/>
                                                                       <input type="hidden" name ="cc" value ="<?php echo $mail_template[0]['mail_cc'].','.$data['student_mail_id']; ?>"/>
                                                                       <input type="hidden" name ="copy_mail" value ="<?php echo $data['recruiter_copy_mail']; ?>"/>
                                                                       <input type="hidden" name ="bcc" value ="<?php echo $mail_template[0]['mail_bcc']; ?>"/>
                                                                       <input type="hidden" name ="subject" value ="<?php echo $mail_template[0]['mail_subject']; ?>"/>
                                                                       <input type="hidden" name ="body" value ="<?php echo $mail_template[0]['mail_body']; ?>"/>
                                                                      
                                                        <div class="clearboth">&nbsp;</div>
                                                    </div>
                                            <?php /*preview recruiter mail data end*/?>
                                            </div>
			</div>
		</div>
	</div>
    </div>        
</form>


