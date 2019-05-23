<template>
  <div class="app-container">
    <div class="filter-container">
      <el-button
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-edit"
        @click="handleCreate"
      >{{ $t('table.add') }}</el-button>
    </div>
    <el-table
      v-loading="listLoading"
      :key="tableKey"
      :data="list"
      border
      fit
      highlight-current-row
      style="width:100%"
    >
      <el-table-column label="名称" align="center">
        <template slot-scope="scope">
          <span>{{scope.row.name}}</span>
        </template>
      </el-table-column>
      <el-table-column label="Url" align="center">
        <template slot-scope="scope">
          <span>{{scope.row.url}}</span>
        </template>
      </el-table-column>
      <el-table-column label="Tab" align="center">
        <template slot-scope="scope">
          <span>{{scope.row.tab}}</span>
        </template>
      </el-table-column>
      <el-table-column label="类别" align="center">
        <template slot-scope="scope">
          <span>{{scope.row.cat}}</span>
        </template>
      </el-table-column>
      <el-table-column
        :label="$t('table.actions')"
        align="center"
        width="230"
        class-name="small-padding fixed-width"
      >
        <template slot-scope="scope">
          <el-button
            type="primary"
            size="mini"
            @click="handleUpdate(scope.row)"
          >{{ $t('table.edit') }}</el-button>
          <el-popover placement="top" width="160" v-model="scope.row.del">
            <p>{{$t('table.del_tips')}}</p>
            <div style="text-align:right; margin:0">
              <el-button
                size="mini"
                type="text"
                @click="scope.row.del = false"
              >{{$t('table.cancel')}}</el-button>
              <el-button
                size="mini"
                type="primary"
                @click="handleDelete(scope.row)"
              >{{ $t('table.confirm') }}</el-button>
            </div>
            <el-button
              size="mini"
              slot="reference"
              type="danger"
              @click="scope.row.del=true"
            >{{ $t('table.delete') }}</el-button>
          </el-popover>
        </template>
      </el-table-column>
    </el-table>
    <div class="pagination-container">
      <el-pagination
        v-show="total>0"
        :current-page="listQuery.page"
        :page-size="listQuery.limit"
        :total="total"
        background
        layout="total, prev, pager, next, jumper"
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
      />
    </div>
    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" width="60%">
      <el-form
        ref="dataForm"
        :rules="rules"
        :model="temp"
        label-position="left"
        label-width="80px"
        style="width: 80%; margin-left:50px;"
      >
        <el-form-item label="名称" prop="name">
          <el-input v-model="temp.name"/>
        </el-form-item>
        <el-form-item label="Url" prop="url">
          <el-input v-model="temp.url"/>
        </el-form-item>
        <el-form-item label="Tab" prop="tab">
          <el-input v-model="temp.tab"/>
        </el-form-item>
        <el-form-item label="翻译" prop="translation">
          <el-input
            v-model="temp.translation"
            type="textarea"
            :autosize="{ minRows: 8, maxRows: 8}"
          />
          <el-alert title="只支持添加原文" type="success" style="margin-top:5px;padding:0"></el-alert>
        </el-form-item>
        <el-form-item label="类别" prop="catId">
          <el-select v-model="temp.catId" placeholder="请选择">
            <el-option
              v-for="(item, index) in VoiceCat"
              :key="index"
              :label="item.label"
              :value="item.value"
            ></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">{{ $t('table.cancel') }}</el-button>
        <el-button
          type="primary"
          @click="dialogStatus === 'create'?createData():updateData()"
        >{{ $t('table.confirm') }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import waves from "../../directive/waves";
import {
  getVoiceList,
  createVoice,
  updateVoice,
  deleteVoice
} from "@/api/voice";
import { itemsVoiceCat } from "@/api/voice";

export default {
  name: "Voice",
  directives: {
    waves
  },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: 0,
      listLoading: false,
      listQuery: {
        page: 1,
        limit: 20,
        sortOrder: "ascend",
        filters: {}
      },
      sortOptions: [
        { label: "ID Ascending", key: "ascend" },
        { label: "ID Descending", key: "descend" }
      ],
      image: "",
      temp: {
        name: "",
        url: "",
        tab: "",
        catId: "",
        translation: ""
      },
      VoiceCat: [],
      dialogFormVisible: false,
      dialogStatus: "",
      textMap: {
        update: this.$t("table.edit"),
        create: this.$t("table.add")
      },
      rules: {
        name: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ],
        url: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ],
        catId: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ]
      }
    };
  },
  created() {
    this.getList();
    this.getVoiceCat();
  },
  methods: {
    getList() {
      this.listLoading = true;
      getVoiceList(this.listQuery).then(res => {
        this.list = res.data.items;
        this.total = res.data.pagination.total;

        this.listLoading = false;
      });
    },
    // 校区
    getVoiceCat() {
      itemsVoiceCat().then(res => {
        this.VoiceCat = res.data;
      });
    },
    //重置表单
    resetTemp() {
      this.temp = {
        name: "",
        url: "",
        tab: "",
        catId: "",
        translation: ""
      };
    },
    //新增
    handleCreate() {
      this.resetTemp();
      this.dialogStatus = "create";
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs["dataForm"].clearValidate();
      });
    },
    //保存数据
    createData() {
      this.$refs["dataForm"].validate(valid => {
        if (valid) {
          createVoice(this.temp).then(res => {
            if (res.code == 100) {
              var message = res.data;
              this.showErrorMessage(message);
            } else {
              this.list.unshift(res.data);
              this.total = this.total + 1;
              this.dialogFormVisible = false;
              this.$notify({
                title: this.$t("table.success"),
                message: this.$t("table.create_success_tips"),
                type: "success",
                duration: 2000
              });
            }
          });
        }
      });
    },
    //更新
    handleUpdate(row) {
      this.temp = Object.assign({}, row);
      this.dialogStatus = "update";
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs["dataForm"].clearValidate();
      });
    },
    //更新数据
    updateData() {
      this.$refs["dataForm"].validate(valid => {
        if (valid) {
          const tempData = Object.assign({}, this.temp);
          updateVoice(tempData).then(res => {
            if (res.code == 100) {
              var message = res.data;
              this.showErrorMessage(message);
            } else {
              for (const v of this.list) {
                if (v.id === this.temp.id) {
                  const index = this.list.indexOf(v);
                  this.temp.cat = res.data.cat;
                  this.list.splice(index, 1, this.temp);
                  break;
                }
              }
              this.dialogFormVisible = false;
              this.$notify({
                title: this.$t("table.success"),
                message: this.$t("table.update_success_tips"),
                type: "success",
                duration: 2000
              });
            }
          });
        }
      });
    },
    //删除
    handleDelete(row) {
      this.$notify({
        title: this.$t("table.success"),
        message: this.$t("table.delete_success_tips"),
        type: "success",
        duration: 2000
      });
      deleteVoice({ id: row.id }).then(() => {
        const index = this.list.indexOf(row);
        this.list.splice(index, 1);
        this.total = this.total - 1;
      });
    },
    handleSizeChange(val) {
      this.listQuery.limit = val;
      this.getList();
    },
    handleCurrentChange(val) {
      this.listQuery.page = val;
      this.getList();
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

<style>
</style>
