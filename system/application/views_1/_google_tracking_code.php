<?php
$ga_user_type   = 'Guest';
$ga_user_id     = 0;
if($this->session->userdata ('USERID')){
    $ga_user_type   = 'Member';
    $ga_user_id     = $this->session->userdata('USERID');
}
?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo c('ga_tracking_id');?>']);  
  _gaq.push(['_setCustomVar',
      1,             // This custom var is set to slot #1.  Required parameter.
      'User Type',   // The name of the custom variable.  Required parameter.
      '<?php echo $ga_user_type;?>',      // Sets the value of "User Type" to "Guest" or "Member" depending on status.  Required parameter.
       1             // Sets the scope to session-level.  Optional parameter.
   ]);
   _gaq.push(['_setCustomVar', 2, 'UserID', <?php echo $ga_user_id;?>, 1]);
   _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>