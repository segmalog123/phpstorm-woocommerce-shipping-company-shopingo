<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WSC_Analytics_Pro {

    public function __construct() {


        add_action('wp_ajax_nopriv_process_company_analytics_pro', [$this, 'process_company_analytics_pro']);
        add_action('wp_ajax_process_company_analytics_pro', [$this, 'process_company_analytics_pro']);
    }

    function process_company_analytics_pro() {


        $data = [];

        if (isset($_REQUEST['function'])) {
            $func = $_REQUEST['function'];
            if ($func == 'main-pro-search') {

                $data = $this->profit_product_main_search_pro();
            }
            if ($func == 'load_data') {

                $data = $this->profit_product_load_all_data();
            }

            echo json_encode($data);
            die();
        }
    }

    function profit_product_load_all_data() {
        return [
            'products' => $this->load_product_search('pro'),
            'category' => $this->load_category_search('pro'),
            'company' => array_values(get_ship_company())
        ];
    }

    function profit_product_main_search_pro() {

        $total_all_orders = $total_charge_transport_estime = 0;
        $total_charge_transport = $total_pickup = $total_purchase_price_valide = $nombre_product_solde_valide = 0;
        $product_solde = $total_purchase_price = $total_completed = $total_completed_wihout_shipping = 0;

        $all_orders_count = $valide_orders_count = $completed_orders_count = 0;
        
        $profit_estime_new = 0;
        
        $nombre_article = $cout_article= 0;
        
        $formdata = $_REQUEST['filterData'];

        $arr_completed = ['completed', 'paiement-recu', 'echange-recu', 'echange-non-payee'];
        $args = [
            'post_type' => 'shop_order',
            'post_status' => wc_get_order_statuses(),
            'fields' => 'ids',
            'posts_per_page' => -1,
            'post__not_in' => get_trashed_order(),
        ];


        if ($formdata['selectedPage'] != '') {

            $args['meta_query'][] = [
                'key' => '_billing_facebook_page',
                'value' => $formdata['selectedPage'],
                'compare' => 'IN'
            ];
        }

        //  $args = $this->filter_source_query($args, $formdata);
        if ($formdata['selectedSource'] && !empty($formdata['selectedSource'])) {
            $args['meta_query'][] = array(
                'key' => '_billing_order_source',
                'value' => $formdata['selectedSource'],
                'compare' => 'LIKE',
            );
        }

        $filter_date = $this->filter_date_query($args, $formdata);
        $args = $filter_date['args'];
        $datediff = $filter_date['date_diff'];


        /*         * ********   All Order    ****** */
        $all_orders = get_posts($args);


        /*         * ********   Check selected prodcut in all order    ****** */
        if (isset($formdata['selectedProduct']) && !empty($formdata['selectedProduct'])) {
            $all_orders = $this->filter_by_product($all_orders, $formdata['selectedProduct']);
        }

        /*         * ********   Check selected categorie in all order    ****** */

        if (isset($formdata['selectedCat']) && $formdata['selectedCat'] != null && !empty($formdata['selectedCat'])) {

            $data = $this->filter_order_category_query($all_orders, $formdata);

            $all_orders_count = $data['count_orders'];
            $total_all_orders = $data['total_orders'];
               $nombre_article = $data['nombre_article'];
        } else {
            if(!empty($all_orders)){
            $all_orders_count = sizeof($all_orders);
            foreach ($all_orders as $order_id) {
                $order = wc_get_order((int) $order_id);
                $total_all_orders += $order->get_total();
                
                   foreach ($order->get_items() as $item) {
              
                 
                $product      = $item->get_product();
 
                      if( $product->is_type('variation') ){
                           
                              $variation_attributes  = $product->get_variation_attributes();
                             foreach($variation_attributes as $attribute_taxonomy => $term_slug ){
                                   $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
                                   
                                    if( taxonomy_exists($taxonomy) ) {
                                        $term_id = get_term_by( 'slug', $term_slug, $taxonomy )->term_id;
                                        
                                        $_qty_pack = get_metadata('term', $term_id, '_qty_pack', TRUE);
                                        if($_qty_pack != ''){
                                            $nombre_article +=  $_qty_pack*$item->get_quantity();
                                        }else{
                                            $nombre_article +=  $item->get_quantity();
                                        }
                                     
                                    }
                             }
                        }else{
                            $nombre_article +=  $item->get_quantity();
                        }
           
            }
            }
            }
        }

      
        /*         * ********   Check selected comapny in all order    ****** */

        $args = $this->filter_company_query($args, $formdata);

        /*         * ********   Valide order (has shipement id)    ****** */

        $args = $this->filter_order_valide_query($args, $formdata);

        $valide_orders = get_posts($args);

        /*         * ********   Check selected prodcut in Valide order    ****** */
        if (isset($formdata['selectedProduct']) && !empty($formdata['selectedProduct'])) {
            $valide_orders = $this->filter_by_product($valide_orders, $formdata['selectedProduct']);
        }


        /*         * ********   Check selected categorie in Valide order    ****** */
        if (isset($formdata['selectedCat']) && $formdata['selectedCat'] != null &&  !empty($formdata['selectedCat'])) {

            $data_valide = $this->filter_order_category_query($valide_orders, $formdata);


            $valide_orders_count = $data_valide['count_orders'];
            $total_pickup = $data_valide['total_orders'];
            $total_charge_transport = $data_valide['total_transport'];
            $total_charge_transport_estime = $data_valide['total_charge_transport_estime'];
            $total_purchase_price_valide = $data_valide['total_purchase'];
            $nombre_product_solde_valide = $data_valide['product_solde'];
            
        } else {
            if(!empty($valide_orders)){

            $valide_orders_count = sizeof($valide_orders);
 
            foreach ($valide_orders as $order_id) {

                $order = wc_get_order((int) $order_id);

                ///total_charge_transport
                $company = get_post_meta($order_id, '_shipment_company_name', true);
//                $company_data = get_page_by_path($company, OBJECT, 'wc-company');
//                $company_shipping_cost = get_post_meta($company_data->ID, 'company_shipping_cost', true);
                $company_data = get_page_by_path($company, OBJECT, 'wsc-companies');
                $company_shipping_cost = get_post_meta($company_data->ID, 'wsc_company_shipping_cost', true);

                if (in_array($order->get_status(), $arr_completed)) {
                    $total_charge_transport += $company_shipping_cost;
                }
                $total_charge_transport_estime += $company_shipping_cost;

                //total pickup 
                $total_pickup += $order->get_total();


                //cout achat produit
                foreach ($order->get_items() as $item) {

                    $is_pack = get_post_meta($item->get_product_id(), '_enable_pack_product', true);

                    if ($is_pack == 1) {

                        $data_pack_products = get_post_meta($item->get_product_id(), '_data_pack_products', true);
                        if (!empty($data_pack_products)) {

                            foreach ($data_pack_products as $pack_id => $data) {
                                $total_purchase_price_valide += $this->get_purchase_price_Atum_by_id($pack_id, $data['qty'], $item->get_quantity());
                                $nombre_product_solde_valide += $data['qty'] * $item->get_quantity();
                            }
                        }
                    } else {
                        $total_purchase_price_valide += $this->get_purchase_price_Atum($item);

                        $nombre_product_solde_valide += $item->get_quantity();
                    }
                }
             
            }
            }
            
        }

       
        /*         * ********   Completed order     ****** */

        $args['post_status'] = ['wc-completed', 'wc-paiement-recu', 'wc-echange-recu', 'wc-echange-non-payee'];

        $completed_orders = get_posts($args);

        /*         * ********   Check selected prodcut in Completed order    ****** */
        if (isset($formdata['selectedProduct']) && !empty($formdata['selectedProduct'])) {
            $completed_orders = $this->filter_by_product($completed_orders, $formdata['selectedProduct']);
        }

  


        /*         * ********   Check selected categorie in Completed order    ****** */

        if (isset($formdata['selectedCat']) && $formdata['selectedCat'] != null &&  !empty($formdata['selectedCat'])) {

          
            $data_completed = $this->filter_order_category_query($completed_orders, $formdata);

            $completed_orders_count = $data_completed['count_orders'];
            $total_completed = $data_completed['total_orders'];

            $total_purchase_price = $data_completed['total_purchase'];
            $product_solde = $data_completed['nombre_article'];
            
            // $product_solde = $data_completed['nombre_article'];
             
        } else {
            
              if(!empty($completed_orders)){
                     $completed_orders_count = sizeof($completed_orders);
          
            foreach ($completed_orders as $order_id) {

                $order = wc_get_order((int) $order_id);

                //cout achat produit
                foreach ($order->get_items() as $item) {

                    $is_pack = get_post_meta($item->get_product_id(), '_enable_pack_product', true);

                    if ($is_pack == 1) {

                        $data_pack_products = get_post_meta($item->get_product_id(), '_data_pack_products', true);
                        if (!empty($data_pack_products)) {

                            foreach ($data_pack_products as $pack_id => $data) {
                                $product_solde += $data['qty'] * $item->get_quantity();
                                $total_purchase_price += $this->get_purchase_price_Atum_by_id($pack_id, $data['qty'], $item->get_quantity());
                            }
                        }
                    } else {
                        $product_solde += $item->get_quantity();

                        $total_purchase_price += $this->get_purchase_price_Atum($item);
                       // $dd[] =get_post_meta($item->get_variation_id(), '_product_purchase_price', true);
                    }
                }
                //total completed
                $total_completed += $order->get_total();
            }
              }
         
        }






 

        ///*************//////


        $taux = 4;


        ///////
        // $total_charge_fix = $formdata['fixCharge'] * $datediff;
        $total_charge_fix = 0;
        ////
        // $total_charge_pub = ($formdata['soldePub'] * $taux);
        ///////////////////////$total_charge_pub = $formdata['soldePub'] * $taux * 1.20;
        
         if(trim($formdata['soldePubUSD']) != ''){
            $total_charge_pub = $formdata['soldePubUSD'] * 3.45 * 1.20;
            $soldePub =  $formdata['soldePubUSD'];
        } 
        
        if(trim($formdata['soldePubEuro']) != ''){
            $total_charge_pub = $formdata['soldePubEuro'] * 4 * 1.20;
            $soldePub =  $formdata['soldePubEuro'];
        }
        
        if(trim($formdata['soldePubUSD']) != '' && trim($formdata['soldePubEuro']) != ''){
            $total_charge_pub = (($formdata['soldePubUSD'] * 3.45) + ($formdata['soldePubEuro'] * 4) )* 1.20;
            
              $soldePub = $formdata['soldePubUSD'] + ($formdata['soldePubEuro']*1.05);
        }
        
       
        
        
        
        ///
        $pourcent_estimed = (100 - $formdata['retourPercent']) / 100;


        $transport_estime = $total_charge_transport_estime * $pourcent_estimed;
        ///
        //////

        $profit_percent_cancelled = $all_orders_count != 0 ? (($all_orders_count - $valide_orders_count) * 100) / $all_orders_count : 0;
        $profit_percent_return = $valide_orders_count != 0 ? (($valide_orders_count - $completed_orders_count) * 100) / $valide_orders_count : 0;


        $total_charge = $total_charge_pub;
 
 
        $profit_net_estime = (($total_pickup * $pourcent_estimed) - 
                ($total_purchase_price_valide * $pourcent_estimed) - $total_charge_fix - $transport_estime - $total_charge_pub);

        $charge_estime_valide =  $total_charge_pub;


        $charge_par_article = 0;

        if ($product_solde != 0) {
            $charge_par_article = $total_charge_transport / $product_solde + $total_charge_pub / $product_solde + $total_charge_fix / $product_solde;
        }


        $charge_par_article_estime = 0;
        if (($nombre_product_solde_valide * $pourcent_estimed) != 0) {
            $charge_par_article_estime = $transport_estime / ($nombre_product_solde_valide * $pourcent_estimed) + $total_charge_pub / ($nombre_product_solde_valide * $pourcent_estimed) + $total_charge_fix / ($nombre_product_solde_valide * $pourcent_estimed);
        }

        $profit_net_real = $total_completed - $total_purchase_price - $total_charge_fix - $total_charge_transport - $total_charge_pub;

       
                
        $net_real_percent = $total_charge!=0?$profit_net_real/$total_charge:0;

        /*         * ************** */
        $profit_estime_par_article = 0;
        
        $nombre_article_estime_termine = 
                $nombre_article*((100-$profit_percent_cancelled)/100)*((100-$formdata['retourPercent'])/100) ;
        
        $profit_estime_new = 
               ( $nombre_article_estime_termine*$formdata['marge'])-$total_charge_pub;

        $profit_estime_par_article = $nombre_article_estime_termine!=0?$profit_estime_new/$nombre_article_estime_termine:0;
        
        return [
            'debug' =>  $profit_percent_cancelled,
            'profit_total_orders' => $all_orders_count,
            'profit_cout_order_fb' => round(($all_orders_count != 0 ? (($soldePub*1.2) / $all_orders_count) : 0), 2),
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
            'profit_net_real' => round($profit_net_real, 2),
            'profit_net_estime' => round($profit_net_estime, 2),
            /*             * ************** */
             'profit_percent_cancelled' => round($profit_percent_cancelled, 2),
            'profit_percent_return' => round($profit_percent_return, 0),
            'net_real_percent' => round($net_real_percent * 100, 2),
            'profit_net_estime_percent' => round(($charge_estime_valide != 0 ? $profit_net_estime / $charge_estime_valide : 0) * 100, 2)
            , 'total_pickup' => $total_pickup
            , 'total_purchase_price_valide' => $total_purchase_price_valide
            , 'nombre_product_solde_valide' => $valide_orders_count != 0 ? round($nombre_article / $all_orders_count, 2) : 0
            , 'charge_par_article' => round($charge_par_article, 2)
            , 'charge_par_article_estime' => round($charge_par_article_estime, 2),
            'transport_estime' => round($transport_estime, 2),
              /**************/
               'nombre_article' => round($nombre_article,2),
               'cout_article' =>   round(($nombre_article != 0 ? (($soldePub*1.2) / $nombre_article) : 0), 2),
            
            /********/
            'profit_estime_new' => round($profit_estime_new,2),
            'profit_estime_par_article' => round($profit_estime_par_article,2)
       
             
        ];
    }

    function filter_by_product($orders, $products) {
        $found = false;
        foreach ($orders as $order_id) {
            $order = wc_get_order($order_id);
            foreach ($order->get_items() as $item) {




                $data_pack_products = get_post_meta($item->get_product_id(), '_data_pack_products', true);
                if (!empty($data_pack_products)) {

                    foreach ($data_pack_products as $pack_id => $data) {
                        if (in_array($pack_id, $products)) {
                            $res[] = $order_id;
                            break;
                        }
                    }
                }


                if (in_array($item->get_product_id(), $products)) {
                    $res[] = $order_id;
                    break;
                }
            }
        }
        return $res;
    }

    function filter_source_query($args, $formdata) {
        if ($formdata['selectedSource'] && !empty($formdata['selectedSource'])) {



            $meta[$value] = array(
                'key' => '_billing_order_source',
                'value' => $formdata['selectedSource'],
                'compare' => 'LIKE',
            );


            $args['meta_query'][] = array(
                $meta
            );
        }


        return $args;
    }

    function filter_order_category_query($orders, $formdata) {
        $arr_cat_ids = $formdata['selectedCat'];
        $total_orders = $count_orders = $total_charge_transport = $total_purchase = $product_solde = $total_completed = $total_charge_transport_estime = 0;
        $arr_completed = ['completed', 'paiement-recu', 'echange-recu', 'echange-non-payee'];
        $nb_article= 0;
        foreach ($orders as $order_id) {

            $order = wc_get_order((int) $order_id);
            $found = false;
            $product_solde_temp = $product_solde;
            $total_purchase_temp = $total_purchase;
            foreach ($order->get_items() as $item) {
                $product_id = $item->get_product_id();
                $product_cat_id = wc_get_product_term_ids($product_id, 'product_cat');


                $is_pack = get_post_meta($product_id, '_enable_pack_product', true);

                if ($is_pack == 1) {

                    $data_pack_products = get_post_meta($product_id, '_data_pack_products', true);
                    if (!empty($data_pack_products)) {

                        foreach ($data_pack_products as $pack_id => $data) {
                            $total_purchase += $this->get_purchase_price_Atum_by_id($pack_id, $data['qty'], $item->get_quantity());
                            $product_solde += $data['qty'] * $item->get_quantity();
                        }
                    }
                } else {
                    $total_purchase += $this->get_purchase_price_Atum($item);

                    $product_solde += $item->get_quantity();
                }
                
                
                
                $product      = $item->get_product();
                if (in_array($product_cat_id[0], $arr_cat_ids)) {

                    $found = true;
                      if( $product->is_type('variation') ){
                           
                             
                             $variation_attributes  = $product->get_variation_attributes();
                             foreach($variation_attributes as $attribute_taxonomy => $term_slug ){
                                   $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
                                  
                                    if( taxonomy_exists($taxonomy) ) {
                                        $term_id = get_term_by( 'slug', $term_slug, $taxonomy )->term_id;
                                        
                                        $_qty_pack = get_metadata('term', $term_id, '_qty_pack', TRUE);
                                        if($_qty_pack != ''){
                                            $nb_article += $_qty_pack*$item->get_quantity();
                                        }else{
                                            $nb_article +=  $item->get_quantity();
                                        }
                                     
                                    }
                             }
                        }else{
                            $nb_article +=  $item->get_quantity();
                        }
                }
            }
            if ($found) {
                $total_orders += $order->get_total();
                $count_orders++;


                $company = get_post_meta($order_id, '_shipment_company_name', true);
//              $company_data = get_page_by_path($company, OBJECT, 'wc-company');
//                $company_shipping_cost = get_post_meta($company_data->ID, 'company_shipping_cost', true);
                $company_data = get_page_by_path($company, OBJECT, 'wsc-companies');
                $company_shipping_cost = get_post_meta($company_data->ID, 'wsc_company_shipping_cost', true);

                if (in_array($order->get_status(), $arr_completed)) {

                    $total_charge_transport += $company_shipping_cost;
                }

                $total_charge_transport_estime += $company_shipping_cost;
            } else {
                $total_purchase = $total_purchase_temp;
                $product_solde = $product_solde_temp;
            }
        }

        return [
            'total_purchase' => $total_purchase,
            'total_transport' => $total_charge_transport,
            'total_charge_transport_estime' => $total_charge_transport_estime,
            'total_orders' => $total_orders,
            'count_orders' => $count_orders,
            'product_solde' => $product_solde,
            'nombre_article' => $nb_article,
        ];
    }

    function get_purchase_price_Atum_by_id($product_id, $qtypack = 1, $qty = 1) {
        if (class_exists("Atum\Inc\Helpers")) {
            $product = Atum\Inc\Helpers::get_atum_product($product_id);
            if ($product) {
                $purchase_price = $product->get_purchase_price();

                return $purchase_price * $qty * $qtypack;
            }
        } else {
            return get_post_meta($product_id, '_product_purchase_price', true) * $qty * $qtypack;
        }
    }

    function get_purchase_price_Atum($item) {

        $product_id = $item->get_product_id();
        if ($item->get_variation_id() != 0) {
            $product_id = $item->get_variation_id();
        }

        if (class_exists("Atum\Inc\Helpers")) {
            $product = Atum\Inc\Helpers::get_atum_product($product_id);
            if ($product) {
                $purchase_price = $product->get_purchase_price();

                return $purchase_price * $item->get_quantity();
            }
        } else {
            $purchaseprice = get_post_meta($product_id, '_product_purchase_price', true);
            if($purchaseprice != ''){
                return  $purchaseprice * $item->get_quantity();
            }
        }



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

        if (isset($formdata['selectedCompany']) && !empty($formdata['selectedCompany'])) {
            $args['meta_query'][] = array(
                'key' => '_shipment_company_name',
                'value' => $formdata['selectedCompany'],
                'compare' => 'IN',
            );
        }
        return $args;
    }

    function filter_date_query($args, $formdata) {


        if ($formdata['dateBy'] == 'pickup') {

            $args['meta_query'][] = array(
                'key' => '_order_date_pickup',
                'value' => array($formdata['startDate'], $formdata['endDate']),
                'compare' => 'BETWEEN',
                'type' => 'DATE'
            );
        } else {
            $start_date = new DateTime($formdata['startDate']);
            $end_date = new DateTime($formdata['endDate']);
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
        }

        $diff = strtotime($formdata['endDate']) - strtotime($formdata['startDate']);
        $date_diff = abs(round($diff / 86400)) + 1;


        return
                [
                    'args' => $args,
                    'date_diff' => $date_diff,
        ];
    }

    function load_product_search($pro = '') {
        $json = [];
        $args = array(
            'post_type' => array('product', 'draft'),
            'status' => 'publish',
            'posts_per_page' => -1,
            's' => $_REQUEST['search'],
            'fields' => 'ids',
        );
        if ($_REQUEST['search'] && $_REQUEST['search'] != '') {
            $args['s'] = $_REQUEST['search'];
        }
        $searched_result = get_posts($args);
        foreach ($searched_result as $id) {
            $product = wc_get_product((int) $id);
            $product_id = $product->get_id();
            $image =  wp_get_attachment_image_src( get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail' );
            $json[] = [
                'id' => $product->get_id(),
                'text' => $product->get_name() . ' #' . $product->get_id() . ' (' . $product->get_type() . ')',
                  'image' => $image[0] ,
            ];
        }
        if ($pro == 'pro') {
            return $json;
        }
        $json[] = $searched_result;
        echo json_encode($json);
        die();
    }

    function load_category_search($pro = '') {
        $json = [];

        $args = array(
            'taxonomy' => "product_cat",
            'hide_empty' => true,
        );
        if ($_REQUEST['search'] && $_REQUEST['search'] != '') {
            $args['search'] = $_REQUEST['search'];
        }

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
