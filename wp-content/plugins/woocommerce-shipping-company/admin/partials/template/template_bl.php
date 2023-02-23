<html>
    <head>
     
        <style>
  body{font-size: 12px;}  .table_order_content, .table_order_content tr,.table_order_content td,.table_order_content th{border: 1px solid #000;border-collapse: collapse;}
  .table_content_product, .table_content_product tr,.table_content_product td,.table_content_product th{border: 0px  ;border-collapse: collapse;}
 
</style>
    </head>
    <body>

 <?php echo get_post_meta($company_id,'wsc_header_bl',true) ?> 
 
<p></p>
<p></p>

<h1 style="font-size: 30px">Bon De Livraison N°<?php echo $num ?></h1>

<table    style="width:100%;">
    <tr style="">
        <td style="width:50%;vertical-align: bottom;text-align: center">
            <table   style="width:100%;border: 1px solid;border-collapse: collapse;">
                 <tr >
                     <td style="padding: 10px"><strong> Date</strong></td>
                          <td  style="padding: 10px"><strong>Société</strong></td>
                          <td  style="padding: 10px"><strong>Numéro Livraison</strong></td>
                    </tr>
                    <tr style="">
                        <td  style="padding: 10px;border-top: 1px solid"><?php echo date('d/m/Y') ?></td>
                          <td  style="padding: 10px;border-top: 1px solid"><?php echo $company['company_label']; ?></td>
                            <td  style="padding: 10px;border-top: 1px solid"><?php echo $ship_number?></td>
                    </tr>
            </table>
        </td>
        <td style="width:10%">
            
        </td>
        <td style="width:40%;text-align: left">
            
             <table   style="width:100%;border: 1px solid;border-collapse: collapse;">
                 <tr >
                     <td style="padding: 10px">
                         <strong> Client : </strong> <?php echo $order->get_billing_first_name() ?></td>
                     </tr>
                      <?php if($order->get_billing_address_1() != ''): ?>
                    <tr style="">
                        <td  style="padding: 10px;">
                          <strong>  Adresse : </strong><?php echo $order->get_billing_address_1() ?>
                        </td>
                   
                    </tr>
                    <?php endif; ?>
                    <?php if($order->get_billing_city() != ''): ?>
                    <tr style="">
                        <td  style="padding: 10px;">
                          <strong>  Gouvernerat : </strong><?php echo $order->get_billing_city() ?>
                        </td>
                   
                    </tr>
                      <?php endif; ?>
                    <tr style="">
                        <td  style="padding: 10px;">
                          <strong>  Téléphone : </strong><?php echo $order->get_billing_phone() ?>
                        </td>
                   
                    </tr>
                    <?php if(get_post_meta($order->get_id(),'_billing_cin',true) != ''): ?>
                     <tr style="">
                        <td  style="padding: 10px ">
                          <strong> CIN : </strong><?php echo get_post_meta($order->get_id(),'_billing_cin',true) ?>
                        </td>
                   
                    </tr>
                    <?php endif; ?>
            </table>
        </td>
    </tr>
   
</table>
<p></p>
<table    style="width:100%;border: 1px solid;border-collapse: collapse;">
    
    <tr>
        <td style="padding: 5px;border-bottom: 1px solid;border-right: 1px solid;">Référence </td>
         <td style="width:250px;padding: 5px;border-bottom: 1px solid;border-right: 1px solid;">Désignation</td>
          <td style="padding: 5px;border-bottom: 1px solid;border-right: 1px solid;text-align: center">Unité</td>
           <td style="padding: 5px;border-bottom: 1px solid;border-right: 1px solid;text-align: center">Qté</td>
            <td style="padding: 5px;border-bottom: 1px solid;border-right: 1px solid;text-align: center">PU HTVA</td>
             <td style="padding: 5px;border-bottom: 1px solid;border-right: 1px solid;text-align: center">Mt Net HT</td>
             <td style="border-bottom: 1px solid;text-align: center">TVA</td>
            
    </tr>
    
    
    <?php 
    $total_ht = $total_tva = $total_net = 0;
    
    foreach ($order->get_items() as $item) { 
                $p = wc_get_product($item->get_product_id());
                    if($p)
                    {
                        $ugs = $p->get_sku();
                    }
                   
                    $price_unitaire_ht = round($order->get_item_subtotal( $item, false, true )/1.19,3);
                    $price_net_ht = $price_unitaire_ht*$item->get_quantity();
                    
                    $total_ht += $price_net_ht;
                //    $total_tva +=   $price_unitaire_ht);
        ?>
    <tr>
        <td style="padding: 5px;border-bottom: 1px solid;"><?php echo $ugs ?></td>
        <td style="padding: 5px;border-bottom: 1px solid;"><?php echo $item->get_name() ?></td>
        <td style="padding: 5px;border-bottom: 1px solid;text-align: center">piéce</td>
        <td style="padding: 5px;border-bottom: 1px solid;text-align: center"><?php echo $item->get_quantity() ?></td>
        <td style="padding: 5px;border-bottom: 1px solid;text-align: center">   <?php  echo $price_unitaire_ht  ?> </td>
        <td style="padding: 5px;border-bottom: 1px solid;text-align: center">  <?php  echo $price_net_ht  ?></td>
        <td style="padding: 5px;border-bottom: 1px solid;text-align: center">19%</td>
    </tr>
    <?php } ?>
</table>

<p></p>
 





<table    style="width:100%;">
    <tr style="">
        <td style="width:50%;vertical-align: bottom;text-align: center">
            
        </td>
       
        <td style="width:50%;text-align: left">
            <table   style=" width:100%;border: 1px solid;border-collapse: collapse;text-align: center">
                 <tr >
                     <td style="padding: 10px; "><strong> Total HT</strong></td>
                          <td  style="padding: 10px"><strong>Total Taxes</strong></td>
                          <td  style="padding: 10px"><strong>NET A PAYER</strong></td>
                    </tr>
                    <tr style="">
                        <td  style="padding: 10px;border-top: 1px solid"><?php echo round($total_ht ,3) ?></td>
                          <td  style="padding: 10px;border-top: 1px solid"><?php echo round($order->get_total()-$total_ht,3)  ?></td>
                            <td  style="padding: 10px;border-top: 1px solid"><?php echo round(($order->get_total()),3)  ?></td>
                    </tr>
            </table>
           
        </td>
    </tr>
   
</table>


<p></p>

<table    style=" width:70%;border: 1px solid;border-collapse: collapse;text-align: center">
   
                 <tr >
                     <td style="padding: 10px; "><strong> Taxe</strong></td>
                          <td  style="padding: 10px"><strong>Base</strong></td>
                          <td  style="padding: 10px"><strong>Montant</strong></td>
                    </tr>
                    <tr style="">
                        <td  style="padding: 10px;border-top: 1px solid">TVA 19%</td>
                          <td  style="padding: 10px;border-top: 1px solid"><?php echo round($total_ht,3)  ?></td>
                            <td  style="padding: 10px;border-top: 1px solid"><?php echo round( $total_ht  ,3)  ?></td>
                    </tr>
       
                     <tr style="">
                        <td  style="padding: 10px;border-top: 1px solid"> Total</td>
                          <td  style="padding: 10px;border-top: 1px solid"><?php echo round($total_ht,3)  ?></td>
                            <td  style="padding: 10px;border-top: 1px solid"><?php echo round( $total_ht  ,3)  ?></td>
                    </tr>
   
</table>

<p></p>


<table    style="width:100%;">
    <tr style="">
        <td style="width:50%;vertical-align: bottom;text-align: center">
            
        </td>
       
        <td style="width:50%;text-align: left">
            <table   style="  width:100%;border: 1px solid;border-collapse: collapse; ">
                <tr >
                    <td>Singture et Caché </td>
                   
                </tr>
                 <tr >
                     <td style="height:  100px; ">
                         
                     </td>
                       
                    </tr>
                 
            </table>
           
        </td>
    </tr>
   
</table>

<p></p>

<?php $note = get_post_meta($order->get_id(),'_custom_note_order',true) ?>
<?php if(trim($note) != ''): ?>
<table    style="width:100%;">
    <tr><td>Note:</td></tr>
    <tr style="">
        <td  >
           <?php echo $note ?>
        </td>
       
      
    </tr>
   
</table>
<?php endif; ?>

</body>
<html>