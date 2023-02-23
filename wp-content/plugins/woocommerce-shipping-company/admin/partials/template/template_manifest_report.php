 
<style>
     .table-products thead th{
        border-bottom: 2px solid #E6E9ED;
         border-top: 2px solid #E6E9ED;
         padding:5px
    }
    .table-products td{
        border-bottom: 2px solid #E6E9ED;
        padding:5px
    }
</style>        
                    
                    <table style="width:100%;text-align: center;border:2px solid #0000A0;color:#000;padding: 
                           10px;font-size: 16px" cellpadding="2" cellspacing="2" align="left">
                        <tr>
                           
                            <td>Manifest Report</td>
                            <td><?php echo $company_title; ?></td>
                        </tr>
                    </table><br>
                    <table style="width:100%;" cellpadding="2" cellspacing="2" align="left">
                        <tr>
                             <td>Nombre de commande : <?php echo sizeof($orders)  ?></td>
                        </tr>
                        <tr> 
                            <td>Manifest Date : <?php echo date('m/d/Y') ?>   </td>

                   
                        </tr>
                    </table>
                    <p></p>
                     
                    
                    
                         <table class="table-products" style="width:100%;" cellpadding="2" cellspacing="2">
                             <thead>
                        <tr   border="1" style="font-size: 8px;">
                            <th width="20">ID</th>  
                            <th width="60">N° Livraison</th>
                         
                            <th width="130">Nom/Prénom</th>
                            <th width="80">Téléphone</th>
                            <th width="70">Gouvernerat</th>
                     
                            <th width="30">PCS</th>
                        </tr>

                             </thead>
                    <?php
                    $i = 1;
                    foreach ($orders as $order_id) {

                         
                            $ship_number = get_post_meta($order_id, '_shipment_number_id', true);
                       
if($ship_number != ''){

                        $order = wc_get_order($order_id);

                        $_shipping_nbr_pcs = get_post_meta($order->get_id(),'_shipping_nbr_pcs',true)!=''?get_post_meta($order->get_id(),'_shipping_nbr_pcs',true):'1';
                        echo '
                   <tr   style="font-size: 8px">
                        <td style="text-align:center">' . $i . '</td>
                        <td style="text-align:center">' . $ship_number . '</td>
                         
                        <td style="text-align:center"> ' . ucfirst(strtolower($order->get_billing_first_name())) . '</td>
                        
                        <td style="text-align:center">' . str_replace(' ', '', $order->get_billing_phone()) . '</td> 
                        <td style="text-align:center">' . $order->get_billing_city() . '</td>
                       
                        <td style="text-align:center">'.$_shipping_nbr_pcs.'</td>
            </tr>';
                        $i++;
                    }
                    }
                    ?>



                    </table>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                   
                    <?php
                      
 