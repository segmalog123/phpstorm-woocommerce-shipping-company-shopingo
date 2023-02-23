  jQuery(document).ready(function ($) {
	'use strict';  
        
        
        
    
        
        
        
        
        
        
        
        
        
        
        
        
        
        /************Analytics**************/
        
      $('body').on('click','.btn-process-search',function(){
        
          var formData = $('.profit-main-form').find("textarea, input").serialize()
          formData += '&profit_product_shipping_company='+$('.profit_product_shipping_company').val()
          formData += '&profit_product_category='+$('.profit_product_category').val()
          formData += '&profit_product_list='+$('.profit_product_list').val()
           formData += '&profit_product_source_order='+$('.profit_product_source_order').val()
          
          $("body").loading({ message: "...." })
           $.ajax({
                            url: ajaxurl,
                             type: "POST",
                             dataType: "json",
                             data: {
                             action: "process_company_analytics",
                             function: "main-search",
                              formdata:  formData

                          },
                         success: function(dataresp) {
                             console.log(dataresp)
                             $("body").loading("stop");
                             $('.profit_total_orders').html(dataresp.profit_total_orders)
                             $('.profit_cout_order_fb').html(dataresp.profit_cout_order_fb)
                             $('.profit_total_valide').html(dataresp.profit_total_valide)
                              $('.profit_total_completed').html(dataresp.profit_total_completed)
                              $('.profit_total_product_vendue').html(dataresp.profit_total_product_vendue)
                               $('.profit_total_moyen_cart').html(dataresp.profit_total_moyen_cart)
                               
                               /*******************/
                               
                                $('.profit_cout_all_products').html(dataresp.profit_cout_all_products)
                                $('.profit_total_charge_fix').html(dataresp.profit_total_charge_fix)
                                $('.profit_total_charge_transport').html(dataresp.profit_total_charge_transport)
                                $('.profit_total_charge_pub').html(dataresp.profit_total_charge_pub)
                                    
                                      /*******************/
                               
                                $('.profit_total_pickup').html(dataresp.profit_total_pickup)
                                $('.profit_chiffre_affaire').html(dataresp.profit_chiffre_affaire)
                                $('.profit_net_real').html(dataresp.profit_net_real)
                                $('.profit_net_estime').html(dataresp.profit_net_estime)
                                
                                  /*******************/
                               
                                $('.profit_pourcent_pub').html(dataresp.profit_pourcent_pub)
                                $('.profit_pourcent_transport').html(dataresp.profit_pourcent_transport)
                                $('.profit_pourcent_fix').html(dataresp.profit_pourcent_fix)
                                $('.profit_prix_vente_produit_ttc').html(dataresp.profit_prix_vente_produit_ttc)
                                $('.profit_prix_achat_ttc').html(dataresp.profit_prix_achat_ttc)
                                
                                /***************/
                                $('.profit_charge_pub_value').html(dataresp.profit_charge_pub_value)
                                 $('.profit_charge_transport_value').html(dataresp.profit_charge_transport_value)
                             $('.profit_charge_fix_value').html(dataresp.profit_charge_fix_value)
                             /********************/
                             $('.profit_total_charge_produit').html(dataresp.profit_total_charge_produit)
                             
                              $('.profit_net_produit').html(dataresp.profit_net_produit)
                             
                             $('.profit_percent_cancelled').html(dataresp.profit_percent_cancelled)
                             $('.profit_percent_return').html(dataresp.profit_percent_return)
                             
                             $('.profit_net_produit_percent').html(dataresp.profit_net_produit_percent)
                             
                              $('.profit_net_estime_percent').html(dataresp.profit_net_estime_percent)
                             
                         
                             
                         } ,error: function(jqXHR, exception) {
            if (jqXHR.status === 401) {
                console.log('HTTP Error 401 Unauthorized.');
            } else {
                 console.log(  jqXHR);
            }
        }
                     })
      })  
        
        
         $('.profit_product_source_order').select2({
              placeholder:"Source Commande",
            theme: "bootstrap"
        })
        $('.profit_product_shipping_company').select2({
              placeholder:"Société de livraison",
            theme: "bootstrap"
        })
    $('#date-range-picker-pickup').dateRangePicker({autoClose: true})
    $('#date-range-picker-order').dateRangePicker({autoClose: true})
 
  var selectCategory = $('.profit_product_category').select2({
      placeholder:"Touts les Catégorie",
        minimumInputLength: 1,
       theme: "bootstrap",
           ajax: {
            url: ajaxurl,
            dataType: 'json',
            data: function (a) {
                return {
                    action: "process_company_analytics",
                    function: "load_category",
                    search: a.term,
                    page: a.page || 1
                }
            },
            processResults: function (e) {
                console.log(e)
                return {
                    results: e
                }
            }
        }
    });
        
        $('.profit_product_list').select2({
      placeholder:"Touts les Produits",
        minimumInputLength: 1,
        width:"100%",
       theme: "bootstrap",
           ajax: {
            url: ajaxurl,
            dataType: 'json',
            data: function (a) {
                return {
                    action: "process_company_analytics",
                    function: "load_product",  
                    search: a.term,
                    page: a.page || 1
                }
            },
            processResults: function (e) {
                console.log(e)
                return {
                    results: e
                }
            }
        }
    });
        
        
        
        
        
        
        
        
        
        
        
         /************Analytics**************/
     }) 