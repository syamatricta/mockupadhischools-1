<?php 
$id = '';
$name = '';
$description = '';
if($staff){
	$id = $staff->id;
	$name = $staff->name;
	$description = $staff->description;
}
 echo form_open_multipart('admin_meetourstaff/edit_staff/'.$id, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
 
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
				<div class="rightsidedata_view"><input type="text" name="txtName" id="txtName" maxlength="250" value="<?php echo set_post_value('txtName',$name);?>" /></div>
				<div class="clearboth"></div>				
				<div class="leftsideheadings_view">Working From<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view">
					<select name="cboyear" id="cboyear">                    
	                    <?php
	                      $cyear =date('Y');
	                            while ($cyear>= 2000){
	                            	$sel =($cyear==set_post_value('txtName',$staff->since))?'selected':'';
	                                echo '<option value="'.$cyear.'"'.$sel.'>'.$cyear.'</option>';                                   
									$cyear --;
	                            }
	                     
	                    ?>
	            	</select>
				</div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Photo</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view">
					<div id="insimg">
						<img  src="<?php echo $this->config->item('staff_image_upload_url').$staff->photo; ?>" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" />
					</div>
					<br />
					<input type="hidden" name="txtPhoto" id="txtPhoto"   value="" />
					<input type="hidden" name="txtimg" id="txtimg"   value="<?php echo $staff->photo?1:""?>" />
					<br/>
					<!--span style="color:#999999">Allowed file types: gif,jpg,png,jpeg.<br/> Allowed size: 4MB</span-->
					</div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Description<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><textarea name="txtContent" id="txtContent" rows="4" cols="30"><?php echo set_post_value('txtContent',$description);?></textarea></div>
				
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Base hours<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><input type="text" name="txtHours" id="txtHours" maxlength="250" value="<?php echo set_post_value('txtHours',$staff->basehour);?>" /></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Weekly hour<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view">
					<div class="weekly"><span id="settotalweekly"><?php echo $staff->totalhour?> </span>&nbsp;&nbsp;
					 <a href="#" class="addweekly">Add Weekly hour</a>
					 <div id="addweeksec" style="display: none " > 
					 	<div class="leftsideheadings_view">Hour</div>
						<div class="middlecolon">:</div>
						<div class="rightsidedata_view"> 
							<input type="text" placeholder="Weekly hours" class="key-numeric" name="weeklyhour" id="weeklyhour" value="" />
							&nbsp;&nbsp;<a href="#" id="addhour" data-staff="<?php echo $staff->id?>">Add</a><span id="weekmsg"></span>
						</div>
					 </div>
					</div>	
				</div>
							
				<div class="clearboth"></div>
				<div class="middlebutton"><input type="button" name="butUpdate" value="Update" onclick="javascript:fncSaveStaff('<?php echo $id; ?>','<?php echo $pageid; ?>');" /></div>
			</div>
			<div style="float: left;width:40%" class="upload-demo">
				<div class="upload-msg"> Upload a new image to start cropping </div>
				<div id="upload-demo" class="croppie-container"></div>
				<div class="actions">
				<a class="btn file-btn">
				<span>Upload</span>
				<input id="upload" type="file" accept="image/*" value="Choose a file">
				</a>
				<a class="btn file-btn upload-result"><span>Crop</span></a>
				</div> 
			
			<div class="clearboth"></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $pageid;?>); return false;"><< Back to staff list </a></div>
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
	        	//alert("Sorry - you're browser doesn't support the FileReader API")
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
				size: 'original'
			}).then(function (resp) {
				 
				 
				html = '<img src="' + resp + '" />';
			 
				jQuery('#insimg').html(html);
				jQuery('#txtPhoto').val(html);
				jQuery('#txtimg').val(1);
			});
		});
	}
 </script>