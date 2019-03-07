<template>
  <div class="container">
    <el-form ref="dataForm" :model="dataForm" :rules="rules" class="form-container">
      <sticky :class-name="'sub-navbar ' + status" :zIndex="3">
        <el-button v-loading="loading" style="margin-right:10px" type="success" @click="submitForm">
          <span v-if="isEdit">更新</span>
          <span v-else>创建</span>
        </el-button>
        <router-link :to="'/app_content/index'">
          <el-button>返回</el-button>
        </router-link>
      </sticky>
      <div class="page-main-container">
        <el-row :gutter="20">
          <el-col :sm="16">
            <el-form-item
              label-width="80px"
              label="标题"
              class="postInfo-container-item"
              prop="title"
            >
              <el-input v-model="dataForm.title"></el-input>
            </el-form-item>
            <el-form-item label-width="80px" label="照片" class="postInfo-container-item">
              <Upload v-model="photo" :value="dataForm.photo" @value="updatePhoto"/>
            </el-form-item>
            <el-form-item label-width="80px" label="摘要">
              <el-input v-model="dataForm.summary" :rows="2" type="textarea"/>
            </el-form-item>
            <el-form-item prop="content" style="margin-bottom: 30px;">
              <Tinymce ref="editor" :height="400" v-model="dataForm.content"/>
            </el-form-item>
            <el-form-item label-width="80px" label="额外信息">
              <el-input v-model="dataForm.extra" :rows="2" type="textarea"/>
            </el-form-item>
            <el-form-item :label="$t('table.contentCat')" prop="catId">
              <el-select v-model="dataForm.catId" placeholder="请选择">
                <el-option
                  v-for="(item, index) in contentCat"
                  :key="index"
                  :label="item.label"
                  :value="item.value"
                ></el-option>
              </el-select>
            </el-form-item>
            <el-form-item :label="$t('table.campus')" prop="campusId">
              <el-select v-model="dataForm.campusId" placeholder="请选择">
                <el-option
                  v-for="(item, index) in campus"
                  :key="index"
                  :label="item.label"
                  :value="item.value"
                ></el-option>
              </el-select>
            </el-form-item>
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
import {
  getContentDetail,
  createContent,
  updateContent,
  itemsContentCat
} from "@/api/content";
import { itemsCampus } from "@/api/campus";
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
      photo: "",
      contentCat: [],
      campus: [],
      dataForm: {
        title: "",
        photo: "",
        summary: "",
        content: "",
        extra: "",
        catId: "",
        campusId: ""
      },
      rules: {
        title: [
          {
            required: true,
            message: "请输入标题",
            trigger: "blur"
          }
        ],
        content: [
          {
            required: true,
            message: "请输入内容",
            trigger: "blur"
          }
        ],
        catId: [
          {
            required: true,
            message: "请选择分类",
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
      getContentDetail({ id })
        .then(res => {
          if (res.code === 0) {
            this.dataForm = res.data;
            this.photo = this.setting.domain + this.dataForm.photo;
          }
        })
        .catch(e => {
          this.$router.push({ path: "/404" });
        });
    }
    this.getContentCat();
    this.getCampus();
  },
  methods: {
    // 获取类别
    getContentCat() {
      itemsContentCat().then(res => {
        this.contentCat = res.data;
      });
    },
    // 校区
    getCampus() {
      itemsCampus().then(res => {
        this.campus = res.data;
      });
    },
    updatePhoto(value) {
      this.dataForm.photo = value;
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
      createContent(this.dataForm).then(res => {
        if (res.code == 100) {
          var message = res.data;
          this.showErrorMessage(message);
        } else {
          this.$router.push("/app_content/index");
          this.loading = true;
          this.$notify({
            title: "成功",
            message: "发布内容成功",
            type: "success",
            duration: 2000
          });
          this.status = "published";
          this.loading = false;
        }
      });
    },
    handleUpdate() {
      updateContent(this.dataForm).then(res => {
        if (res.code == 100) {
          var message = res.data;
          this.showErrorMessage(message);
        } else {
          this.loading = true;
          this.$notify({
            title: "成功",
            message: "更新内容成功",
            type: "success",
            duration: 2000
          });
          this.status = "published";
          this.loading = false;
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
