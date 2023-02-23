<?php

//for($i=0 ; $i<=1000 ; $i++ ){
//    echo $i.'<br>';
//}
// $responses =  Requests::request_multiple( 
//         [
//             [
//	'url' => 'https://administrateur.targuiexpress.com/WebServiceExterne/tracking_position/140703832132' ,
//	'type' => 'GET'
//            ],
//                   [
//	'url' =>  'https://administrateur.targuiexpress.com/WebServiceExterne/tracking_position/120303767988' ,
//	'type' => 'GET'
//            ],
//         
//             ]);
//$data = [];
// foreach ( $responses as $response ){
//	
//	if( is_a( $response, 'Requests_Response' ) ){
//		$data[] = json_decode( $response->body );
//	}
//}
// d($data);die();

//update_tracking_hourly('wc-pickup');

//    $args = [
//            'post_type' => 'shop_order',
//            'post_status' => ['wc-pick-up'],
//            'fields' => 'ids',
//            'posts_per_page' => -1,
//            'post__not_in' => get_trashed_order(),
//        ];
//    
//    $ids = get_posts($args);
//    $i=0;
//      $event_id = [];
//    foreach ($ids as $id) {
//       
//       $ship_number = get_post_meta($id, '_shipment_number_id', true);
//                $company = get_post_meta($id, '_shipment_company_name', true);
//                
//                 $data_company = get_ship_company($company);
//                 
//                  $datatrack  = json_decode(company_get_action('tracking_position',[$ship_number],false,
//                         get_post_meta($data_company['company_id'],'wsc_company_end_point',true)));
//                  
//                 foreach($datatrack->evenements as $eve){
//                     
//                                   $event_id[] = $eve->eventid;
//                    
//                 }
//                 
//                   $counts = array_count_values($event_id);
//                   d($counts);
//       
////      $i++;
////      if($i == 5){
////          break;
////      }
//    }
//d($ids);
?>

<h1><?php echo __( 'Company Payment', $this->plugin_name ) ?></h1>
<div id="paymentapp">
    <v-app v-cloak>
        <v-main>
            <v-container fluid>
                <div class="d-flex justify-space-between   pa-5">

                    <template class="">
                        <form class="gcol-2" enctype="multipart/form-data" id="fileToUpload" method="post">
                            <div class="process_order_tracking_csv">
                                <input type="file" name="fileToUpload" id="inputfile" class="inputfile"
                                       style="border: none;padding: 0">
                            </div>
                        </form>

                        <div class="gcol-2">OU</div>


                        <input type="text" class="input_date_range_payment gcol-2" placeholder="Choisir Date Commande"
                               style="border: 1px solid !important; ">


                        <div class="">
                            <label for="checkbox_filter_date_pickup">
                                <input checked id="checkbox_filter_date_pickup" type="radio" style="height: 17px;"
                                       value="pickup" name="checkbox_filter_date"/>
                                Date PickUp</label>
                            <label class="ml-5" for="checkbox_filter_date_completed">
                                <input id="checkbox_filter_date_completed" type="radio" style="height: 17px;"
                                       value="completed" name="checkbox_filter_date"/>
                                Date Terminée/Retour</label>
                        </div>
                    </template>
                    <select class="company_shippment gcol-2" name="company_shippment">

                        <option value="">Select Société...</option>

                        <option value="targui-express">Targui Express</option>


                    </select>

                    <select name="status_shippment" class="status_shippment gcol-2">
                        <option value="all">Tout</option>
                        <option value="wc-completed">Terminée</option>
                        <option value="wc-retour">Retour</option>
                    </select>
                    <label><input type="checkbox" class="filter_order_factured">Facturé</label>
                    <button type="button" class="button btn_load_table_date_company">Charger les données dans le
                        tableau
                    </button>


                </div>
                <div class="d-flex  justify-space-around pa-5">

                    <div>
                        <div class="gcol-5">
                            <button type="button" class="button btn_check_payment">Vérifier états paiments</button>
                        </div>
                        <div class="gcol-5 mt-5">
                            <button type="button" class="button btn_change_status_order">Changer Commandes en Paiment
                                reçue
                            </button>
                        </div>

                    </div>
                    <div>
                        <div class="gcol-5">
                            <button type="button" class="button btn_check_factured">Vérifier Facturation</button>
                        </div>
                        <div class="gcol-5  mt-5">
                            <button type="button" class="button btn_change_factured_order">Changer Commandes en
                                Facturé
                            </button>
                        </div>
                    </div>
                    <div>
                        <div class="gcol-2 gright">
                            <button type="button" class="button btn_clear_data">Vider Table</button>
                        </div>
                    </div>

                </div>


                <div class="gcol-12">
                    <span><strong><span class="filter_order_found">0</span> Commandes trouvées</strong></span>
                </div>
                <div id="data_shippement_csv"></div>
                <input type="hidden" class="res_success_order">
                <input type="hidden" class="res_success_key">
                <input type="hidden" class="res_success_order_factured">
            </v-container>
        </v-main>
    </v-app>
</div>
 