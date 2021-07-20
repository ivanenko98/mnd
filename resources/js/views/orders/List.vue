<template>
    <div class="app-container">
        <div class="filter-container">
            <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;"
                      class="filter-item" @keyup.enter.native="handleFilter"/>
            <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
                {{ $t('table.search') }}
            </el-button>
            <el-button v-if="checkRole(['admin','manager'])" class="filter-item" style="margin-left: 10px;"
                       type="primary" icon="el-icon-plus"
                       @click="handleCreate">
                {{ $t('table.add') }}
            </el-button>
        </div>

        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" :label="$t('table.id')" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" :label="$t('table.phone')">
                <template slot-scope="scope">
                    <span>{{ scope.row.phone_number }}</span>
                </template>
            </el-table-column>

            <el-table-column v-if="checkRole(['admin','manager'])" width="120px" align="center"
                             :label="$t('table.master')">
                <template slot-scope="scope">
                    <router-link v-if="scope.row.master != null" :to="'/users/edit/'+scope.row.master.id"
                                 class="link-type">
                        <span>{{ scope.row.master.first_name+' '+scope.row.master.last_name+' (#'+scope.row.master.id+')' }}</span>
                    </router-link>
                    <span v-else>{{ $t('table.master_is_searching') }}</span>
                </template>
            </el-table-column>


            <el-table-column width="120px" align="center" :label="$t('table.city')">
                <template slot-scope="scope">
                    <span>{{ scope.row.city.title }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" :label="$t('table.total_cost')">
                <template slot-scope="scope">
                    <span v-if="scope.row.total_cost != null">₴{{ scope.row.total_cost }}</span>
                    <span v-else>{{ $t('table.total_cost_not_set') }}</span>
                </template>
            </el-table-column>

            <el-table-column class-name="status-col" :label="$t('table.status')" width="190">
                <template slot-scope="{row}">
                    <el-tag :type="row.status | statusFilter">
                        {{ $t('table.status_'+row.status) }}
                    </el-tag>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" :label="$t('table.created_at')">
                <template slot-scope="scope">
                    <span>{{ scope.row.created_at | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" :label="$t('table.actions')" width="120">
                <template slot-scope="scope">
                    <router-link v-if="checkRole(['admin','manager'])" :to="'/orders/edit/'+scope.row.id">
                        <el-button type="primary" size="small" icon="el-icon-edit">
                            {{ $t('table.edit') }}
                        </el-button>
                    </router-link>
                    <el-button v-if="checkRole(['master'])" type="primary" size="small" icon="el-icon-view"
                               @click="handleShow(scope.row.id)">
                        {{ $t('table.show') }}
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit"
                    @pagination="getList"/>

        <el-dialog :title="$t('table.create_new_order')" :visible.sync="dialogFormVisible">
            <div v-loading="orderCreating" class="form-container">
                <el-form ref="orderForm" :model="newOrder" label-position="left" label-width="150px"
                         style="max-width: 500px;">
                    <el-form-item :label="$t('form.phone_number')" :error="this.errors.phone_number[0]" required>
                        <el-input :placeholder="$t('form.phone_number_placeholder')" v-model="newOrder.phone_number">
                            <template slot="prepend">+380</template>
                        </el-input>
                    </el-form-item>
                    <el-form-item :label="$t('form.services')" :error="this.errors.services[0]" required>
                        <div class="block">
                            <el-cascader
                                v-model="newOrder.services"
                                :options="servicesList"
                                :props="{multiple: true}"
                                collapse-tags
                                clearable style="width:100%"></el-cascader>
                        </div>
                    </el-form-item>
                    <el-form-item :label="$t('form.city')" :error="this.errors.city[0]" required>
                        <el-select v-model="newOrder.city" class="filter-item" :placeholder="$t('form.select_city')"
                                   filterable clearable>
                            <el-option v-for="city in cityList" :key="city.id" :label="city.title" :value="city.id"/>
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="$t('form.address')" :error="this.errors.address[0]" required>
                        <el-input v-model="newOrder.address" :placeholder="$t('form.address_placeholder')"/>
                    </el-form-item>
                    <el-form-item :label="$t('form.comment')" :error="this.errors.comment[0]">
                        <el-input v-model="newOrder.comment" type="textarea"/>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible = false">
                        {{ $t('table.cancel') }}
                    </el-button>
                    <el-button type="primary" @click="createOrder()">
                        {{ $t('table.confirm') }}
                    </el-button>
                </div>
            </div>
        </el-dialog>

        <el-dialog :title="$t('table.order_info')" :visible.sync="dialogOrderShowingVisible">
            <div v-loading="orderShowing" class="form-container">

                <p><span class="row-title">{{ $t('form.order_id') + ': ' }}</span>{{ order.id }}</p>
                <p><span class="row-title">{{ $t('form.phone_number') + ': ' }}</span>{{ order.phone_number }}</p>
                <p><span class="row-title">{{ $t('form.city') + ': ' }}</span>{{ order.city.title }}</p>
                <p><span class="row-title">{{ $t('form.address') + ': ' }}</span>{{ order.address }}</p>
                <p><span class="row-title">{{ $t('form.total_cost') + ': ' }}</span>{{ order.total_cost + ' грн' }}</p>
                <p><span class="row-title">{{ $t('form.platform_fee') + ': ' }}</span>{{ order.platform_fee + ' грн' }}</p>

                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogOrderShowingVisible = false">
                        {{ $t('table.close') }}
                    </el-button>
                </div>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
    import Resource from '@/api/resource';
    import waves from '@/directive/waves';
    import permission from "@/directive/permission";
    import checkRole from "@/utils/role";
    import ElDragSelect from '@/components/DragSelect';
    import ServiceResource from '@/api/service';
    import CityResource from '@/api/city';

    const cityResource = new CityResource();
    const serviceResource = new ServiceResource();
    const orderResource = new Resource('orders');


    export default {
        name: 'OrderList',
        components: {Pagination, ElDragSelect},
        directives: {waves},
        filters: {
            statusFilter(status) {
                const statusMap = {
                    new: 'primary',
                    is_pending: 'info',
                    in_progress: 'progress',
                    done_by_master: 'success',
                    checking_by_manager: 'warning',
                    completed: 'success',
                    cancelled: 'danger',
                };
                return statusMap[status];
            },
        },
        data() {
            return {
                list: null,
                total: 0,
                listLoading: true,
                query: {
                    page: 1,
                    limit: 20,
                },
                dialogFormVisible: false,
                dialogOrderShowingVisible: false,
                orderCreating: false,
                orderShowing: false,
                newOrder: {},
                order: {
                    city: {},
                    master: {}
                },
                servicesList: [],
                cityList: [],
                errors: {},
            };
        },
        created() {
            this.getList();
            this.setDefaultErrors();
            this.getListServices();
            this.getListCities();
        },
        methods: {
            checkRole,
            async getList() {
                const {limit, page} = this.query;
                this.listLoading = true;
                const {data, meta} = await orderResource.list(this.query);
                this.list = data;
                this.list.forEach((element, index) => {
                    element['index'] = (page - 1) * limit + index + 1;
                });
                this.total = meta.total;
                this.listLoading = false;
            },
            handleFilter() {
                this.query.page = 1;
                this.getList();
            },
            handleCreate() {
                this.resetNewOrder();
                this.dialogFormVisible = true;
                this.$nextTick(() => {
                    this.$refs['orderForm'].clearValidate();
                });
            },
            handleShow(id) {
                this.getOrder(id);
                this.dialogOrderShowingVisible = true;
            },
            resetNewOrder() {
                this.newOrder = {
                    phone_number: '',
                    services: [],
                    city: '',
                    address: '',
                    comment: '',
                };
            },
            createOrder() {
                this.orderCreating = true;
                orderResource
                    .store(this.newOrder)
                    .then(response => {
                        this.$message({
                            message: this.$t('table.order_created'),
                            type: 'success',
                            duration: 5 * 1000,
                        });
                        this.resetNewOrder();
                        this.setDefaultErrors();
                        this.dialogFormVisible = false;
                        this.handleFilter();
                    })
                    .catch(error => {
                        this.setErrors(error.response.data.data);
                    })
                    .finally(() => {
                        this.orderCreating = false;
                    });
            },
            setDefaultErrors() {
                this.errors = {
                    phone_number: '',
                    services: '',
                    city: '',
                    address: '',
                    comment: '',
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
            async getOrder(id) {
                const {data} = await orderResource.get(id);
                this.order = data;
            },
        },
    };
</script>

<style scoped>
    .edit-input {
        padding-right: 100px;
    }

    .cancel-btn {
        position: absolute;
        right: 15px;
        top: 10px;
    }

    .row-title {
        font-weight: bold;
    }
</style>
