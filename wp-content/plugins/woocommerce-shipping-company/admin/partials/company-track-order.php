
<script type="text/x-template" id="tracktpl" >
 
 <div>
  <v-dialog
  ref="dialogtrack"
    style="z-index:9999999"
 
    width="700px" 
    v-model="dialog" 
    transition="dialog-bottom-transition" >
    
     
    <v-card>
    
    <v-toolbar
    height="50px" 
    dark 
    color="primary" 
     > 
    
    <v-toolbar-title> Track Commande {{order_id}}</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items>  

    <v-btn 
    icon
    dark
    @click="dialog = false" 
    >
    <v-icon>mdi-close</v-icon>
    </v-btn>
    </v-toolbar-items>
    </v-toolbar> 


    <v-card-text>
    <v-row class="mt-3">
   
     <v-col  cols="12"   class="pt-0 pb-0 ">   
      
  
  <v-timeline>
  
 
    <v-timeline-item v-for="(item,index) in trackData" :key="index"  small
    :color="item.color"
      :icon="item.icon" fill-dot> 
    
    
     <span slot="opposite"><strong class="text--primary">{{toDateTime(Number(item.date.replace(/[^0-9]+/g, ""))/1000)}}</strong></span>
        <v-card  :color="item.color"
        dark class="elevation-2">
          <v-card-title  style="font-size:16px!important" class="text-h6 pt-0 pb-0">
             {{item.evenement}} 
             ({{item.eventid}})
          </v-card-title>
          <v-card-text class="  white text--primary">
         <span class="mt-3"> {{item.motif_anomalie}}</span>
           </v-card-text> 
        </v-card>
    
    
    
      
    </v-timeline-item>
    
  </v-timeline>

     
     </v-col>
     </v-row>
     </v-card-text>
</v-card>


</v-dialog>
 <snack-component ref="snack"></snack-component>
  <v-overlay :value="overlayloading"  z-index="99999999999999999999999" >
                        <v-progress-circular
                            indeterminate
                            size="64"
                            ></v-progress-circular>
                    </v-overlay>
</div>
    </script>