<template>
  <div class="container">
    <el-form ref="form" :model="formData" class="form-container">
      <div class="form-main-container">
        <el-form-item label-width="80px" :label="$t('form.system_name')">
          <el-input
            v-model="formData.system_name"
            type="text"
            class="input"
            autosize
            :placeholder="$t('form.placeholder_name')"
          />
        </el-form-item>
        <el-form-item label-width="80px" label="LOGO">
          <Upload v-model="image" :value="formData.logo" @value="updateValue"/>
        </el-form-item>
        <el-button type="primary" icon="el-icon-document" @click="submit">{{$t('form.save')}}</el-button>
      </div>
    </el-form>
  </div>
</template>

<script>
import Upload from "@/components/Upload/singleImage2";
import { getSetting, createSetting } from "@/api/setting";
import { mapGetters } from "vuex";

export default {
  name: "SettingSystem",
  components: { Upload },
  data() {
    return {
      image: "",
      formData: {
        system_name: "",
        logo: ""
      },
      loading: false,
      listQuery: {
        identify: "_system"
      }
    };
  },
  computed: {
    ...mapGetters(["setting"])
  },
  created() {
    this.getList();
  },
  methods: {
    //获取数据
    getList() {
      this.loading = true;
      getSetting(this.listQuery).then(res => {
        if (!Array.isArray(res.data)) {
          this.formData = res.data;
          this.image = this.setting.domain + this.formData.logo;
        }

        this.loading = false;
      });
    },
    updateValue(value) {
      this.formData.logo = value;
    },
    submit() {
      this.$refs["form"].validate(valid => {
        if (valid) {
          createSetting(this.formData, "_system").then(res => {
            this.$notify({
              title: this.$t("table.success"),
              message: this.$t("table.create_success_tips"),
              type: "success",
              duration: 2000
            });
          });
        }
      });
    }
  }
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "src/styles/mixin.scss";
.container {
  position: relative;
  .form-main-container {
    padding: 40px 45px 20px 50px;
  }
}
</style>