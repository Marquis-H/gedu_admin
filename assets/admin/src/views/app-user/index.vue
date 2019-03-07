<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        :placeholder="$t('table.name')"
        v-model="listQuery.filters.name"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-input
        :placeholder="$t('table.phone')"
        v-model="listQuery.filters.phone"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-select
        v-model="listQuery.sortOrder"
        style="width: 140px"
        class="filter-item"
        @change="handleFilter"
      >
        <el-option
          v-for="item in sortOptions"
          :key="item.key"
          :label="item.label"
          :value="item.key"
        />
      </el-select>
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >{{ $t('table.search') }}</el-button>
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
      <el-table-column type="expand">
        <template slot-scope="scope">
          <el-form label-position="left" inline class="demo-table-expand">
            <el-form-item label="微信头像">
              <span v-if="scope.row.avatar">
                <img :src="scope.row.avatar">
              </span>
              <span v-else>-</span>
            </el-form-item>
            <el-form-item label="微信昵称">
              <span>{{ scope.row.nickname }}</span>
            </el-form-item>
          </el-form>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.id')" align="center" width="65">
        <template slot-scope="scope">
          <span>{{scope.row.id}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.name')" align="center" min-width="150">
        <template slot-scope="scope">
          <span>{{scope.row.name}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.gender')" align="center" min-width="150">
        <template slot-scope="scope">
          <span>{{scope.row.gender}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.birthday')" align="center" min-width="150">
        <template slot-scope="scope">
          <span>{{scope.row.birthday}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.phone')" align="center" min-width="150">
        <template slot-scope="scope">
          <span>{{scope.row.phone}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.integral')" align="center" min-width="100">
        <template slot-scope="scope">
          <span>{{scope.row.integral}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.enable')" align="center" width="120">
        <template slot-scope="scope">
          <span v-if="scope.row.isEnable">
            <svg-icon icon-class="yes" style="fill: #409EFF"/>
          </span>
          <span v-else>
            <svg-icon icon-class="close" style="fill: #f56c6c"/>
          </span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.isMember')" align="center" width="160">
        <template slot-scope="scope">
          <span v-if="scope.row.isMember">
            <svg-icon icon-class="yes" style="fill: #409EFF"/>
          </span>
          <span v-else>
            <svg-icon icon-class="close" style="fill: #f56c6c"/>
          </span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.campus')" align="center" width="160">
        <template slot-scope="scope">
          <span>{{scope.row.campus}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.createdAt')" align="center" width="160">
        <template slot-scope="scope">
          <span>{{scope.row.createdAt}}</span>
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
            size="small"
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
          </el-popover>
          <el-button type="success" size="small" @click="handleUpdateIntegral(scope.row)">积分扣除</el-button>
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
    <el-dialog title="积分扣除" :visible.sync="dialogFormVisibleIntegral" width="60%">
      <el-form
        ref="dataIntegralForm"
        :model="tempIntegral"
        :rules="integralRules"
        label-position="left"
        label-width="80px"
        style="width: 80%; margin-left:50px;"
      >
        <el-alert :title="'当前积分：'+tempIntegral.integral" :closable="false" type="success"></el-alert>
        <p></p>
        <el-form-item label="扣除积分" prop="reduceIntegral">
          <el-input v-model="tempIntegral.reduceIntegral" type="number"/>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisibleIntegral = false">{{ $t('table.cancel') }}</el-button>
        <el-button type="primary" @click="updateIntegral()">{{ $t('table.confirm') }}</el-button>
      </div>
    </el-dialog>
    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" width="60%">
      <el-form
        ref="dataForm"
        :rules="rules"
        :model="temp"
        label-position="left"
        label-width="80px"
        style="width: 80%; margin-left:50px;"
      >
        <el-form-item prop="isEnable">
          <el-checkbox v-model="temp.isEnable">{{$t('table.enable')}}</el-checkbox>
        </el-form-item>
        <el-form-item prop="isMember">
          <el-checkbox v-model="temp.isMember">{{$t('table.isMember')}}</el-checkbox>
        </el-form-item>
        <el-form-item :label="$t('table.name')" prop="name">
          <el-input v-model="temp.name"/>
        </el-form-item>
        <el-form-item :label="$t('table.gender')" prop="gender">
          <el-radio v-model="temp.gender" label="男">男</el-radio>
          <el-radio v-model="temp.gender" label="女">女</el-radio>
        </el-form-item>
        <el-form-item :label="$t('table.birthday')" prop="birthday">
          <el-date-picker
            type="date"
            value-format="yyyy-MM-dd"
            format="yyyy-MM-dd"
            placeholder="选择日期"
            v-model="temp.birthday"
          ></el-date-picker>
        </el-form-item>
        <el-form-item :label="$t('table.phone')" prop="phone">
          <el-input v-model="temp.phone"/>
        </el-form-item>
        <el-form-item :label="$t('table.campus')" prop="campusId">
          <el-select v-model="temp.campusId" placeholder="请选择">
            <el-option
              v-for="(item, index) in campus"
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
  getUserList,
  createUser,
  updateUser,
  updateIntegral
} from "@/api/appUser";
import { itemsCampus } from "@/api/campus";

export default {
  name: "AppUser",
  directives: {
    waves
  },
  data() {
    return {
      tableKey: 0,
      list: null,
      total: null,
      listLoading: false,
      listQuery: {
        page: 1,
        limit: 20,
        sortOrder: "ascend",
        filters: {
          name: undefined,
          phone: undefined
        }
      },
      sortOptions: [
        { label: "ID Ascending", key: "ascend" },
        { label: "ID Descending", key: "descend" }
      ],
      temp: {
        isEnable: true,
        isMember: true,
        name: "",
        gender: "男",
        birthday: "",
        phone: "",
        campusId: ""
      },
      tempIntegral: {
        id: "",
        integral: "",
        reduceIntegral: 0
      },
      campus: [],
      dialogFormVisible: false,
      dialogFormVisibleIntegral: false,
      dialogStatus: "",
      textMap: {
        update: this.$t("table.edit"),
        create: this.$t("table.add")
      },
      integralRules: {
        reduceIntegral: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ]
      },
      rules: {
        name: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ],
        gender: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ],
        phone: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ],
        campusId: [
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
    this.getCampus();
  },
  methods: {
    getList() {
      this.listLoading = true;
      getUserList(this.listQuery).then(res => {
        this.list = res.data.items;
        this.total = res.data.pagination.total;

        this.listLoading = false;
      });
    },
    // 获取校区
    getCampus() {
      itemsCampus().then(res => {
        this.campus = res.data;
      });
    },
    //搜索
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    //重置表单
    resetTemp() {
      this.temp = {
        isEnable: true,
        isMember: true,
        name: "",
        gender: "男",
        birthday: "",
        phone: "",
        campusId: ""
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
    createData() {
      this.$refs["dataForm"].validate(valid => {
        if (valid) {
          createUser(this.temp).then(res => {
            if (res.code == 100) {
              var message = res.data;
              this.showErrorMessage(message);
            } else {
              this.list.unshift(res.data);
              this.dialogFormVisible = false;
              this.total = this.total + 1;
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
    //编辑
    handleUpdate(row) {
      this.temp = Object.assign({}, row);
      this.dialogStatus = "update";
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs["dataForm"].clearValidate();
      });
    },
    handleUpdateIntegral(row) {
      this.tempIntegral = {
        id: row.id,
        integral: row.integral,
        reduceIntegral: 0
      };
      this.dialogFormVisibleIntegral = true;
      this.$nextTick(() => {
        this.$refs["dataIntegralForm"].clearValidate();
      });
    },
    updateIntegral() {
      this.$refs["dataIntegralForm"].validate(valid => {
        if (valid) {
          updateIntegral({
            id: this.tempIntegral.id,
            integral: this.tempIntegral.reduceIntegral
          }).then(res => {
            if (res.code == 100) {
              var message = res.message;
              this.showErrorMessage([message]);
            } else {
              for (const v of this.list) {
                if (v.id === this.tempIntegral.id) {
                  const index = this.list.indexOf(v);
                  this.list[index].integral = res.data.integral;
                  break;
                }
              }
              this.dialogFormVisibleIntegral = false;
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
    //更新数据
    updateData() {
      this.$refs["dataForm"].validate(valid => {
        if (valid) {
          const tempData = Object.assign({}, this.temp);
          updateUser(tempData).then(res => {
            if (res.code == 100) {
              var message = res.data;
              this.showErrorMessage(message);
            } else {
              for (const v of this.list) {
                if (v.id === this.temp.id) {
                  const index = this.list.indexOf(v);
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
.demo-table-expand {
  font-size: 0;
}
.demo-table-expand label {
  width: 90px;
  color: #99a9bf;
}
.demo-table-expand .el-form-item {
  margin-right: 0;
  margin-bottom: 0;
  width: 20%;
}
</style>
