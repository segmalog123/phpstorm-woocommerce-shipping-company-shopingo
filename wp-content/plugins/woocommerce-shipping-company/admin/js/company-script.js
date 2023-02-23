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


        var ajaxConfig = {
            dataType: 'json',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
            },
        }
        const snackComp = Vue.component('snack-component', {
            template: '<v-snackbar style="z-index:99999999999999999" v-model="visiblity" :timeout="options.timeout" :color="options.color"   top :vertical="options.vertical" > <v-icon v-if="options.icon">{{ options.icon }}</v-icon> {{ message }} <template v-slot:action="{ attrs }"> <v-btn icon dark @click="visiblity = false" > <v-icon >mdi-close</v-icon> </v-btn> </template> <v-progress-linear :active="options.loading" :indeterminate="options.loading" absolute bottom color="red"></v-progress-linear></v-snackbar>',
            data() {
                return {

                    visiblity: false,
                    message: null,
                    options: {
                        timeout: 5000,
                        color: '',
                        icon: '',
                        vertical: false,
                        loading: false,
                    }
                }
            },
            methods: {
                show(message, options) {
                    this.visiblity = true
                    this.message = message
                    this.options = Object.assign(this.options, options)

                },
            }
        })



        if (companydata.post_type && companydata.post_type == 'shop_order') {
            $('.wp-heading-inline').after(
                    '<span id="trackorderapp" data-app class="v-application v-application--is-ltr theme--light" >\n\
                        <print-company ref="printCompany"></print-company>  \n\
                        <track-company ref="trackCompany"></track-company>\n\
                      \n\
               </span>\n\
<span id="bulkorderapp" data-app class="v-application v-application--is-ltr theme--light" > <bulk-company ref="bulkCompany"></track-company></span>')


        }


        /***********************/


        const printComp = Vue.component('print-company', {
            template: '#printtpl',
            vuetify: new Vuetify(),

            data() {
                return {
                    dialog: false,
                    listCompany: Object.values(companydata.listeCompany),
                    overlayloading: false,
                    post_status: companydata.post_status,
                    title: '',
                    type: ''
                }
            },
            computed: {
                requiredRule() {
                    return [v => !!v || "Champ Obligatoire"]
                },

            },
            mounted() {
                this.listCompany = this.listCompany.map(el => {

                    el.items = [
                        {label: 'Manifest Repport', value: 'repport'},
                        {label: 'Label/Livraison', value: 'label_bl'},
                    ]

                    return el
                })
            },
            methods: {
                async  printOrder(item, company) {
                    let self = this
                    let orders = [];

                    this.type = item.value

                    $.each($("input[name='post[]']:checked"), function () {
                        orders.push($(this).val())
                    })

                    this.overlayloading = true
                    if (orders.length <= 0) {
                        //

                        ajaxConfig.url = wpApiSettings.root + "globalapi/v2/get_order_data"
                        ajaxConfig.data = {order_ids: orders, status: ['wc-manifest']}
                        await  $.ajax(ajaxConfig).done(function (data) {
                            console.log(data.order_data)
                            orders = data.order_data.map(el => {
                                return el.id
                            })
                            this.overlayloading = false
                        })

//                        
                    }
                    console.log(orders)
                    if (orders.length <= 0) {
                        this.$refs.snack.show('Pas commandes trouvées!', {color: 'error', icon: 'mdi-close-octagon'})
                        this.overlayloading = false
                        return;
                    }

                    ajaxConfig.url = wpApiSettings.root + "globalapi/v2/process_company_shipping"
                    ajaxConfig.data = {function: item.value,
                        orders: orders, company: company
                    }

                    ajaxConfig.success = function (data) {

                        console.log(data)

                        self.overlayloading = false
                        if (data.orders.length >= 1) {
                            self.title = item.label + ' ' + company.company_label
                            self.dialog = true


                            setTimeout(function () {
                                $('.wsc_pdf_preview object').attr('data', data.url)

                            }, 1000)
                        }
                        if (data.problem.length >= 1) {
                            var msg = 'Les commandes suivantes sont introuvables dans le système de la société de livraison:\n'
                                    + data.problem.join('\n')
                            self.$refs.snack.show(msg,
                                    {color: 'error', icon: 'mdi-close-octagon'}, {timeout: 10000})
                        }


                    }

                    await $.ajax(ajaxConfig)




                }
            }
        })

        /***********************/

        const shippingComp = Vue.component('shipping-company', {
            template: '#companytpl',
            vuetify: new Vuetify(),
            props: ['refdata', 'orderinfo'],
            data() {
                return {
                    parentref: this.refdata,
                    listCompany: Object.values(companydata.listeCompany),
                    formData: {shipping_nbr_pcs: 1},
                    orderData: {},
                    arrNbrPcs: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                }
            },
            computed: {
                requiredRule() {
                    return [v => !!v || "Champ Obligatoire"]
                },
                requiredCustomRule() {

                    return [v => !!v || "Champ Obligatoire"]
                },
            },
            mounted() {
//                  this.orderData = this.orderinfo
                // console.log( this.parentref.$refs.newOrder.orderData.companyData.shipping_nbr_pcs)
                if (this.parentref.$refs.newOrder.orderData.companyData) {
                    this.formData.echange_contenu = this.parentref.$refs.newOrder.orderData.companyData.echange_contenu
                    this.formData.shipping_nbr_pcs = Object.values(this.arrNbrPcs).find(el => {
                        return el == this.parentref.$refs.newOrder.orderData.companyData.shipping_nbr_pcs
                    })
                }
            },
            methods: {
                createPosition() {
                    let self = this

                    this.parentref.$refs.btn = 'position'
                    let valid = this.parentref.$refs.newOrder.$refs.orderform.validate() &&
                            this.parentref.$refs.newOrder.$refs.addressform.validate() &&
                            this.parentref.$refs.newOrder.$refs.cityform.validate()
                    if (valid) {

                        self.parentref.$refs.newOrder.overlayloading = true
                        self.parentref.$refs.newOrder.currentStatus = 'manifest'
                        ajaxConfig.url = wpApiSettings.root + "globalapi/v2/process_company_shipping"
                        ajaxConfig.data = {formData: this.formData, function: 'create-position',
                            total_order: self.parentref.$refs.newOrder.totalOrder,
                            products: self.parentref.$refs.newOrder.selectedProducts,
                            orderData: self.orderinfo,
                            userData: self.parentref.$refs.newOrder.userData}

                        ajaxConfig.success = function (data) {

                            console.log(data)
                            self.parentref.$refs.newOrder.orderData.formData = this.formData

                            self.parentref.$refs.newOrder.overlayloading = false
                            self.parentref.$refs.newOrder.validateArticle()
                        }

                        $.ajax(ajaxConfig)


                    }

                }
            }
        })
        /***********************/

        if ($('#bulkorderapp').length >= 1) {

            const bulkComp = Vue.component('bulk-company', {
                template: '#bulktpl',
                vuetify: new Vuetify(),
                data() {
                    return {
                        arrNbrPcs: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                        submitting: true,
                        isawait: false,
                        dialog: false,
                        overlayloading: false,
                        bulk_shipping_company: '',
                        listCompany: Object.values(companydata.listeCompany),
                        ordersBulk: [],
                        headers: [
                            {text: '#', value: 'id'},
                            {text: 'Nom/Prénom', value: 'billing.first_name'},
                            {text: 'Etat', value: 'label'},
                            {text: 'Nbr Colis', value: 'nbr_pcs', width: '20%'},
                            {text: 'Echange', value: 'echange'},
                            {text: 'Actions', value: 'actions'},
                        ]
                    }
                },
                computed: {
                    requiredRule() {
                        return [v => !!v || "Champ Obligatoire"]
                    },

                },
                methods: {
                    async   validateBulk() {
                        let self = this
                        ajaxConfig.url = wpApiSettings.root + "globalapi/v2/process_company_shipping"

                        if (this.$refs.refCompany.validate() && this.ordersBulk.length >= 1) {

                            this.submitting = false

                            for (let index = 0; index < self.ordersBulk.length; index++) {
                                var thisorder = self.ordersBulk[index]
                                thisorder.doneawait = false
                                thisorder.isawait = true
                                ajaxConfig.data = {orderData: thisorder, company: self.bulk_shipping_company, function: 'bulk-position', }
                                ajaxConfig.success = function (data) {
                                    thisorder.isawait = false
                                    thisorder.doneawait = true
                                    thisorder.dataresp = data

                                    // $('#post-'+)
                                    console.log(data)
                                }
                                ajaxConfig.error = function (request, status, error) {
                                    thisorder.isawait = false
                                    thisorder.doneawait = true
                                    thisorder.dataresp = {
                                        'msg': 'Une erreur est survenue!',
                                        'resp': 'error',
                                    }
                                    return;
                                }
                                await  jQuery.ajax(ajaxConfig)

                            }

                            this.submitting = true




                        }
                    },
                    dialogBulk() {
                        let self = this
                        var checked_order = [];
                        $.each($("input[name='post[]']:checked"), function () {
                            var status = $(this).parents('tr').find('.order-status').attr('class').replace('order-status', '').replace('tips', '')
                            if (status.replace('status-', '').trim() == 'en-cours') {
                                checked_order.push($(this).val())
                            }
                        })
                        this.ordersBulk = []

                        this.overlayloading = true


                        ajaxConfig.url = wpApiSettings.root + "globalapi/v2/get_order_data"
                        ajaxConfig.data = {order_ids: checked_order, status: ['wc-en-cours']}
                        $.ajax(ajaxConfig).done(function (data) {

                        if(!Array.isArray(data.order_data)){
                            data.order_data = [data.order_data]
                        }
                            self.ordersBulk = data.order_data.map(el => {

                                el.order_id = el.id
                                el.label = el.statusData.label
                                el.class = 'order-status status-' + el.status
                                el.nbr_pcs = Object.values(self.arrNbrPcs).find(ell => {
                                    return ell == el.companyData.shipping_nbr_pcs
                                })
                                el.echange = el.companyData.echange_contenu
                                el.dataresp = []
                                el.isawait = false
                                el.doneawait = false

                                return el
                            })
                            self.overlayloading = false
                            self.dialog = true

                            console.log(self.ordersBulk)
                        })
//                        $.each($("input[name='post[]']:checked"), function () {
//
//                            var status = $(this).parents('tr').find('.order-status').attr('class').replace('order-status', '').replace('tips', '')
//                            status = status.replace('status-', '').trim()
//                            var statusLabel = $(this).parents('tr').find('.order-status').text()
//                            var statusClass = $(this).parents('tr').find('.order-status').attr('class')
//                            var order_number = $(this).parents('tr').find('.order_number').find('.order-view').text()
//
//                            if (status == 'en-cours') {
//                                self.ordersBulk.push(
//                                        {   order_id: $(this).val(),
//                                            order_number: order_number.replace('#', ''),
//                                            label: statusLabel,
//                                            status: status,
//                                            class: statusClass,
//                                            nbr_pcs: 1, 
//                                            echange: '',
//                                            dataresp: [],
//                                            isawait: false, doneawait: false}
//                                )
//                            }
//                        })

//                        if (self.ordersBulk.length <= 0) {
//                            self.$refs.snack.show('Séléctionner des commandes EN COURS svp!', {color: 'error', icon: 'mdi-close-octagon'})
//                            return;
//                        }





                    }
                }

            })

        }



        if ($('#trackorderapp').length >= 1) {


            const trackComp = Vue.component('track-company', {
                template: '#tracktpl',
                vuetify: new Vuetify(),
                data() {
                    return {
                        order_id: '',
                        dialog: false,
                        overlayloading: false,
                        trackData: []
                    }
                },
                methods: {
                    showDialog(order_id) {

                        this.getData(order_id)
                        this.order_id = order_id

                    },
                    getData(order_id) {
                        let self = this
                        this.overlayloading = true
                        ajaxConfig.url = wpApiSettings.root + "globalapi/v2/process_company_shipping"
                        ajaxConfig.data = {orderData: {id: order_id}, function: 'track', }

                        ajaxConfig.success = function (data) {

                            self.overlayloading = false
                            console.log(data)

                            if (data == 'error') {
                                self.$refs.snack.show('Erreur! Numéro de livraison n\'est pas valide!', {color: 'error', icon: 'mdi-close-octagon'})
                                return;

                            }

                            self.dialog = true
                            self.trackData = data.evenements.map(el => {
                                el.color = 'grey'
                                el.icon = ''
                                if (el.eventid == 25) {
                                    el.color = 'green'
                                    el.icon = 'mdi-check'
                                }

                                if (el.eventid == 20) {
                                    el.color = 'red'
                                    el.icon = 'mdi-close-octagon'
                                }

                                return el
                            })

                        }

                        $.ajax(ajaxConfig)


                    },
                    toDateTime(secs) {
                        var curdate = new Date(null);
                        curdate.setTime(secs * 1000);
                        return curdate.toLocaleString()
                    }
                }
            })

            const vueObj = new Vue({
                el: '#trackorderapp',
                vuetify: new Vuetify(),
            })
            $(".btn_order_ship_number_tracking").on("click", function (a) {

                let order_id = $(this).attr("data-id")

                vueObj.$refs.trackCompany.showDialog(order_id)

            })

            new Vue({
                el: '#bulkorderapp',
                vuetify: new Vuetify(),
            })
        }

        /***********************/









    })
})(jQuery);