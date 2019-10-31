<?php echo form_open_multipart('admin_region/add_subregion', array('name'=>'adminregionform','id' => 'adminregionform')); ?>
<div class="adminmainlist">
	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
		<div class="clearboth paddingtop"></div>
		<div class="breadcrump"><?php echo $region_name;?> >>></div>
	</div>
	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div  class="page_error" id="divError">&nbsp;
			<?php 
				if(validation_errors()) echo  validation_errors();
				if(isset($error_region)) echo $error_region;
			?>
		</div>
		<div class="clearboth paddingtop">&nbsp;</div>
		
		<div class="listdata paddingleft">
			<?php 
			if(count($subregion)>0){ 
				$i = 1;
				?>
				<div style="float:left;font-weight:bold;width:100%;">
					<div class="floatleft" style="width:6%;background-color:#CCCCCC;">Sl No</div>
					<div class="floatleft" style="width:25%;background-color:#CCCCCC;">Sub-Region Name</div>
					<div class="floatleft" style="width:64%;background-color:#CCCCCC;">Address</div>
				</div>
				<div class="clearboth paddingtop"></div>
				<?php 
				foreach($subregion as $value){ ?>
					<div class="floatleft" style="width:6%;">&nbsp;<?php echo $i;?>.</div>
					<div class="floatleft" style="width:25%;"><?php echo $value->subregion_name;?></div>
					<div class="floatleft"><?php echo $value->subregion_address;?></div>
					<div class="clearboth paddingtop"></div>
				<?php 
					$i++;
				} 
			}else{
				echo '<div class="floatleft" style="width:30%;font-weight:bold;">No Sub-Regions found</div>';
			} ?>
		</div>
		
	</div>
	
	<div class="backtolist"><?php echo anchor('admin_region/list_region/'.$page_no,'<< Back to regions list')?></div>
 </div>
<?php echo form_close();?>