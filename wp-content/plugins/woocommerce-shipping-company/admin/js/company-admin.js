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
     *
     */ $(function () {

        var ajaxConfig = {
            dataType: 'json',
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
            },
        }

        var htmlbtn2 = ''
        if (jsdata.post_status && jsdata.post_status == 'wc-manifest') {

            htmlbtn2 += "<a data-action='bl' data-company='targui-express' class='  wsc_print_data'  href='#'  > Bon de Livraison</a>"
            htmlbtn2 += "<a data-action='rp' data-company='targui-express'  class='  wsc_print_data'  href='#'  > Manifest Repport</a>"
            htmlbtn2 += "<a data-action='lab' data-company='targui-express' class='  wsc_print_data'  href='#'  > Label/Livraion</a>"
        }

        $('.btn_add_new_order_popup').after("<button style='display:block!important'  class='  page-title-action  > Créer Plusieurs Positions </button> ")

        if (htmlbtn2 != '') {
            $('.btn_add_new_order_popup').after('<div class="dropdown">\n\
                            <button style="display:block!important" class="dropbtn page-title-action">Société Targui Express</button>\n\
                      <div class="dropdown-content">' + htmlbtn2 + '</div></div>')


        }

        if ($(".input_date_range_payment").length) {
            $('.input_date_range_payment').dateRangePicker({
                autoClose: true,
                showShortcuts: true,

            });
        }

        /***********************/


        var popup
        if (document.getElementById('data_shippement_csv') != null) {
            var jTable = jexcel(document.getElementById('data_shippement_csv'), {
                minDimensions: [6, 1],
                allowDeleteColumn: false,
                allowDeleteRow: false,
                search: true,
                pagination: 100,
                footers: [['Total', '=ROUND(SUM(D1:D8), 2)']],
                columns: [
                    {title: 'Numéro de livraison', width: 150, type: 'numeric'},
                    {title: 'Prix', width: 80},
                    {title: 'Commande', width: 100, type: 'text',},
                    {title: 'Etat', width: 150, type: 'text',},
                    {title: 'Dupliquer', width: 100, type: 'text',},

                    {title: 'Résultat', width: 500, type: 'text',}
                ],
                onevent: function (event_name, table_html, instance, d, col_number, row_number, g, h) {
                    var keyC = 'C' + parseInt(parseInt(d) + 1)
                    var goKey = $('#data_shippement_csv').jexcel('getValue', keyC)

                    if (col_number == 2 && goKey != '' && event_name == 'onselection' && event_name != 'onpaste') {

                        window.open(
                            '/wp-admin/post.php?post=' + goKey + '&action=edit',
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                    if (event_name == 'onpaste') {

                        var totall = 0
                        var i = 0
                        $.each(instance, function (k, v) {
                            totall = totall + parseFloat(v[1])
                            i++
                        })
                        $('.jexcel tfoot td:eq(2)').html(totall)
                        $('.filter_order_found').html(i)
                    }


                    if (event_name == 'onload') {
                        var i = 0
                        var k = 0
                        var total = 0
                        $.each(instance.getData(), function () {
                            if (instance.getValue('A' + i) != '') {
                                instance.setValue('A' + i, parseInt(instance.getValue('A' + i)))
                            }
                            i++
                            if (instance.getValue('B' + k) != '') {
                                total = total + parseFloat(instance.getValue('B' + k))
                            }
                            k++
                        })

                        $('.jexcel tfoot td:eq(2)').html(total)
                    }

                },

            });

            $(document).on("change", "#inputfile", function () {
                var s = new FormData,
                    a = $("#fileToUpload").find(".inputfile");

                $("body").loading({message: "En cours...."}),
                    s.append("files_data", a[0].files[0]),
                    s.append("action", "process_company_payment"),
                    s.append("function", "upload"),
                    $.ajax({
                        url: ajaxurl,
                        type: "POST",
                        dataType: 'json',
                        data: s,
                        cache: !1,
                        processData: !1,
                        contentType: !1,
                        success: function (s, e, n) {
                            console.log(s)
                            a.val(""),
                                $("body").loading("stop");
                            var finaldata = []
                            $.each(s.data, function (k, v) {

                                finaldata.push([v[0], v[s.sizeHeader - 2]])

                            })


                            console.log(finaldata)
                            jTable.setData([['', '', '', '', '', '']])
                            jTable.setData(finaldata)

                        }
                    })
            })
        }

        /***********************/
        $('.btn_load_table_date_company').on('click', function () {
            if ($('.input_date_range_payment').val() != '' && $('.company_shippment').val() != '') {
                $("body").loading({message: "Chargement...."}),
                    $.ajax({
                        url: ajaxurl,
                        type: "POST",
                        dataType: "json",
                        data: {
                            action: "process_company_payment",
                            date_load: $('.input_date_range_payment').val(),
                            company_load: $('.company_shippment').val(),
                            function: "process_load",
                            status_shippment: $('.status_shippment').val(),
                            is_factured: $('.filter_order_factured').is(':checked'),
                            filter_date: $('input[name="checkbox_filter_date"]:checked').val(),
                        },
                        success: function (resp) {
                            console.log(resp)
                            $("body").loading("stop")
                            jTable.setData([['', '', '', '', '', '']])
                            jTable.setData(resp.data)
                            found_data_refresh(resp)
                        }
                    })
            }
        })

        function found_data_refresh(data) {
            $('.filter_order_found').html(data.found_order)
        }

        $('body').on('click', '.btn_clear_data', function () {
            jTable.setData([['', '', '']])
        })


        $('body').on('click', '.btn_check_payment', function () {
            var array_ship = jTable.getColumnData(0)
            var proceed = []
            $.each(array_ship, function (k, v) {
                if (v == '') {
                    proceed.push('0')
                } else {
                    proceed.push('1')
                }
            })
            if ($.inArray('1', proceed) != -1) {
                //console.log("hiiiii" + jTable.getData());
                $("body").loading({message: "En cours...."}),
                    $.ajax({
                        url: ajaxurl,
                        type: "POST",
                        dataType: "json",
                        data: {
                            action: "process_company_payment",
                            function: 'check_payment',
                            data: JSON.stringify(jTable.getData()),
                            array_ship: JSON.stringify(jTable.getColumnData(0))
                            /*data: jTable.getData(),
                            array_ship: jTable.getColumnData(0)*/
                        },
                        success: function (resp) {
                            $("body").loading("stop")
                            jTable.setData(resp.data)

                            $('.jexcel tfoot td:eq(2)').html(resp.total)
                            $.each(resp.data, function (k, v) {
                                jTable.setStyle('C' + parseInt(parseInt(k) + 1), 'color', 'blue');
                                jTable.setStyle('C' + parseInt(parseInt(k) + 1), 'cursor', 'pointer');
                                jTable.setStyle('C' + parseInt(parseInt(k) + 1), 'text-decoration', 'underline');
                            })
                            $.each(resp.highlighted.found, function (k, v) {
                                setStyleRow(v, 'background-color', 'green')
                                setStyleRow(v, 'color', 'white')
                            })
                            $.each(resp.highlighted.not_found, function (k, v) {
                                setStyleRow(v, 'background-color', 'red')
                                setStyleRow(v, 'color', 'white')
                            })
                            $.each(resp.highlighted.incorrect_status, function (k, v) {
                                setStyleRow(v, 'background-color', '#ddaa3b')
                                setStyleRow(v, 'color', 'white')
                            })
                            $.each(resp.highlighted.duplicate, function (k, v) {
                                setStyleRow(v, 'background-color', '#ddaa3b')
                                setStyleRow(v, 'color', 'white')
                            })
                            $.each(resp.highlighted.incorrect_price, function (k, v) {
                                setStyleRow(v, 'background-color', 'yellow')
                                setStyleRow(v, 'color', 'black')
                            })

                            $('.res_success_order').val(resp.array_success_order)
                            $('.res_success_key').val(resp.array_success_key)

                        }
                    })
            } else {
                Swal.fire({
                    toast: !0,
                    showConfirmButton: !1,
                    timer: 2500,
                    type: 'error',
                    title: 'Pas de données! Séléctionner une fichier CSV ou coller des données dans le tableau svp!'
                })
            }
        })

        $('body').on('click', '.btn_check_factured', function () {
            var array_ship = jTable.getColumnData(0)
            var proceed = []
            $.each(array_ship, function (k, v) {
                if (v == '') {
                    proceed.push('0')
                } else {
                    proceed.push('1')
                }
            })
            if ($.inArray('1', proceed) != -1) {
                $("body").loading({message: "En cours...."}),
                    $.ajax({
                        url: ajaxurl,
                        type: "POST",
                        dataType: "json",
                        data: {
                            action: "process_company_payment",
                            function: 'check_factured',
                            data: jTable.getData(),
                            array_ship: jTable.getColumnData(0)
                        },
                        success: function (resp) {
                            console.log(resp)
                            $("body").loading("stop")
                            jTable.setData(resp.data)

                            $('.jexcel tfoot td:eq(2)').html(resp.total)
                            $.each(resp.data, function (k, v) {
                                jTable.setStyle('C' + parseInt(parseInt(k) + 1), 'color', 'blue');
                                jTable.setStyle('C' + parseInt(parseInt(k) + 1), 'cursor', 'pointer');
                                jTable.setStyle('C' + parseInt(parseInt(k) + 1), 'text-decoration', 'underline');
                            })
                            $.each(resp.highlighted.found, function (k, v) {
                                setStyleRow(v, 'background-color', 'green')
                                setStyleRow(v, 'color', 'white')
                            })
                            $.each(resp.highlighted.not_found, function (k, v) {
                                setStyleRow(v, 'background-color', 'red')
                                setStyleRow(v, 'color', 'white')
                            })

                            $.each(resp.highlighted.duplicate, function (k, v) {
                                setStyleRow(v, 'background-color', '#ddaa3b')
                                setStyleRow(v, 'color', 'white')
                            })
                            $.each(resp.highlighted.factured, function (k, v) {
                                setStyleRow(v, 'background-color', 'yellow')
                                setStyleRow(v, 'color', 'black')
                            })

                            $('.res_success_order_factured').val(resp.array_success_order)
                            $('.res_success_key').val(resp.array_success_key)

                        }
                    })
            } else {
                Swal.fire({
                    toast: !0,
                    showConfirmButton: !1,
                    timer: 2500,
                    type: 'error',
                    title: 'Pas de données! Séléctionner une fichier CSV ou coller des données dans le tableau svp!'
                })
            }
        })


        $('body').on('click', '.btn_save_order_payment', function () {
            $('.show_error').removeClass('msg_error')
            $('.show_error').html('')
            if ($('.id_transcation').val() == '') {

                $('.show_error').addClass('msg_error')
                $('.show_error').html('Numéro transaction obligatoire!')

                return;
            }

            var order_found = $('.res_success_order').val()
            $.ajax({
                url: ajaxurl,
                type: "POST",
                dataType: "json",
                data: {
                    action: "process_company_payment",
                    function: 'save_payment',
                    orders: order_found,
                    date_paid: $('.date_payment_recieved').val(),
                    num_tr: $('.id_transcation').val()

                },
                success: function (resp) {
                    console.log(resp)
                    if (resp.type == 'success') {
                        Swal.fire({
                            toast: !0,
                            showConfirmButton: !1,
                            timer: 2500,
                            type: 'success',
                            title: 'Commandes ont été chnagées on paiement reçu! '
                        })
                        popup.close()
                    } else {
                        $('.show_error').addClass('msg_error')
                        $('.show_error').html(resp.msg)
                    }
                }
            })

        })
        $('body').on('click', '.btn_save_order_factured', function () {
            $('.show_error').removeClass('msg_error')
            $('.show_error').html('')
            var order_found = $('.res_success_order_factured').val()
            $.ajax({
                url: ajaxurl,
                type: "POST",
                dataType: "json",
                data: {
                    action: "process_company_payment",
                    function: 'save_factured',
                    orders: order_found,
                    date_paid: $('.date_payment_recieved').val(),
                    num_tr: $('.id_transcation').val()

                },
                success: function (resp) {
                    console.log(resp)
                    if (resp.type == 'success') {
                        Swal.fire({
                            toast: !0,
                            showConfirmButton: !1,
                            timer: 2500,
                            type: 'success',
                            title: 'Commandes ont été chnagées on facturées! '
                        })
                        popup.close()
                    } else {
                        $('.show_error').addClass('msg_error')
                        $('.show_error').html(resp.msg)
                    }
                }
            })

        })


        function setStyleRow(v, style, value) {
            jTable.setStyle('A' + v, style, value);
            jTable.setStyle('B' + v, style, value);
            jTable.setStyle('C' + v, style, value);
            jTable.setStyle('D' + v, style, value);
            jTable.setStyle('E' + v, style, value);
            jTable.setStyle('F' + v, style, value);
            jTable.setStyle('G' + v, style, value);
            jTable.setStyle('H' + v, style, value);


        }


        $('body').on('click', '.btn_change_status_order', function () {

            var order_found
            var jData = jTable.getData()
            var array_ship = jTable.getColumnData(0)
            var proceed = []
            $.each(array_ship, function (k, v) {
                if (v == '') {
                    proceed.push('0')
                } else {
                    proceed.push('1')
                }
            })


            if ($.inArray('1', proceed) != -1) {
                $('.btn_check_payment').click()
                order_found = $('.res_success_order').val()
                if (order_found != '') {
                    popup = new $.Zebra_Dialog({
                        source: {
                            ajax: {
                                url: ajaxurl,
                                data: {
                                    action: 'process_company_payment',
                                    function: 'show_popup_payment',
                                    orders: order_found,
                                }
                            }
                        },
                        buttons: false,
                        type: false,
                        modal: true,
                        width: 800,
                        title: 'Confirmation',

                    })
                } else {
                    Swal.fire({
                        toast: !0,
                        showConfirmButton: !1,
                        timer: 2500,
                        type: 'error',
                        title: 'Aucune commande valide à changer trouvée!'
                    })
                }
            } else {
                Swal.fire({
                    toast: !0,
                    showConfirmButton: !1,
                    timer: 2500,
                    type: 'error',
                    title: 'Pas de données! Séléctionner une fichier CSV ou coller des données dans le tableau svp!'
                })
            }
        })


        $('body').on('click', '.btn_change_factured_order', function () {

            var order_found
            var jData = jTable.getData()
            var array_ship = jTable.getColumnData(0)
            var proceed = []
            $.each(array_ship, function (k, v) {
                if (v == '') {
                    proceed.push('0')
                } else {
                    proceed.push('1')
                }
            })


            if ($.inArray('1', proceed) != -1) {
                $('.btn_check_factured').click()
                order_found = $('.res_success_order_factured').val()
                if (order_found != '') {
                    popup = new $.Zebra_Dialog({
                        source: {
                            ajax: {
                                url: ajaxurl,
                                data: {
                                    action: 'process_company_payment',
                                    function: 'show_popup_factured',
                                    orders: order_found,
                                }
                            }
                        },
                        buttons: false,
                        type: false,
                        modal: true,
                        width: 800,
                        title: 'Confirmation',

                    })
                } else {
                    Swal.fire({
                        toast: !0,
                        showConfirmButton: !1,
                        timer: 2500,
                        type: 'error',
                        title: 'Aucune commande valide à changer trouvée!'
                    })
                }
            } else {
                Swal.fire({
                    toast: !0,
                    showConfirmButton: !1,
                    timer: 2500,
                    type: 'error',
                    title: 'Pas de données! Séléctionner une fichier CSV ou coller des données dans le tableau svp!'
                })
            }
        })


        $(".wsc_print_data").on("click", function (e) {
            e.preventDefault()
            var action = $(this).data('action')
            var company = $(this).data('company')
            var a = [];
            $.each($("input[name='post[]']:checked"), function () {
                a.push($(this).val())
            })
            if (a.length <= 0) {
                Swal.fire({
                    toast: !0,
                    showConfirmButton: !1,
                    timer: 1800,
                    type: "error",
                    title: "Séléctionnez des commandes svp!"
                })

            } else {
                $("body").loading({message: "loading...."});
                $.ajax({
                    url: ajaxurl,
                    type: "GET",
                    dataType: "json",
                    data: {
                        action: "process_company_shipping",
                        function: action,
                        checked_order: a,
                        company: company
                    },
                    success: function (e) {
                        console.log(e)
                        $("body").loading("stop")
                        Swal.fire({
                            showConfirmButton: false,

                            html: '<p><a class="button button-primary" target="_blank" href="' + e + '"> Télécharger / Imprimer </a></p>'
                        })

                    }
                })
            }
        })


        /***********************/


        $('body').on('click', '.btn_create_position_shipping', function () {

            var order_id = $(this).attr('data-id')

            if ($.trim($('.order_popup_data .billing_city').val()) == '' ||
                $.trim($('.order_popup_data .billing_address_1').val()) == '') {

                $('.msg_error').removeClass('hidden')
                $('.msg_error').empty().append('Gouvernorat et Adresse obligatoire!')

            } else if ($('.select_company_shipping').val() == '') {

                $('.msg_error').removeClass('hidden')
                $('.msg_error').empty().append('Sélectionnez une société de livraison svp!')

            } else if ($.trim($('.billing_first_name').val()) == '' ||
                $.trim($('.billing_phone').val()) == '') {

                $('.msg_error').removeClass('hidden')
                $('.msg_error').empty().append('Nom ou Numéro de Téléphone obligatoire')

            } else {
                $("body").loading({message: "Traitement...."})
                $('.msg_error').addClass('hidden')
                $('.save_order_type').val('shippment')

                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "process_company_shipping",
                        function: "create-position",
                        order_id: order_id,
                        formdata: $('.order_popup_data').find("textarea,select, input").serialize()

                    },
                    success: function (dataresp) {
                        console.log(dataresp)

                        $("body").loading("stop");
                        if (dataresp.resp == 'error') {
                            $('.msg_error').removeClass('hidden')
                            $('.msg_error').empty().append('Il y a une erreur lors creation de position!')
                        } else {
                            $('.btn_save_new_order_popup').trigger('click')
                        }


                    }
                })
            }


        })


    });
    /*
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

})(jQuery);
