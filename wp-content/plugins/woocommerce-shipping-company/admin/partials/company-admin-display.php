 
<table  class="wsc-admin-box">
    <tr  >
        <td  ><label><?php echo __('ENL CONTACT NOM',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_enl_contact_nom]"  type="text" value="<?php echo get_post_meta($post->ID,'wsc_enl_contact_nom',true) ?>"></td>
        
           <td  ><label><?php echo __('Company Username',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_company_username]"  type="text" value="<?php echo get_post_meta($post->ID,'wsc_company_username',true) ?>"></td>
        
    </tr>
    
      <tr  >
        <td ><label><?php echo __('ENL PORTABLE',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_enl_portable]"  type="text" value="<?php echo  get_post_meta($post->ID,'wsc_enl_portable',true) ?>"></td>
        
        
          <td  ><label><?php echo __('Company Password',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_company_password]"  type="password" value="<?php echo  get_post_meta($post->ID,'wsc_company_password',true) ?>"></td>
        
    </tr>
    
     <tr  >
        <td ><label><?php echo __('ENL CONTACT PRENOM',$this->plugin_name) ?></label></td>
        <td ><input name="wscdata[wsc_enl_contact_prenom]"  type="text" value="<?php echo  get_post_meta($post->ID,'wsc_enl_contact_prenom',true) ?>"></td>
        
        
          <td  ><label><?php echo __('Company Logo',$this->plugin_name) ?></label></td>
        <td ><input name="wscdata[wsc_company_logo]"   type="text" value="<?php  echo get_post_meta($post->ID,'wsc_company_logo',true) ?>"></td>
    </tr>
    
    
      <tr  >
        <td  ><label><?php echo __('ENL ADRESSE',$this->plugin_name) ?></label></td>
        <td ><input name="wscdata[wsc_enl_adress]"   type="text" value="<?php echo  get_post_meta($post->ID,'wsc_enl_adress',true) ?>"></td>
        
        
         <td  ><label><?php echo __('Company Shipping Cost',$this->plugin_name) ?></label></td>
        <td ><input name="wscdata[wsc_company_shipping_cost]"   type="text" value="<?php echo  get_post_meta($post->ID,'wsc_company_shipping_cost',true) ?>"></td>
    </tr>
    
    
      <tr  >
        <td ><label><?php echo __('ENL GOUV',$this->plugin_name) ?></label></td>
        <td ><input name="wscdata[wsc_enl_gouv]"  type="text" value="<?php  echo get_post_meta($post->ID,'wsc_enl_gouv',true) ?>"></td>
        
        
           <td  ><label><?php echo __('Company Token(API)',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_company_token]"  type="text" value="<?php  echo get_post_meta($post->ID,'wsc_company_token',true) ?>"></td>
    </tr>
  
    
     <tr  >
        <td ><label><?php echo __('ENL VILLE',$this->plugin_name) ?></label></td>
        <td ><input name="wscdata[wsc_enl_ville]"  type="text" value="<?php  echo get_post_meta($post->ID,'wsc_enl_ville',true) ?>"></td>
        
          <td  ><label><?php echo __('Company URL End Point(API)',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_company_end_point]"  type="text" value="<?php  echo get_post_meta($post->ID,'wsc_company_end_point',true) ?>"></td>
    </tr>
    
    
     <tr  >
        <td ><label><?php echo __('ENL CODE POSTAL',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_enl_code_postal]" type="text" value="<?php  echo get_post_meta($post->ID,'wsc_enl_code_postal',true) ?>"></td>
   
        
        
      <td  ><label><?php echo __('Header Bon de livraison',$this->plugin_name) ?></label></td>
      <td >
          
          <textarea  name="wscdata[wsc_header_bl]"  style="width: 100%;height: 100px" ><?php  echo trim(get_post_meta($post->ID,'wsc_header_bl',true)) ?></textarea>
          </td>

     
     
     </tr>
    
    
     <tr  >
        <td ><label><?php echo __('ENL MAIL',$this->plugin_name) ?></label></td>
        <td ><input name="wscdata[wsc_enl_mail]"   type="text" value="<?php  echo get_post_meta($post->ID,'wsc_enl_mail',true) ?>"></td>

         <td  ><label><?php echo __('Aramex Mode',$this->plugin_name) ?></label></td>
         <td ><input  name="wscdata[wsc_aramex_mode]"  type="text" value="<?php echo get_post_meta($post->ID,'wsc_aramex_mode',true) ?>"></td>
    </tr>

    <tr  >
        <td  ><label><?php echo __('Account Number',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_account_number]"  type="text" value="<?php echo get_post_meta($post->ID,'wsc_account_number',true) ?>"></td>

        <td  ><label><?php echo __('Account Pin',$this->plugin_name) ?></label></td>
        <td ><input  name="wscdata[wsc_account_pin]"  type="text" value="<?php echo get_post_meta($post->ID,'wsc_account_pin',true) ?>"></td>

    </tr>
</table>
