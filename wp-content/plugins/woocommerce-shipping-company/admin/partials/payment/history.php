 
 
<h1><?php echo __('Historique Payment',$this->plugin_name) ?></h1>
<div id="paymentapp">
    <v-app   v-cloak >
            <v-main>
       
                <v-data-table
 :item-class="itemRowBackground"
 
    dense
 
                    fixed-header
                    height="650px"
                    :headers="headers"
                    :items="items"
               
                    :footer-props="{ 'items-per-page-options': [100, 500, 1000,-1] }"
                    :items-per-page="100"
                 
              
                     >
                    <template v-slot:item.colis_tr="{ item }">
                        {{item.orders_tr.length}}
                        
                    </template>
                    
                    
                        <template v-slot:item.actions="{ item }">
                            <v-btn @click="validateTr(item)" v-if="item.status_tr == ''" outlined small>
                                <v-icon>mdi-check</v-icon> Vérifier
                            </v-btn>
                        
                    </template>
                    
                    
                    
                    
                    
                    
                    
                </v-data-table>
                  <v-overlay :value="overlay">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
                
                <confirm-component ref="confirm"></confirm-component>
    </v-main>
    </v-app>
</div>
 