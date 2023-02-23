<?php

//Adding Custom Interval
add_filter( 'cron_schedules', 'cron_add_custom_intervals' );
function cron_add_custom_intervals( $schedules ) {
    // Adds two_hours to the existing schedules.
    $schedules['two_hours'] = array(
        'interval' => 7200,
        'display' => __( 'Once Two Hours' )
    );
    $schedules['three_hours'] = array(
        'interval' => 10800,
        'display' => __( 'Once Three Hours' )
    );
    return $schedules;
}

if (!wp_next_scheduled('cron_update_tracking_manifest')) {
    //  wp_schedule_event(time(), 'daily', 'cron_update_tracking');
    wp_schedule_event(strtotime('today 3am'), 'three_hours', 'cron_update_tracking_manifest', ['wc-manifest']);
     /* wp_schedule_event(strtotime('today 5am'), 'daily', 'cron_update_tracking_manifest', ['wc-manifest']);
        wp_schedule_event(strtotime('today 5am'), 'daily', 'cron_update_tracking_manifest', ['wc-manifest']);
          wp_schedule_event(strtotime('today 6am'), 'daily', 'cron_update_tracking_manifest', ['wc-manifest']);*/
}
if (!wp_next_scheduled('cron_update_tracking_anomalie')) {
    wp_schedule_event(strtotime('today 8am'), 'two_hours', 'cron_update_tracking_anomalie', ['wc-anomalie']);
       /*wp_schedule_event(strtotime('today 10am'), 'daily', 'cron_update_tracking_anomalie', ['wc-anomalie']);
          wp_schedule_event(strtotime('today 1pm'), 'daily', 'cron_update_tracking_anomalie', ['wc-anomalie']);
             wp_schedule_event(strtotime('today 3pm'), 'daily', 'cron_update_tracking_anomalie', ['wc-anomalie']);
                wp_schedule_event(strtotime('today 5pm'), 'daily', 'cron_update_tracking_anomalie', ['wc-anomalie']);
                    wp_schedule_event(strtotime('today 8pm'), 'daily', 'cron_update_tracking_anomalie', ['wc-anomalie']);*/
}
if (!wp_next_scheduled('cron_update_tracking_livraison')) {
    wp_schedule_event(strtotime('today 9am'), 'two_hours', 'cron_update_tracking_livraison', ['wc-en-livraison']);
    /* wp_schedule_event(strtotime('today 11am'), 'daily', 'cron_update_tracking_livraison', ['wc-en-livraison']);
      wp_schedule_event(strtotime('today 2pm'), 'daily', 'cron_update_tracking_livraison', ['wc-en-livraison']);
       wp_schedule_event(strtotime('today 4pm'), 'daily', 'cron_update_tracking_livraison', ['wc-en-livraison']);
         wp_schedule_event(strtotime('today 7pm'), 'daily', 'cron_update_tracking_livraison', ['wc-en-livraison']);*/
}
if (!wp_next_scheduled('cron_update_tracking_pickup')) {
    wp_schedule_event(strtotime('today 10am'), 'three_hours', 'cron_update_tracking_pickup', ['wc-pick-up']);
      /*wp_schedule_event(strtotime('today 2pm'), 'daily', 'cron_update_tracking_pickup', ['wc-pick-up']);
       wp_schedule_event(strtotime('today 5am'), 'daily', 'cron_update_tracking_pickup', ['wc-pick-up']);
          wp_schedule_event(strtotime('today 6am'), 'daily', 'cron_update_tracking_pickup', ['wc-pick-up']);*/
}



//wp_schedule_event(strtotime('tomorrow 1am'), 'daily', 'cron_update_tracking');
//   add_action('sanitize_comment_cookies', 'run_cron_functions_hourly');


add_action('cron_update_tracking_manifest', 'run_cron_functions_hourly');
add_action('cron_update_tracking_anomalie', 'run_cron_functions_hourly');
add_action('cron_update_tracking_livraison', 'run_cron_functions_hourly');
add_action('cron_update_tracking_pickup', 'run_cron_functions_hourly');

function run_cron_functions_hourly($status) {
    try {
        update_tracking_hourly($status);
    } catch (Exception $e) {
        d($e);
    }
}

function update_tracking_hourly($status = '') {
    $args = array(
        'post_type' => 'shop_order',
        'post_status' => $status,
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => array(
            array(
                'key' => '_shipment_number_id',
                'value' => '',
                'compare' => '!='
            )
        )
    );
    $orders = get_posts($args);

    $i = 0;
    if (isset($orders) && !empty($orders)) {
        shuffle($orders);
        
        
        $ch = curl_init();
        
             
   
        foreach ($orders as $order_id) {
            $order = wc_get_order((int) $order_id);
            $ship_number = get_post_meta($order->get_id(), '_shipment_number_id', true);
            $company = get_post_meta($order->get_id(), '_shipment_company_name', true);
            $data_company = get_ship_company($company);

            if (isset($ship_number) && $ship_number != '') {
                try {
                    if ($company == 'aramex') {
                        //  aramex_update_order_status($order,$ship_number);
                    } else {
                         
             
                        curl_setopt($ch, CURLOPT_URL,"https://administrateur.targuiexpress.com/WebServiceExterne/tracking_position/".$ship_number);

                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $server_output = curl_exec($ch);

                         company_update_order_status($order, $ship_number, $data_company,$server_output);
                    }
                } catch (Exception $e) {
//                    d($e);
//                    $fh = fopen('crondefault.txt', 'w') or die("Can't open file.");
//                    $results = print_r($e . '///', true);
//                    fwrite($fh, $results);
//                    fclose($fh);
                }
            }
            if ($i >= 200)
                break;
            $i++;
//              s
        }
        curl_close ($ch);
    }
}

function company_update_order_status($order, $ship_number, $data_company,$server_output='') {
    $datatrack = [];

    $i = 0;



    if ($ship_number != '') {

//        $datatrack = json_decode(company_get_action('tracking_position', [$ship_number], false,
//                        get_post_meta($data_company['company_id'], 'wsc_company_end_point', true)));

        $datatrack = json_decode($server_output);

        $event_id = [];
        if (isset($datatrack->evenements) && $datatrack->evenements) {
            foreach ($datatrack->evenements as $eve) {
                $event_id[] = $eve->eventid;
                if ($eve->eventid == '25') {
                    $datet = date("Y-m-d", ((int) preg_replace('/[^0-9.]+/', '', $eve->date) / 1000));
                }
                if ($eve->eventid == '30') {
                    $dater = date("Y-m-d", ((int) preg_replace('/[^0-9.]+/', '', $eve->date) / 1000));
                }
                if ($eve->eventid == '4') {
                    $datep = date("Y-m-d", ((int) preg_replace('/[^0-9.]+/', '', $eve->date) / 1000));
                }
            }
        }
        $counts = array_count_values($event_id);
        if ($counts && !empty($counts)) {
            $ten = 0;
            if (isset($counts['30'])) {
                if ((int) $counts['30'] >= 1)
                    $ten += (int) $counts['30'];
            }
            if (isset($counts['20'])) {
                if ((int) $counts['20'] >= 1)
                    $ten += (int) $counts['20'];
            }
            if ($ten != 0) {
                update_post_meta($order->get_id(), '_order_tentative_number', $ten);
            }
        }

        if (in_array('25', $event_id)) {
            $order->update_status('completed', 'Commande modifie en terminé depuis CRONJOB');
            if ($datet != '') {
                update_post_meta($order->get_id(), '_order_date_delivred', $datet);
            }
        } elseif (in_array('30', $event_id)) {
            $order->update_status('retour', 'Commande modifie en anomalie de livraison depuis CRONJOB');

            if ($dater != '') {
                update_post_meta($order->get_id(), '_order_date_delivred', $dater);
            }
        } else if (in_array('20', $event_id)) {
            $order->update_status('anomalie', 'Commande modifie en anomalie de livraison depuis CRONJOB');
        } else if (in_array('18', $event_id)) {
            $order->update_status('en-livraison', 'Commande modifie en cours de livraison depuis CRONJOB');

//                        $upload_dir = wp_upload_dir();
//                        $path = $upload_dir['basedir'] . '/wsc_files_orders/orders/' . $order->get_id();
//
//                        delete_folder_pdf($path . '/*');
//                        rmdir($path);
        } else if (in_array('4', $event_id)) {
            $order->update_status('pick-up', 'Commande modifie en Pickup depuis CRONJOB');

            if ($datep != '') {
                update_post_meta($order->get_id(), '_order_date_pickup', $datep);
            }
        }
    }

    // return $event_id;
}
