<template>
  <div class="singleImageUpload2 upload-container">
    <el-upload class="image-uploader" drag :multiple="false" :show-file-list="false" :action="action"
      :on-success="handleImageScucess"
      :http-request="myUpload">
      <i class="el-icon-upload"></i>
      <div class="el-upload__text">Drag或<em>点击上传</em></div>
    </el-upload>
    <div v-show="imageUrl.length>0" class="image-preview">
      <div class="image-preview-wrapper" v-show="imageUrl.length>1">
        <img :src="imageUrl">
        <div class="image-preview-action">
          <i @click="rmImage" class="el-icon-delete"></i>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "singleImageUpload2",
  props: {
    value: String
  },
  computed: {
    imageUrl() {
      return this.value;
    }
  },
  data() {
    return {
      tempUrl: "",
      action: 'https://gedu.qidorg.com/v1/upload/image'
    };
  },
  methods: {
    rmImage() {
      this.emitInput("");
      this.emitValue("");
    },
    emitInput(val) {
      this.$emit("input", val);
    },
    emitValue(val) {
      this.$emit("value", val);
    },
    handleImageScucess(response, file, fileList) {
      this.tempUrl = file.url;
      this.emitInput(this.tempUrl); //显示图片
      this.emitValue(response.file); //实际的值
    },
    myUpload(data) {
      var xhr = new XMLHttpRequest();
      var file = data.file;
      if (xhr.upload) {
        xhr.upload.onprogress = function progress(e) {
          if (e.total > 0) {
            e.percent = (e.loaded / e.total) * 100;
          }
          data.onProgress(e);
        };
      }
      const formData = new FormData();
      if (data.data) {
        Object.keys(data.data).map(function(key) {
          formData.append(key, data.data[key]);
        });
      }
      formData.append(data.filename, data.file);
      xhr.onerror = function error(e) {
        data.onError(e);
      };

      xhr.onload = function onLoad() {
        if (xhr.status < 200 || xhr.status >= 300) {
          return data.onError(getError(action, data, xhr));
        }

        data.onSuccess(getBody(xhr));
      };
      function getError(action, option, xhr) {
        var msg;
        if (xhr.response) {
          msg = xhr.status + (xhr.response.error || xhr.response);
        } else if (xhr.responseText) {
          msg = xhr.status + xhr.responseText;
        } else {
          msg = "fail to post " + action + xhr.status;
        }

        const err = new Error(msg);
        err.status = xhr.status;
        err.method = "post";
        err.url = action;
        return err;
      }

      function getBody(xhr) {
        const text = xhr.responseText || xhr.response;
        if (!text) {
          return text;
        }

        try {
          var repo = JSON.parse(text);
          return repo.data;
        } catch (e) {
          return text;
        }
      }

      xhr.open("post", data.action, true);
      if (data.withCredentials && "withCredentials" in xhr) {
        xhr.withCredentials = true;
      }
      xhr.setRequestHeader("X-File-Name", encodeURIComponent(file.name));
      xhr.setRequestHeader("X-File-Size", file.size);
      xhr.send(file);
    }
  }
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.upload-container {
  width: 50%;
  height: 100%;
  position: relative;
  .image-uploader {
    height: 100%;
  }
  .image-preview {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0px;
    top: 0px;
    border: 1px dashed #d9d9d9;
    .image-preview-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
      img {
        width: 100%;
        height: 100%;
      }
    }
    .image-preview-action {
      position: absolute;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      cursor: default;
      text-align: center;
      color: #fff;
      opacity: 0;
      font-size: 20px;
      background-color: rgba(0, 0, 0, 0.5);
      transition: opacity 0.3s;
      cursor: pointer;
      text-align: center;
      line-height: 200px;
      .el-icon-delete {
        font-size: 36px;
      }
    }
    &:hover {
      .image-preview-action {
        opacity: 1;
      }
    }
  }
}
</style>
