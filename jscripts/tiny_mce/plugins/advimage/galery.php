<?php
/*
 ROBIT BT plugins for tinyCME editor
 Image galery browser, image delete, image upload,thumblair generator.
 Accept only one image folder
 Required: PHP4 and gd.lib extension

 Install:
   1. edit this file config section
   2. copy this file into tinyCME/plugins/advimage folder
   3. replace the image.htm in tinyCME/plugins/advimage folder
   4. copy audio.jpg, video.jpg into tinyCME/plugins/advimage folder

 licence: GNU/GPL
 Authot:  Tibor Fogler   foglert@robitbt.hu
                         www.robitbt.hu
 2008.04.20
*/
define ("BASEPATH", '');
require_once("../../../../system/application/config/siteconfig.php");
global $GDok,$IMGFOLDER,$IMGURL,$AUDIOICON,$VIDEOICON;
$GDok 			= TRUE;
// ------------ config section -------------------- 
	
$IMGFOLDER 		= $config['tiny_image_folder'];
$IMGURL 		= $config['tiny_image_url'];

$VIDEOICON		= 'video.jpg';
$AUDIOICON 		= 'audio.jpg';
// language setting   en
$LARGEIMG 		= 'Large Image';
$DELETEIMG 		= 'Delete Image';
$INSERTIMG 		= 'Insert Image Into HTML';
$UPLOADIMG 		= 'Upload';
$HELPSTR 		= 'Click a Image!';
// -------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <style type="text/css">
  	.inputbutton{
		height: 23px; 
		background-color: #FFFFFF; 
		border: 1px solid #ACBDD7; 
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px; 
		font-style: normal; 
		font-weight: normal; 
		color: #487884; 
		border-right: 3px solid #ACBDD7;
		border-bottom: 3px solid #ACBDD7;
	}
	.file_selected{
		border:1px dashed #993399;
		color:#993366;
		font-weight:bold;
		text-align:left;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px; 
		text-align:center;
		height:25px;
		vertical-align:middle;
		padding-top:5px;
	}
  </style>
</head>
<body bgcolor="#F0F0EE">
<?php

function make_thumb($img_name,$filename,$new_w,$new_h) {
  $fsize = filesize($img_name);
  if (!$fsize) {
    return;
  }
  if ($fsize > 100000) {
    return;
  }
  //get image extension.
  $ext=getExtension($img_name);
  //creates the new image using the appropriate function from gd library
  if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext))
    $src_img=ImageCreateFromJPEG($img_name);
  if(!strcmp("JPG",$ext) || !strcmp("JPEG",$ext))
    $src_img=ImageCreateFromJPEG($img_name);
  if(!strcmp("gif",$ext))
    $src_img=ImageCreateFromGIF($img_name);
  if(!strcmp("GIF",$ext))
    $src_img=ImageCreateFromGIF($img_name);
  if(!strcmp("png",$ext))
    $src_img=ImageCreateFromPng($img_name);
  if(!strcmp("PNG",$ext))
    $src_img=ImageCreateFromPng($img_name);
  if (isset($src_img)) {
    if ($src_img != '') {
      //gets the dimmensions of the image
      $old_x=imagesx($src_img);
      $old_y=imagesy($src_img);
      if (($old_x > new_w) | ($old_y > new_h)) {
	      $ratio1=$old_x/$new_w;
	      $ratio2=$old_y/$new_h;
	      if($ratio1>$ratio2) {
	        $thumb_w=$new_w;
	        $thumb_h=$old_y/$ratio1;
	      } else {
	        $thumb_h=$new_h;
	        $thumb_w=$old_x/$ratio2;
	      }
	      // we create a new image with the new dimmensions
	      if (($old_x < 1000) and ($old_y < 1000)) {
	         $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	         // resize the big image to the new created one
	         imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	         // output the created image to the file. Now we will have the thumbnail into the
			 // file named by $filename
	         if(!strcmp("png",$ext))
	           imagepng($dst_img,$filename);
	         else if(!strcmp("gif",$ext))
	           imagegif($dst_img,$filename);
	         else
	           imagejpeg($dst_img,$filename);
	           
	         //  touch ($dst_img);
	      }
	  }
      //destroys source and destination images.
      @imagedestroy($dst_img);
      @imagedestroy($src_img);
    }
  }
}

// get size of image
function getimgsize($filename,&$x,&$y) {
  $x = -1;
  $y = -1;
  $result = FALSE;
  $imginfo = GetImageSize($filename);
  if (count($imginfo) > 2) {
    $x = $imginfo[0];
    $y = $imginfo[1];
    $result = TRUE;
  }
  return $result;
}

// read directory list,
// echo table with thumbmail images
// (generate thumbmail if not exists)
// onclick=parent.imgselect(i);

 
function maketable($dirname) {
  global $GDok,$IMGFOLDER,$IMGURL,$VIDEOICON,$AUDIOICON;
  $handle = opendir($dirname);
  $file_lista[]=array();
  while ($file = readdir($handle)) {
     if (($file != '.') && ($file != '..')) {
	//	$file_lista[]=$file;
		//echo $file;
     }
  };
  
 	// Grab all files from the desired folder
	$files = glob( $IMGFOLDER.'/*.*' );
	// Sort files by modified time, latest to earliest
	// Use SORT_ASC in place of SORT_DESC for earliest to latest
		array_multisort(
		array_map( 'filemtime', $files ),
		SORT_NUMERIC,
		SORT_DESC,
		$files
		);
		$file_counter = 0;
		// do whatever you want with $files
		foreach ($files as $file){
			$file_counter++;
			if ($file_counter > 100) continue;
			$file_lista[]	= str_replace($IMGFOLDER.'/','',$file) ; 
		}

  closedir($handle);
  $kepdb= -1;
  $coldb = 0;
  print '<table border="0" cellspacin="0" cellpadding="0"><tr>'."\n";
  if (count($file_lista) > 0) {
  	for ( $a=0; $a<sizeof($file_lista); $a++) {
          $fnev = $dirname."/".$file_lista[$a];
          if (! is_dir($fnev)) {
          if (((substr($fnev,-4)==".jpg") || (substr($fnev,-4)==".gif") ||
	            (substr($fnev,-4)==".mpg") || (substr($fnev,-4)==".MPG") ||
	            (substr($fnev,-4)==".mpeg") || (substr($fnev,-4)==".MPEG") ||
	            (substr($fnev,-4)==".avi") || (substr($fnev,-4)==".AVI") ||
	            (substr($fnev,-4)==".wmv") || (substr($fnev,-4)==".WMV") ||
	            (substr($fnev,-4)==".mov") || (substr($fnev,-4)==".MOV") ||
	            (substr($fnev,-4)==".png") || (substr($fnev,-4)==".PNG") ||
	            (substr($fnev,-4)==".mp3") || (substr($fnev,-4)==".MP3") ||
	            (substr($fnev,-4)==".JPG") || (substr($fnev,-4)==".GIF")) &&
                ($file_lista[$a] != 'index.gif') &&
                ($file_lista[$a] != 'index.gif') &&
                (!strpos($file_lista[$a],'_t.'))) {
                $kepdb++;
                $coldb++;
         	    $picname=substr($file_lista[$a], 0, -4);
                $belyeg = $dirname.'/'.$picname.'_t'.substr($file_lista[$a],-4);
                $belyegurl = $IMGURL.'/'.rawurlencode($picname).'_t'.substr($file_lista[$a],-4);
	            if ((substr($fnev,-4)==".mpg") || (substr($fnev,-4)==".MPG") ||
	                (substr($fnev,-4)==".avi") || (substr($fnev,-4)==".AVI") ||
	                (substr($fnev,-4)==".wmv") || (substr($fnev,-4)==".WMV") ||
	                (substr($fnev,-4)==".mov") || (substr($fnev,-4)==".MOV")) {
                   $belyeg = './'.$VIDEOICON;
                   $belyegurl = './'.$VIDEOICON;
                }
                if ((substr($fnev,-4)==".mp3") || (substr($fnev,-4)==".MP3")) {
                     $belyeg = './'.$AUDIOICON;
                     $belyegurl = './'.$AUDIOICON;
                }
                // ha m�g nincsb�lyegk�p akkor l�trehozni
                if (!file_exists($belyeg)) {
                   if ($GDok) make_thumb($fnev,$belyeg,60,60);
	            };
				if (! file_exists($belyeg)) {
                   $belyeg = $dirname.'/'.$file_lista[$a];
				   $belyegurl = $IMGURL.'/'.rawurlencode($file_lista[$a]);
                }
                $x = -1;
                $y = -1;
                getimgsize($belyeg,$x,$y);
                print '<td width="70" height="70" onclick="parent.selectimg('.$kepdb.')" '.
                      'align="center" valign="center" style="padding:5px; cursor:pointer;">'."\n";
                if ($x < 0) {
				  print '<img src="'.$belyegurl.'" alt="'.$file_lista[$a].'" width="60" height="60" id="'.$kepdb.'" />';
				} else if ($x > $y) {
				  print '<img src="'.$belyegurl.'" alt="'.$file_lista[$a].'" width="60" id="'.$kepdb.'" />';
				} else {
				  print '<img src="'.$belyegurl.'" alt="'.$file_lista[$a].'" height="60" id="'.$kepdb.'" />';
				}
                print '</td>'."\n";
				if ($coldb == 5) {
				  print '</tr><tr>'."\n";
				  $coldb = 0;
				}
  	      }
       }
     }
   }
   print '</tr></table>'."\n";
} //function makejsdir

// This function reads the extension of the file.
// It is used to determine if the file is an image by checking the extension.
function getExtension($str) {
  $i = strrpos($str,".");
  if (!$i) { return ""; }
  $l = strlen($str) - $i;
  $ext = substr($str,$i+1,$l);
  return $ext;
}
function fncUuid(){
	return sprintf('%08x-%04x-%04x-%02x%02x-%012x', mt_rand(), mt_rand(0, 65535), bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '0100', 11, 4)), bindec(substr_replace(sprintf('%08b', mt_rand(0, 255)), '01', 5, 2)), mt_rand(0, 255), mt_rand() );
}
// ----------------
// main program
// ----------------
if (!extension_loaded('gd')) {
   if (!dl('gd.so')) {
       $GDok = FALSE;
   }
}
if (isset($_GET['dirname'])) $dirname = $_GET['dirname']; else $dirname = $IMGFOLDER;
if (isset($_GET['act'])) $act = $_GET['act']; else $act = $list;
if (isset($_POST['act'])) $act = $_POST['act'];
if (isset($_POST['fname'])) $fname = $_POST['fname']; else $fname = '';
if ($act == 'upload') {
  // do file upload
    $name = strtolower(substr(fncUuid(),0,8).'_'.str_replace(' ','',$_FILES['upload']['name']));
    if (!is_dir($dirname)) {
       mkdir($dirname,0777);
    };
    if (file_exists("$dirname/$name"))  {
         echo "<p>"._EXIST." $dirname/$name </p>";
    } else {
        if (is_uploaded_file($_FILES['upload']['tmp_name'])) {
           if (move_uploaded_file($_FILES['upload']['tmp_name'],"$dirname/$name" ))
              chmod("$dirname/$name",0777);
        };
        if (!file_exists("$dirname/$name")) {
          echo "<p>"._UPLOADERROR." $dirname/$name</p2>\n";
        };
       	$picname=substr($name, 0, -4);
    };
}
if ($act == 'delete') {
  // do delete file
  unlink($IMGFOLDER.'/'.$_POST['fname']);
}
if ($act == 'list') {
  // generate table
  maketable($dirname);
  print '</body></html>';
  exit();
}
// draw image manager window
print '<iframe id="frm1" name="frm1" width="480" height="220" frameborder="0" style="border:1px dashed #993399;" src="./galery.php?act=list"></iframe>'."\n";
print "<form name=\"imgupload\" method=\"post\" frameborder=\"0\" action=\"./galery.php?dirname=$dirname\" enctype=\"multipart/form-data\">\n";
print "<center>\n";
print '<p id="imgalt" class = "file_selected">'.$HELPSTR.'&nbsp;</p>'."\n";
//print "<p>$HELPSTR</p>\n";
print ("<button type=button onclick=viewimg(); class=\"inputbutton\">$LARGEIMG</button>&nbsp;&nbsp;&nbsp;\n");
print ("<button type=button onclick=insertimg(); class=\"inputbutton\" >$INSERTIMG</button>&nbsp;&nbsp;&nbsp;\n");
print ("<button type=button onclick=deleteimg(); class=\"inputbutton\">$DELETEIMG</button>&nbsp;&nbsp;&nbsp;\n");
print ("<button type=button onclick=\"javascript:window.close();\" class=\"inputbutton\">Close</button>&nbsp;&nbsp;&nbsp;<br />\n<br/>");

print ("<input type=file size=40 name=upload >&nbsp;");
print ("<input type=hidden name=act value=\"upload\" class=\"inputbutton\">&nbsp;");
print ("<input type=hidden name=fname value=\"\" class=\"inputbutton\">&nbsp;");
print ("<button type=button onclick=\"uploadimg();\" class=\"inputbutton\">$UPLOADIMG</button><br />\n");
print ("</center>\n");
print ("</form>\n");
print ("</center>\n");
?>
<script language="JavaScript">

function selectimg(i) {
  doc = frames['frm1'].document;
  if (selected >= 0) {
    img = doc.getElementById(selected);
    img.parentNode.style.background = 'white';
  }
  selected = i;
  img = doc.getElementById(i);
  img.parentNode.style.background = 'blue';
  document.getElementById('imgalt').innerHTML = img.alt;
}

function deleteimg() {
	if(!confirm('Are you sure do you want to delete the image?')){
		return;
	}
	if (selected >= 0) {
		doc = frames['frm1'].document;
		img = doc.getElementById(selected);
		document.forms.imgupload.act.value='delete';
		document.forms.imgupload.fname.value=img.alt;;
		document.forms.imgupload.submit();
	}
}

function uploadimg() {
  document.forms.imgupload.act.value='upload';
  document.forms.imgupload.submit();
}

function insertimg() { 
  if (selected >= 0) { 
    doc = frames['frm1'].document; 
    img = doc.getElementById(selected);
    opener.document.forms[0].src.value = '<?php echo $IMGURL ?>/'+img.alt;
    window.close();
  }
}

function viewimg() {
  if (selected >= 0) {
    doc = frames['frm1'].document;
    img = doc.getElementById(selected);
    fnev = '<?php echo $IMGURL ?>/'+img.alt;
    window.open(fnev,'','left=100,top=100,width=600,height=600,resizable=yes,scrollbars=yes');
  }
}
// js main program
selected = -1;
</script>
</body>
</html>
