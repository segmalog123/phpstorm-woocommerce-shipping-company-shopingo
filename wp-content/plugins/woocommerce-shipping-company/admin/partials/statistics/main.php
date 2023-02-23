<?php   
  wp_enqueue_style('bootstrapcss', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/css/bootstrap.min.css');
            wp_enqueue_style('select2-min', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/css/select2.min.css');
            wp_enqueue_style('select2-bootstrap', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/css/select2-bootstrap.css');
            wp_enqueue_style('pmd-select2', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/css/pmd-select2.css');
            wp_enqueue_style('propellercss', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/css/propeller.min.css');
            wp_enqueue_style('googleapisfontscss', 'https://fonts.googleapis.com/icon?family=Material+Icons');

            wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css');
              wp_enqueue_style('daterangepicker', WOOCOMMERCE_SHIPPING_COMPANY_URL .
                'assets/css/daterangepicker.min.css');
 ?>
<h1><?php echo __('Company Statistics',$this->plugin_name) ?></h1>
<div class="profit-main-form">
    <input name="profit_analytics_page" type="hidden" value="analytics">
<div class="pmd-card pmd-z-depth">
    <div class="pmd-card-body">	
        <div class="row"  >
            <div class="col-sm-12">
                <div class="form-group pmd-textfield  ">
                      <div class="input-group">
                        <div class="input-group-addon">
                            <i class="material-icons  pmd-sm">format_list_bulleted</i></div>

                <select class=" form-control pmd-select2 profit_product_list" multiple="" name="profit_product_list">
                            <option value="all">Touts les Produits</option>
                        </select>  
                      </div>
                </div>
                </div>
       
            <div class="col-sm-3">
            
                <div class="form-group pmd-textfield  ">
                     <div class="input-group">
                        <div class="input-group-addon">
                            <i class="material-icons  pmd-sm">format_list_bulleted</i></div>

                        <select class=" form-control pmd-select2 profit_product_category" multiple="" name="profit_product_category">
                            <option value="all">Touts les Catégorie</option>
                        </select>                   
                    </div>
                </div>
            </div>


            <div class="col-sm-2">
                <div class="form-group pmd-textfield  ">
                     <div class="input-group">
                        <div class="input-group-addon">
                            <i class="material-icons  pmd-sm">local_shipping</i></div>

                            <select class=" form-control pmd-select2 profit_product_shipping_company" multiple=""  
                                    name="profit_product_shipping_company">
                            <option value="all">Touts les sociétes</option>
                            <?php
                            foreach (get_ship_company() as $k => $comp) {
                                echo '<option value="' . $k . '">' . $comp['company_label'] . '</option>';
                            }
                            ?>
                        </select>	
                    </div></div>
            </div>
  <div class="col-sm-2">
               <select class=" form-control pmd-select2 profit_product_source_order" multiple=""  
                   name="profit_product_source_order">
                   <option value="all">Touts</option> 
                   <option value="siteweb">SiteWeb</option> 
                   <option value="fb">FaceBook</option> 
                   <option value="tel">Téléphone</option> 
               </select>  
            </div>
            
            <div class="col-sm-2">
                <div class="form-group pmd-textfield">
                     <div class="input-group">
                        <div class="input-group-addon"><i class="material-icons  pmd-sm">date_range</i></div>
                        <input placeholder="Date Commande" name="profit_product_date_order" type="text" class="form-control"
                               id="date-range-picker-order"> 
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group pmd-textfield">
                     <div class="input-group">
                        <div class="input-group-addon"><i class="material-icons  pmd-sm">date_range</i></div>
                        <input placeholder="Date Pickup" name="profit_product_date_pickup" type="text" class="form-control" 
                               id="date-range-picker-pickup" > 
                    </div>
                </div>
            </div>
       
           
            <div class="col-sm-2">
               
        <div class="form-group pmd-textfield pmd-textfield-floating-label form-group-sm">
                <label for="Small">Charge Fixe</label>
                <input name="profit_product_fix_charge" value="0" type="text" id="Small" class="form-control"> 
        </div>
            </div>
         <div class="col-sm-2">
                <div class="form-group pmd-textfield">
                    <label for="inputError1" class="control-label pmd-input-group-label">Charge Publicité</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fab fa-facebook "></i></div>
                        <input name="profit_product_fb_cost" value="100" type="text" class="form-control "> 

                    </div>
                    <label class="radio-inline pmd-radio">
                        <input type="radio" checked="" name="profit_product_fb_cost_currency" id="inlineRadio3" value="EUR" class="pm-ini"><span class="pmd-radio-label">&nbsp;</span>
                        <span for="inlineRadio3">EUR</span> </label>
                    <label class="radio-inline pmd-radio">
                        <input type="radio" name="profit_product_fb_cost_currency" id="inlineRadio3" value="USD" class="pm-ini"><span class="pmd-radio-label">&nbsp;</span>
                        <span for="inlineRadio3">USD</span> </label>
                </div>
            </div>
          

        </div>
    </div>
</div>
<div class="col-md-2 col-sm-6 ">

    <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth  ">

        <div class="pmd-card-media">
            <div class="media-body">
                <i class="material-icons  pmd-md">shopping_cart</i><br>
                <span class="pmd-card-title-text">Commande</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_orders"  >0 </span>
            </div>
        </div>

    </div>  
</div>
<div class="col-md-2 col-sm-6 ">

    <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-info ">

        <div class="pmd-card-media">
            <div class="media-body">
                <i class="material-icons  pmd-md">monetization_on</i><br>
                <span class="pmd-card-title-text">Cout</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_cout_order_fb"   style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
<div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-info">
         <div class="pmd-card-media">
            <div class="media-body">
                <i class="material-icons  pmd-md">spellcheck</i><br>
                <span class="pmd-card-title-text">Validée</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_valide" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
<div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                <i class="material-icons  pmd-md">done_all</i><br>
                <span class="pmd-card-title-text">Terminée</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_completed" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
<div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                <i class="material-icons  pmd-md">playlist_add_check</i><br>
                <span class="pmd-card-title-text">Articles Vendus</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_product_vendue" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
<div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
<i class="material-icons  pmd-md">shopping_basket</i><br>       
<span class="pmd-card-title-text">Panier Moyen</span><br>
<small>(sans trasport)</small>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_moyen_cart" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
    
 <div class="col-md-12 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth ">
         <div class="pmd-card-media"></div>   
     </div>
 </div>
    
    <!------------------------------------------------------------------------->
     <!------------------------------------------------------------------------->
      <!------------------------------------------------------------------------->
       <!------------------------------------------------------------------------->
     
    
       <div>
<div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Cout Achats Produits</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_cout_all_products" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
    
    <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Total Charge fixe</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_charge_fix" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
    
    
    
        <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Total Charge Transport</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_charge_transport" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
    
    
      <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Total Charge Pub(dt)</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_charge_pub" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
           
           <div class="col-md-2 col-sm-6 text-center">
               <div class="circle">
        <div id="circles-1"><div class="circles-wrp" style="position: relative; display: inline-block;">
                <svg xmlns="http://www.w3.org/2000/svg" width="100"
                                                                                                             height="100">
                <path fill="transparent" stroke="#dfe3e7" stroke-width="7"
                      d="M 49.99052919602818 3.500000964474502 A 46.5 46.5 0 1 1 49.93541243287967 3.5000448554391212 Z" 
                      class="circles-maxValueStroke"></path><path fill="transparent" stroke="#f79332" stroke-width="7" 
                      d="M 49.99052919602818 3.500000964474502 A 46.5 46.5 0 0 1 92.05112512242934 30.151753832194853 " 
                      class="circles-valueStroke"></path></svg>
                <div class="circles-text" style="position: absolute; top: 0px; left: 0px; text-align: center; width: 
                     100%; font-size: 25px; height: 100px; line-height: 100px;">
                    <span class="circles-integer profit_percent_cancelled">0</span></div></div></div>
        <div class="source-semibold text-center chart-title">Annulation</div>
</div>
           </div>
           <div class="col-md-2 col-sm-6 text-center">
               <div class="circle">
<div id="circles-1"><div class="circles-wrp" style="position: relative; display: inline-block;"><svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><path fill="transparent" stroke="#dfe3e7" stroke-width="7" d="M 49.99052919602818 3.500000964474502 A 46.5 46.5 0 1 1 49.93541243287967 3.5000448554391212 Z" class="circles-maxValueStroke"></path><path fill="transparent" stroke="#f79332" stroke-width="7" d="M 49.99052919602818 3.500000964474502 A 46.5 46.5 0 0 1 92.05112512242934 30.151753832194853 " class="circles-valueStroke"></path></svg><div class="circles-text" style="position: absolute; top: 0px; left: 0px; text-align: center; width: 100%; font-size: 25px; height: 100px; line-height: 100px;">
            <span class="circles-integer profit_percent_return">0</span></div></div></div>
<div class="source-semibold text-center chart-title">Retour</div>
							</div>
           </div>
       </div>
 <div class="col-md-12 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth ">
         <div class="pmd-card-media"></div>   
     </div>
 </div>
    
    <!------------------------------------------------------------------------->
     <!------------------------------------------------------------------------->
      <!------------------------------------------------------------------------->
       <!------------------------------------------------------------------------->
     
       <div>
    
<div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Total Pickup</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_pickup" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
  
    
    
        <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Chiffre d'Affaire</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_chiffre_affaire" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
    
    
      <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Profit Net Réelle</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_net_real" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
           
           
             
    <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Profit Net Estimé</span>
                <br>
                <input name="profit_return_estimated" type="text" value="20" class="col-md-6 profit_return_estimated">
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_net_estime" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
        <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-info">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Pourcentage Estimé</span>
               </div>
            <div class="media-right">
                <span class="pmd-display1 profit_net_estime_percent" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
           
           
            <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-warning">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Profit Net / Produit</span>
               </div>
            <div class="media-right">
                <span class="pmd-display1 profit_net_produit" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
                  <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-info">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Pourcentage</span>
               </div>
            <div class="media-right">
                <span class="pmd-display1 profit_net_produit_percent" style="color:#fff">0 </span>
            </div>
        </div>

    </div> 
</div>
    
       </div> 
 <div class="col-md-12 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth ">
         <div class="pmd-card-media"></div>   
     </div>
 </div>
    
    <!------------------------------------------------------------------------->
     <!------------------------------------------------------------------------->
      <!------------------------------------------------------------------------->
       <!------------------------------------------------------------------------->
     
<div>
    
<div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">% Publicité</span><br>
                <span class="profit_charge_pub_value">0</span> DT
                
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_pourcent_pub" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
  
    
    
        <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">% Transport</span><br>
                <span class="profit_charge_transport_value">0</span> DT
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_pourcent_transport" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
    
    
      <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">% Fixe</span><br>
                <span class="profit_charge_fix_value">0</span> DT
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_pourcent_fix" style="color:#fff">0 </span>
            </div>
        </div>

    </div>  
</div>
       
   
             
    
    
       </div>
       
        <div class="col-md-12 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth ">
         <div class="pmd-card-media"></div>   
     </div>
 </div>
    
    <!------------------------------------------------------------------------->
     <!------------------------------------------------------------------------->
      <!------------------------------------------------------------------------->
       <!------------------------------------------------------------------------->
       <div>
           
           
            <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Prix de vente Produit TTC</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_prix_vente_produit_ttc" style="color:#fff">0 </span>
            </div>
        </div>

    </div> 
           
</div>
              <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Prix d'achat Produit TTC</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_prix_achat_ttc" style="color:#fff">0 </span>
            </div>
        </div>

    </div> 
           
</div>
      
            <div class="col-md-2 col-sm-6 ">
     <div class="pmd-card pmd-card-media-inline pmd-card-default pmd-z-depth btn-success">
         <div class="pmd-card-media">
            <div class="media-body">
                
                <span class="pmd-card-title-text">Total Charge / Produit</span>
             </div>
            <div class="media-right">
                <span class="pmd-display1 profit_total_charge_produit" style="color:#fff">0 </span>
            </div>
        </div>

    </div> 
           
</div>
           
        
       </div>
 
    </div>
<div class=" block-bottom-fixed">
                           <button class="btn btn-lg  pmd-btn-raised btn-primary btn-block pmd-ripple-effect btn-process-search" type="button">
                               <i class="fa fa-search"></i> RECHERCHER</button>

    </div>


<?php


    wp_enqueue_script('jquery12js', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/js/jquery-1.12.2.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script('bootstrapjs', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/js/bootstrap.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script('pmd-select2', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/js/pmd-select2.js', array('jquery'), $this->version, true);
            wp_enqueue_script('select2full', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/js/select2.full.js', array('jquery'), $this->version, true);
            wp_enqueue_script('propellerjs', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'assets/js/propeller.min.js', array('jquery'), $this->version, true);

             wp_enqueue_script('moment-script', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js');
        wp_enqueue_script('daterangepicker-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-date-range-picker/0.20.0/jquery.daterangepicker.min.js', array('jquery'));
 wp_enqueue_script('jquery.loading',  WOOCOMMERCE_SHIPPING_COMPANY_URL .  'assets/js/jquery.loading.min.js'); 
  wp_enqueue_script('company-analytics', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'admin/js/company-analytics.js', array('jquery'), $this->version, true);
