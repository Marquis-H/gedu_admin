<template>
  <div class="container">
    <el-form ref="form" :model="formData" class="form-container">
      <div class="form-main-container">
        <el-form-item label-width="120px" :label="$t('form.website_name')">
          <el-input
            v-model="formData.system_name"
            type="text"
            class="input"
            autosize
            :placeholder="$t('form.placeholder_name')"
          />
        </el-form-item>
        <el-form-item label-width="120px" :label="$t('form.page_title_format')">
          <el-input
            v-model="formData.page_title_format"
            type="text"
            class="input"
            autosize
            :placeholder="$t('form.placeholder_name')"
          />
          <el-alert
            :title="$t('form.page_title_format_tips')"
            type="success"
            class="page_title_format_tips"
            :closable="false"
          ></el-alert>
        </el-form-item>
        <el-form-item label-width="120px" :label="$t('form.website_keywords')">
          <el-input
            v-model="formData.website_keywords"
            type="text"
            class="input"
            autosize
            :placeholder="$t('form.placeholder_name')"
          />
        </el-form-item>
        <el-form-item label-width="120px" :label="$t('form.website_description')">
          <el-input
            v-model="formData.website_description"
            :rows="5"
            type="textarea"
            :placeholder="$t('form.placeholder_name')"
          />
        </el-form-item>
        <el-form-item label-width="120px" :label="$t('form.custom_style')">
          <el-input
            v-model="formData.custom_style"
            :rows="5"
            type="textarea"
            :placeholder="$t('form.placeholder_name')"
          />
        </el-form-item>
        <el-form-item label-width="120px" label="分享积分">
          <el-input v-model="formData.share_integral" type="number" class="input" autosize/>
        </el-form-item>
        <el-form-item label-width="120px" label="分享注册积分">
          <el-input v-model="formData.share_reg_integral" type="number" class="input" autosize/>
        </el-form-item>
        <el-form-item label-width="120px" label="单词打卡积分">
          <el-input v-model="formData.word_integral" type="number" class="input" autosize/>
        </el-form-item>
        <el-form-item label-width="120px" label="每天积分上限">
          <el-input v-model="formData.each_day_integral" type="number" class="input" autosize/>
          <el-alert
            title="分享积分上限|分享注册积分上限|单词打卡积分上限|单词打卡满30天积分上限"
            type="success"
            class="page_title_format_tips"
            :closable="false"
          ></el-alert>
        </el-form-item>
        <el-form-item label-width="120px" label="分享活动规则">
          <el-input
            v-model="formData.shate_tips"
            :rows="8"
            type="textarea"
            placeholder="请输入分享活动规则"
          />
        </el-form-item>
        <el-button type="primary" icon="el-icon-document" @click="submit">{{$t('form.save')}}</el-button>
      </div>
    </el-form>
  </div>
</template>

<script>
import Upload from "@/components/Upload/singleImage2";
import { getSetting, createSetting } from "@/api/setting";

export default {
  name: "SettingFrontend",
  components: { Upload },
  data() {
    return {
      image: "",
      formData: {
        website_name: "",
        page_title_format: "",
        website_keywords: "",
        website_description: "",
        custom_style: "",
        share_integral: 0,
        share_reg_integral: 0,
        each_day_integral: 0,
        word_integral: 0,
        shate_tips: ''
      },
      loading: false,
      listQuery: {
        identify: "_frontend"
      }
    };
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
          this.image = this.formData.logo;
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
          createSetting(this.formData, "_frontend").then(res => {
            this.$notify({
              title: this.$t("table.success"),
              message: this.$t("table.update_success_tips"),
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
  .page_title_format_tips {
    padding: 0;
    margin-top: 8px;
  }
}
</style>