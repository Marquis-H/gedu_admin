<template>
  <div class="container">
    <sticky :class-name="'sub-navbar draft'" :zIndex="3">
      <span style="color: #606060">请选择需要编辑的菜单</span>
      <el-select v-model="menu" filterable placeholder="请选择">
        <el-option v-for="item in menuOptions" :key="item.id" :label="item.text" :value="item.id"></el-option>
      </el-select>
      <span style="color: #606060">请在下面编辑你的菜单，或者点击这里</span>
      <el-button style="margin-right:10px" type="success" @click="handleCreateMenuMain()">
        <span>创建</span>
      </el-button>
    </sticky>
    <div class="app-container">
      <el-row :gutter="20">
        <el-col :sm="8">
          <el-card class="box-card">
            <el-select v-model="page" filterable placeholder="请选择">
              <el-option
                v-for="item, k in pageOptions"
                :key="item.id"
                :label="item.text"
                :value="k"
              ></el-option>
            </el-select>
            <el-button type="success" @click="add()">添加</el-button>
          </el-card>
        </el-col>
        <el-col :sm="16">
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>主菜单</span>
              <el-button style="float: right; padding: 3px 0" type="text">保存</el-button>
            </div>
            <VueNestable v-model="nestableItems" cross-list group="cross">
              <VueNestableHandle slot-scope="{ item }" :item="item">
                {{ item.text }}
                <span class="control">
                  <router-link to>
                    <svg-icon style="color:#478FCA" icon-class="edit"/>
                  </router-link>
                  <a @click="handeDel(item.id)">
                    <i style="color:#ff4949" class="el-icon-delete"/>
                  </a>
                </span>
              </VueNestableHandle>
            </VueNestable>
          </el-card>
        </el-col>
      </el-row>
    </div>
    <el-dialog title="创建菜单" :visible.sync="dialogFormVisible" width="60%">
      <el-form
        ref="dataForm"
        :rules="rules"
        :model="menuForm"
        label-position="left"
        label-width="80px"
        style="width: 80%; margin-left:50px;"
      >
        <el-form-item :label="$t('table.name')" prop="name">
          <el-input v-model="menuForm.name"/>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">{{ $t('table.cancel') }}</el-button>
        <el-button type="primary" @click="createMenuData()">{{ $t('table.confirm') }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { VueNestable, VueNestableHandle } from "vue-nestable";
import Sticky from "@/components/Sticky";

export default {
  name: "Menu",
  components: {
    VueNestable,
    VueNestableHandle,
    Sticky
  },
  data() {
    return {
      menu: "",
      page: "",
      dialogFormVisible: false,
      menuForm: {
        title: ""
      },
      rules: {
        name: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ]
      },
      menuOptions: [
        // {
        //   id: 1,
        //   text: "黄金糕"
        // },
        // {
        //   id: 2,
        //   text: "双皮奶"
        // }
      ],
      pageOptions: [
        // {
        //   id: 1,
        //   text: "黄金糕"
        // },
        // {
        //   id: 2,
        //   text: "双皮奶"
        // },
        // {
        //   id: 3,
        //   text: "蚵仔煎"
        // },
        // {
        //   id: 4,
        //   text: "龙须面"
        // },
        // {
        //   id: 5,
        //   text: "北京烤鸭"
        // }
      ],
      nestableItems: []
    };
  },
  watch: {
    menu: data => {
      console.log(data);
    }
  },
  methods: {
    // 创建菜单的主节点
    handleCreateMenuMain() {
      this.menuForm = {
        name: ""
      };
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs["dataForm"].clearValidate();
      });
    },
    createMenuData() {},
    // 添加page到menu
    add() {
      var index = this.page;
      var page = this.pageOptions[index];
      // 移除
      this.page = "";
      // 加入
      page.children = [];
      this.nestableItems.push(page);
    },
    // 删除menu
    handeDel(id) {
      console.log(id);
    }
  }
};
</script>

<style type="text/css">
.nestable {
  position: relative;
}
.nestable .nestable-list {
  margin: 0;
  padding: 0 0 0 40px;
  list-style-type: none;
}
.nestable > .nestable-list {
  padding: 0;
}
.nestable-item,
.nestable-item-copy {
  margin: 10px 0 0;
}
.nestable-item:first-child,
.nestable-item-copy:first-child {
  margin-top: 0;
}
.nestable-item .nestable-list,
.nestable-item-copy .nestable-list {
  margin-top: 10px;
}
.nestable-item {
  position: relative;
}
.nestable-item.is-dragging .nestable-list {
  pointer-events: none;
}
.nestable-item.is-dragging * {
  opacity: 0;
  filter: alpha(opacity=0);
}
.nestable-item.is-dragging:before {
  content: " ";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(106, 127, 233, 0.274);
  border: 1px dashed rgb(73, 100, 241);
  -webkit-border-radius: 5px;
  border-radius: 5px;
}
.nestable-drag-layer {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  pointer-events: none;
}
.nestable-drag-layer > .nestable-list {
  position: absolute;
  top: 0;
  left: 0;
  padding: 0;
  background-color: rgba(106, 127, 233, 0.274);
}
.nestable [draggable="true"] {
  cursor: move;
}
.nestable-handle {
  background-color: #fafafa;
  display: block;
  min-height: 38px;
  margin: 5px 0;
  padding: 8px 12px;
  border: 1px solid #dfdfdf;
  color: #606060;
}
.control {
  float: right;
}
</style>
