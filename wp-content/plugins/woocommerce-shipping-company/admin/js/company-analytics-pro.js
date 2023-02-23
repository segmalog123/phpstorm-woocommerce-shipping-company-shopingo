jQuery(document).ready(function ($) {
    'use strict';



    var ajaxConfig = {
       url :ajaxurl,
        dataType: 'json',
        method: 'POST',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
        },
    }
    var date30days = new Date()
    date30days.setDate(date30days.getDate() - 15);

    if ($('#statisticsapp').length >= 1) {

        const vueObj = new Vue({
            el: '#statisticsapp',
            vuetify: new Vuetify(),
            data() {
                return {
                    listPage:Object.values(['Shopingo.tn','HomeDeco.tn','TopModeles.tn','Fashio.tn' ]),
                    listSource:[{label:'SiteWeb',value:"siteweb"},{label:'Facebook',value:"fb"},{label:'Téléphone',value:"tel"}],
                    resData:{},
                    overlay:false,
                    listCompany:[],
                    resProducts: [],
                    dates: [date30days.toISOString().substr(0, 10), new Date().toISOString().substr(0, 10)],
                    menu: false,
                    menu2: false,
                    date: new Date().toISOString().substr(0, 10),
                    dateStart: new Date().toISOString().substr(0, 10),
                    dateEnd: new Date().toISOString().substr(0, 10),
                    categories: [],
                    filterData: {dateBy: 'commande', soldePub: 100,retourPercent:20,fixCharge:55}
                }
            },
            mounted(){
                let self =this
                
                 ajaxConfig.data = {  
                                action: "process_company_analytics_pro",
                                function: "load_data",
                             }

                        ajaxConfig.success = function (data) {

                                console.log(data)
                            self.listCompany = data.company
                            self.resProducts = data.products
                            self.categories = data.category
                           
                        }

                        $.ajax(ajaxConfig)
                        
                        this.searchData()
            },
            methods:{
                searchData(){
                    
                    let self =this
                    
                    
                    self.filterData.startDate = this.dateStart
                    self.filterData.endDate = this.dateEnd
                    
                    this.overlay = true
                    
                     
                        ajaxConfig.data = {  
                                action: "process_company_analytics_pro",
                                function: "main-pro-search",
                                filterData:  self.filterData
                            }

                        ajaxConfig.success = function (data) {

                                console.log(data)
                             self.overlay = false
                             self.resData = data
                           
                        }

                        $.ajax(ajaxConfig)
                }
            }
        })




    }






    /************Analytics**************/
}) 