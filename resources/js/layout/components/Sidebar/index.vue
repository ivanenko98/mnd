<template>
  <div :class="{'has-logo':showLogo}">
    <logo v-if="showLogo" :collapse="isCollapse" />
          <div v-role="['master']" class="user-block">
              <pan-thumb :image="avatar" class="main-photo" :hoverable="false"/>

              <div class="box-center">
                  <div class="user-name text-center">
                      {{name}}
                  </div>
              </div>
          </div>
    <el-scrollbar wrap-class="scrollbar-wrapper">
      <el-menu
        :show-timeout="200"
        :default-active="$route.path"
        :collapse="isCollapse"
        :background-color="variables.menuBg"
        :text-color="variables.menuText"
        :active-text-color="variables.menuActiveText"
        mode="vertical"
      >
        <sidebar-item
          v-for="route in routes"
          :key="route.path"
          :item="route"
          :base-path="route.path"
        />
      </el-menu>
    </el-scrollbar>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import SidebarItem from './SidebarItem';
import Logo from './Logo';
import variables from '@/styles/variables.scss';
import PanThumb from '@/components/PanThumb';
import role from '@/directive/role';

export default {
  components: { SidebarItem, Logo , PanThumb},
    directives: { role },
  computed: {
    ...mapGetters(['sidebar', 'permission_routers', 'avatar', 'name']),
    routes() {
      return this.$store.state.permission.routes;
    },
    showLogo() {
      return this.$store.state.settings.sidebarLogo;
    },
    variables() {
      return variables;
    },
    isCollapse() {
      return !this.sidebar.opened;
    },
  },
};
</script>

<style lang="scss" scoped>

    .user-block {
        display: block;

        .main-photo {
            display: block;
            margin: 10px auto;
        }

        .user-name {
            font-size: 17px;
            color: #ffffff;
            margin: 20px 0;
        }
    }

</style>
