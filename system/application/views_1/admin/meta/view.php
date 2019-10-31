<div class="adminmainlist">
	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		
		<div class="clearboth paddingtop" >&nbsp;</div>
		<div class="subregion_main">
			<div class="floatleft subregion_label">Page Name</div>
			<div class="floatleft subregion_midcolon">:</div>
			<div class="floatleft subregion_data"><?php echo $meta->meta_page_name;?></div>
			<div class="clearboth paddingtop"></div>
			<div class="floatleft subregion_label">Page Title</div>
			<div class="floatleft subregion_midcolon">:</div>
			<div class="floatleft subregion_data"><?php echo $meta->meta_page_title;?></div>
			<div class="clearboth paddingtop"></div>
			<div class="floatleft subregion_label">Keyword</div>
			<div class="floatleft subregion_midcolon">:</div>
			<div class="floatleft subregion_data"><?php echo $meta->meta_keyword;?></div>
			<div class="clearboth paddingtop"></div>
			<div class="floatleft subregion_label">Description</div>
			<div class="floatleft subregion_midcolon">:</div>
			<div class="floatleft subregion_data"><?php echo $meta->meta_description;?></div>
			<div class="clearboth paddingtop"></div>
		</div>
		
	</div>
	<div class="backtolist"><?php echo anchor('admin_meta/list_items/','<< Back to meta tag list')?></div>
 </div>
