<script type="text/x-template" id="companytpl">

    <v-row style="    background: #eee;">
        <template v-if="orderinfo.statusData && orderinfo.statusData.value == 'en-cours'">
            <v-col cols="12" sm="3">
                <v-select
                        ref="refCompanyShipping"
                        style="background:#fff"
                        :rules="requiredCustomRule"
                        v-model="formData.shipping_company"
                        class="vselect"
                        placeholder="Séléctionner..."
                        :items="listCompany"
                        item-value="company_id"
                        item-text="company_label"
                        label="Société de livraison"
                        outlined
                        dense
                        return-object
                        hide-details="auto"
                >
                </v-select>
            </v-col>


            <v-col cols="12" sm="2">
                <v-select
                        style="background:#fff"
                        :rules="requiredRule"
                        v-model="formData.shipping_nbr_pcs"
                        class="vselect"
                        :items="Object.values(arrNbrPcs)"

                        label="Nombre de Colis"
                        outlined
                        dense
                        hide-details="auto"
                >
                </v-select>
            </v-col>


            <v-col cols="12" sm="2">
                <v-text-field
                        style="background:#fff"
                        outlined
                        label="Echange Contenu"
                        dense
                        v-model.trim="formData.echange_contenu"
                        hide-details="auto"
                ></v-text-field>
            </v-col>

            <v-col cols="12" sm="3">
                <v-btn


                        color="primary"
                        @click="createPosition"
                >
                    <v-icon left>
                        mdi-check-bold
                    </v-icon>
                    Créer Position
                </v-btn>


            </v-col>
        </template>


        <template v-if="orderinfo.ship_number && orderinfo.ship_number != '' ">
            <v-col cols="3">
                Société de livraison: <strong>{{orderinfo.companyData.company_label}}</strong>
            </v-col>
            <v-col cols="2">
                Nombre de Colis: <strong>{{orderinfo.companyData.shipping_nbr_pcs}}</strong>
            </v-col>
            <v-col cols="3" v-if="orderinfo.companyData.echange_contenu">
                Echange: <strong>{{orderinfo.companyData.echange_contenu}}</strong>
            </v-col>
        </template>


    </v-row>

</script>