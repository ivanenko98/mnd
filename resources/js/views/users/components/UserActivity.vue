<template>
    <el-card v-if="user.full_name">
        <el-tabs v-model="activeActivity" @tab-click="handleClick">
            <el-tab-pane v-loading="updating" :label="$t('user.tabs.edit')" name="first">
                <user-edit :user="user" @updating="updatingUser" />
            </el-tab-pane>
            <el-tab-pane :label="$t('user.tabs.account')" name="second">
                <user-card :user="user" />
                <user-bio />
            </el-tab-pane>
            <el-tab-pane :label="$t('user.tabs.timeline')" name="third">
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
</template>

<script>
    import UserBio from '@/views/users/components/UserBio';
    import UserCard from '@/views/users/components/UserCard';
    import UserEdit from '@/views/users/components/UserEdit';

    export default {
        components: {UserBio, UserCard, UserEdit},
        props: {
            user: {
                type: Object,
            },
        },
        data() {
            return {
                activeActivity: 'first',
                carouselImages: [
                    'https://cdn.laravue.dev/photo1.png',
                    'https://cdn.laravue.dev/photo2.png',
                    'https://cdn.laravue.dev/photo3.jpg',
                    'https://cdn.laravue.dev/photo4.jpg',
                ],
                updating: false
            };
        },
        methods: {
            handleClick(tab, event) {
                console.log('Switching tab ', tab, event);
            },
            updatingUser(status) {
                this.updating = status;
            },
        }
    };
</script>

<style lang="scss" scoped>
    .user-activity {
        .user-block {
            .username, .description {
                display: block;
                margin-left: 50px;
                padding: 2px 0;
            }

            img {
                width: 40px;
                height: 40px;
                float: left;
            }

            :after {
                clear: both;
            }

            .img-circle {
                border-radius: 50%;
                border: 2px solid #d2d6de;
                padding: 2px;
            }

            span {
                font-weight: 500;
                font-size: 12px;
            }
        }

        .post {
            font-size: 14px;
            border-bottom: 1px solid #d2d6de;
            margin-bottom: 15px;
            padding-bottom: 15px;
            color: #666;

            .image {
                width: 100%;
            }

            .user-images {
                padding-top: 20px;
            }
        }

        .list-inline {
            padding-left: 0;
            margin-left: -5px;
            list-style: none;

            li {
                display: inline-block;
                padding-right: 5px;
                padding-left: 5px;
                font-size: 13px;
            }

            .link-black {
                &:hover, &:focus {
                    color: #999;
                }
            }
        }

        .el-carousel__item h3 {
            color: #475669;
            font-size: 14px;
            opacity: 0.75;
            line-height: 200px;
            margin: 0;
        }

        .el-carousel__item:nth-child(2n) {
            background-color: #99a9bf;
        }

        .el-carousel__item:nth-child(2n+1) {
            background-color: #d3dce6;
        }
    }
</style>
