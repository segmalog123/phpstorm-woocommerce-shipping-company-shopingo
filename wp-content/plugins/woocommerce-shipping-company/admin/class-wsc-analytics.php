<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class WSC_Analytics {
    
    
     public function __construct() {
 

        add_action('wp_ajax_nopriv_process_company_analytics', [$this, 'process_company_analytics']);
        add_action('wp_ajax_process_company_analytics', [$this, 'process_company_analytics']);

   
        add_action('add_meta_boxes',[$this, 'create_custom_meta_box']);
        
        add_action('save_post_product',[$this,'save_custom_post_product'],10,2);
        
        
    }
     function save_custom_post_product($post_id, $post) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // bail out if this is not an event item
        if ('product' !== $post->post_type) {
            return;
        }
        if (isset($_POST['product_purchase_price'])) {
            
            update_post_meta($post_id,'_product_purchase_price',$_POST['product_purchase_price']);
            
        }
     }
     function create_custom_meta_box() {
         add_meta_box('template_info_meta_box', 'Produit', array($this, 'template_info_meta_box'), 'product', 'side');
         
    }
       function template_info_meta_box($post) {
           echo '<p>Prix d\'achat</p>';
             echo ' <input type="text" name="product_purchase_price" value="'.
                     get_post_meta($post->ID,'_product_purchase_price',true).'">';
       }
    function process_company_analytics(){
        
        
            $data = [];
         
        if (isset($_REQUEST['function'])) {
            $func = $_REQUEST['function'];
              if ($func == 'load_category') {

                $data = $this->load_category_search();
            }
            if ($func == 'load_product') {

                $data = $this->load_product_search();
            }
            if ($func == 'main-search') {
                $formdata = [];
                parse_str($_REQUEST['formdata'], $formdata);
                if ($formdata['profit_analytics_page'] == 'archives') {
                    $data = $this->profit_product_archives_search($formdata);
                } else {
                    $data = $this->profit_product_main_search($formdata);
                }
            }
           echo json_encode($data);
        die();
    }
    }
    
        function profit_product_main_search($formdata) {



        if (trim($formdata['profit_product_category']) == 'null') {
            $formdata['profit_product_category'] = '';
        }
        if (trim($formdata['profit_product_list']) == 'null') {
            $formdata['profit_product_list'] = '';
        }
        if (trim($formdata['profit_product_list']) != '') {
            $profit_product_list = explode(',', trim($formdata['profit_product_list']));
        }
        $args = [
            'post_type' => 'shop_order',
            'post_status' => wc_get_order_statuses(),
            'fields' => 'ids',
            'posts_per_page' => -1,
            'post__not_in' => get_trashed_order(),
        ];

        $args = $this->filter_source_query($args, $formdata);
 
        $filter_date = $this->filter_date_query($args, $formdata);
        $args = $filter_date['args'];
        $datediff = $filter_date['date_diff'];


        /*         * ******* */
        $all_orders = get_posts($args);
        if (!empty($profit_product_list)) {
            $all_orders = $this->filter_by_product($all_orders, $profit_product_list);
        }


        $total_all_orders = 0;

        if (trim($formdata['profit_product_category']) != '') {

            $data = $this->filter_order_category_query($all_orders, $formdata);

            $all_orders_count = $data['count_orders'];
            $total_all_orders = $data['total_orders'];
        } else {
            $all_orders_count = sizeof($all_orders);
            foreach ($all_orders as $order_id) {
                $order = wc_get_order((int) $order_id);
                $total_all_orders += $order->get_total();
 
            }
        }



        /*         * ***** */


        $args = $this->filter_company_query($args, $formdata);

        $args = $this->filter_order_valide_query($args, $formdata);



        /*         * ********* */
        $valide_orders = get_posts($args);
        if (!empty($profit_product_list)) {
            $valide_orders = $this->filter_by_product($valide_orders, $profit_product_list);
        }

        $total_charge_transport = $total_pickup = $total_purchase_price_valide = 0;

        if (trim($formdata['profit_product_category']) != '') {

            $data_valide = $this->filter_order_category_query($valide_orders, $formdata);

            //$data_valide_product =  $this->filter_order_category_query($valide_orders,  $formdata)  ;

            $valide_orders_count = $data_valide['count_orders'];
            $total_pickup = $data_valide['total_orders'];
            $total_charge_transport = $data_valide['total_transport'];
            $total_purchase_price_valide = $data_valide['total_purchase'];
        } else {

            $valide_orders_count = sizeof($valide_orders);

            foreach ($valide_orders as $order_id) {

                $order = wc_get_order((int) $order_id);

                ///total_charge_transport
                $company = get_post_meta($order_id, '_shipment_company_name', true);
                $company_data = get_page_by_path($company, OBJECT, 'wsc-companies');
                $company_shipping_cost = get_post_meta($company_data->ID, 'wsc_company_shipping_cost', true);
                $total_charge_transport += $company_shipping_cost;


                //total pickup 
                $total_pickup += $order->get_total();


                //cout achat produit
                foreach ($order->get_items() as $item) {
                   
        
                     $total_purchase_price_valide += $this->get_purchase_price_Atum($item);
                }
            }
        }
        /*         * ********* */

        $args['post_status'] = ['wc-completed', 'wc-paiement-recu', 'wc-echange-recu', 'wc-echange-non-payee'];
        $completed_orders = get_posts($args);
        if (!empty($profit_product_list)) {
            $completed_orders = $this->filter_by_product($completed_orders, $profit_product_list);
        }

        $product_solde = $total_purchase_price = $total_completed = $total_completed_wihout_shipping = 0;


        if (trim($formdata['profit_product_category']) != '') {

            $data_completed = $this->filter_order_category_query($completed_orders, $formdata);
            //$data_completed_product =  $this->filter_order_category_query($completed_orders,  $formdata)  ;

            $completed_orders_count = $data_completed['count_orders'];
            $total_completed = $data_completed['total_orders'];

            $total_purchase_price = $data_completed['total_purchase'];
            $product_solde = $data_completed['product_solde'];
        } else {
            $completed_orders_count = sizeof($completed_orders);
            foreach ($completed_orders as $order_id) {

                $order = wc_get_order((int) $order_id);


                //cout achat produit
                foreach ($order->get_items() as $item) {

                    $product_solde += $item->get_quantity();

                    $total_purchase_price += $this->get_purchase_price_Atum($item);
                }

                //total completed
                $total_completed += $order->get_total();
                //total compleed wihtou shipping
                //$total_completed_wihout_shipping += $order->get_subtotal(); 
            }
        }



        ///*************//////
        if ($formdata['profit_product_fb_cost_currency'] == 'EUR')
            $taux = 3.4;
        else
            $taux = 2.8;

        ///////
        $total_charge_fix = $formdata['profit_product_fix_charge'] * $datediff;

        ////
        $total_charge_pub = $formdata['profit_product_fb_cost'] * $taux;

        ///
        $pourcent_estimed = (100 - $formdata['profit_return_estimated']) / 100;

        ///
        $pourcent_charge_pub = $total_completed != 0 ? ($total_charge_pub / $total_completed) * 100 : 0;
        // 0.2 taux de retour a changer dynamic

        $pourcent_charge_transport = $total_completed != 0 ? ( $total_charge_transport / $total_completed) * 100 : 0;
        //
        $pourcent_charge_fix = $total_completed != 0 ? ($total_charge_fix / $total_completed) * 100 : 0;

        //

        $profit_prix_vente_produit_ttc = $product_solde != 0 ? ($total_completed / $product_solde) : 0;
        //
        $profit_prix_achat_ttc = $product_solde != 0 ? $total_purchase_price / $product_solde : 0;
        //
        $profit_charge_pub_value = ($profit_prix_vente_produit_ttc * $pourcent_charge_pub) / 100;
        $profit_charge_transport_value = ($profit_prix_vente_produit_ttc * $pourcent_charge_transport) / 100;
        $profit_charge_fix_value = ($profit_prix_vente_produit_ttc * $pourcent_charge_fix) / 100;


        //

        $profit_total_charge_produit = $profit_charge_pub_value + $profit_charge_fix_value + $profit_charge_transport_value;


        //////

        $profit_percent_cancelled = $all_orders_count != 0 ? (($all_orders_count - $valide_orders_count) * 100) / $all_orders_count : 0;
        $profit_percent_return = $valide_orders_count != 0 ? (($valide_orders_count - $completed_orders_count) * 100) / $valide_orders_count : 0;

        $profit_product_net = $profit_prix_vente_produit_ttc - $profit_prix_achat_ttc - $profit_total_charge_produit;


        $charge_ttc_produit = $profit_prix_achat_ttc + $profit_total_charge_produit;
        $profit_net_produit_percent = 0;

        if ($charge_ttc_produit != 0) {
            $profit_net_produit_percent = $profit_product_net / $charge_ttc_produit;
        }

        $profit_net_estime = (($total_pickup * $pourcent_estimed) - ($total_purchase_price_valide * $pourcent_estimed) - $total_charge_fix - $total_charge_transport - $total_charge_pub);

        $profit_net_estime_valide = ($total_purchase_price_valide * $pourcent_estimed) + $total_charge_fix + $total_charge_transport + $total_charge_pub;

        return [
            'debug' => $args,
            'profit_total_orders' => $all_orders_count,
            'profit_cout_order_fb' => round(($all_orders_count != 0 ? ($formdata['profit_product_fb_cost'] / $all_orders_count) : 0), 2),
            'profit_total_valide' => $valide_orders_count,
            'profit_total_completed' => $completed_orders_count,
            'profit_total_product_vendue' => $product_solde,
            'profit_total_moyen_cart' => round($all_orders_count != 0 ? ($total_all_orders / $all_orders_count) : 0, 2),
            /*             * ********************* */
            'profit_cout_all_products' => round($total_purchase_price, 2),
            'profit_total_charge_fix' => round($total_charge_fix, 2),
            'profit_total_charge_transport' => round($total_charge_transport, 2),
            'profit_total_charge_pub' => round($total_charge_pub, 2),
            /*             * ************** */
            /*             * ********************* */
            'profit_total_pickup' => round($total_pickup, 2),
            'profit_chiffre_affaire' => round($total_completed, 2),
            'profit_net_real' => round(($total_completed - $total_purchase_price - $total_charge_fix - $total_charge_transport - $total_charge_pub), 2),
            'profit_net_estime' => round($profit_net_estime, 2),
            /*             * ************** */
            /*             * ********************* */
            'profit_pourcent_pub' => round($pourcent_charge_pub, 2),
            'profit_pourcent_transport' => round($pourcent_charge_transport, 2),
            'profit_pourcent_fix' => round($pourcent_charge_fix, 2),
            /*             * ******************* */
            /*             * ***************** */
            'profit_prix_vente_produit_ttc' => round($profit_prix_vente_produit_ttc, 2),
            'profit_prix_achat_ttc' => round($profit_prix_achat_ttc, 2),
            'profit_charge_pub_value' => round($profit_charge_pub_value, 2),
            'profit_charge_fix_value' => round($profit_charge_fix_value, 2),
            'profit_charge_transport_value' => round($profit_charge_transport_value, 2),
            /*             * ************** */
            'profit_total_charge_produit' => round($profit_total_charge_produit, 2),
            'profit_net_produit' => round($profit_product_net, 2),
            /*             * ************ */
            'profit_percent_cancelled' => round($profit_percent_cancelled, 2),
            'profit_percent_return' => round($profit_percent_return, 2),
            'profit_net_produit_percent' => round($profit_net_produit_percent * 100, 2),
            'profit_net_estime_percent' => round($profit_net_estime_valide != 0 ? $profit_net_estime / $profit_net_estime_valide : 0, 2) * 100
            , 'total_pickup' => $total_pickup
            , 'total_purchase_price_valide' => $total_purchase_price_valide
        ];
    }

    function filter_by_product($orders, $products) {
        $found = false;
        foreach ($orders as $order_id) {
            $order = wc_get_order($order_id);
            foreach ($order->get_items() as $item) {
                if (in_array($item->get_product_id(), $products)) {
                    $res[] = $order_id;
                    break;
                }
            }
        }
        return $res;
    }

    function filter_source_query($args, $formdata) {
        if ($formdata['profit_product_source_order'] != 'null' && $formdata['profit_product_source_order'] != 'all') {

            $values_to_search = explode(',', $formdata['profit_product_source_order']);
            $meta['relation'] = 'OR';
            foreach ($values_to_search as $value) {
                $meta[$value] = array(
                    'key' => '_billing_order_source',
                    'value' => $value,
                    'compare' => 'LIKE',
                );
            }

            $args['meta_query'][] = array(
                $meta
            );
        }


        return $args;
    }

    function filter_order_category_query($orders, $formdata) {
        $arr_cat_ids = explode(',', $formdata['profit_product_category']);
        $total_orders = $count_orders = $total_charge_transport = $total_purchase = $product_solde = $total_completed = 0;
        foreach ($orders as $order_id) {

            $order = wc_get_order((int) $order_id);
            $found = false;
            $product_solde_temp = $product_solde;
            $total_purchase_temp = $total_purchase;
            foreach ($order->get_items() as $item) {
                $product_id = $item->get_product_id();
                $product_cat_id = wc_get_product_term_ids($product_id, 'product_cat');

                $total_purchase += $this->get_purchase_price_Atum($item);

                $product_solde += $item->get_quantity();

                if (in_array($product_cat_id[0], $arr_cat_ids)) {

                    $found = true;
                }
            }
            if ($found) {
                $total_orders += $order->get_total();
                $count_orders++;


                $company = get_post_meta($order_id, '_shipment_company_name', true);
                $company_data = get_page_by_path($company, OBJECT, 'wsc-companies');
                $company_shipping_cost = get_post_meta($company_data->ID, 'wsc_company_shipping_cost', true);
                $total_charge_transport += $company_shipping_cost;
            } else {
                $total_purchase = $total_purchase_temp;
                $product_solde = $product_solde_temp;
            }
        }

        return [
            'total_purchase' => $total_purchase,
            'total_transport' => $total_charge_transport,
            'total_orders' => $total_orders,
            'count_orders' => $count_orders,
            'product_solde' => $product_solde,
        ];
    }

    function get_purchase_price_Atum($item) {

        $product_id = $item->get_product_id();
        if ($item->get_variation_id() != 0) {
            $product_id = $item->get_variation_id();
        }
        
        return get_post_meta($product_id,'_product_purchase_price',true) * $item->get_quantity();

//        if (class_exists("Atum\Inc\Helpers")) {
//            $product = Atum\Inc\Helpers::get_atum_product($product_id);
//            if($product){
//            $purchase_price = $product->get_purchase_price();
//
//            return $purchase_price * $item->get_quantity();
//            }
//        }

        return 0;
    }

    function filter_order_valide_query($args, $formdata) {

        $args['meta_query'][] = array(
            'key' => '_shipment_number_id',
            'value' => array(''),
            'compare' => 'NOT IN',
        );

        return $args;
    }

    function filter_company_query($args, $formdata) {

        if (trim($formdata['profit_product_shipping_company']) != 'null' && trim($formdata['profit_product_shipping_company']) != 'all') {
            $args['meta_query'][] = array(
                'key' => '_shipment_company_name',
                'value' => explode(',', $formdata['profit_product_shipping_company']),
                'compare' => 'IN',
            );
        }
        return $args;
    }

    function filter_date_query($args, $formdata) {

        $filter_date = [date('Y-m-d', strtotime('-30 days')), date('Y-m-d')];
        $meta_date = 'date_query';

        if (trim($formdata['profit_product_date_order']) != '') {
            $filter_date = explode('to', trim($formdata['profit_product_date_order']));
        }

        if (trim($formdata['profit_product_date_pickup']) != '') {
            $filter_date = explode('to', trim($formdata['profit_product_date_pickup']));
            $meta_date = '_order_date_pickup';
        }


        if ($meta_date == 'date_query') {
            $start_date = new DateTime($filter_date[0]);
            $end_date = new DateTime(isset($filter_date[1]) ? $filter_date[1] : $filter_date[0]);
            $args['date_query'] = array(
                array(
                    'after' => array(
                        'year' => $start_date->format('Y'),
                        'month' => $start_date->format('m'),
                        'day' => $start_date->format('d'),
                    ),
                    'before' => array(
                        'year' => $end_date->format('Y'),
                        'month' => $end_date->format('m'),
                        'day' => $end_date->format('d'),
                    ),
                    'inclusive' => true,
                ),
            );
        } else {
            $args['meta_query'][] = array(
                'key' => $meta_date,
                'value' => array($filter_date[0], isset($filter_date[1]) ? $filter_date[1] : $filter_date[0]),
                'compare' => 'BETWEEN',
                'type' => 'DATE'
            );
        }

        $diff = strtotime(isset($filter_date[1]) ? $filter_date[1] : $filter_date[0]) - strtotime($filter_date[0]);
        $date_diff = abs(round($diff / 86400)) + 1;


        return
                [
                    'args' => $args,
                    'date_diff' => $date_diff,
                    'filter_date' => $filter_date
        ];
    }
    
    
      function load_product_search(){
          $json = [];
                    $args = array(
                            'post_type' => array('product','draft'),
                            'status' => 'publish',
                            'posts_per_page' => -1,
                            's' => $_REQUEST['search'],
                            'fields' => 'ids',
                         );
                     $searched_result = get_posts($args);
                       foreach ($searched_result as $id) {
                            $product = wc_get_product((int)$id);
                            $product_id = $product->get_id();
                            $enbale_pack_product = get_post_meta($product_id, '_enable_pack_product', true);
                             if($enbale_pack_product != '1'){
                                $json[] = [
                                    'id' => $product->get_id(),
                                    'text' => $product->get_name() . ' #' . $product->get_id() . ' (' . $product->get_type() . ')',
                               
                                ];
                             }
                          
                        }
          $json[] = $searched_result;
            echo json_encode($json);
                    die();
      }
    
    
    
      function load_category_search() {
        $json = [];

        $args = array(
            'taxonomy' => "product_cat",
            'hide_empty' => true,
            'search' => $_REQUEST['search']
        );
        $product_categories = get_terms($args);


        foreach ($product_categories as $cat) {

            $json[] = [
                'id' => $cat->term_id,
                'text' => $cat->name,
            ];
        }



        return $json;
    }
}
