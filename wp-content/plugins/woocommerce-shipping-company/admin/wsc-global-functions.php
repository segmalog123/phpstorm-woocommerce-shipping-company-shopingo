<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

  function get_trashed_order(){
         $argstrash = array(
                    'post_type' => 'shop_order',
                    'post_status' => array('trash'),
                    'posts_per_page' => -1,
                    'fields' => 'ids',
                    );
                $trash_ids = get_posts($argstrash);
                return $trash_ids;
   }
 
      function delete_folder_pdf($path = '') {
        $files = glob($path); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                unlink($file); // delete file
        }
    }
    
    
  function company_get_action($action,$params = [],$posttype = true,$endpoint = ''){
            $ch = curl_init();
            if($posttype){
            curl_setopt($ch, CURLOPT_URL,$endpoint."/".$action);
            
            curl_setopt($ch, CURLOPT_POST, 1);
            
            // In real life you should use something like:
             curl_setopt($ch, CURLOPT_POSTFIELDS, 
                      http_build_query($params));
            }else{
                 curl_setopt($ch, CURLOPT_URL,$endpoint."/".$action."/".$params[0]);
            }
            // Receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close ($ch);
            return $server_output;
        }
function get_ship_company($ship_company = '' ) {
     $array_ship_company=[];
      $args = [
                    'post_type' => 'wsc-companies',
                    'posts_per_page' => -1,
                    'post_status' => array('publish'),
                    'fields' => 'ids',
         ];
    
    $ids = get_posts($args);
 
    foreach ($ids as $id) {
         $array_ship_company[get_post_field( 'post_name', (int)$id )] = [
                'company_id' => $id,
                'company_slug' => get_post_field( 'post_name', (int)$id ),
                'company_label' => get_post_field( 'post_title', (int)$id ),
              ];
    }
    
 
        if ($ship_company != ''){
            return $array_ship_company[$ship_company];
        }

        return $array_ship_company;
    }
    
    
      function replace_special_carac($string = ''){
      $replace = [
    '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
    '&quot;' => '', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'Ae',
    '&Auml;' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'A', '??' => 'Ae',
    '??' => 'C', '??' => 'C', '??' => 'C', '??' => 'C', '??' => 'C', '??' => 'D', '??' => 'D',
    '??' => 'D', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E',
    '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'E', '??' => 'G', '??' => 'G',
    '??' => 'G', '??' => 'G', '??' => 'H', '??' => 'H', '??' => 'I', '??' => 'I',
    '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I', '??' => 'I',
    '??' => 'I', '??' => 'IJ', '??' => 'J', '??' => 'K', '??' => 'K', '??' => 'K',
    '??' => 'K', '??' => 'K', '??' => 'K', '??' => 'N', '??' => 'N', '??' => 'N',
    '??' => 'N', '??' => 'N', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O',
    '??' => 'Oe', '&Ouml;' => 'Oe', '??' => 'O', '??' => 'O', '??' => 'O', '??' => 'O',
    '??' => 'OE', '??' => 'R', '??' => 'R', '??' => 'R', '??' => 'S', '??' => 'S',
    '??' => 'S', '??' => 'S', '??' => 'S', '??' => 'T', '??' => 'T', '??' => 'T',
    '??' => 'T', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'Ue', '??' => 'U',
    '&Uuml;' => 'Ue', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U', '??' => 'U',
    '??' => 'W', '??' => 'Y', '??' => 'Y', '??' => 'Y', '??' => 'Z', '??' => 'Z',
    '??' => 'Z', '??' => 'T', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a',
    '??' => 'ae', '&auml;' => 'ae', '??' => 'a', '??' => 'a', '??' => 'a', '??' => 'a',
    '??' => 'ae', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c', '??' => 'c',
    '??' => 'd', '??' => 'd', '??' => 'd', '??' => 'e', '??' => 'e', '??' => 'e',
    '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e', '??' => 'e',
    '??' => 'f', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'g', '??' => 'h',
    '??' => 'h', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i',
    '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'i', '??' => 'ij', '??' => 'j',
    '??' => 'k', '??' => 'k', '??' => 'l', '??' => 'l', '??' => 'l', '??' => 'l',
    '??' => 'l', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n', '??' => 'n',
    '??' => 'n', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'oe',
    '&ouml;' => 'oe', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'o', '??' => 'oe',
    '??' => 'r', '??' => 'r', '??' => 'r', '??' => 's', '??' => 'u', '??' => 'u',
    '??' => 'u', '??' => 'ue', '??' => 'u', '&uuml;' => 'ue', '??' => 'u', '??' => 'u',
    '??' => 'u', '??' => 'u', '??' => 'u', '??' => 'w', '??' => 'y', '??' => 'y',
    '??' => 'y', '??' => 'z', '??' => 'z', '??' => 'z', '??' => 't', '??' => 'ss',
    '??' => 'ss', '????' => 'iy', '??' => 'A', '??' => 'B', '??' => 'V', '??' => 'G',
    '??' => 'D', '??' => 'E', '??' => 'YO', '??' => 'ZH', '??' => 'Z', '??' => 'I',
    '??' => 'Y', '??' => 'K', '??' => 'L', '??' => 'M', '??' => 'N', '??' => 'O',
    '??' => 'P', '??' => 'R', '??' => 'S', '??' => 'T', '??' => 'U', '??' => 'F',
    '??' => 'H', '??' => 'C', '??' => 'CH', '??' => 'SH', '??' => 'SCH', '??' => '',
    '??' => 'Y', '??' => '', '??' => 'E', '??' => 'YU', '??' => 'YA', '??' => 'a',
    '??' => 'b', '??' => 'v', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'yo',
    '??' => 'zh', '??' => 'z', '??' => 'i', '??' => 'y', '??' => 'k', '??' => 'l',
    '??' => 'm', '??' => 'n', '??' => 'o', '??' => 'p', '??' => 'r', '??' => 's',
    '??' => 't', '??' => 'u', '??' => 'f', '??' => 'h', '??' => 'c', '??' => 'ch',
    '??' => 'sh', '??' => 'sch', '??' => '', '??' => 'y', '??' => '', '??' => 'e',
    '??' => 'yu', '??' => 'ya','%'=>'','x'=>''
];
      
      return str_replace(array_keys($replace), $replace, $string);
}


         function get_post_code_gov($selected){
//Beja,BenArous,Bizerte,Gabes,Gafsa,Jendouba,Kairouan,Kasserine,Kebili,Kef,Mahdia,Mannouba,Medenine,Monastir,Nabeul,Sfax,SidiBouzid,Siliana,Sousse,Tataouine,Tozeur,Tunis,Zaghouan    }
            $gov = [
            'Zaghouan'  =>  '1100',
            'Tunis'	 =>    '1000',
            'Tozeur' 	=>     '2200',
            'Tataouine'  =>  '3200',
            'Sousse'    =>   '4004',
            'Sidi Bouzid'=>  '9100',
            'Sfax' 	  =>   '3000',
            'Siliana'	=>     '6100',
            'Nabeul'     =>  '8000',
            'Monastir'   =>  '5000',
            'M??denine'   =>  '4130',
            'Mannouba'    => '2010',
            'Mahdia'	=>     '5100',
            'Kef'	  =>   '7117',
            'K??bili'	   => '4200',
            'Kasserine' =>  '1200',
            'Kairouan'  =>   '3100',
            'Jendouba' =>    '8100',
            'Gafsa' 	=>     '2100',
            'Gab??s' 	=>     '6000',
            'Bizerte'   =>   '7000',
            'Ben Arous' =>  '2013',
            'B??ja'	   =>  '9000',
            'Ariana'	=>     '2080'
            ];
            
            return $gov[$selected];
        }
        
               function get_product_label($order){
        
          $products_name = '';
                $ref_product = '';
                $items = $order->get_items();
                $i = 1;
                foreach ($items as $item) {
                    
                    $p = wc_get_product($item->get_product_id());
                    if($p->get_type() == "variable"){
                        $p = wc_get_product($item->get_variation_id());
                    }
                    if($p)
                    {
                        $ugs = $p->get_sku();
                        
                       if($ugs != ''){
                           $ref_product = $ugs;
                       }else{
                           $ref_product = substr($item->get_name(), 0,50);
                       }
                           $products_name .= $ref_product.'('.$item->get_quantity().')';
                           if(count($items) > 1 && $i != count($items)){
                           $products_name .= ' et ';
                             } 
                         
                       
                    }
                    $i++;
                }
                
                return $products_name;
    }