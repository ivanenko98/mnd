<template>
    <el-card v-if="user.full_name">
        <el-tabs v-model="activeActivity" @tab-click="handleClick">
            <el-tab-pane v-loading="updating" :label="$t('user.tabs.edit')" name="first">
                <el-form-item>
                    <pan-thumb :image="user.avatar"/>

                    <el-button type="primary" icon="upload" style="position: absolute;bottom: 15px;margin-left: 40px;"
                               @click="imagecropperShow=true">
                        {{$t('form.change_avatar')}}
                    </el-button>

                    <image-cropper
                        v-show="imagecropperShow"
                        :key="imagecropperKey"
                        :width="300"
                        :height="300"
                        url="https://httpbin.org/post"
                        lang-type="en"
                        @close="closeCrop"
                        @crop-upload-success="cropSuccess"
                    />
                </el-form-item>
                <el-form-item>
                    <el-col :span="11">
                        <el-form-item :label="$t('form.first_name')" :error="this.errors.first_name[0]">
                            <el-input v-model="user.first_name"/>
                        </el-form-item>
                    </el-col>
                    <el-col :span="11">
                        <el-form-item :label="$t('form.last_name')" :error="this.errors.last_name[0]">
                            <el-input v-model="user.last_name"/>
                        </el-form-item>
                    </el-col>
                </el-form-item>

                <el-form-item :label="$t('form.email')">
                    <el-input v-model="user.email" :error="this.errors.email[0]"/>
                </el-form-item>

                <el-form-item :label="$t('form.about')">
                    <el-input v-model="user.about" type="textarea" :error="this.errors.about[0]"/>
                </el-form-item>

                <el-form-item :label="$t('form.date_of_birth')" :error="this.errors.date_of_birth[0]">
                    <el-date-picker v-model="user.date_of_birth" :placeholder="$t('form.pick_date')" type="date" format="yyyy-MM-dd" value-format="yyyy-MM-dd"/>
                </el-form-item>

                <el-form-item :label="$t('form.skills')" :error="this.errors.skills[0]">
                    <el-drag-select v-model="user.skills" style="width:500px;" multiple :placeholder="$t('form.select_skills')">
                        <el-option v-for="skill in skillsList" :key="skill.id" :label="skill.title" :value="skill.id" />
                    </el-drag-select>
                </el-form-item>

                <el-button type="primary" @click="onSubmit">
                    Update
                </el-button>
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
    import Resource from '@/api/resource';
    const userResource = new Resource('users');
    import SkillResource from "@/api/skill";
    const skillResource = new SkillResource();

    import ImageCropper from '@/components/ImageCropper';
    import PanThumb from '@/components/PanThumb';
    import UserBio from '@/views/users/components/UserBio';
    import UserCard from '@/views/users/components/UserCard';
    import ElDragSelect from '@/components/DragSelect';
    import UserResource from "@/api/user";

    export default {
        components: {ImageCropper, PanThumb, UserBio, UserCard, ElDragSelect},
        props: {
            user: {
                type: Object,
                default: () => {
                    return {
                        first_name: '',
                        last_name: '',
                        email: '',
                        avatar: '',
                        about: '',
                        date_of_birth: '',
                        roles: [],
                        skills: [],
                    };
                },
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
                updating: false,
                imagecropperShow: false,
                imagecropperKey: 0,
                selectedSkills: [],
                skillsList: [],
                defaultErrorsObject: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    about: '',
                    date_of_birth: '',
                    skills: '',
                },
                errors: {}
            };
        },
        methods: {
            handleClick(tab, event) {
                console.log('Switching tab ', tab, event);
            },
            onSubmit() {
                this.updating = true;
                userResource
                    .update(this.user.id, this.user)
                    .then(response => {
                        this.updating = false;
                        this.setDefaultErrors();

                        this.$message({
                            message: 'User information has been updated successfully',
                            type: 'success',
                            duration: 5 * 1000,
                        });
                    })
                    .catch(error => {


                        this.errors = error.response.data.data;

                        console.log(error.response.data.data);

                        this.updating = false;
                    });
            },
            cropSuccess(resData) {
                this.imagecropperShow = false;
                this.imagecropperKey = this.imagecropperKey + 1;
                this.image = resData.files.avatar;
            },
            closeCrop() {
                this.imagecropperShow = false;
            },
            async getListSkills() {
                const { data } = await skillResource.list({});
                this.skillsList = data;
            },
            setSelectedSkills() {
                this.selectedSkills = this.user.skills
            },
            setDefaultErrors() {
                this.errors = this.defaultErrorsObject
            },
        },
        created() {
            this.setDefaultErrors();
            this.getListSkills();
            this.setSelectedSkills();
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
