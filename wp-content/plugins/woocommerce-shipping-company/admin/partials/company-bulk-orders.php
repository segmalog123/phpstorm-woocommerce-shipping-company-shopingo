<script type="text/x-template" id="bulktpl">

    <div>

        <v-btn color="primary" outlined tile @click="dialogBulk" small class="  btn_action_order mr-2">Crée Plusieurs
            Positions
        </v-btn>

        <v-dialog
                ref="dialogtrack"
                style="z-index:9999999"

                width="750px"
                v-model="dialog"
                transition="dialog-bottom-transition">

            <v-form @submit.prevent="" ref="refCompany">
                <v-card>

                    <v-toolbar
                            height="35px"
                            dark
                            color="primary"
                    >

                        <v-toolbar-title> Bulk Commande</v-toolbar-title>
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

                            <v-col cols="12" class="pt-0 pb-0 ">


                                <v-select

                                        clearable
                                        :rules="requiredRule"
                                        v-model="bulk_shipping_company"
                                        class="mb-3 vselect"
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

                                <v-data-table
                                        dense
                                        :headers="headers"
                                        :items="Object.values(ordersBulk)"
                                        hide-default-footer
                                        fixed-header
                                        :items-per-page="-1"
                                        height="300"
                                        class="elevation-1"
                                >
                                    <template
                                            v-slot:footer
                                    >
                                        <div class="pa-3">
                                            {{ordersBulk.length}} Commandes(s)
                                        </div>
                                    </template>
                                    <template v-slot:item.label="{ item }">

                                        <mark style="line-height: 1.5em;" :class="item.class">
                                            <span>{{item.label}}</span></mark>

                                    </template>


                                    <template v-slot:item.actions="{ item }">
                                        <div class="text-center">
                                            <v-progress-circular
                                                    indeterminate
                                                    color="primary"
                                                    v-if="item.isawait"
                                            ></v-progress-circular>


                                            <v-icon color="green"
                                                    v-if="item.doneawait && item.dataresp.resp == 'success'">mdi-check
                                            </v-icon>

                                            <v-icon color="red" v-if="item.doneawait && item.dataresp.resp == 'error'">
                                                mdi-close-octagon
                                            </v-icon>
                                            <span v-if="item.doneawait && item.dataresp.msg">{{item.dataresp.msg}}</span>
                                        </div>
                                    </template>

                                    <template v-slot:item.nbr_pcs="{ item }">
                                        <v-select


                                                :rules="requiredRule"
                                                v-model="item.nbr_pcs"
                                                class="vselect"
                                                :items="Object.values(arrNbrPcs)"
                                                outlined
                                                dense
                                                hide-details="auto"
                                        >
                                        </v-select>
                                    </template>

                                    <template v-slot:item.echange="{ item }">
                                        <v-text-field


                                                outlined
                                                dense
                                                v-model.trim="item.echange"
                                                hide-details="auto"
                                        ></v-text-field>
                                    </template>

                                </v-data-table>


                            </v-col>
                        </v-row>
                    </v-card-text>

                    <v-divider></v-divider>
                    <v-card-actions class="justify-center">
                        <v-btn
                                v-if="submitting"
                                width="20%"
                                color="success"
                                @click="validateBulk"
                        >
                            <v-icon left>
                                mdi-check-bold
                            </v-icon>
                            Valider
                        </v-btn>
                    </v-card-actions>

                </v-card>

            </v-form>
        </v-dialog>
        <snack-component ref="snack"></snack-component>
        <v-overlay :value="overlayloading" z-index="99999999999999999999999">
            <v-progress-circular
                    indeterminate
                    size="64"
            ></v-progress-circular>
        </v-overlay>
    </div>
</script>

<style>

    .v-text-field--box .v-input__slot, .v-text-field--outline .v-input__slot {
        min-height: 56px;
    }


</style>