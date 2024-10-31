<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       owids.com
 * @since      1.0.0
 *
 * @package    Owids
 * @subpackage Owids/public/partials
 */
?>

<!-- owids snippet start -->
<script>
  (function(d,id){
    if(d.getElementById(id))return;var sc,node=d.getElementsByTagName('script')[0];sc=d.createElement('script');
    sc.id=id;sc.src='<?php echo OWIDS_SDK_URL; ?>#id=<?php echo $api_key; ?>';node.parentNode.insertBefore(sc,node);
  }(document,'owids-sdk'));
</script>
<!-- owids snippet end -->
