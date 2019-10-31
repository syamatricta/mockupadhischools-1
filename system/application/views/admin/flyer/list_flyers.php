<?php echo form_open_multipart('admin_flyer/list_flyers', array('name'=>'frmadhischool','id' => 'frmadhischool'));
if('' != $this->uri->segment(3)){
    $segment = $this->uri->segment(3);
}else{
    $segment ='';
}
?>
<div class="adminmainlist">
    <div class="clearboth"> </div>
        <div class="adminpagebanner">
            <div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"> </div>
        <div class="admininnercontentdiv">
            <div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">                            
                <div class="floatleft smallpaddingright">Title : <br /><input type="text" value="<?php echo $search_title;?>" name="txtSrchTitle" id="txtSrchTitle" style="width:150px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                <div class="floatleft smallpaddingright">Date :  <br />
                    <input type="text" maxlength="20" style="width:110px;margin-top: 5px;" name="txtSrchDate" id="txtSrchDate" readonly value="<?php echo  $search_date;?>"/>
                    <img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.frmadhischool.txtSrchDate,'mm/dd/yyyy',this)" style="margin-bottom:-3px;"/>                    
                </div>
                <div class="floatleft"> &nbsp;&nbsp;&nbsp; <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" style="margin-top: 5px;"/></div>
                <a href="#" id="clearSearchFields" class="floatleft" style="margin-top: 23px;margin-left:10px;">Clear All</a>
            </div>
                    
            <div class="floatright" style="margin-top:10px;"><a href="<?php echo site_url()."admin_flyer/add_flyer"?>">Add Flyer</a></div>
                        
			<?php 
			if(count($flyers) > 0){
                        /* list headings starts here*/		
			?>
			<div class="listdata">
				
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>
                                
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:15%;">Title</div>
					<div class="adminlistheadings" style="width:35%;">Heading</div>
					<div class="adminlistheadings" style="width:15%;">Date & Time</div>
					<div class="adminlistheadings" style="width:12%;text-align:left;">Created Date</div>
					<div class="adminlistheadings" style="width:13%;text-align:center;">Actions</div>
				</div>
			</div>
			<div class="clearboth"> </div>
                        <?php
                           $count=1; 
                            if ($this->uri->segment(3)){
                                $count = $count+$this->uri->segment(3);
                            } 
                            foreach($flyers as $data){
                                $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
                                /* data list starts here */ 
                        ?>
                                <div class="<?php print($bg_color);?>">
                                      <div class="floatleft" style="width:10%;  text-align:center;"><?php print $count;?></div> 
                                      <div class="floatleft" style="width:15%;overflow: hidden"><?php echo $data->title; ?></div>
                                      <div class="floatleft" style="width:35%;overflow: hidden"><?php echo $data->heading; ?></div>
                                      <div class="floatleft" style="width:15%;overflow: hidden;"><?php echo date('m/d/Y h:i a', strtotime($data->date_time));?></div> 
                                      <div class="floatleft" style="width:12%;text-align:left;"><?php echo formatDate($data->created_at);?></div>                                                                                          
                                      <div class="floatleft" style="width:13%;text-align:center;">
                                      <?php
                                          echo '<a href="'.base_url().'admin_flyer/edit_flyer/'.$data->id.'">Edit</a>&nbsp;&nbsp;';
                                          echo '<a href="'.base_url().'admin_flyer/export_flyer/'.$data->id.'" target="_blank">Export</a>&nbsp;&nbsp;';                                                                                                             
                                          echo '<a href="#" onclick="deleteFlyer('.$data->id.')" >Delete</a>'; 
                                      ?>
                                      </div>
                                </div>
                                <div class="clearboth"> </div>
                        <?php
                            $count++;                                 		
                            } 
                        ?>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div>
			<?php } else { ?>
				<div class="nodata">No Flyer found</div>
			<?php }?>
		</div>
		
</div>
<?php echo form_close();?>
<script>
$('clearSearchFields').addEventListener("click", function(event){
    event.preventDefault();
    $('txtSrchTitle').value  = '';
    $('txtSrchDate').value   = '';
    $("frmadhischool").submit();
});
</script>
    