 
 <?php
 //update_post_meta(81169,'_shipment_number_id',140303237339)
 //wp_clear_scheduled_hook('cron_update_tracking');
 //update_tracking_hourly()
 ?>
 
<table class="wp-list-table   fixed striped  " style="width:100%">
    
    <?php    foreach ($data_track->evenements as $eve): ?>
 
    <?php
    $style = '';
    if($eve->eventid == 20    ) $style = 'color:#fff;background:#a51010;';
    if($eve->eventid == 25    ) $style = 'color:#fff;background:#3ec522;';
      //if($eve->eventid == 18    ) $style = 'color:#fff;background:#4f93ca;';
      
 
      
    ?>
    
    <tr class="track_content track_content_<?php echo $eve->eventid ?>" style="<?php echo $style ?>">
    <td class="track_left">
        <span class="track_day"><strong><?php echo date("d-m-Y", ((int)preg_replace('/[^0-9.]+/', '', $eve->date)/1000)); ?></strong></span><br>
        <span class="track_time"></span> 
     </td>
   
    <td class="track_right">
        <span class="track_message"><strong><?php echo $eve->evenement ?></strong>
            <br><?php echo $eve->eventid ?>
        </span><br>
        <span class="track_location"><?php echo $eve->motif_anomalie?$eve->motif_anomalie:'' ?> </span>
    </td>
    </tr>
            <?php endforeach; ?>
</table>  