/* check every five second for active users */
    function initActiveUserCount(){
        setTimeout("timeoutActiveUserCount()", 5000);        
    }
    function timeoutActiveUserCount(){
        setInterval(function (){
            var url	= base_url+'admin/active_user_count';
            new Ajax.Request(url, {method:"post", parameters : {selected_item : selected_dashboard_item}, 
                onSuccess: function (resp){
                    var response = JSON.parse(resp.responseText);
                    if(0 == response.success){
                        //$('dashboard_item_page').innerHTML  = response.message;
                    }else{
                        $('active_total').innerHTML = response.total;
                        $('active_total_1').innerHTML = response.total;
                        $('active_guest').innerHTML = response.guest;
                        $('active_registered').innerHTML = response.registered;
                        if('visitors_analysis' == selected_dashboard_item){
                            drawActiveUserChart(eval(response.active_line_object), eval(response.total));
                            $('active_total_inpage').innerHTML = response.total;
                            $('active_guest_inpage').innerHTML = response.guest;
                            $('active_registered_inpage').innerHTML = response.registered;
                        }
                    }
            }});
        }, 5000)
    }
    
    
    function viewTab(selected_item){
        $(selected_dashboard_item+'_tab').removeClassName('boxr_head_sel');
        $(selected_dashboard_item+'_tab').addClassName('boxr_head');
        selected_dashboard_item = selected_item;
        $(selected_item+'_tab').addClassName('boxr_head_sel');
        getDashboardItem();
    }
    
        
    function getDashboardItem(){
        var url	= base_url+'admin/dashboard_item';
        addOverlayDiv($$('.dash_r_box')[0], 'dash_r_box_1');
        new Ajax.Request(url, {method:"post", parameters : {selected_item : selected_dashboard_item, 'start_date' :start_date, 'end_date' : end_date}, 
            onSuccess: function (resp){
                var response = JSON.parse(resp.responseText);
                removeOverlayDiv($('dash_r_box_1'));
                if(0 == response.success){
                    $('dashboard_item_page').innerHTML  = response.message;
                }else{
                    $('dashboard_item_page').innerHTML=response.html;
                    if('browser_platform' == selected_dashboard_item){
                        browser_pie_object  = eval(response.js_variables.browser_pie_object);
                        os_pie_object       = eval(response.js_variables.os_pie_object);
                        browserPlatform(browser_pie_object, os_pie_object);
                        Event.observe($('osbdd_select_browser'), 'change', function (){browserPlatformCombCount();});
                        Event.observe($('osbdd_select_platform'), 'change', function (){browserPlatformCombCount();});
                        browserPlatformCombCount();
                    }else if('visitors_analysis' == selected_dashboard_item){
                        unique_line_object  = eval(response.js_variables.unique_line_object);
                        active_line_object  = eval(response.js_variables.active_line_object);
                        $('unique_user_count').innerHTML        = eval(response.js_variables.unique_users);
                        $('unique_users_guest_count').innerHTML = eval(response.js_variables.unique_user_seperate.guest);                        
                        $('unique_users_reg_count').innerHTML   = eval(response.js_variables.unique_user_seperate.member);
                        visitorsAnalysis(unique_line_object, active_line_object, eval(response.js_variables.unique_users), eval(response.js_variables.active_users));
                    }else if('exam_report' == selected_dashboard_item) {
                        showReport('report_total','');
                    }else if('user_report' == selected_dashboard_item){
                        user_pie_object  = eval(response.user_pie_object);
                        userReport(user_pie_object, eval(response.js_variables.show_chart));
                    } else if('recruiter' == selected_dashboard_item){
                        if(response.js_variables.recruiter_pie_object == ''){
                            $("rec_select_browser").hide();
                            $("piechart5").hide();
                            $("rec_head").hide();
                        } else{
                            recruiter_pie_object  = eval(response.js_variables.recruiter_pie_object);
                            recruiterPlatform(recruiter_pie_object);
                        }
                    }
                }
        }});
    }
    
    function recruiterPlatform(recruiter_pie_object){
        Array.prototype.reduce = undefined;
        
        google.load('visualization', '1', {packages:['corechart'], 'callback' : function(){
            drawChart(recruiter_pie_object);
        }});
        function drawChart(recruiter_pie_object) {
         var data = google.visualization.arrayToDataTable(
                            recruiter_pie_object
                        );
//            var data = google.visualization.arrayToDataTable(
//                            JSON.parse(recruiter_pie_object)
//                        );                
                     
            var options = {
              width: 650,
              height:350,
              //title: 'Browser type used by Visitors',
              legend: 'none',
              //pieSliceText: 'label',
              pieSliceTextStyle: {fontSize:12},
              colors: ['#049CC2', '#14B9D5', '#1586D7', '#9D8FF6', '#35D4E5'],
              pieSliceBorderColor: 'transparent',
              tooltip: {text:'percentage'},
              chartArea:{left:150, top:0,right:0,bottom:0}
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart5'));
            chart.draw(data, options);
        }
    }
    
    function recruiterPlatformCount(){
        var rec_id = $("rec_select_browser").value;
        var url	= base_url+'admin/select_recruiter_report_data';
        $('recruiter_report').innerHTML='<img src="'+base_url+'images/indicator.gif" />';
        new Ajax.Request(url, {method:"post", parameters : {'start_date' :start_date, 'end_date' : end_date, 'recruiter' : rec_id }, 
            onSuccess: function (response){
                var resp = JSON.parse(response.responseText);
                $('recruiter_report').innerHTML = resp.html;
                    recruiter_pie_object  = eval(resp.js_variables.recruiter_pie_object);
                    recruiterPlatform(recruiter_pie_object);
              
            }});
    }
    
    
    var active_user_chart;
    var active_user_chart_options;
    
    function browserPlatform(browser_pie_object, os_pie_object){
        Array.prototype.reduce = undefined;
        
        google.load('visualization', '1', {packages:['corechart'], 'callback' : function(){
            drawChart(browser_pie_object, os_pie_object);
        }});
        function drawChart(browser_pie_object, os_pie_object) {
            var data = google.visualization.arrayToDataTable(
                            browser_pie_object
                        );

            var options = {
              width: 390,
              //title: 'Browser type used by Visitors',
              legend: 'none',
              pieSliceText: 'label',
              pieSliceTextStyle: {fontSize:12},
              colors: ['#049CC2', '#14B9D5', '#1586D7', '#9D8FF6', '#35D4E5'],
              pieSliceBorderColor: 'transparent',
              tooltip: {text:'percentage'},
              chartArea:{left:55, top:15}
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
            chart.draw(data, options);

            var data = google.visualization.arrayToDataTable(
                            os_pie_object
                        );

            var options = {
                width: 390,
                //title: 'Platforms type used by Visitors',
                legend: 'none',
                pieSliceText: 'label',
                pieSliceTextStyle: {fontSize:12},
                colors: ['#049CC2', '#14B9D5', '#1586D7', '#9D8FF6', '#35D4E5'],
                pieSliceBorderColor: 'transparent',
                tooltip: {text:'percentage'},                
                chartArea:{left:60,top:15}
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
            chart.draw(data, options);
        }
    }
    
    function browserPlatformCombCount(){
        var url	= base_url+'admin/browser_platform_comb_count';
        $('browser_platform_count').innerHTML='<img src="'+base_url+'images/indicator.gif" />';
        new Ajax.Request(url, {method:"post", parameters : {'start_date' :start_date, 'end_date' : end_date, 'browser' : $('osbdd_select_browser').value, 'platform' : $('osbdd_select_platform').value }, 
            onSuccess: function (resp){
                $('browser_platform_count').innerHTML = resp.responseText;
            }});
    }  
    function noDataFound(count, div, width_arr){
        if(count > 0){
            $(div).innerHTML    =   '';
            $(div).setStyle({height : width_arr[0]+'px'});
        }else{
            $(div).innerHTML    =   '<div class="no_record_found">No Records found</div>';
            $(div).setStyle({height : width_arr[1]+'px'});
        }
    }    
    
    var guest_color         = '#18D6BD';
    var registered_color    = '#5EA8C8';
    var gridline_color      = '#EDEDED';
    function visitorsAnalysis(unique_line_object, active_line_object, unique_users_count, active_users_count){
        Array.prototype.reduce = undefined;
        
        google.load('visualization', '1', {packages:['corechart'], 'callback' : function(){
            drawChart(unique_line_object, active_line_object, unique_users_count, active_users_count);
        }});        
        function drawChart(unique_line_object, active_line_object, unique_users_count, active_users_count) {
            noDataFound(unique_users_count, 'linechart1', [350, 150]);
            if(unique_users_count > 0){
                var data = google.visualization.arrayToDataTable(
                                unique_line_object
                            );
                var options = {
                   width: 850,
                   height: 400,
                   lineWidth: 0.8,
                   legend: 'none',
                   chartArea:{left:40,top:30},
                   hAxis: {gridlines : {color:gridline_color, lineWidth:0.8}, minorGridlines:{count:1, color:gridline_color, lineWidth:0.8}, baselineColor : gridline_color, textStyle:{color:'#878787', fontSize:12}},
                   vAxis: {gridlines: {count:-1, color: gridline_color, lineWidth:0.8}, minorGridlines:{count:1, color:gridline_color, lineWidth:0.8}, baselineColor : gridline_color, textStyle:{color:'#878787', fontSize:12}},
                   colors:[guest_color, registered_color],
                   pointSize : 7
                };

                var chart = new google.visualization.LineChart(document.getElementById('linechart1'));
                chart.draw(data, options);
            }
            
            var data = google.visualization.arrayToDataTable(
                            active_line_object
                        );
            active_user_chart_options = {
               width: 850,
               height: 400,
               lineWidth: 0.8,
               legend: 'none',
               series: [{lineWidth: 0.8}],
               chartArea:{left:40,top:30},
               hAxis: {gridlines : {color:gridline_color, lineWidth:0.8}, minorGridlines:{count:1, color:gridline_color, lineWidth:0.8}, baselineColor : gridline_color, textStyle:{color:'#878787', fontSize:12}},
               vAxis: {gridlines: {count:-1, color: gridline_color, lineWidth:0.8}, minorGridlines:{count:1, color:gridline_color, lineWidth:0.8, format: 'HH:mm:ss'}, baselineColor : gridline_color, textStyle:{color:'#878787', fontSize:12}},
               colors:[guest_color, registered_color],
               pointSize : 7,
               animation:{
                 duration: 1000,
                 easing: 'out'
               }
            };
            noDataFound(active_users_count, 'linechart2', [350, 150]);
            active_user_chart = new google.visualization.LineChart(document.getElementById('linechart2'));
            if(active_users_count > 0){                
                active_user_chart.draw(data, active_user_chart_options);
            }
        }
    }
    
    function drawActiveUserChart(active_line_object, active_users_count){
        noDataFound(active_users_count, 'linechart2', [350, 150]);        
        if(active_users_count > 0){
            var data = google.visualization.arrayToDataTable(
                                active_line_object
                            );
                    active_user_chart = new google.visualization.LineChart(document.getElementById('linechart2'));
                    //console.log(active_user_chart_options);
            active_user_chart.draw(data, active_user_chart_options);
        }
    }

    function showCourse(course_selected, course_id) {
        addOverlayDiv($$('.report_content')[0], 'report_content1');
        
        var elms = document.getElementsByClassName('current')
        for (var i = 0; i < elms.length; i++) {
          if (elms[i].getAttribute("class") === "current"){
           elms[i].setAttribute("class", "");
          }
        }
        document.getElementById(course_selected).setAttribute('class','current');
        
        var url	= base_url+'admin/course_detail';
        new Ajax.Request(url, {method:"post", parameters : {'course_selected':course_selected, 'course_id' : course_id, 'start_date' :start_date, 'end_date' : end_date}, 
            onSuccess: function (resp){
                 removeOverlayDiv($('report_content1'));
                var response = JSON.parse(resp.responseText);
                document.getElementById('total_students').innerHTML= "Students: "+ response.total_result;
                document.getElementById('detail_students').innerHTML=response.html;
                
        }});
    }
    
    function showReport(report_type, report_type_code) {
        addOverlayDiv($$('.report_content')[0], 'report_content1');
        var elms = document.getElementsByClassName('current')
        for (var i = 0; i < elms.length; i++) {
          if (elms[i].getAttribute("class") === "current"){
           elms[i].setAttribute("class", "");
          }
        }
        document.getElementById(report_type).setAttribute('class','current');
        
        var url	= base_url+'admin/exam_report_detail';
        new Ajax.Request(url, {method:"post", parameters : {'code':report_type_code, 'report_type' : report_type, 'start_date' :start_date, 'end_date' : end_date}, 
            onSuccess: function (resp){
                removeOverlayDiv($('report_content1'));
                var response = JSON.parse(resp.responseText);
                var title = '';
                if(response.report_type === "report_total") {
                    title   = 'Total Students attended exams';
                } else if(response.report_type === "report_passed"){
                    title   = 'No. of students passed';
                } else if(response.report_type === "report_failed"){
                    title   = 'No. of students failed';
                } else{
                    title   = 'No. of ongoing';
                }
                document.getElementById('total_students').innerHTML= title+" : "+ response.total_result;
                document.getElementById('detail_students').innerHTML=response.html;
                
                $("chart_title").hide();
                if(response.report_type === "report_total") {
                    var total_passed    = parseInt(response.total_passed);
                    var total_failed    = parseInt(response.total_failed);
                    var total_ongoing   = parseInt(response.total_ongoing);
                    if(total_passed > 0 || total_failed > 0 || total_ongoing > 0){$('chart_title').show();}
                    loadExamReportChart('total', [['Browser', 'Number'],['Passed', total_passed],['Failed', total_failed],['Ongoing', total_ongoing]]);
                } else if(response.report_type === "report_passed") {
                    var total_passed_normal     = parseInt(response.total_passed_normal);
                    var total_passed_unexpected = parseInt(response.total_passed_unexpected);
                    if(total_passed_unexpected > 0 || total_passed_normal > 0){$('chart_title').show();}
                    loadExamReportChart('passed', [['Browser', 'Number'],['Normal', total_passed_normal],['Unexpectedly', total_passed_unexpected]]);
                } else if(response.report_type === "report_failed") {
                    var total_failed_normal        = parseInt(response.total_failed_normal);
                    var total_failed_unexpected    = parseInt(response.total_failed_unexpected);
                    if(total_failed_normal > 0 || total_failed_unexpected > 0 ){$('chart_title').show();}
                    loadExamReportChart('failed', [['Browser', 'Number'],['Normal', total_failed_normal],['Unexpectedly', total_failed_unexpected]]);
                } else {
                    document.getElementById("piechart1").innerHTML="";
                    document.getElementById("chart_title").style.display = "none";
                }
                
        }});
    }
    var g_total_passed;
    var g_total_failed;
    var g_total_ongoing;
    var g_total_passed_normal;
    var g_total_passed_unexpected;
    var g_total_failed_normal;
    var g_total_failed_unexpected;
    
    var report_pie_options;
    
    function loadExamReportChart(type, pie_data){
        Array.prototype.reduce = undefined;
        
        if('total' == type){
            var pie_colors  = ['#658D06', '#FF0000', '#E8C900'];
        }else if('passed' == type){
            var pie_colors  = ['#658D06', '#314402'];
        }else if('failed' == type){
            var pie_colors  = ['#FF0000', '#7F0000'];
        }
        
        var options  =  {
                                width: 370,
                                height:370,
                                legend: { 
                                    position: 'bottom',
                                    alignment : 'center',
                                    textStyle : {fontSize : 13}
                                },
                                pieStartAngle: 180,
                                pieSliceText: 'value',
                                pieSliceTextStyle: {fontSize:15},
                                colors: pie_colors,
                                pieSliceBorderColor: 'transparent',
                                backgroundColor:'#F2F2F2',
                                chartArea:{left:15, top:10}
                              };
        google.load('visualization', '1', {packages:['corechart'], 'callback' : function(){
            drawChart(pie_data);
        }});
    
        function drawChart(pie_data){
            var data = google.visualization.arrayToDataTable(
                           pie_data 
                        );
            var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
            chart.draw(data, options);
        }
        
        
    }
    
    function userReport(user_report_pie_object, show_chart){
        if(show_chart){
            Array.prototype.reduce = undefined;

            google.load('visualization', '1', {packages:['corechart'], 'callback' : function(){
                drawChart(user_report_pie_object);
            }});
            function drawChart(user_report_pie_object) {
                var data = google.visualization.arrayToDataTable(
                                user_report_pie_object
                            );

                var options = {
                  width: 1000,
                  height:450,
                  chartArea : { top: 10, bottom:-20, left: 0, height:320},
                  legend: { 
                      position: 'bottom',
                      alignment : 'center',
                      textStyle : {fontSize : 15}
                  },
                  pieSliceText: 'label',
                  pieSliceTextStyle: {fontSize : 15},
                  colors: ['#14BCD5', '#049CC2', '#14BCD5', '#9D8FF6'],
                  pieSliceBorderColor: 'transparent',
                  tooltip: {text:'percentage'}

                };

                var chart = new google.visualization.PieChart(document.getElementById('user_report_piechart1'));
                chart.draw(data, options);
            }
        }
    }
    
    
    function addOverlayDiv(element, element_id){
        element.insert('<div class="overlay_div" id="'+element_id+'"></div>');
    }
    function removeOverlayDiv(element){
        element.remove();
    }
    function dashboardDataWithDateRange(){
        if('' == $("date_from").value || '' == $("date_to").value){$("date_errordisplay").show();$("date_errordisplay").innerHTML = "Please select a date range";return false;}
        var from_date   = new Date($("date_from").value);
        var to_date     = new Date($("date_to").value);
        if(from_date > to_date){
            $("date_errordisplay").show();$("date_errordisplay").innerHTML = "Please select a valid date range";return false;
        }
        $("date_errordisplay").show();
        $("date_errordisplay").innerHTML = "";
        
        $('selected_section').value = selected_dashboard_item;
        $('frmadhischool').action   = base_url+'admin/dashboard';
        $('frmadhischool').submit();
    }
    function averageTimeSpentAjax(url){
        $('ats_data').innerHTML='<img style="margin-top:10px;" src="'+base_url+'images/indicator.gif" />';
        new Ajax.Request(url, {method:"post", parameters : {'start_date' :start_date, 'end_date' : end_date }, 
            onSuccess: function (resp){
                $('ats_data').innerHTML = resp.responseText;
            }});
    }