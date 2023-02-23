<h1><?php echo __('Company Statistics', $this->plugin_name) ?></h1>
<div id="statisticsapp">
    <v-app   v-cloak style="background: transparent">
        <v-main>
            <v-container fluid>
                <v-row>
                    <v-col cols="12" sm="8">
                        <v-card class="pa-3">
                            <h2> Indicateurs clés</h2>
                            <div class="d-flex justify-space-around flex-md-row flex-column">
                                <v-alert color="blue darken-4" class="text-center mr-3"    prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                         {{resData.profit_total_orders}}
                                    
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Nombre <br>de Commande</small>
                                </v-alert>
                                <v-alert color="blue darken-4" class="text-center mr-3"   prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                        {{resData.profit_cout_order_fb}}
                                    
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Cout <br>Commande</small>
                                </v-alert>
                                
                                  
                                  <v-alert color="blue darken-1" class="text-center mr-3"    prominent 
                                            border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                        {{resData.nombre_article}}
                                    
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Nombre <br>Articles</small>
                                </v-alert>
                                <v-alert color="blue darken-1" class="text-center mr-3 "  
                                         prominent   border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                         {{resData.cout_article}}
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Cout <br>Article</small>
                                </v-alert>
                                <v-alert color="blue darken-4" class="text-center mr-3 "    prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                         {{resData.nombre_product_solde_valide}}
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Quantité Moyen <br>d'Article par Panier</small>
                                </v-alert>
                      
                            </div>
                            <div class="d-flex justify-center flex-md-row flex-column">    
                                      
<!--   <v-alert color="blue-grey darken-2" class="text-center mr-3"     prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                        {{resData.charge_par_article}}
                                        
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Charge <br>Par Article</small>
                                </v-alert>-->
                                
<!--                                 <v-alert color="teal" class="text-center mr-3"   prominent border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0">
                                         {{resData.profit_net_real}}
                                    
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Profit <br>Net Réel</small>
                                </v-alert>-->

<v-alert color="green"  class="text-center mr-3"   prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                    
                                    {{resData.profit_estime_new}}
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Profit Estimé</small>
                                </v-alert> 
<v-alert color="green"  class="text-center mr-3"   prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                    
                                    {{resData.profit_estime_par_article}}
                                    </h1>
    <small class="ma-0 pa-0 white--text "> Profit Estimé <br> Par Article</small>
                                </v-alert> 
                                 
<!--                                     <v-alert color="green"  class="text-center mr-3"   prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                    
                                    {{resData.net_real_percent}}
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Pourcentage Rélle</small>
                                </v-alert>  -->

                                
                            </div>
<!--                            <div class="d-flex justify-center flex-md-row flex-column">       
 
                                 <v-alert color="blue-grey darken-2" class="text-center mr-3"   prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                        {{resData.charge_par_article_estime}}
                                        
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Charge <br>Par Article Estimé</small>
                                </v-alert>
                                
                                
                                
                                
                               
                                <v-alert color="green"  class="text-center mr-3 "    prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                    
                                    {{resData.profit_net_estime}}
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Profit <br>Net Estimé</small>
                                </v-alert>
                                
                                
                                    <v-alert color="green" class="text-center mr-3 "   prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                    
                                    {{resData.profit_net_estime_percent}}
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Pourcentage Estimé</small>
                                </v-alert> 
                            </div>
                         -->
                        </v-card>
                        
                        <v-card class="mt-3 pa-3">
                            
                             <h2> Commande</h2>
                             <div class="d-flex justify-space-around flex-md-row flex-column">
                               <v-alert color="purple darken-4" class="text-center mr-3"   prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0">
                                         
                                        {{resData.profit_total_valide}}
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Validée</small>
                                </v-alert>
                             <v-alert color="purple darken-4" class="text-center mr-3"    prominent   border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0">
                                        {{resData.profit_total_completed}}
                                        </h1>
                                    <small class="ma-0 pa-0 white--text "> Terminée</small>
                                </v-alert>
                                   <v-alert color="purple darken-4" class="text-center mr-3"   prominent  border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                        {{resData.profit_total_product_vendue}}
                                         </h1>
                                    <small class="ma-0 pa-0 white--text "> Articles Vendues</small>
                                </v-alert>
<!--                             <v-alert color="cyan" class="text-center mr-3"  icon="mdi-cart-arrow-down" prominent  type="success" border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                    
                                        {{resData.profit_percent_cancelled}}
                                    </h1>
                                 
                               
                                    <small class="ma-0 pa-0 white--text "> Taux Annulation</small>
                                </v-alert>-->
<div class="d-flex flex-column  text-center">

                                   <v-progress-circular
                                         :rotate="360"
                                            :size="100"
                                            :width="15"
                                            :value="resData.profit_percent_cancelled"
                                            color="red"
                                          >
                                           <h1>  {{ resData.profit_percent_cancelled }}% </h1>
                                          </v-progress-circular>
    <small class="ma-0 pa-0  "> Taux Annulation</small>
</div>
 <div class="d-flex flex-column text-center">
                               
                                    <v-progress-circular
                                         :rotate="360"
                                            :size="100"
                                            :width="15"
                                            :value="resData.profit_percent_return"
                                            color="red"
                                          >
                                        <h1>{{ resData.profit_percent_return }}%</h1>
                                          </v-progress-circular>
       <small class="ma-0 pa-0  "> Taux Retour</small>
                                   
                             </div>             
<!--                             <v-alert color="cyan" class="text-center mr-3"  icon="mdi-cart-arrow-down" prominent  type="success" border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                    
                                        {{resData.profit_percent_return}}
                                    </h1>
                                 
                                
                                 
                                 
                                    <small class="ma-0 pa-0 white--text "> Taux Retour</small>
                                </v-alert>-->
                             </div>
                        </v-card>
                        
                           <v-card class="mt-3 pa-3">
                             <h2> Charge</h2>
                            <div class="d-flex justify-space-around flex-md-row flex-column">
                                   <v-alert color="blue-grey darken-2" class="text-center mr-3"   prominent  border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                        {{resData.profit_total_charge_pub}}
                                        
                                    </h1>
                                    <small class="ma-0 pa-0 white--text "> Total <br>Charge Pub</small>
                                </v-alert>
                               <v-alert color="red darken-4" class="text-center mr-3"    prominent    border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0"> 
                                          {{resData.profit_cout_all_products}}
                                        
                                         </h1>
                                    <small class="ma-0 pa-0 white--text "> Cout Achat Produits</small>
                                </v-alert>
                                  <v-alert color="red darken-4" class="text-center mr-3"   prominent  border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0">
                                        
                                          {{resData.profit_total_charge_transport}}
                                         </h1>
                                    <small class="ma-0 pa-0 white--text "> Charge Transport</small>
                                </v-alert>
                                
                                
                                
                                   <v-alert color="red darken-4" class="text-center mr-3"    prominent  border="bottom" >

                                    <h1 class="white--text text-h3 font-weight-bold ma-0">
                                        
                                          {{resData.profit_total_charge_fix}}
                                         </h1>
                                    <small class="ma-0 pa-0 white--text "> Charge Fix</small>
                                </v-alert>
                                
                                
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-card  class="pa-3 text-center">
                            <v-radio-group
                                v-model="filterData.dateBy"
                                row
                                >
                                <v-radio
                                    label="Date Commande"
                                    value="commande"
                                    ></v-radio>
                                <v-radio
                                    label="Date PickUp"
                                    value="pickup"
                                    ></v-radio>
                            </v-radio-group>


                            <div class="d-flex">



                                <v-menu
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="dateStart"
                                            label="De"
                                            prepend-icon="mdi-calendar"
                                            v-bind="attrs"
                                            v-on="on"
                                            outlined
                                            dense
                                            ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        locale="fr-fr"
                                        v-model="dateStart"
                                        @input="menu = false"
                                        ></v-date-picker>
                                </v-menu> 






                                <v-menu
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-left="100"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"

                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            outlined
                                            dense
                                            v-model="dateEnd"
                                            label="Au"

                                            v-bind="attrs"
                                            v-on="on"
                                            ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        locale="fr-fr"
                                        v-model="dateEnd"
                                        @input="menu2 = false"
                                        ></v-date-picker>
                                </v-menu>







                            </div>











                            <v-row>
                                <v-col>
                               <v-text-field
                                prepend-icon="mdi-facebook"
                                dense
                                outlined
                                label="USD"
                                v-model="filterData.soldePubUSD"
                                >


                            </v-text-field>
                                </v-col>
                                <v-col>
                            <v-text-field
                                
                                dense
                                outlined
                                label="Euro"
                                v-model="filterData.soldePubEuro"
                                >


                            </v-text-field>
                                </v-col>
                            </v-row>
                            
                              <v-text-field
                                
                                dense
                                outlined
                                label="Marge"
                                v-model="filterData.marge"
                                >


                            </v-text-field>
                            
                            <v-autocomplete
                                prepend-icon="mdi-format-list-text"
                                v-model="filterData.selectedCat"
                                :items="categories"
                                label="Catégories"
                                multiple
                                outlined
                                dense
                                item-text="text"
                                item-value="id"
                                 clearable
                                chips
                                 small-chips
                                ></v-autocomplete>


                            <v-autocomplete
chips
 small-chips
                                
                                multiple
                                dense
                                v-model="filterData.selectedProduct"
                                :items="resProducts"
                           
                                clearable
                                outlined
                                hide-selected
                                item-text="text"
                                item-value="id"
                                label="Produits"
                                placeholder="Commencer a écrire pour rechercher"
                                prepend-icon="mdi-database-search"

                                 
                                >
                            
                             <template v-slot:selection="data">
                <v-chip
                  v-bind="data.attrs"
                  :input-value="data.selected"
                  close
                  @click="data.select"
                  @click:close="remove(data.item)"
                >
                  <v-avatar left>
                    <v-img :src="data.item.image"></v-img>
                  </v-avatar>
                  {{ data.item.text }}
                </v-chip>
              </template>
              <template v-slot:item="data">
                <template v-if="typeof data.item !== 'object'">
                  <v-list-item-content v-text="data.item"></v-list-item-content>
                </template>
                <template v-else>
                  <v-list-item-avatar>
                    <img :src="data.item.image">
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title v-html="data.item.text"></v-list-item-title>
                
                  </v-list-item-content>
                </template>
              </template>
                            </v-autocomplete>

                            <v-select
                                clearable
                                chips
                                 small-chips
                          item-text="company_label"
                                item-value="company_slug"
                                outlined
                                dense
                                :items="listCompany"
                                v-model="filterData.selectedCompany"
                                label="Société de livraison"
                                prepend-icon="mdi-office-building"
                                >
                                
                            </v-select>
                            
                            
                            
                            
<!--                             <v-select
                                 multiple
                                clearable
                                chips
                                 small-chips 
                                outlined
                                dense
                                :items="listSource"
                                v-model="filterData.selectedSource"
                                label="Source Commande"
                                prepend-icon="mdi-office-building"
                                 item-text="label"
                                item-value="value"
                                >
                                
                            </v-select>-->
                            
                            
<!--                         <v-select
                             multiple
                                clearable
                                chips
                                 small-chips 
                                outlined
                                dense
                                :items="listPage"
                                v-model="filterData.selectedPage"
                                label="Facebook Page"
                                prepend-icon="mdi-office-building"
                                >
                                
                            </v-select>-->
                            
                            
                            
                            
                            
                            
                            
                            
                            
                              <v-text-field
                                  
                                prepend-icon="mdi-label-percent"
                                dense
                                outlined
                                label="Pourcentage retour estimée"
                                v-model="filterData.retourPercent"
                                >


                            </v-text-field>
                            
<!--                             <v-text-field
                                  type="nomber"
                                prepend-icon="mdi-usd"
                                dense
                                outlined
                                label="Charge Fix"
                                v-model="filterData.fixCharge"
                                >


                            </v-text-field>-->
                            
                            <v-btn
                                large
                                dark
                                left
                                color="green"
                                @click="searchData"
                                >
                                <v-icon>mdi-check</v-icon>
                                Rechercher
                            </v-btn>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
               <v-overlay :value="overlay">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
        </v-main>
    </v-app>
</div>

<?php
wp_enqueue_script('company-analytics', WOOCOMMERCE_SHIPPING_COMPANY_URL . 'admin/js/company-analytics-pro.js',
        array('jquery'), $this->version, true);
?>