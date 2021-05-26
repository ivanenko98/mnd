<template>
    <el-dropdown trigger="click" class="international" @command="handleSetLanguage">
        <div>
            <svg-icon class-name="international-icon" icon-class="language"/>
        </div>
        <el-dropdown-menu slot="dropdown">
            <el-dropdown-item :disabled="language==='uk'" command="uk">
                Українська
            </el-dropdown-item>
            <el-dropdown-item :disabled="language==='ru'" command="ru">
                Русский
            </el-dropdown-item>
            <el-dropdown-item :disabled="language==='en'" command="en">
                English
            </el-dropdown-item>
        </el-dropdown-menu>
    </el-dropdown>
</template>

<script>
    import UserResource from '@/api/user';
    const userResource = new UserResource();

    export default {
        computed: {
            language() {
                return this.$store.getters.language;
            },
        },
        methods: {
            handleSetLanguage(lang) {
                this.$i18n.locale = lang;
                this.$store.dispatch('app/setLanguage', lang);

                userResource.setLanguage(lang);

                this.$message({
                    message: this.$t('notifications.changed_language'),
                    type: 'success',
                });
            },
        },
    };
</script>

<style scoped>
    .international-icon {
        font-size: 20px;
        cursor: pointer;
        vertical-align: -5px !important;
    }
</style>

