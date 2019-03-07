<template>
  <div class="container">
    <el-form ref="dataForm" :model="dataForm" :rules="rules" class="form-container">
      <sticky :class-name="'sub-navbar ' + status" :zIndex="3">
        <el-button v-loading="loading" style="margin-right:10px" type="success" @click="submitForm">
          <span v-if="isEdit">更新</span>
          <span v-else>创建</span>
        </el-button>
        <router-link :to="'/content/page'">
          <el-button>返回</el-button>
        </router-link>
      </sticky>
      <div class="page-main-container">
        <el-row :gutter="20">
          <el-col :sm="16">
            <el-form-item label-width="80px" label="路径" class="postInfo-container-item" prop="path">
              <el-input v-model="dataForm.path"></el-input>
            </el-form-item>
            <el-form-item label-width="80px" label="上线时间" class="postInfo-container-item">
              <el-date-picker
                v-model="dataForm.onlineAt"
                type="datetime"
                format="yyyy-MM-dd HH:mm:ss"
                placeholder="选择日期时间"
                value-format="yyyy-MM-dd HH:mm:ss"
              />
            </el-form-item>
            <el-form-item label-width="80px" label="下线时间" class="postInfo-container-item">
              <el-date-picker
                v-model="dataForm.offlineAt"
                type="datetime"
                format="yyyy-MM-dd HH:mm:ss"
                placeholder="选择日期时间"
                value-format="yyyy-MM-dd HH:mm:ss"
              />
            </el-form-item>
            <el-form-item label-width="80px" label="横幅" class="postInfo-container-item">
              <Upload v-model="banner" :value="dataForm.banner" @value="updateBanner"/>
            </el-form-item>
            <el-tabs style="margin-top:15px" type="border-card">
              <el-tab-pane label="中文" style="z-index:-1">
                <el-form-item
                  label-width="80px"
                  label="标题"
                  class="postInfo-container-item"
                  prop="zh.title"
                >
                  <el-input v-model="dataForm.zh.title"></el-input>
                </el-form-item>
                <el-form-item
                  label-width="80px"
                  label="菜单标题"
                  class="postInfo-container-item"
                  prop="navTitle"
                >
                  <el-input v-model="dataForm.zh.navTitle"></el-input>
                </el-form-item>
                <el-form-item
                  label-width="80px"
                  label="横幅"
                  class="postInfo-container-item"
                  prop="otherBanner"
                >
                  <Upload
                    v-model="otherBanner"
                    :value="dataForm.zh.otherBanner"
                    @value="updateOtherBanner"
                  />
                </el-form-item>
                <el-form-item label-width="80px" label="摘要">
                  <el-input v-model="dataForm.zh.summary" :rows="2" type="textarea"/>
                </el-form-item>
                <el-form-item prop="content" style="margin-bottom: 30px;">
                  <Tinymce ref="editor" :height="400" v-model="dataForm.zh.content"/>
                </el-form-item>
                <el-form-item label-width="120px" label="SEO标题">
                  <el-input v-model="dataForm.zh.metaTitle" :rows="4" type="textarea"/>
                </el-form-item>
                <el-form-item label-width="120px" label="SEO关键词">
                  <el-input v-model="dataForm.zh.keywords" :rows="4" type="textarea"/>
                </el-form-item>
                <el-form-item label-width="120px" label="SEO页面简介">
                  <el-input v-model="dataForm.zh.description" :rows="4" type="textarea"/>
                </el-form-item>
              </el-tab-pane>
            </el-tabs>
          </el-col>
          <el-col :sm="8">
            <el-card class="box-card">
              <div slot="header" class="clearfix">
                <span>修改历史</span>
              </div>
              <div></div>
            </el-card>
          </el-col>
        </el-row>
      </div>
    </el-form>
  </div>
</template>

<script>
import Sticky from "@/components/Sticky";
import Upload from "@/components/Upload/singleImage2";
import Tinymce from "@/components/Tinymce";
import { getPageDetail, createPage, updatePage } from "@/api/page";
import { mapGetters } from "vuex";

export default {
  name: "PageForm",
  components: { Sticky, Upload, Tinymce },
  props: {
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      loading: false,
      status: "draft",
      banner: "",
      otherBanner: "",
      dataForm: {
        path: "",
        onlineAt: "",
        offlineAt: "",
        banner: "",
        zh: {
          title: "",
          navTitle: "",
          otherBanner: "",
          summary: "",
          content: "",
          metaTitle: "",
          keywords: "",
          description: ""
        }
      },
      rules: {
        path: [
          {
            required: true,
            message: "请输入路径",
            trigger: "blur"
          }
        ],
        "zh.title": [
          {
            required: true,
            message: "请输入标题",
            trigger: "blur"
          }
        ]
      }
    };
  },
  computed: {
    ...mapGetters(["setting"])
  },
  created() {
    if (this.isEdit === true) {
      var id = this.$route.params.id;
      getPageDetail({ id })
        .then(res => {
          if (res.code === 0) {
            this.dataForm = res.data;
            this.banner = this.setting.domain + this.dataForm.banner;
            this.otherBanner = this.setting.domain + this.dataForm.zh.otherBanner;
          }
        })
        .catch(e => {
          this.$router.push({ path: "/404" });
        });
    }
  },
  methods: {
    updateBanner(value) {
      this.dataForm.banner = value;
    },
    updateOtherBanner(value) {
      this.dataForm.zh.otherBanner = value;
    },
    submitForm() {
      this.$refs.dataForm.validate(valid => {
        if (valid) {
          // 判断新增和更新
          if (this.isEdit == true) {
            this.handleUpdate();
          } else {
            this.handleCreate();
          }
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
    handleCreate() {
      var zh = this.dataForm.zh;
      delete this.dataForm.zh;
      createPage({ ...this.dataForm, ...zh }).then(res => {
        if (res.code == 100) {
          var message = res.data;
          this.showErrorMessage(message);
        } else {
          this.$router.push("/content/page");
          this.loading = true;
          this.$notify({
            title: "成功",
            message: "发布文章成功",
            type: "success",
            duration: 2000
          });
          this.status = "published";
          this.loading = false;
        }
      });
    },
    handleUpdate() {
      var zh = this.dataForm.zh;
      delete this.dataForm.zh;
      updatePage({ ...this.dataForm, ...zh }).then(res => {
        if (res.code == 100) {
          var message = res.data;
          this.showErrorMessage(message);
        } else {
          this.loading = true;
          this.$notify({
            title: "成功",
            message: "更新文章成功",
            type: "success",
            duration: 2000
          });
          this.status = "published";
          this.loading = false;

          this.dataForm.zh = zh;
        }
      });
    },
    showErrorMessage(message) {
      var newMessage = [];
      message.map(item => {
        newMessage.push(this.$t(item));
      });
      this.$message({
        message: newMessage.join("，"),
        type: "error"
      });
    }
  }
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "~@/styles/mixin.scss";
.container {
  position: relative;
  .page-main-container {
    padding: 40px 45px 40px 50px;
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
