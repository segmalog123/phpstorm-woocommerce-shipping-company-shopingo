 
<div class="grow table_payment_conf">
    <div class="gcol-12 show_error "></div>
    
     <div class="gcol-12 gcenter"  style="    width: 50%;float: left;margin-bottom: 10px;">
         <label>Choisir date de paiement:
             <input   class="date_payment_recieved" type="text"  value="<?php echo date('Y-m-d') ?>"  placeholder="Select Date.." ></label>
     </div>
    <div class="gcol-12 gcenter" style="    width: 50%;float: right;margin-bottom: 10px;">
         <label>Numéro transaction:
             <input   class="id_transcation" type="text"    placeholder="Numéro transaction" ></label>
     </div>
   
    <div class="gcol-12 cadre-table-scroll " style="margin-top: 10px">
    <table class="wp-list-table widefat  striped table-scroll">
        <tr>
            <td>#</td>
            <td>Numéro de livraison</td>
            <td>Etat</td>
            <td>Prix</td>
        </tr>
        
        
            <?php foreach($array_orders as $order_id){ 
        $order= wc_get_order((int)$order_id);
        ?>
        <tr>
            <td><?php echo $order_id ?></td>
            <td><?php echo get_post_meta($order->get_id(),'_shipment_number_id',true) ?></td>
            <td><mark class="order-status status-<?php echo $order->get_status() ?> tips"><span><?php echo wc_get_order_status_name($order->get_status())  ?></span></mark></td>
            <td><?php echo str_replace('.000','',$order->get_total()) ?> DT</td>
        </tr>


<?php } ?>
    </table>
    </div>
</div>

 <div class="grow gcenter">
    <p>
         <button   data-id="<?php echo $order_id ?>" type="button"  class="button   button-primary <?php echo $show_popup == 'show_popup_factured'?'btn_save_order_factured':'btn_save_order_payment' ?> gcol-4">
            Sauvgarder</button>
        <button type="button"  class="button ZebraDialog_Button_closee gfright">Fermer</button>
      </p>
</div>
<script>
    jQuery(".date_payment_recieved").dateRangePicker({
    autoClose: true,
            singleDate : true,
	showShortcuts: false,
	singleMonth: true,
  
    })
    </script>