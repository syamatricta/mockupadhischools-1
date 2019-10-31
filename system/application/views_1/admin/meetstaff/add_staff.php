<?php echo form_open_multipart('admin_meetourstaff/add_staff', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (isset($error) && ''!= $error) : echo '<div class="page_error">'.$error.'</div>'; endif;?>		
		<div class="listdata">
			<div style="float: left;width:60%">
				<div class="leftsideheadings_view">Name<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><input type="text" name="txtName" id="txtName" maxlength="50" value="<?php echo set_post_value('txtName');?>" /></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Working From<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view">
					<select name="cboyear" id="cboyear">
	                    <option value="0">Year</option>
	                    <?php
	                      $year =date('Y');
	                            while ($year>= 2000){
	                            	  $sel =($year==set_post_value('txtName'))?'selected="selected"':'';
	                                  echo '<option value="'.$year.'"'.$sel.'>'.$year.'</option>';
									  $year--;
	                            }
	                     
	                    ?>
	            </select>
				</div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Base hours<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><input type="text" name="txtHours" id="txtHours" maxlength="50" value="<?php echo set_post_value('txtHours');?>" /></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Photo<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view">
					<div id="insimg">
						
					</div>
					<br />
					<input type="hidden" name="txtPhoto" id="txtPhoto"   value="" />
					<input type="hidden" name="txtimg" id="txtimg"   value="" />
					<br/>
				</div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Description<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><textarea name="txtContent" id="txtContent" rows="4" cols="30"><?php echo set_post_value('txtContent');?></textarea></div>
				<div class="clearboth"></div>
				<div class="middlebutton">
					<input type="image" name="butSave" id="butSave"  onclick="javascript:return fncSaveStaff('','');"  src="<?php  echo $this->config->item('images');?>innerpages/user_submit.jpg" />
					<!--<input type="button" name="butSave" value="Submit" onclick="javascript:fncSaveStaff('','');" />-->
				</div>
				
			</div>
			<div style="float: left;width:40%" class="upload-demo">
				<div class="upload-msg"> Upload image to start cropping </div>
				<div id="upload-demo" class="croppie-container"></div>
				<div class="actions">
				<a class="btn file-btn">
				<span>Upload</span>
				<input id="upload" type="file" accept="image/*" value="Choose a file">
				</a>
				<a class="btn file-btn upload-result"><span>Crop</span></a>
				</div> 
			
				<div class="clearboth"></div>
			</div> 
			<div class="clearboth"></div>
			
			
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="<?php echo base_url().'admin_meetourstaff/list_staff';?>"><< Back to Staff list </a></div>
	<input type="hidden" id="hidStaffid" name="hidStaffid"  value="" />
        <?php  enable_tiny_mce("txtContent","advanced"); ?>
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>
<script>
 	  
   
 demoUpload();
 jQuery('#txtPhoto').val('');
 function output(node) {
		var existing = $('#result .croppie-result');
		if (existing.length > 0) {
			existing[0].parentNode.replaceChild(node, existing[0]);
		}
		else {
			$('#result')[0].appendChild(node);
		}
	}

	function popupResult(result) {
		var html;
		if (result.html) {
			html = result.html;
		}
		if (result.src) {
			html = '<img src="' + result.src + '" />';
		}
		console.log(html);
		return false;
		//swal({
		//	title: '',
		//	html: true,
		//	text: html,
		//	allowOutsideClick: true
		//});
		
	}
 function demoUpload() {
		var $uploadCrop;

		function readFile(input) {
 			if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
	            	$uploadCrop.croppie('bind', {
	            		url: e.target.result
	            	});
	            	jQuery('.upload-demo').addClass('ready');
	            }
	            
	            reader.readAsDataURL(input.files[0]);
	        }
	        else {
		       // swal("Sorry - you're browser doesn't support the FileReader API");
		    }
		}

		$uploadCrop = jQuery('#upload-demo').croppie({
		    exif: true,
		    viewport: {
		        width: 150,
		        height: 150,
		        type: 'circle'
		    },
		    boundary: {
		        width: 200,
		        height: 200
		    }
		});

		jQuery('#upload').on('change', function () { readFile(this); });
		jQuery('.upload-demo').on('click','.upload-result', function (ev) {
 			ev.preventDefault()
			$uploadCrop.croppie('result', {
				type: 'canvas',
				size: 'viewport'
			}).then(function (resp) {
				 
				 
				html = '<img src="' + resp + '" />';
			 
				jQuery('#insimg').html(html);
				jQuery('#txtPhoto').val(html);
				jQuery('#txtimg').val(1);
			});
		});
	}
 </script>