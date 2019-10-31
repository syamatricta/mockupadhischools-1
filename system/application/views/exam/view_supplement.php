<div class="floatleft" style="padding-top:10px;width:290px;" >		
	<div class="writeexam"><a rel="nofollow" href="javascript:void(0)" onclick="javascript:view_supplement(<?php echo $id; ?>); return false;"><div class="view_supp_img"></div></a></div>
	<div class="clearboth"></div>
	<?php /* popup starts */ ?>
	<div style="display:none;" id="viewsupplement<?php echo $id; ?>" class="supp-center-screen">
		<?php  echo suppl_box_top($id);?>
			<div class="popup_content_main" style="padding:0 13px;">
				<div class="popup_content_name"><b>View Supplement</b></div>
				<div class="cb"></div>
				<div class="fl" style="position:relative;">
					<select class="styled" name="sel_supplement<?php echo $id; ?>" id="sel_supplement<?php echo $id; ?>">
					<?php foreach ($supplements as $row) { ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
					<?php } ?>					
					</select>
				</div>
				<div class="fl" style="padding-left:20px;">
					<div class="down_supp_img" onclick="downloadSupplement(<?php echo $id; ?>)"></div>
				</div>
			</div>
		<?php echo popup_box_bottom();?>
	</div>
	<?php /* popup ends */ ?>				
</div>	
<script>
function view_supplement(id){
	$('viewsupplement'+id).show();
}
function supple_close(id){
	$('viewsupplement'+id).hide();
}
function downloadSupplement(sel){
	id = $('sel_supplement'+sel).value;
	window.location = base_url+'exam/download/'+id;
}
</script>