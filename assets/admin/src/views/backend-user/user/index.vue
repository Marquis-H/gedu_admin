<template>
    <div class="app-container">
        <div class="filter-container">
            <el-input :placeholder="$t('table.username')" v-model="listQuery.filters.username" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter"/>
            <el-select v-model="listQuery.sortOrder" style="width: 140px" class="filter-item" @change="handleFilter">
                <el-option v-for="item in sortOptions" :key="item.key" :label="item.label" :value="item.key"/>
            </el-select>
            <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">{{ $t('table.search') }}</el-button>
            <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleCreate">{{ $t('table.add') }}</el-button>
        </div>
      <el-table
        v-loading="listLoading"
        :key="tableKey"
        :data="list"
        border
        fit
        highlight-current-row
        style="width:100%">
          <el-table-column :label="$t('table.id')" align="center" width="65">
            <template slot-scope="scope">
              <span>{{scope.row.id}}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.active')" align="center" width="65">
            <template slot-scope="scope">
              <span v-if="scope.row.isActive"><svg-icon icon-class="yes" style="fill: #409EFF" /></span>
              <span v-else><svg-icon icon-class="close" style="fill: #f56c6c" /></span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.username')" align="center" min-width="150">
            <template slot-scope="scope">
              <span>{{scope.row.username}}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.isSuperAdmin')" align="center" width="120">
            <template slot-scope="scope">
              <span v-if="scope.row.isSuperAdmin"><svg-icon icon-class="yes" style="fill: #409EFF" /></span>
              <span v-else><svg-icon icon-class="close" style="fill: #f56c6c" /></span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.name')" align="center" width="150">
            <template slot-scope="scope">
              <span>{{scope.row.name}}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.email')" align="center" width="160">
            <template slot-scope="scope">
              <span>{{scope.row.email}}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.lastLogin')" align="center" width="160">
            <template slot-scope="scope">
              <span>{{scope.row.lastLogin}}</span>
            </template>
          </el-table-column>
          <el-table-column :label="$t('table.actions')" align="center" width="230" class-name="small-padding fixed-width">
            <template slot-scope="scope">
              <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">{{ $t('table.edit') }}</el-button>
              <el-popover
                placement="top"
                width="160"
                v-model="scope.row.del">
                <p>{{$t('table.del_tips')}}</p>
                <div style="text-align:right; margin:0">
                  <el-button size="mini" type="text" @click="scope.row.del = false">{{$t('table.cancel')}}</el-button>
                  <el-button size="mini" type="primary" @click="handleDelete(scope.row)">{{ $t('table.confirm') }}</el-button>
                </div>
                <el-button size="mini" slot="reference" type="danger" @click="scope.row.del=true">{{ $t('table.delete') }}</el-button>
              </el-popover>
            </template>
          </el-table-column>
      </el-table>
      <div class="pagination-container">
        <el-pagination v-show="total>0" :current-page="listQuery.page" :page-size="listQuery.limit" :total="total" background layout="total, prev, pager, next, jumper" @size-change="handleSizeChange" @current-change="handleCurrentChange" />
      </div>

      <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" width="60%">
        <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="80px" style="width: 80%; margin-left:50px;">
          <el-form-item prop="isActive">
            <el-checkbox v-model="temp.isActive" >{{$t('table.active')}}</el-checkbox>
          </el-form-item>
          <el-form-item prop="isSuperAdmin">
            <el-checkbox v-model="temp.isSuperAdmin">{{$t('table.isSuperAdmin')}}</el-checkbox>
          </el-form-item>
          <el-form-item :label="$t('table.username')" prop="username">
            <el-input v-model="temp.username"/>
          </el-form-item>
          <el-form-item :label="$t('table.email')" prop="email">
            <el-input v-model="temp.email" />
          </el-form-item>
          <el-form-item :label="$t('table.password')" prop="password">
            <el-input type="password" v-model="temp.password" />
          </el-form-item>
          <el-form-item :label="$t('table.checkPass')" prop="checkPass">
            <el-input type="password" v-model="temp.checkPass" />
          </el-form-item>
          <el-form-item :label="$t('table.firstname')" prop="firstname">
            <el-input v-model="temp.firstname" />
          </el-form-item>
          <el-form-item :label="$t('table.lastname')" prop="lastname">
            <el-input v-model="temp.lastname" />
          </el-form-item>
          <el-form-item :label="$t('route.role')" prop="role">
            <el-checkbox-group v-model="temp.role">
              <el-checkbox v-for="(item, index) in roles" :label="item.value" :key="index">{{item.label}}</el-checkbox>
            </el-checkbox-group>
          </el-form-item>
          <el-form-item :label="$t('route.group')" prop="group">
            <el-checkbox-group v-model="temp.group">
              <el-checkbox v-for="(item, index) in groups" :label="item.value" :key="index">{{item.label}}</el-checkbox>
            </el-checkbox-group>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">{{ $t('table.cancel') }}</el-button>
          <el-button type="primary" @click="dialogStatus === 'create'?createData():updateData()">{{ $t('table.confirm') }}</el-button>
        </div>
      </el-dialog>
    </div>
</template>

<script>
import waves from "../../../directive/waves";
import {
  getUserList,
  createUser,
  updateUser,
  deleteUser,
  itemsRole,
  itemsGroup
} from "@/api/user";

export default {
  name: "BackendUser",
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
          username: undefined
        }
      },
      sortOptions: [
        { label: "ID Ascending", key: "ascend" },
        { label: "ID Descending", key: "descend" }
      ],
      temp: {
        username: "",
        email: "",
        password: "",
        checkPass: "",
        isSuperAdmin: false,
        isActive: false,
        firstname: "",
        lastname: "",
        role: [],
        group: []
      },
      roles: [],
      groups: [],
      dialogFormVisible: false,
      dialogStatus: "",
      textMap: {
        update: this.$t("table.edit"),
        create: this.$t("table.add")
      },
      rules: {
        username: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ],
        email: [
          {
            required: true,
            message: this.$t("table.required"),
            trigger: "change"
          }
        ],
        password: [
          {
            required: true,
            validator: (rule, value, callback) => {
              if (this.dialogStatus === "create") {
                if (value === "") {
                  callback(new Error(this.$t("table.required")));
                } else {
                  if (this.temp.checkPass !== "") {
                    this.$refs["dataForm"].validateField("checkPass");
                  }
                  callback();
                }
              } else {
                callback();
              }
            },
            trigger: "blur"
          },
          {
            min: 6,
            message: this.$t("table.check_lenth"),
            trigger: "blur"
          }
        ],
        checkPass: [
          {
            required: true,
            validator: (rule, value, callback) => {
              if (this.dialogStatus === "create") {
                if (value === "") {
                  callback(new Error(this.$t("table.password.check_again")));
                } else if (value !== this.temp.password) {
                  callback(
                    new Error(this.$t("table.password.check_disaccord"))
                  );
                } else {
                  callback();
                }
              } else {
                callback();
              }
            },
            trigger: "blur"
          },
          {
            min: 6,
            message: this.$t("table.check_lenth"),
            trigger: "blur"
          }
        ]
      }
    };
  },
  created() {
    this.getList();
    this.getRolesGroups();
  },
  methods: {
    //获取数据
    getList() {
      this.listLoading = true;
      getUserList(this.listQuery).then(res => {
        this.list = res.data.items;
        this.total = res.data.pagination.total;

        this.listLoading = false;
      });
    },
    //获取权限所有选项
    getRolesGroups() {
      itemsRole().then(res => {
        this.roles = res.data;
      });
      itemsGroup().then(res => {
        this.groups = res.data;
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
        username: "",
        email: "",
        password: "",
        checkPass: "",
        isSuperAdmin: false,
        isActive: false,
        firstname: "",
        lastname: "",
        role: [],
        group: []
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
                  this.temp["name"] = res.data.name;
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
      deleteUser({ id: row.id }).then(() => {
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
