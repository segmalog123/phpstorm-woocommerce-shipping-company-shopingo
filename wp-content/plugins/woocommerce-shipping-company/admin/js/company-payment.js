(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     */
    $(function () {
 

const ConfirmComp = Vue.component('confirm-component', {
                template: '<v-dialog v-model="show" :max-width="options.width" :style="{ zIndex: options.zIndex }" @keydown.esc="cancel"><v-card><v-toolbar :color="options.color" dark dense flat><v-toolbar-title class="white--text">{{ title }}</v-toolbar-title></v-toolbar><v-card-text v-show="!!message" class="pa-4">{{ message }}</v-card-text><v-card-actions class="pt-0"><v-spacer></v-spacer><v-btn   @click.native="agree" color="success darken-1" >Confirmer</v-btn><v-btn @click.native="cancel" color="grey" text>Annuler</v-btn></v-card-actions></v-card></v-dialog>',
                data() {
                    return {
                        dialog: false,
                        resolve: null,
                        reject: null,
                        message: null,
                        title: null,
                        options: {
                            color: 'primary',
                            width: 290,
                            zIndex: 200
                        }
                    }
                },
                computed: {
                    show: {
                        get() {
                            return this.dialog
                        },
                        set(value) {
                            this.dialog = value
                            if (value === false) {
                                this.cancel()
                            }
                        }
                    }
                },
                methods: {

                    open(title, message, options) {
                        this.dialog = true
                        this.title = title
                        this.message = message
                        this.options = Object.assign(this.options, options)
                        return new Promise((resolve, reject) => {
                            this.resolve = resolve
                            this.reject = reject
                        })
                    },
                    agree() {
                        this.resolve(true)
                        this.dialog = false
                    },
                    cancel() {
                        this.resolve(false)
                        this.dialog = false
                    }
                }
            })


 



        var ajaxConfig = {
            dataType: 'json',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
            },
        }
           if ($('#paymentapp').length >= 1) {
        
          const vueObj = new Vue({
                el: '#paymentapp',
                vuetify: new Vuetify(),
                   data() {
                        return {
                            overlay:false,
                            headers:[
                                {text: 'Date', value: 'date_tr', divider: true ,},  
                             {text: 'Num Transaction', value: 'num_tr', divider: true, }, 
                              {text: 'Colis', value: 'colis_tr', divider: true, }, 
                             {text: 'Montant', value: 'total_tr', divider: true, }, 
                            {text: 'Actions', value: 'actions', divider: true, }, 
                            ],
                            items:[]

                        }
                    },
                    mounted(){
                     this.overlay = true
                        this.getDataFromApi()
                    },
                    methods:{
                         itemRowBackground: function (item) {
                            return  'tr_'+item.status_tr
                         },
                        validateTr(item){
                            let self = this
                            
                                ajaxConfig.url = ajaxurl
                                ajaxConfig.data = {
                                    action: 'process_company_payment',
                                    function: 'validate_tr' ,
                                    item_tr : item
                                }

                                ajaxConfig.success = function (data) {
                                    
                                  self.getDataFromApi()
                                    console.log( data)
                                }
                                
                                 this.$refs.confirm.open('Confirmation', 'Changement état transaction.', {color: 'red'}).then((confirm) => {
                                    if (confirm) {
                                         self.overlay = true
                                        $.ajax(ajaxConfig)
                                    } 
                                 })      
                             
                        },
                        getDataFromApi(){
                            let self = this
                             
                                ajaxConfig.url = ajaxurl
                                ajaxConfig.data = {action: 'process_company_payment',
                                    function: 'get_tr' 
                                }

                                ajaxConfig.success = function (data) {
                                     self.overlay = false
                                     self.items= data.items
                                    console.log( data)
                                }
                                
                                $.ajax(ajaxConfig)
                        }
                    }
            })
        }
        
    })
})(jQuery);