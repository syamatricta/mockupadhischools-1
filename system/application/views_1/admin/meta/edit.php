<?php echo form_open_multipart("admin_meta/edit/".$meta_id, array('name'=>'frm_meta_update','id' => 'frm_meta_update'));?>
<div class="adminmainlist">
	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
		<div class="clearboth paddingtop"></div>
	</div>
	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (isset($error) && ''!= $error) : echo '<div class="page_error">'.$error.'</div>'; endif;?>
		<div  class="page_error" id="divError">&nbsp;
			<?php 
				if(validation_errors()) echo  validation_errors();
				if(isset($error)) echo $error;
			?>
		</div>
		<div class="page_success"><?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success');}?></div>
		<div class="clearboth paddingtop">&nbsp;</div>
		<div class="listdata">
				<div class="floatleft region_leftlabel">Page Name<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<input  type="text" id="txt_meta_name" name="txt_meta_name" title="Meta Name" value="<?php if(set_value('txt_meta_name')){ echo set_value('txt_meta_name');} else{echo  $meta->meta_page_name;}?>" autocomplete="off" />
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">Title<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<input  type="text" id="txt_meta_title" name="txt_meta_title" title="Meta Title" value="<?php if(set_value('txt_meta_title')){ echo set_value('txt_meta_title');}else{echo $meta->meta_page_title;}?>" autocomplete="off" />
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">Keyword<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<input  type="text" id="txt_meta_keyword" name="txt_meta_keyword" title="Meta Keyword" value="<?php if(set_value('txt_meta_keyword')){ echo set_value('txt_meta_keyword');}else{echo  $meta->meta_keyword;}?>" autocomplete="off" />
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">Description<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<textarea rows="10" cols="10" style="width:200px;"  id="txt_meta_description" name="txt_meta_description" title="Meta Description"><?php if(set_value('txt_meta_description')){ echo set_value('txt_meta_description');}else{echo $meta->meta_description;}?></textarea>
				</div>
				
			
				<div class="clearboth paddingtop"></div>
				<div class="subregion_addbutton">
					<input type="image" name="btnAdd" id="btnAdd"  onclick="javascript:return fncSaveMeta('<?php echo $meta->meta_id; ?>','');"src="<?php  echo $this->config->item('images');?>innerpages/user_submit.jpg" />
				</div>
				<div class="clearboth"></div>
		</div>
	</div>
	
	<div class="backtolist"><?php echo anchor('admin_meta/list_items/','<< Back to meta tag list')?></div>
 </div>
<?php echo form_close();?>




