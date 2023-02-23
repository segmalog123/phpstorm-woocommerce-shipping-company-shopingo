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
    '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae',
    '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
    'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
    'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
    'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
    'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
    'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
    'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
    'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
    'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
    'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
    'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
    'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
    'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
    '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
    'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
    'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
    'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
    'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
    'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
    'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
    'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
    'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
    'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
    'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
    'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
    'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
    '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
    'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
    'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
    'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
    'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
    'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
    'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
    'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
    'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
    'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
    'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
    'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
    'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
    'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
    'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
    'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
    'ю' => 'yu', 'я' => 'ya','%'=>'','x'=>''
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
            'Médenine'   =>  '4130',
            'Mannouba'    => '2010',
            'Mahdia'	=>     '5100',
            'Kef'	  =>   '7117',
            'Kébili'	   => '4200',
            'Kasserine' =>  '1200',
            'Kairouan'  =>   '3100',
            'Jendouba' =>    '8100',
            'Gafsa' 	=>     '2100',
            'Gabès' 	=>     '6000',
            'Bizerte'   =>   '7000',
            'Ben Arous' =>  '2013',
            'Béja'	   =>  '9000',
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