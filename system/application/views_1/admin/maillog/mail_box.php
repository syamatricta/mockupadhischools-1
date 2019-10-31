<!--<link type="text/css" rel="stylesheet" href="http://192.168.0.113/madgigs/trunk/css/common.css"  />-->
<!--       <link type="text/css" rel="stylesheet" href="http://192.168.0.113/madgigs/trunk/css/modalbox.css"  rel='stylesheet' media='screen' />-->
       <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>style/jquery.autocomplete.css"  />
                 <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>style/msg/jquery-ui-theme.custom.css"  />
<!--                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="keywords" content=""  />
		<title>Messages</title>-->

		<script  language="javascript">
			//var base_url		= 	"http://192.168.0.113/madgigs/trunk/";
			var img_url			= 	"<?php echo base_url();?>images";
		</script>
        <link rel="stylesheet" href="http://192.168.0.113/madgigs/trunk/css/pagination.css" />
        <script type='text/javascript' src='<?php echo base_url();?>js/jquery.js'></script>
        <script type='text/javascript' src='<?php echo base_url();?>js/jquery_min.php'></script>
        <script type='text/javascript' src='<?php echo base_url();?>js/jquery_ui_min.php'></script>
<!--       <script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/calendar/jquery-ui-datepicker-custom.min.js'></script>-->
<!--        <script type="text/javascript" src="http://192.168.0.113/madgigs/trunk/js/pagination.js" ></script>-->
<!--       <script type="text/javascript" src="http://192.168.0.113/madgigs/trunk/js/common.js" ></script>-->
       <script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/validate_recruiter.js'></script>
       <script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/custom_element.js'></script>
<!--        <script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/jquery.autocomplete.js'></script>
        <script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/jquery.simplemodal.js'></script>
        <script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/common.js'></script>-->

		
<!--                <script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/livevalidation_standalone.js'></script>-->


<!--	<body marginheight="0" topmargin="0" marginwidth="0">-->
		<center>
				<div class="m_b_c">
					

					<div class="error_message" id="error_message">
					<div class="err_rclose" onclick="err_close()"></div>
					<div id="show_error"><p></p></div>
					</div><script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/jquery.tablesorter.js'></script><script type='text/javascript' src='http://192.168.0.113/madgigs/trunk/js/admin.js'></script><script type="text/javascript" src="http://192.168.0.113/madgigs/trunk/js/jquery.ui.core.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.tabs.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>style/jquery.ui.tabs.css"  />

<script>
    $(function() {
        $( "#tabs" ).tabs();

    });

    $(document).ready(function()
    {
        $("#mytable").tablesorter( {sortList: [[0,0], [1,0]]} );
        $("#mytable1").tablesorter( {sortList: [[0,0], [1,0]]} );
    }
);
    function displayMail(mail_id,mailType){

        var url         = base_url+"admin/get_INMail_byMailId/";
        var params      ="mail_id="+mail_id+"&mail_type="+mailType;
        $.ajax({
            url: url,
            type: "POST",
            data: params,
            success:mail_display

        });
    }
    function mail_display(response){

        result = eval("(" + response + ")");
        _text ='<table cellspacing="1"><tr>';
        _text +='<td width="300px">From:</td><td>'+result.sender[0]['user_name']+'  "< '+result.sender[0]['user_email']+'>"</td>';
        _text +='</tr><tr>';
        _text +='<td>To:</td><td>'+result.to[0]['user_name']+' "<  '+result.to[0]['user_email']+'>"</td>';
        _text +='</tr><tr>';
        _text +='<td>Date:</td><td>'+result.mail['sent_date']+'</td>';
        _text +='</tr><tr>';
        _text +='<td>Subject:</td><td>'+result.mail['msg_title']+'</td>';
        _text +='</tr><tr>';
        _text +='<td>Mailed By:</td><td>MADGIGS</td>';
        _text +='</tr><tr>';
        _text +='<td></td><td><span>'+result.mail['msg_content']+'</span></td>';
        _text +='</tr></table>';

        $('.tablesorter').hide();
        $('._table').hide();


        /*set mail as read**/
        if(result.mailtype == 'inbox'){
            $('#maildisplay_inbox').html(_text);
            $('#maildisplay_inbox').show();
            var url         = base_url+"admin/update_internalmail/";
            var params      ="mail_id="+result.mail['mail_id'];
            $.ajax({
                url: url,
                type: "POST",
                data: params,
                success:''

            });

        }else{
            $('#maildisplay').html(_text);
            $('#maildisplay').show();
        }
    }
    function display1(item){
        if(item== 'compose'){
            $('.tablesorter').hide();
            $('._table').hide();
            $('#maildisplay').hide();
            $('#maildisplay_inbox').hide();


      //      $('#sent').css("background-color","#F7F7F7 ");
       //     $('#inbox').css("background-color","#F7F7F7 ");

        }
        else{
            $('.tablesorter').show();
            $('._table').show();
            $('#maildisplay').hide();
            $('#maildisplay_inbox').hide();
            if(item =='sent'){

          //      $('#inbox').css("background-color","#F7F7F7")

            }
            if(item=='inbox'){

         //       $('#sent').css("background-color","#F7F7F7")
            }
          //  $('#compose').css("background-color","#F7F7F7 ");
        }
    }


    function addrecipient(){

        toUsers_id = $('#users').val();
        if(toUsers_id==null) alert('Select Email Address');
        else{

            for(i=0;i<toUsers_id.length;i++){


                var url         = base_url+"admin/get_user_details/";
                var params      ="user_id="+toUsers_id[i];
                $.ajax({
                    url: url,
                    type: "POST",
                    data: params,
                    success:fill_Toaddress

                });


            }

        }

    }
    function fill_Toaddress(response){

        result = eval("(" + response + ")");
        _toid = $('#to_ids').html();

        for(i=0;i<result.length;i++){

            _toValue = $('#to').val();


            _toValue +='"' + result[i]['user_name'] + '" <' + ' ' + result[i]['user_email'] + ' >,';

            if(_toid!=null) _toid +='<option value="'+ result[i]['user_id'] +'" selected="selected">' + result[i]['user_id'] + '</option>';
            else  _toid ='<option value="'+ result[i]['user_id'] +'" selected="selected">' + result[i]['user_id'] + '</option>';

            $('#to').val(_toValue);
            $('#to_ids').html(_toid);
        }

    }
    function validate_internal_email(){
        toUsers_id = $('#users').val();
        subject = $('#subject').val();
        content = $('#content').val();
        to = $('#to').val();

        if(toUsers_id== null) alert('Select to address');
        else if(to== "")alert('Please Add recipient');
        else if(subject== "")alert('subject fiels is empty');
        else if(content== "")alert('content is empty');
        else $('#mail_compose').submit();


    }

    function getaddressByUser(userType){
        var url='';

        if(userType==3)   url         = base_url+"admin/getEmailRecruiters/";
        else if(userType==4)   url         = base_url+"admin/getAllMailCandidates/";
        else if(userType==1)  url         = base_url+"admin/getAllAdminUsers/";
        else url         = base_url+"admin/getAllMailUsers/";
        //alert(url)
        var params      ="user_id="+1;
        $.ajax({
            type: 'POST',
            url: url,
            data: params,
            success:display_address

        });

    }
    function display_address(response){
    	//alert(response);
        result = eval("(" + response + ")");
        _toValue="";

        for(var x=0; x<result.length; x++){


            _toValue+= '<option value='+result[x]['user_id']+'>'+'"' + result[x]['user_name'] + '" <' + ' ' + result[x]['user_email'] + ' >'+'</option>';

        }


        $('#users').html(_toValue);

    }
    function approve_Profile_Photo(user_id){


        var x =confirm('Do you want to approve the profile image?');
        if(x) {

            var url         = base_url+"admin/update_candidate_details/";
            var params      ="user_id="+user_id+"&photo_active="+1;
            $.ajax({
                url: url,
                type: "POST",
                data: params,
                success:photo_approval

            });
        }
    }
    function photo_approval(response){

        result = eval("(" + response + ")");
        if(result=='false') alert('Already Approved');
        else alert('approved');

    }

</script>

<style>
    .header{
        float:none;
        height:0;
    }
    .comn_txt_box {
        width:485px !important;
    }

    /* tables */
    table.tablesorter {
        font-family:arial;

        margin:1px 0pt 0px;
        font-size: 8pt;
        width: 100%;
        text-align: left;
/*        border:2px solid;*/
    }
    table.tablesorter thead tr th, table.tablesorter tfoot tr th {
        background-color: #EEEEEE;
        border: 1px solid #FFF;
        font-size: 8pt;
        padding: 4px;
    }
    table.tablesorter thead tr .header {
        background-image: url(./../images/bg.gif);
        background-repeat: no-repeat;
        background-position: center right;
        cursor: pointer;
        align:left;
    }
    table.tablesorter tbody td {
        color: #3D3D3D;
        padding: 4px;
        vertical-align: top;
    }
    table.tablesorter tbody tr.odd td {
        background-color:#F0F0F6;
    }
    table.tablesorter thead tr .headerSortUp {
        background-image: url(./../images/asc.gif);
    }
    table.tablesorter thead tr .headerSortDown {
        background-image: url(./../images/desc.gif);
    }
    table.tablesorter thead tr .headerSortDown, table.tablesorter thead tr .headerSortUp {
        background-color: #EEE;
        height:30px;
        text-align:left;
    }
    table.tablesorter {	border-collapse:separate;	border-spacing:1px;}
    .to_text{
        height:25px;
        width:490px;
    }
    .login_button{
    background:#1F5CAE none repeat scroll 0 0;
    color:white;
    font-size:10px;
    font-weight:normal;
    height:30px;
    margin-top:10px;
    width:100px;
}
.mandatory{
    color:#D8000C;
    padding-right:10px;
}
</style>
<script type="text/javascript">
function load_inbox_sbjt()
{
	var srtOrder = $('#sort_order_sbjt').val();
	if(srtOrder == 'ASC')
	{
		$("#sort_order_sbjt").val('DESC');
		$("#sort_sjct_img").html('<img src="http://192.168.0.113/madgigs/trunk/images/desc.gif" border="0" alt="Sort message" title="Sort message" />');
	}
	else
	{
		$("#sort_order_sbjt").val('ASC');
		$("#sort_sjct_img").html('<img src="http://192.168.0.113/madgigs/trunk/images/asc.gif" border="0" alt="Sort message" title="Sort message" />');
	}
	$.ajax({
	   type: "POST",
	   url: "http://192.168.0.113/madgigs/trunk/recruiter/get_msg_sbjt",
	   data: "ord="+srtOrder,
	   success: function(msg){
	   	$("#wrapper1").html(msg);
	   }
	});
}

function load_inbox_date()
{
	var srtOrder = $("#sort_order_date").val();
	if(srtOrder == 'ASC')
	{
		$("#sort_order_date").val('DESC');
		$("#sort_date_img").html('<img src="http://192.168.0.113/madgigs/trunk/images/desc.gif" border="0" alt="Sort message" title="Sort message" />');
	}
	else
	{
		$("#sort_order_date").val('ASC');
		$("#sort_date_img").html('<img src="http://192.168.0.113/madgigs/trunk/images/asc.gif" border="0" alt="Sort message" title="Sort message" />');
	}
	$.ajax({
	   type: "POST",
	   url: "http://192.168.0.113/madgigs/trunk/recruiter/get_msg_date",
	   data: "ord="+srtOrder,
	   success: function(msg){
		   $("#wrapper1").html(msg);
	   }
	});
}

function load_sent_sbjt()
{
	var srtOrder = $('#sort_order_sbjt').val();
	if(srtOrder == 'ASC')
	{
		$("#sort_order_sbjt").val('DESC');
		$("#sort_sjct_snt_img").html('<img src="http://192.168.0.113/madgigs/trunk/images/desc.gif" border="0" alt="Sort message" title="Sort message" />');
	}
	else
	{
		$("#sort_order_sbjt").val('ASC');
		$("#sort_sjct_snt_img").html('<img src="http://192.168.0.113/madgigs/trunk/images/asc.gif" border="0" alt="Sort message" title="Sort message" />');
	}
	$.ajax({
	   type: "POST",
	   url: "http://192.168.0.113/madgigs/trunk/recruiter/get_sent_msg_sbjt",
	   data: "ord="+srtOrder,
	   success: function(msg){
	   	$("#wrapper2").html(msg);
	   }
	});
}

function load_sent_date()
{
	var srtOrder = $("#sort_order_date").val();
	if(srtOrder == 'ASC')
	{
		$("#sort_order_date").val('DESC');
		$("#sort_date_snt_img").html('<img src="http://192.168.0.113/madgigs/trunk/images/desc.gif" border="0" alt="Sort message" title="Sort message" />');
	}
	else
	{
		$("#sort_order_date").val('ASC');
		$("#sort_date_snt_img").html('<img src="http://192.168.0.113/madgigs/trunk/images/asc.gif" border="0" alt="Sort message" title="Sort message" />');
	}
	$.ajax({
	   type: "POST",
	   url: "http://192.168.0.113/madgigs/trunk/recruiter/get_sent_msg_date",
	   data: "ord="+srtOrder,
	   success: function(msg){
		   $("#wrapper2").html(msg);
	   }
	});
}

$(document).ready(function(){
	$('#paging_container8').pajinate({
		num_page_links_to_display : 3,
		items_per_page : 10
	});
});

$(document).ready(function(){
	$('#paging_container9').pajinate({
		num_page_links_to_display : 3,
		items_per_page : 10
	});
});
</script>
<div class="fl">
	<div class="body_bg_l"></div>
	<div class="body_bg_c">

		<div class="fl recruiter-sign">
			<div class="fl title_main">Messages</div>
		</div>
	</div>
	<div class="body_bg_r"></div>
</div>
<div id="php_msg"><p><div class="success_message" style="display:none" id="success_message"><div class="suc_gclose" onclick="suc_close()"></div><div><p></p></div></div></p></div>
<div class="fl cmn_bg_rpt">
<div class="fl msg_cntnr">
    <div id="page-wrap">

        <div  class="fl"style="width: 954px;margin-bottom:20px;">
          <div class="tabbed-area cur-nav-fix">
                <div class="box-wrap">
                 <div id="tabs">
                 		<input type="hidden" id="sort_order_sbjt" name="sort_order_sbjt" value="ASC" />
                        <input type="hidden" id="sort_order_date" name="sort_order_date" value="ASC" />
                        <ul class="tabs group">
                            <li class="sel"><a class="asel" href="#tabs-1" onclick="display1('inbox');" id="inbox">Inbox</a></li>

                            <li class="sel"><a class="asel" href="#tabs-2" onclick="display1('sent');"  id="sent">Sent Items</a></li>
                            <li class="sel"><a class="asel" href="#tabs-3" onclick="display1('compose');"  id="compose">Compose</a></li>
                            <li style="float:right;line-height:42px;font-size:11px;margin-right:25px;font-weight: normal;">Fields marked with <span class="mandatory">*</span>are mandatory</li>
                        </ul>
                        <!-- inbox -->
                        <div id="tabs-1">
                        <span id="maildisplay_inbox">&nbsp;</span>

                        <div class="mail_subjct"><a onclick="javascript:load_inbox_sbjt();" id="inbox_sbjt" href="javascript:void(0);">Subject&nbsp;<span id="sort_sjct_img"><img src="http://192.168.0.113/madgigs/trunk/images/bg.gif" border="0" alt="Sort message" title="Sort message" /></span></a></div>
                        <div class="mail_date"><a onclick="javascript:load_inbox_date();"  id="inbox_date" href="javascript:void(0);">Date&nbsp;<span id="sort_date_img"><img src="http://192.168.0.113/madgigs/trunk/images/bg.gif" border="0" alt="Sort message" title="Sort message" /></span></a></div>
                        <div id="wrapper1">
             			<div id="paging_container8" class="container">
						<ul class="content_ul" id="caseListing">

							<li class="msg_tr"  style="background-color:#FFF;" >
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('84','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-07-26&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15:07:15							</span>
							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('85','inbox')">Job invitation from Madgigs</a>
							</span>

							<span style="padding-left: 10px;">
							2011-07-26&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15:08:38							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('86','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-07-26&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15:09:02							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('92','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-07-26&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15:21:06							</span>
							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('155','inbox')">Shortlisted for interview for Cobol developer</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-04&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:42:20							</span>
							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('416','inbox')">test</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-05&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;05:59:53							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('480','inbox')">test222222222222222</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-08&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;05:14:45							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('481','inbox')">test222222222222222</a>
							</span>

							<span style="padding-left: 10px;">
							2011-08-08&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;05:14:45							</span>
							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('484','inbox')">Shortlisted for interview for PHP and perl</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-09&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:58:02							</span>

							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('492','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-09&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14:24:22							</span>
							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('493','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-09&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14:27:27							</span>
							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('494','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-09&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14:54:23							</span>
							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('495','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;09:35:11							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1000','inbox')">Shortlisted for interview for Madgigs</a>
							</span>

							<span style="padding-left: 10px;">
							2011-08-23&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;05:59:19							</span>
							</div></li>

							<li class="msg_tr"  style="background-color:#FFF;" >
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1001','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-23&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:24:00							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1005','inbox')">Feedback from client</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-24&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;03:29:49							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1028','inbox')">Shortlisted for interview for test fir giri</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-26&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;06:00:19							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1030','inbox')">Shortlisted for interview for DB Analyzer</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-29&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;04:48:32							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('1032','inbox')">Shortlisted for interview for Mag Devolper</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;03:04:24							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1041','inbox')">Agreement Initiation from Madgigs</a>
							</span>

							<span style="padding-left: 10px;">
							2011-08-31&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:56:14							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1054','inbox')">Shortlisted for interview for Consult</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:31:24							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1055','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:33:10							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1056','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:49:21							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1057','inbox')">Job is deleted</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:51:24							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('1059','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:57:39							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1061','inbox')">Shortlisted for interview for sree job</a>
							</span>

							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:01:57							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1063','inbox')">Shortlisted for interview for cycle1</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:21:58							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1064','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:56:19							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1074','inbox')">Shortlisted for interview for animator</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;08:00:44							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1084','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;17:02:29							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('1097','inbox')">Shortlisted for interview for Datawarehousing</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;06:00:09							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1098','inbox')">Agreement Initiation from Madgigs</a>
							</span>

							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;18:07:11							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1099','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;18:18:59							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1100','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;18:40:18							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1102','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;18:47:50							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1107','inbox')">Shortlisted for interview for Marketing Excecutive</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;07:21:17							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('1108','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:22:27							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1116','inbox')">Shortlisted for interview for Baloon Seller</a>
							</span>

							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11:05:06							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1118','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:07:43							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1124','inbox')">Contract Status</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:38:14							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1130','inbox')">Job is deleted</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15:37:24							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1136','inbox')">Shortlisted for interview for Bag seller</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;04:01:44							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('1142','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:08:28							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1144','inbox')">Contract Status</a>
							</span>

							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:32:33							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1145','inbox')">Shortlisted for interview for Silver light - .Net</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;07:46:02							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1146','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:47:11							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1174','inbox')">Contract Status</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:46:12							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1175','inbox')">Shortlisted for interview for System Admin</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11:05:45							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('1176','inbox')">Reject candidate notification from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11:07:35							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1177','inbox')">Shortlisted for interview for System Admin Assiste</a>
							</span>

							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11:25:53							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1178','inbox')">Agreement Initiation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11:45:06							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1182','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14:41:01							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">

							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1183','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14:42:47							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">

							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1184','inbox')">Job invitation from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14:44:38							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">

							<a href="javascript:void(0);" onclick="displayMail('1186','inbox')">Shortlisted for interview for Job tile</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-05&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:14:33							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1187','inbox')">Agreement Initiation from Madgigs</a>
							</span>

							<span style="padding-left: 10px;">
							2011-09-05&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:39:44							</span>
							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1190','inbox')">Shortlisted for interview for Bogurard2</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-05&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11:41:41							</span>

							</div></li>

							<li class="msg_tr" style="background-color:#FEFEFE; font-weight: bold;">
							<div style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1191','inbox')">Reject candidate notification from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-05&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:28:25							</span>
							</div></li>
												</ul>
												<div class="page_navigation" style="text-align: right; float: right;"></div>

												</div>
						</div>
						</div>


                        <!-- sent items -->
                        <div id="tabs-2">
                        <span id="maildisplay">&nbsp;</span>
                        <div class="mail_subjct"><a onclick="javascript:load_sent_sbjt();" id="sent_sbjt" href="javascript:void(0);">Subject&nbsp;<span id="sort_sjct_snt_img"><img src="http://192.168.0.113/madgigs/trunk/images/bg.gif" border="0" alt="Sort message" title="Sort message" /></span></a></div>
                        <div class="mail_date"><a onclick="javascript:load_sent_date();"  id="sent_date" href="javascript:void(0);">Date&nbsp;<span id="sort_date_snt_img"><img src="http://192.168.0.113/madgigs/trunk/images/bg.gif" border="0" alt="Sort message" title="Sort message" /></span></a></div>

                        <div id="wrapper2">
             			<div id="paging_container9" class="container">
						<ul class="content_ul">
													<li class="msg_tr"  style="background-color: #FFF; line-height: 40px" >
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('133','sentitems')">Candidate Profile-photo Approval</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;18:00:20							</span>

							</p>
							</li>
													<li class="msg_tr"  style="background-color: #FFF; line-height: 40px" >
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('447','sentitems')">test msg</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-08&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;02:25:30							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('448','sentitems')">test2</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-08&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;02:32:11							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('480','sentitems')">test222222222222222</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-08&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;05:14:45							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('481','sentitems')">test222222222222222</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-08&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;05:14:45							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('967','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:25:00							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('968','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:25:00							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('969','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:25:05							</span>

							</p>
							</li>
													<li class="msg_tr"  style="background-color: #FFF; line-height: 40px" >
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('970','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:25:05							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('971','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:25:29							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('972','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:25:29							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('973','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:43:56							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('974','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:43:56							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('975','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:45:02							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('976','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-18&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:45:02							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1002','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-23&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:24:23							</span>

							</p>
							</li>
													<li class="msg_tr"  style="background-color: #FFF; line-height: 40px" >
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1029','sentitems')">test design</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-29&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:29:46							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1042','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-08-31&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:59:18							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1060','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11:20:32							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1065','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:57:15							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1089','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;17:30:06							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1103','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;18:48:22							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1109','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-01&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:22:44							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1119','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;12:08:49							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1128','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15:30:57							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1129','sentitems')">Job is flagged</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15:30:57							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1143','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:08:36							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1147','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-02&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;19:50:34							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1179','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-03&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11:49:44							</span>

							</p>
							</li>
													<li class="msg_tr" style="background-color:#FEFEFE;line-height: 40px">
							<p  style="border-bottom: 1px solid #EBEBEB;">
							<span class="spn_subjct">
							<a href="javascript:void(0);" onclick="displayMail('1188','sentitems')">Agreement Executed from Madgigs</a>
							</span>
							<span style="padding-left: 10px;">
							2011-09-05&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:39:55							</span>

							</p>
							</li>
												</ul>

						<div class="page_navigation" style="text-align: right; float: right;"></div>
												</div>
                        </div>
						</div>

                        <!-- Compose mail -->
                                    <div id="tabs-3" style="border-bottom:0px;">
                                        <form name="mail_compose" id="mail_compose" action="http://192.168.0.113/madgigs/trunk/candidate/messages" method="POST">
<!--                                            <span class="right_msg_div fr">Fields marked with <span class="mandatory">*</span>are mandatory</span>-->
                                            <div class="compose_mail_cntnr">

                                        <table width="845" >
                                                <tbody>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>

                                                    </tr>
                                                    <tr>
                                                        <td>From</td>
                                                        <td align="left">"ashi.ssm@gmail.com" < ashi.ssm@gmail.com > </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>

                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                          </table>
                                    <div class="msg_hr"></div>
                                    <div style="float:right;margin-left: 10px;margin-right:10px;">
                                             <table width="845" >
                                                <tbody>
                                                    <tr>

                                                        <td>&nbsp;</td>
                                                        <td>
                                                            <span class="fl">
                                                                <select id="usertype" name="usertype" class="styled" onchange="getaddressByUser(this.value);" style="width:300px;position: absolute;
padding:8px 32px 3px 8px;
width:256px;
height: 36px;
color: #000000;
text-align:left;
color:#484848;
font-size:13px;
background: url(../images/drop-down-bg.png) no-repeat;
overflow: hidden;
font-size:12px;">
                                                                    <option value="">Select User Type</option>
                                                                    <option value="3">Recruiters</option>
                                                                    <option value="4">Candidates</option>

                                                                    <option value="1">Others</option>
                                                                </select>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>

                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>

                                                    <tr>
                                                        <td valign="top">To<span class="mandatory">*</span></td>
                                                        <td> <span class="fl">
                                                                <span class="compose_msg_mul_sel_l"></span>
                                                                <span class="compose_msg_mul_sel_c" style="width:760px;">
                                                                   <select id="users" name="users[]"  size="3" multiple="multiple">

                                                                                                                                                    <option value="140">"anajajaa@akdkdkd.dd" < anajajaa@akdkdkd.dd ></option>

                                                                                                                                                    <option value="164">"aneeta@kelvin.com" < aneeta@kelvin.com ></option>
                                                                                                                                                    <option value="157">"anitha@rainconcert.in" < anitha@rainconcert.in ></option>
                                                                                                                                                    <option value="220">"anuradha@anu.com" < anuradha@anu.com ></option>
                                                                                                                                                    <option value="93">"asdasd@3asdasddd.ff" < asdasd@3asdasddd.ff ></option>
                                                                                                                                                    <option value="201">"ashi.ssm1@gmail.com" < ashi.ssm1@gmail.com ></option>

                                                                                                                                                    <option value="216">"ashi.ssm2@gmail.com" < ashi.ssm2@gmail.com ></option>
                                                                                                                                                    <option value="148">"ashi.ssm@gmail.com" < ashi.ssm@gmail.com ></option>
                                                                                                                                                    <option value="170">"ashi1@ashi1.com" < ashi1@ashi1.com ></option>
                                                                                                                                                    <option value="160">"ashitha1@rainconcert.in" < ashitha1@rainconcert.in ></option>
                                                                                                                                                    <option value="217">"ashitha@ashitha.com" < ashitha@ashitha.com ></option>

                                                                                                                                                    <option value="92">"ghfgh@df.ff" < ghfgh@df.ff ></option>
                                                                                                                                                    <option value="102">"gireeshkumar10@rainconcert.in" < gireeshkumar10@rainconcert.in ></option>
                                                                                                                                                    <option value="17">"gireeshkumar@rainconcert.in" < gireeshkumar@rainconcert.in ></option>
                                                                                                                                                    <option value="100">"gks.gireesh1@gmail.com" < gks.gireesh1@gmail.com ></option>
                                                                                                                                                    <option value="116">"gks.gireesh@yahoo.com" < gks.gireesh@yahoo.com ></option>

                                                                                                                                                    <option value="229">"jerry@rainconcert.in" < jerry@rainconcert.in ></option>
                                                                                                                                                    <option value="1">"madgigs_admin" < ashitha@rainconcert.in ></option>
                                                                                                                                                    <option value="228">"neeraj@reeraj.com" < neeraj@reeraj.com ></option>
                                                                                                                                                    <option value="196">"nithin@nithinn.com" < nithin@nithinn.com ></option>
                                                                                                                                                    <option value="222">"recruiter1@madgigs.com" < recruiter1@madgigs.com ></option>

                                                                                                                                                    <option value="221">"recruiter@madgigs.com" < recruiter@madgigs.com ></option>
                                                                                                                                                    <option value="114">"rterete@sds.dsd" < rterete@sds.dsd ></option>
                                                                                                                                                    <option value="132">"sangeethajohns@gmail.com" < sangeethajohns@gmail.com ></option>
                                                                                                                                                    <option value="130">"shilpa@rainconcert.inf" < shilpa@rainconcert.inf ></option>
                                                                                                                                                    <option value="35">"shilpa@rainconcert.ins" < shilpa@rainconcert.ins ></option>

                                                                                                                                                    <option value="84">"shilpaelisa2007@gmail.com" < shilpaelisa2007@gmail.com ></option>
                                                                                                                                                    <option value="200">"sree@test.com" < sree@test.com ></option>
                                                                                                                                                    <option value="223">"sreeraj1@rainconcert.in" < sreeraj1@rainconcert.in ></option>
                                                                                                                                                    <option value="224">"sreeraj@rainconcert.in" < sreeraj@rainconcert.in ></option>
                                                                                                                                                    <option value="135">"sreerajmeloth@gmail.com" < sreerajmeloth@gmail.com ></option>

                                                                                                                                                    <option value="231">"sreerajmeloth@hotmail.com" < sreerajmeloth@hotmail.com ></option>
                                                                                                                                                    <option value="235">"sreerajmt1@rainconcert.in" < sreerajmt1@rainconcert.in ></option>
                                                                                                                                                    <option value="161">"sreerajmt@rainconcert.in" < sreerajmt@rainconcert.in ></option>
                                                                                                                                                    <option value="147">"suraya@suraya.com" < suraya@suraya.com ></option>
                                                                                                                                                    <option value="163">"surya111@test1.com" < surya111@test1.com ></option>

                                                                                                                                                    <option value="232">"test@test.com" < test@test.com ></option>
                                                                                                                                                    <option value="184">"vcb@stgsr.hjhj" < vcb@stgsr.hjhj ></option>
                                                                                                                                                    <option value="234">"vineesh@test.com" < vineesh@test.com ></option>
                                                                                                                                                    <option value="230">"willington85@gmail.com" < willington85@gmail.com ></option>
                                                                                                                                            </select>

                                                                </span>
                                                                    <span class="compose_msg_mul_sel_r"></span>
                                                    </span>
<!--                                                    <span class="fl" style="padding-left:5px;"><input type="button" value="Add Recipient" class="login_button" onclick="addrecipient();"></span>-->
                                                    <!--<td><input type="button" value="Add Recipient" class="login_button" onclick="addrecipient();"></td>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="right"><span class="" style="padding-right:15px;"><input type="button"  class="add_recipient" onclick="addrecipient();"></span></td>

                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="left"><span>Select Email address and add recipient list to the below box<span class="mandatory">*</span></span></td>

                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><span class="compose_msg_txtbox_l"></span><span class="compose_msg_txtbox_c" style="width:760px;"><input type="text" readonly name="to" id="to" class=""/></span><span class="compose_msg_txtbox_r"></span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;<select id="to_ids" name="to_ids[]" style="display:none;" size="3" multiple="multiple"></select></td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td valign="top">Subject<span class="mandatory">*</span></td>
                                            <td><span class="compose_msg_txtbox_l"></span><span class="compose_msg_txtbox_c" style="width:760px;"><input type="text" name="subject" id="subject" style="width:760px;"/></span><span class="compose_msg_txtbox_r"></span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td valign="top">Content<span class="mandatory">*</span></td>
                                            <td><span class="compose_msg_txtarea_l"></span><span class="compose_msg_txtarea_c" ><textarea rows="3" cols="68" id="content" name="content"></textarea></span><span class="compose_msg_txtarea_r"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                </div>
                                <div class="msg_hr"></div>
                                                                <div class="send_msg_div">
	                                <div class="snd_msg_bttn"><input type="button" class="send_message_bttn"  onclick="validate_internal_email();"/></div>
                                    <div class="cancel_msg_bttn"><input type="button" class="cancel_message_bttn"  onclick="cancelMsg('candidate/messages');"/></div>
                                </div>
                              </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function cancelInvitationForm(){

        window.location = base_url;


    }
</script>
				<div class="footer_brd"></div>

				</div>
				
		</center>

<script type="text/javascript">

    setTimeout("updateLogDEtails()",1000);

    function updateLogDEtails()
    {
            var url         = base_url+"common_ajax/update_log_details/";
           // var params      = "lType="+item+"&lValue="+limit_value;
            $.ajax({
                url: url,
                type: "GET"
              //data: params,
              //success:limits_container

            });
    }
</script>
<!--</body></html>-->