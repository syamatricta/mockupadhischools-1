<div class="row">
    <div class="col-md-12"><div class="pack_title">COURSE LIST</div></div>
</div>
<input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
<input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />
<input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
<input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />
<?php
$this->load->view("reskin/course/apply_new/_sales_courses");
$this->load->view("reskin/course/apply_new/_sales_courses_optional");
$this->load->view("reskin/course/apply_new/_broker_courses");
?>
