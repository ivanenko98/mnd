<template>
    <div class="app-container">
        <el-form v-if="order" :model="order">
            <el-row>
                <el-col>
                    <el-card v-if="order.id">
                        <el-tabs v-model="activeTab">
                            <el-tab-pane v-loading="updating" :label="$t('order.tabs.edit')" name="first">
                                <el-row>
                                    <el-col :span="18">
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
                                            <!--                                                            <el-form-item>-->
                                            <!--                                                                <el-col :span="11">-->
                                            <!--                                                                    <el-form-item :label="$t('form.first_name')" :error="this.errors.first_name[0]">-->
                                            <!--                                                                        <el-input v-model="user.first_name"/>-->
                                            <!--                                                                    </el-form-item>-->
                                            <!--                                                                </el-col>-->
                                            <!--                                                                <el-col :span="11">-->
                                            <!--                                                                    <el-form-item :label="$t('form.last_name')" :error="this.errors.last_name[0]">-->
                                            <!--                                                                        <el-input v-model="user.last_name"/>-->
                                            <!--                                                                    </el-form-item>-->
                                            <!--                                                                </el-col>-->
                                            <!--                                                            </el-form-item>-->

                                            <!--                                                            <el-form-item :label="$t('form.email')">-->
                                            <!--                                                                <el-input v-model="user.email" :error="this.errors.email[0]"/>-->
                                            <!--                                                            </el-form-item>-->

                                            <!--                                                            <el-form-item :label="$t('form.about')">-->
                                            <!--                                                                <el-input v-model="user.about" type="textarea" :error="this.errors.about[0]"/>-->
                                            <!--                                                            </el-form-item>-->

                                            <!--                                                            <el-form-item :label="$t('form.date_of_birth')" :error="this.errors.date_of_birth[0]">-->
                                            <!--                                                                <el-date-picker v-model="user.date_of_birth" :placeholder="$t('form.pick_date')" type="date" format="yyyy-MM-dd" value-format="yyyy-MM-dd"/>-->
                                            <!--                                                            </el-form-item>-->

                                            <!--                                                            <el-form-item :label="$t('form.skills')" :error="this.errors.skills[0]">-->
                                            <!--                                                                <el-drag-select v-model="user.skills" style="width:500px;" multiple :placeholder="$t('form.select_skills')">-->
                                            <!--                                                                    <el-option v-for="skill in skillsList" :key="skill.id" :label="skill.title" :value="skill.id" />-->
                                            <!--                                                                </el-drag-select>-->
                                            <!--                                                            </el-form-item>-->

                                            <el-button type="primary" @click="onSubmit">
                                                {{$t('form.save')}}
                                            </el-button>
                                        </el-card>
                                    </el-col>

                                    <el-col :span="5" :offset="1">
                                        <el-card>
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
            };
        },
        watch: {
            order: function (newOrder) {
                if (newOrder.master !== null) {
                    this.masterAvatar = newOrder.master_avatar;
                }
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
                            message: 'Order information has been updated successfully',
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
            setDefaultErrors() {
                this.errors = {
                    phone_number: '',
                    services: '',
                    city: '',
                    address: '',
                    comment: '',
                    master: '',
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

    .createPost-container {
        position: relative;

        .createPost-main-container {
            padding: 0 45px 20px 50px;

            .postInfo-container {
                position: relative;
                @include clearfix;
                margin-bottom: 10px;

                .postInfo-container-item {
                    float: left;
                }
            }
        }

        .word-counter {
            width: 40px;
            position: absolute;
            right: -10px;
            top: 0px;
        }
    }
</style>
<style>
    .createPost-container label.el-form-item__label {
        text-align: left;
    }
</style>
