
<script type="text/x-template" id="printtpl" >
  <!-- v-if="post_status == 'wc-manifest'" -->
 <div v-if="post_status == 'wc-manifest' || post_status == 'wc-pick-up' "> 
 
    <v-menu
      v-for="(company,index) in listCompany"
      :key="index"
     open-on-hover
      offset-y 
    > 
      <template v-slot:activator="{ attrs, on }">
        <v-btn
       color="primary" small outlined tile
         class="  btn_action_order mr-2"
          v-bind="attrs"
          v-on="on"
        >
           {{company.company_label}}
        </v-btn>
      </template> 

      <v-list>
        <v-list-item
          v-for="(item,indexx) in company.items"
          :key="indexx"
          link
          @click="printOrder(item,company)" 
        >
          <v-list-item-title   v-text="item.label"></v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  
 
  <v-dialog
  ref="dialogtrack"
    style="z-index:9999999"
 
    width="900px" 
    v-model="dialog" 
    transition="dialog-bottom-transition" >
    
     
    <v-card>
    
    <v-toolbar
    height="50px" 
    dark 
    color="primary" 
     >
    
    <v-toolbar-title> {{title}}  </v-toolbar-title>
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
      
  <div class="wsc_pdf_preview"   >
        <object   data="" type="application/pdf" width="100%" height="500"></object>
    
 </div>

     
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