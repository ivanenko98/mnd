<template>
  <div class="app-container">
    <el-form v-if="user" :model="user">
      <el-row :gutter="20">
        <el-col>
            <el-card>
                <user-edit :user="user" />
            </el-card>
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import UserEdit from './components/UserEdit';
import UserCard from './components/UserCard';
import UserActivity from './components/UserActivity';

export default {
  name: 'SelfProfile',
  components: { UserEdit, UserCard, UserActivity },
  data() {
    return {
      user: {},
    };
  },
  watch: {
    '$route': 'getUser',
  },
  created() {
    this.getUser();
  },
  methods: {
    async getUser() {
      const data = await this.$store.dispatch('user/getInfo');
      this.user = data;
    },
  },
};
</script>
