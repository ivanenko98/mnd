<template>
    <div class="app-container">
        <div class="filter-container">
            <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;"
                      class="filter-item" @keyup.enter.native="handleFilter"/>
            <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
                {{ $t('table.search') }}
            </el-button>
            <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-plus"
                       @click="handleCreate">
                {{ $t('table.add') }}
            </el-button>
        </div>

        <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="width: 100%">
            <el-table-column align="center" label="ID" width="80">
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="Phone">
                <template slot-scope="scope">
                    <span>{{ scope.row.phone_number }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="Master">
                <template slot-scope="scope">
                    <router-link :to="'/users/edit/'+scope.row.master.id" class="link-type">
                        <span>{{ scope.row.master.first_name+' '+scope.row.master.last_name }}</span>
                    </router-link>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="Master">
                <template slot-scope="scope">
                    <span>{{ scope.row.city.title }}</span>
                </template>
            </el-table-column>

            <el-table-column width="120px" align="center" label="Total Cost">
                <template slot-scope="scope">
                    <span>{{ scope.row.total_cost }}</span>
                </template>
            </el-table-column>

            <el-table-column class-name="status-col" label="Status" width="170">
                <template slot-scope="{row}">
                    <el-tag :type="row.status | statusFilter">
                        {{ row.status }}
                    </el-tag>
                </template>
            </el-table-column>

            <el-table-column width="180px" align="center" label="Created At">
                <template slot-scope="scope">
                    <span>{{ scope.row.created_at | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
                </template>
            </el-table-column>

            <el-table-column align="center" label="Actions" width="120">
                <template slot-scope="scope">
                    <router-link :to="'/orders/edit/'+scope.row.id">
                        <el-button type="primary" size="small" icon="el-icon-edit">
                            Edit
                        </el-button>
                    </router-link>
                </template>
            </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit"
                    @pagination="getList"/>

        <el-dialog :title="'Create new Order'" :visible.sync="dialogFormVisible">
            <div v-loading="orderCreating" class="form-container">
                <el-form ref="orderForm" :rules="rules" :model="newOrder" label-position="left" label-width="150px" style="max-width: 500px;">
<!--                    <el-form-item :label="$t('user.role')" prop="role">-->
<!--                        <el-select v-model="newOrder.role" class="filter-item" placeholder="Please select role">-->
<!--                            <el-option v-for="item in nonAdminRoles" :key="item" :label="item | uppercaseFirst" :value="item" />-->
<!--                        </el-select>-->
<!--                    </el-form-item>-->
                    <el-form-item :label="$t('form.first_name')" :error="this.errors.phone_number[0]" required>
                        <el-input v-model="newOrder.phone_number"/>
                    </el-form-item>
<!--                    <el-form-item :label="$t('form.last_name')" :error="this.errors.last_name[0]" required>-->
<!--                        <el-input v-model="newOrder.last_name"/>-->
<!--                    </el-form-item>-->
<!--                    <el-form-item :label="$t('form.email')" :error="this.errors.email[0]" required>-->
<!--                        <el-input v-model="newOrder.email"/>-->
<!--                    </el-form-item>-->
<!--                    <el-form-item :label="$t('user.password')" :error="this.errors.password[0]" prop="password">-->
<!--                        <el-input v-model="newOrder.password" show-password />-->
<!--                    </el-form-item>-->
<!--                    <el-form-item :label="$t('user.password_confirmation')" prop="password_confirmation" required>-->
<!--                        <el-input v-model="newOrder.password_confirmation" show-password />-->
<!--                    </el-form-item>-->
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
    </div>
</template>

<script>
    import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
    import Resource from '@/api/resource';
    import waves from '@/directive/waves';
    import permission from "@/directive/permission";
    import role from "@/directive/role"; // Waves directive

    const orderResource = new Resource('orders');

    export default {
        name: 'OrderList',
        components: {Pagination},
        directives: { waves },
        filters: {
            statusFilter(status) {
                const statusMap = {
                    new: 'primary',
                    is_pending: 'info',
                    in_progress: 'primary',
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
                orderCreating: false,
                newOrder: {},
                defaultErrorsObject: {
                    phone_number: '',
                },
                errors: {},
                rules: {
                    phone_number: [{ required: true, message: 'Phone is required', trigger: 'change' }],
                },
            };
        },
        created() {
            this.getList();
            this.setDefaultErrors();
        },
        methods: {
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
            resetNewOrder() {
                this.newOrder = {
                    phone_number: '',
                    // last_name: '',
                    // email: '',
                    // password: '',
                    // password_confirmation: '',
                    // role: 'master',
                };
            },
            createOrder() {
                // this.$refs['userForm'].validate((valid) => {
                //     if (valid) {
                //         this.newUser.roles = [this.newUser.role];
                //         this.userCreating = true;
                //         userResource
                //             .store(this.newUser)
                //             .then(response => {
                //                 this.$message({
                //                     message: 'New user ' + this.newUser.name + '(' + this.newUser.email + ') has been created successfully.',
                //                     type: 'success',
                //                     duration: 5 * 1000,
                //                 });
                //                 this.resetNewUser();
                //                 this.setDefaultErrors();
                //                 this.dialogFormVisible = false;
                //                 this.handleFilter();
                //             })
                //             .catch(error => {
                //                 this.errors = error.response.data.data;
                //                 console.log(error);
                //             })
                //             .finally(() => {
                //                 this.userCreating = false;
                //             });
                //     } else {
                //         console.log('error submit!!');
                //         return false;
                //     }
                // });
            },
            setDefaultErrors() {
                this.errors = this.defaultErrorsObject
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
</style>
