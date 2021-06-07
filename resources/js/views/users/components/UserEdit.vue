<template>
    <div v-if="user.full_name" class="user-edit">
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
                :maxSize="5000"
                :url="this.imageUploadUrl"
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

        <el-form-item v-if="onlyMaster" :label="$t('form.skills')" :error="this.errors.skills[0]">
            <el-drag-select v-model="user.skills" style="width:500px;" multiple :placeholder="$t('form.select_skills')">
                <el-option v-for="skill in skillsList" :key="skill.id" :label="skill.title" :value="skill.id" />
            </el-drag-select>
        </el-form-item>

        <el-button type="primary" @click="onSubmit">
            {{$t('form.update')}}
        </el-button>
    </div>
</template>

<script>

    import Resource from '@/api/resource';
    import SkillResource from "@/api/skill";
    import ImageCropper from '@/components/ImageCropper';
    import PanThumb from '@/components/PanThumb';
    import ElDragSelect from '@/components/DragSelect';
    import role from '@/directive/role';

    const userResource = new Resource('users');
    const skillResource = new SkillResource();

    export default {
        components: {ImageCropper, PanThumb, ElDragSelect},
        directives: {role},
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
                imagecropperShow: false,
                imagecropperKey: 0,
                selectedSkills: [],
                skillsList: [],
                errors: {},
                imageUploadUrl: ''
            };
        },
        methods: {
            onSubmit() {
                this.updatingEvent(true);
                userResource
                    .update(this.user.id, this.user)
                    .then(response => {
                        this.updatingEvent(false);

                        this.setDefaultErrors();

                        this.$message({
                            message: 'User information has been updated successfully',
                            type: 'success',
                            duration: 5 * 1000,
                        });
                    })
                    .catch(error => {
                        this.setErrors(error.response.data.data);
                        this.updatingEvent(false);
                    });
            },
            cropSuccess(resData) {
                this.imagecropperShow = false;
                this.imagecropperKey = this.imagecropperKey + 1;
                this.user.avatar = resData.data;
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
                this.errors = {
                    first_name: '',
                    last_name: '',
                    email: '',
                    about: '',
                    date_of_birth: '',
                    skills: '',
                };
            },
            setErrors(errors) {

                this.setDefaultErrors();

                for (let key in errors) {
                    this.errors[key] = errors[key];
                }
            },
            setImageUploadUrl(id) {
                this.imageUploadUrl = '/users/'+id+'/upload-avatar'
            },
            updatingEvent(status) {
                this.$emit('updating', status);
            }
        },
        watch: {
            user: function(newOne){
                this.setImageUploadUrl(newOne.id);
            }
        },
        computed: {
            onlyMaster() {
                return this.user.roles.find(element => element === 'master') !== undefined;
            }
        },
        created() {
            this.setDefaultErrors();
            this.getListSkills();
            this.setSelectedSkills();
        }
    }
</script>

<style scoped>

</style>
