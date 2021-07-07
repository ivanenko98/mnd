<template>
    <div class="app-container">
        <el-form v-if="order" :model="order">
            <el-row>
                <el-col>
                    <el-card v-if="order.id">
                        <el-tabs v-model="activeTab">
                            <el-tab-pane v-loading="updating" :label="$t('order.tabs.edit')" name="first">
                                <el-row>
                                    <el-col :span="17">
                                        <el-card>
                                            <el-form-item :label="$t('form.phone_number')"
                                                          :error="this.errors.phone_number[0]" required>
                                                <el-input :placeholder="$t('form.phone_number_placeholder')"
                                                          v-model="order.phone_number">
                                                    <template slot="prepend">+380</template>
                                                </el-input>
                                            </el-form-item>
                                            <el-form-item :label="$t('form.services')" :error="this.errors.services[0]"
                                                          required>
                                                <div class="block">
                                                    <el-cascader
                                                        v-model="order.services"
                                                        :options="servicesList"
                                                        :props="{multiple: true}"
                                                        clearable style="width:100%"></el-cascader>
                                                </div>
                                            </el-form-item>
                                            <el-form-item :label="$t('form.city')" :error="this.errors.city[0]"
                                                          required>
                                                <el-select v-model="order.city" class="filter-item"
                                                           :placeholder="$t('form.select_city')" filterable clearable>
                                                    <el-option v-for="city in cityList" :key="city.id"
                                                               :label="city.title" :value="city.id"/>
                                                </el-select>
                                            </el-form-item>
                                            <el-form-item :label="$t('form.address')" :error="this.errors.address[0]"
                                                          required>
                                                <el-input v-model="order.address"
                                                          :placeholder="$t('form.address_placeholder')"/>
                                            </el-form-item>
                                            <el-form-item :label="$t('form.comment')" :error="this.errors.comment[0]">
                                                <el-input v-model="order.comment" type="textarea"/>
                                            </el-form-item>
                                        </el-card>
                                    </el-col>

                                    <el-col :span="6" :offset="1">
                                        <el-card>
                                            <div class="status-wrap">
                                                {{$t('form.status')+': '}}
                                                <el-tag v-if="order.status == 'cancelled'" class="pointer" type="danger">
                                                    {{ $t('table.status_'+order.status) }}
                                                </el-tag>
                                                <el-dropdown v-else @command="handleSelectStatus" trigger="click">
                                                    <el-tag class="pointer" :type="order.status | statusFilter">
                                                        {{ $t('table.status_'+order.status) }}
                                                    </el-tag>
                                                    <el-dropdown-menu slot="dropdown">
                                                        <el-dropdown-item v-for="(type, status) in statusMapList" :key="status" :label="status" :command="status">
                                                            <span :class="type">{{ $t('table.status_'+status) }}</span>
                                                        </el-dropdown-item>
                                                    </el-dropdown-menu>
                                                </el-dropdown>
                                            </div>
                                            <div v-if="order.status == 'cancelled'" class="item-line danger-text">
                                                {{ order.cancel_reason }}
                                            </div>
                                            <div class="item-line">
                                                {{ $t('form.sum_order')+': '}} <span class="pointer" @click="handleSum()">{{ order.total_cost !== null ? order.total_cost : 0 }} {{ $t('form.currency')}}   <svg-icon icon-class="edit" /></span>
                                            </div>
                                            <div class="box-center">
                                                <pan-thumb :image="masterAvatar" :height="'100px'"
                                                           :width="'100px'" :hoverable="false"/>
                                            </div>
                                            <el-form-item :label="$t('form.master')" :error="this.errors.master[0]"
                                                          required>
                                                <el-select v-model="order.master" class="filter-item"
                                                           :placeholder="$t('form.select_master')"
                                                           @change="changeMaster" @clear="clearMaster" filterable
                                                           clearable>
                                                    <el-option v-for="master in mastersList" :key="master.id"
                                                               :label="master.full_name+' (#'+master.id+')'" :value="master.id"/>
                                                </el-select>
                                            </el-form-item>

                                            <div class="buttons">
                                                <el-button type="primary" @click="onSubmit" size="medium">
                                                    {{$t('form.save')}}
                                                </el-button>
                                                <el-button v-if="order.status !== 'cancelled'" type="danger" @click="handleCancelling()" size="medium">
                                                    {{$t('form.cancel_order')}}
                                                </el-button>
                                            </div>

                                        </el-card>
                                    </el-col>

                                </el-row>

                            </el-tab-pane>
                            <el-tab-pane :label="$t('order.tabs.timeline')" name="second">
                                <div class="block">
                                    <el-timeline>
                                        <el-timeline-item timestamp="2019/4/17" placement="top">
                                            <el-card>
                                                <h4>Update Github template</h4>
                                                <p>tuandm committed 2019/4/17 20:46</p>
                                            </el-card>
                                        </el-timeline-item>
                                        <el-timeline-item timestamp="2019/4/18" placement="top">
                                            <el-card>
                                                <h4>Update Github template</h4>
                                                <p>tonynguyen committed 2019/4/18 20:46</p>
                                            </el-card>
                                            <el-card>
                                                <h4>Update Github template</h4>
                                                <p>tuandm committed 2019/4/19 21:16</p>
                                            </el-card>
                                        </el-timeline-item>
                                        <el-timeline-item timestamp="2019/4/19" placement="top">
                                            <el-card>
                                                <h4>
                                                    Deploy
                                                    <a href="https://laravue.dev" target="_blank">laravue.dev</a>
                                                </h4>
                                                <p>tuandm deployed 2019/4/19 10:23</p>
                                            </el-card>
                                        </el-timeline-item>
                                    </el-timeline>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </el-card>
                </el-col>
            </el-row>
        </el-form>


        <el-dialog :title="$t('form.cancel_order')" :visible.sync="dialogCancelVisible">
            <div v-loading="orderCancelling" class="form-container">
                <el-form ref="cancelOrderForm" :model="cancelOrder" label-position="left" label-width="150px" style="max-width: 500px;">
                    <el-form-item :label="$t('form.type_reason')" :error="this.errors.reason[0]" required>
                        <el-input v-model="cancelOrder.cancel_reason" type="textarea"/>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogCancelVisible = false">
                        {{ $t('form.close') }}
                    </el-button>
                    <el-button type="danger" @click="cancelingOrder()">
                        {{ $t('form.confirm') }}
                    </el-button>
                </div>
            </div>
        </el-dialog>

        <el-dialog :title="$t('form.set_sum_order')" :visible.sync="dialogSumChangeVisible">
            <div v-loading="sumChangeCancelling" class="form-container">
                <el-form ref="sumOrderForm" label-position="left" label-width="150px" style="max-width: 500px;">
                    <el-form-item :label="$t('form.sum_order')" required>
                        <el-input v-model="total_cost" type="number">
                            <template slot="append">грн</template>
                        </el-input>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogSumChangeVisible = false">
                        {{ $t('form.close') }}
                    </el-button>
                    <el-button type="primary" @click="setOrderSum()">
                        {{ $t('form.save') }}
                    </el-button>
                </div>
            </div>
        </el-dialog>

    </div>
</template>

<script>
    import ServiceResource from '@/api/service';
    import CityResource from '@/api/city';
    import OrderResource from "@/api/order";
    import UserResource from "@/api/user";
    import PanThumb from '@/components/PanThumb';
    import Variables from '@/utils/variables';

    const cityResource = new CityResource();
    const orderResource = new OrderResource();
    const serviceResource = new ServiceResource();
    const userResource = new UserResource();
    const variables = new Variables();

    const statusMap = {
        new: 'primary',
        is_pending: 'info',
        in_progress: 'progress',
        done_by_master: 'success',
        checking_by_manager: 'warning',
        completed: 'success',
    };

    export default {
        name: 'OrderDetail',
        components: {PanThumb},
        props: {
            order: {
                type: Object,
                default: () => {
                    return {
                        address: '',
                        city: '',
                        comment: '',
                        created_at: '',
                        id: '',
                        master: '',
                        master_avatar: '',
                        phone_number: '',
                        platform_fee: '',
                        status: '',
                        total_cost: '',
                    };
                },
            },
        },
        filters: {
            statusFilter(status) {
                return statusMap[status];
            },
        },
        data() {
            return {
                activeTab: 'first',
                updating: false,
                tempRoute: {},
                servicesList: [],
                cityList: [],
                mastersList: [],
                errors: {},
                masterAvatar: variables.getDefaultUserAvatar(),
                dialogCancelVisible: false,
                orderCancelling: false,
                dialogSumChangeVisible: false,
                sumChangeCancelling: false,
                cancelOrder: {},
                total_cost: 0,
                statusMapList: statusMap,
            };
        },
        watch: {
            order: function (newOrder) {
                if (newOrder.master !== null) {
                    this.masterAvatar = newOrder.master_avatar;
                }

                this.total_cost = newOrder.total_cost;
            }
        },
        created() {
            this.setDefaultErrors();
            this.getListServices();
            this.getListCities();
            this.getListMasters();
            // Why need to make a copy of this.$route here?
            // Because if you enter this page and quickly switch tag, may be in the execution of the setTagsViewTitle function, this.$route is no longer pointing to the current page
            this.tempRoute = Object.assign({}, this.$route);
        },
        methods: {
            onSubmit() {
                this.updating = true;
                orderResource
                    .update(this.order.id, this.order)
                    .then(response => {
                        this.updating = false;
                        this.setDefaultErrors();

                        this.$message({
                            message: this.$t('order.saved'),
                            type: 'success',
                            duration: 5 * 1000,
                        });
                    })
                    .catch(error => {
                        this.setErrors(error.response.data.data);
                    })
                    .finally(() => {
                        this.updating = false;
                    });
            },
            changeMaster(id) {
                this.setMasterAvatar(id);
            },
            clearMaster() {
                this.masterAvatar = variables.getDefaultUserAvatar();
            },
            setMasterAvatar(id) {
                this.mastersList.forEach(master => {
                    if (master.id === id) {
                        this.masterAvatar = master.avatar;
                    }
                });
            },
            handleCancelling() {
                // this.resetCancelOrder();
                this.dialogCancelVisible = true;
                this.$nextTick(() => {
                    this.$refs['cancelOrderForm'].clearValidate();
                });
            },
            handleSelectStatus(status) {
                this.order.status = status;
            },
            handleSum() {
                this.total_cost = this.order.total_cost;
                this.dialogSumChangeVisible = true;
                this.$nextTick(() => {
                    this.$refs['sumOrderForm'].clearValidate();
                });
            },
            setOrderSum() {
                if ((this.total_cost.length === undefined || this.total_cost.length > 0) && this.total_cost >= 0) {
                    this.order.total_cost = this.total_cost;
                    this.dialogSumChangeVisible = false
                } else {
                    this.$message({
                        message: this.$t('form.incorrect_data'),
                        type: 'error',
                        duration: 5 * 1000,
                    });
                }
            },
            cancelingOrder() {
                this.updating = true;
                orderResource
                    .cancel(this.order.id, this.cancelOrder)
                    .then(response => {
                        this.updating = false;

                        this.$message({
                            message: this.$t('order.succefully_cancelled'),
                            type: 'success',
                            duration: 5 * 1000,
                        });

                        this.order.status = response.data.status;

                        this.dialogCancelVisible = false;
                    })
                    .catch(error => {
                        // this.setErrors(error.response.data.data);
                    })
                    .finally(() => {
                        this.updating = false;
                    });
            },
            setDefaultErrors() {
                this.errors = {
                    phone_number: '',
                    services: '',
                    city: '',
                    address: '',
                    comment: '',
                    master: '',
                    reason: '',
                };
            },
            setErrors(errors) {

                this.setDefaultErrors();

                for (let key in errors) {
                    this.errors[key] = errors[key];
                }
            },
            async getListServices() {
                const {data} = await serviceResource.list({});
                this.servicesList = data;
            },
            async getListCities() {
                const {data} = await cityResource.list({});
                this.cityList = data;
            },
            async getListMasters() {
                const {data} = await userResource.listMasters();
                this.mastersList = data;
            },
        },
    };
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    @import "~@/styles/mixin.scss";

    .status-item {
        margin-bottom: 10px;
    }

    .item-line {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        display: block;
        font-size: 14px;
        color: #606266;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .danger-text {
        color: #ff4949c9;
        font-size: 11px;
    }

    .status-wrap {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        display: inline-block;
        font-size: 14px;
        color: #606266;
        line-height: 40px;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .buttons {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }
</style>
