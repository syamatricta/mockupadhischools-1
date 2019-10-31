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
 * Goto pages, add/Upload 
 * Load pages for add/upload
 * @param string action
 */
function goto_page_action(page_action)
{
	if(page_action != ''){
		courseId = $('course').value;
		chapterId = $('chapter').value;
		
		url = base_url + 'admin_classroom/' + page_action + '/';
		
		if(courseId != '' && chapterId != '' ) {
			//url +=   courseId + '/' + chapterId;
			
		} 
		window.location.href = url;
	}
}

/**
 * Goto videos, 
 * Load videos corresponding to the course and chapters
 */
function goto_list()
{
	courseId = $('course').value;
	chapterId = $('chapter').value;
	
	if(courseId != '' && chapterId != '' ) {
		$('videoListForm').action = base_url + 'admin_classroom/view/' + courseId + '/' + chapterId;
		$('videoListForm').submit();
	} else {
		$('page_error').innerHTML = 'Please select a course and a chapter!'
	}
}

/**
 * confirm_delete
 * 
 * function to confirm delete 
 * 
 */
function confirm_delete(url)
{
	if(confirm("Are you sure, you want to delete this Class Room Video?")){
		$('videoListForm').action = url;
		$('videoListForm').submit();
	}
	
}

/**
* function to cancel the action
*
**/
function cancel_action(url){
	window.location=url;
}