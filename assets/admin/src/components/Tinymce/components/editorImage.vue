<template>
  <div class="upload-container">
    <el-button icon='el-icon-upload' size="mini" :style="{background:color,borderColor:color}" @click=" dialogVisible=true" type="primary">上传图片
    </el-button>
    <el-dialog :visible.sync="dialogVisible">
      <el-upload class="editor-slide-upload" :action="action" :multiple="true" :file-list="fileList" :show-file-list="true"
        list-type="picture-card" :on-remove="handleRemove" :on-success="handleSuccess" :before-upload="beforeUpload" :http-request="myUpload">
        <el-button size="small" type="primary">点击上传</el-button>
      </el-upload>
      <el-button @click="dialogVisible = false">取 消</el-button>
      <el-button type="primary" @click="handleSubmit">确 定</el-button>
    </el-dialog>
  </div>
</template>

<script>
// import { getToken } from 'api/qiniu'

export default {
  name: 'editorSlideUpload',
  props: {
    color: {
      type: String,
      default: '#1890ff'
    }
  },
  data() {
    return {
      dialogVisible: false,
      listObj: {},
      fileList: [],
      action: 'https://gedu.qidorg.com/v1/upload/image'
    }
  },
  methods: {
    checkAllSuccess() {
      return Object.keys(this.listObj).every(item => this.listObj[item].hasSuccess)
    },
    handleSubmit() {
      const arr = Object.keys(this.listObj).map(v => this.listObj[v])
      if (!this.checkAllSuccess()) {
        this.$message('请等待所有图片上传成功 或 出现了网络问题，请刷新页面重新上传！')
        return
      }
      this.$emit('successCBK', arr)
      this.listObj = {}
      this.fileList = []
      this.dialogVisible = false
    },
    handleSuccess(response, file) {
      const uid = file.uid
      const objKeyArr = Object.keys(this.listObj)
      for (let i = 0, len = objKeyArr.length; i < len; i++) {
        if (this.listObj[objKeyArr[i]].uid === uid) {
          this.listObj[objKeyArr[i]].url = response.file
          this.listObj[objKeyArr[i]].hasSuccess = true
          return
        }
      }
    },
    handleRemove(file) {
      const uid = file.uid
      const objKeyArr = Object.keys(this.listObj)
      for (let i = 0, len = objKeyArr.length; i < len; i++) {
        if (this.listObj[objKeyArr[i]].uid === uid) {
          delete this.listObj[objKeyArr[i]]
          return
        }
      }
    },
    beforeUpload(file) {
      const _self = this
      const _URL = window.URL || window.webkitURL
      const fileName = file.uid
      this.listObj[fileName] = {}
      return new Promise((resolve, reject) => {
        const img = new Image()
        img.src = _URL.createObjectURL(file)
        img.onload = function() {
          _self.listObj[fileName] = { hasSuccess: false, uid: file.uid, width: this.width, height: this.height }
        }
        resolve(true)
      })
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
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.editor-slide-upload {
  margin-bottom: 20px;
  /deep/ .el-upload--picture-card {
    width: 100%;
  }
}
</style>
