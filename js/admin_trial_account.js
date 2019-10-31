/**
 * js functions for admin classroom
 */
function ajax_load_chapters()
{
	courseId = $('course').value;
	if(courseId != '') {
		/*url	= base_url+'admin_classroom/load_chapters/' + $('course').value;
		new Ajax.Request(url, {method:"get", onSuccess: populate_chapter_options });*/
		
		url_e	= base_url+'admin_classroom/load_editions/' + $('course').value;
		new Ajax.Request(url_e, {method:"get", onSuccess: populate_edition_options });
		
	} else {
		/*$('chapter').options.length = null;
		$('chapter').options[$('chapter').options.length] = new Option('--Select Chapter--', '');*/
		
		$('edition').options.length = null;
		$('edition').options[$('edition').options.length] = new Option('--Select Edition--', '');
	}
        $('video-player').innerHTML = '';
}
function ajax_load_edition_chapters()
{
	courseId = $('course').value;
	if(courseId != '') {
		url	= base_url+'admin_classroom/load_chapters/' + $('course').value+'/'+$('edition').value;
		new Ajax.Request(url, {method:"get", onSuccess: populate_chapter_options });
		
	} else {
		$('chapter').options.length = null;
		$('chapter').options[$('chapter').options.length] = new Option('--Select Chapter--', '');		
	}
        $('video-player').innerHTML = '';
}
/**
 * js function to populate options for chapter selects box
 * @return void
 */
function populate_chapter_options(transport)
{
	var obj = eval(transport.responseText);
	
	if(obj != '') {
		$('chapter').options.length = null;
		$('chapter').options[$('chapter').options.length] = new Option('--Select Chapter--', '');
		obj.each(function(chapter){
			$('chapter').options[$('chapter').options.length] = new Option(chapter.name, chapter.id);
		});
	} else {
		$('chapter').options.length = null;
		$('chapter').options[$('chapter').options.length] = new Option('--Select Chapter--', '');
	}
	return;
}

/**
 * js function to populate options for chapter selects box
 * @return void
 */
function populate_edition_options(j_arr)
{
	var obj = eval(j_arr.responseText);
	$('chapter').options.length = null;
		$('chapter').options[$('chapter').options.length] = new Option('--Select Chapter--', '');
	if(obj != '') {
		$('edition').options.length = null;
		$('edition').options[$('edition').options.length] = new Option('--Select Edition--', '');
		obj.each(function(edition){
			$('edition').options[$('edition').options.length] = new Option(edition.edition_no, edition.id);
		});
	} else {
		$('edition').options.length = null;
		$('edition').options[$('edition').options.length] = new Option('--Select Edition--', '');
	}
	return;
}

/**
 * Goto videos, 
 * Load videos corresponding to the course and chapters
 */
function view_video(){
	var chapter_id = $('chapter').value;	
	url	= base_url+'admin_trial_account/load_video/' + chapter_id;
        new Ajax.Request(url, 
            {
                method:"get", 
                onSuccess: function (res){
                    var data    = JSON.parse(res.responseText);
                    if('' != data.video){
                        console.log(data.video);
                        $('video-player').innerHTML = '<div id="classroom-video_'+chapter_id+'" ></div>';
                        file_path       = 'http://streams.adhischools.com/videos/'+data.video;
                        jwplayer("classroom-video_"+chapter_id).setup({
                                //autostart: true,
                                width: 400,
                                flashplayer: base_url+"js/jwplayer/player.swf?file="+file_path,
                                file: file_path

                        });
                    }else{
                        $('video-player').innerHTML = '<b>No Classroom video found for this Quiz</b>';
                    }
                }
        });
}
