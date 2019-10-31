<div id="sitepagemain">
    
    <table border="0" cellpadding="0" cellspacing="0" width="701">
        <tr>
            <td width="701" align="left" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="701">
                	<tr>
	            		<td colspan="2">
	            			<table border="0" cellpadding="0" cellspacing="0" width="201" align="left">
	                            <tr>
	                                <td height="135" ><?php if(isset($contentdetails->image_name)) {?><img src="<?php echo $this->config->item('image_uploadbp_url').$contentdetails->image_name;?>" width="201"  height="135"> <?php  } ?></td>
	                            </tr>
	                         </table>
	            		</td>
	            	</tr>
                    <tr>
                        <td width="500" align="left" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="500" style="margin-top: 40px;">
                            	
                                <tr>
                                    <td>
                                        <div class="brokerlabelcontent">Company name</div>
                                        <div class="brokerlabelcolon">:&nbsp;&nbsp;</div>
                                        <div class="brokertxtcontent"><?php echo (isset($contentdetails->company_name))?$contentdetails->company_name:''; ?></div>
                                        <div class="clearboth10"></div>
                                        <div class="brokerlabelcontent">Address</div>
                                         <div class="brokerlabelcolon">:&nbsp;&nbsp;</div>
                                        <div class="brokertxtcontent"><?php print(isset($contentdetails->address))?$contentdetails->address:''; ?></div>
                                       <div class="clearboth10"></div>
                                        <div class="brokerlabelcontent">Hiring Contact</div>
                                         <div class="brokerlabelcolon">:&nbsp;&nbsp;</div>
                                        <div class="brokertxtcontent"><?php print(isset($contentdetails->hiring_contact_name))?$contentdetails->hiring_contact_name:''; ?></div>
                                        <div class="clearboth10"></div>
                                        <div class="brokerlabelcontent">Phone number</div>
                                        <div class="brokerlabelcolon">:&nbsp;&nbsp;</div>
                                        <div class="brokertxtcontent"><?php print(isset($contentdetails->phone_number))?$contentdetails->phone_number:''; ?></div>
                                        <div class="clearboth10"></div>
                                        <div class="brokerlabelcontent">Company Information</div>
                                        <div class="brokerlabelcolon">:&nbsp;&nbsp;</div>
                                        <div class="brokertxtcontent"><?php print(isset($contentdetails->company_information))?$contentdetails->company_information:''; ?></div>
                                        </td>
                                </tr>
                            </table>
                        </td>
                         <td height="230" valign="top" style="text-align:center">
                             <div id="youtube_vid"></div>
                             <?php if(isset($contentdetails->yt_video)) {?>                            
                                <input type="hidden" id="yt_video_id" />
                                <script>function popup_close(){}$('yt_video_id').value=get_youtube_id('<?php echo $contentdetails->yt_video;?>');initYoutubeVideo();once_played=true;</script>
                             <?php }?>
                         </td>
                    </tr>
            </table>
        </tr>      
    </table>
</div>
