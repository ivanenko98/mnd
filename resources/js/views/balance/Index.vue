<template>
    <div class="app-container">
        <el-tabs>
            <el-tab-pane :label="$t('balance.tabs.refill_account')">

                <div class="payment-methods">
                    <img class="payment-method-img" src="/images/logo_privat24.png" alt="">
                    <img class="payment-method-img" src="/images/logo_visa_mastercard.png" alt="">
                    <img class="payment-method-img" src="/images/logo_portmone.png" alt="">
                </div>

                <el-form ref="form" :model="form" class="refill-form">
                    <h4>{{ $t('balance.type_refill_sum') }}</h4>
                    <el-form-item>
                        <el-input v-model="form.name">
                            <template slot="append">грн</template>
                        </el-input>
                        <span>{{ $t('balance.type_refill_sum_warning') }}</span>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSubmit">
                            {{ $t('balance.refill') }}
                        </el-button>
                    </el-form-item>
                </el-form>


            </el-tab-pane>
            <el-tab-pane :label="$t('balance.tabs.history')">

                <el-table v-loading="listLoading" :data="list" border fit highlight-current-row style="max-width: 900px">
                    <el-table-column align="center" :label="$t('table.amount')" width="200px">
                        <template slot-scope="scope">
                            <span>{{ scope.row.amount + ' грн' }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column align="center" :label="$t('table.comment')">
                        <template slot-scope="scope">
                            <span>{{ scope.row.comment }}</span>
                        </template>
                    </el-table-column>
                </el-table>

                <pagination v-show="total>0" :total="total" :page.sync="query.page" :limit.sync="query.limit"
                            @pagination="getList"/>

            </el-tab-pane>
        </el-tabs>

    </div>
</template>

<script>
    import BalanceHistoryResource from '@/api/balance-history';
    import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

    const balanceHistoryResource = new BalanceHistoryResource();

    export default {
        components: {Pagination},
        data() {
            return {
                list: null,
                total: 0,
                listLoading: true,
                query: {
                    page: 1,
                    limit: 10,
                },
                form: {
                    name: '',
                    region: '',
                    date1: '',
                    date2: '',
                    delivery: false,
                    type: [],
                    resource: '',
                    desc: '',
                },
            };
        },
        methods: {
            onSubmit() {
                this.$message('submit!');
            },
            async getList() {
                const {limit, page} = this.query;
                this.listLoading = true;
                const {data, meta} = await balanceHistoryResource.list(this.query);
                this.list = data;
                this.list.forEach((element, index) => {
                    element['index'] = (page - 1) * limit + index + 1;
                });
                this.total = meta.total;
                this.listLoading = false;
            },
        },
        created() {
            this.getList();
        },
    };
</script>

<style scoped>
    .refill-form {
        width: 300px;
        display: block;
        margin: 0 auto;
    }

    .payment-methods {
        display: flex;
        justify-content: center;
        margin: 50px 0;
    }

    .payment-method-img {
        height: 45px;
        margin: 0 10px;
    }
</style>

