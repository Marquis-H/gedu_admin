<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        :placeholder="$t('table.word')"
        v-model="listQuery.filters.title"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >{{ $t('table.search') }}</el-button>
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
      <el-table-column :label="$t('table.word')" align="center" min-width="150">
        <template slot-scope="scope">
          <span>{{scope.row.word}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.rate')" align="center" min-width="150">
        <template slot-scope="scope">
          <svg-icon
            v-for="n in +scope.row.rate"
            :key="n"
            icon-class="star"
            class="meta-item__icon"
          />
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.translation')" align="center" min-width="320">
        <template slot-scope="scope">
          <span>{{scope.row.translation}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.enSymbol')" align="center" min-width="150">
        <template slot-scope="scope">
          <span>{{scope.row.enSymbol}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.usSymbol')" align="center" min-width="150">
        <template slot-scope="scope">
          <span>{{scope.row.usSymbol}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.annotation')" align="center" min-width="640">
        <template slot-scope="scope">
          <span>{{scope.row.annotation}}</span>
        </template>
      </el-table-column>
      <el-table-column min-width="300px" :label="$t('table.tabs')" align="center">
        <template slot-scope="scope">
          <template v-if="scope.row.edit">
            <el-input v-model="scope.row.tabs" class="edit-input" size="small"/>
            <el-button
              class="cancel-btn"
              size="small"
              icon="el-icon-refresh"
              type="warning"
              @click="cancelEdit(scope.row)"
            >取消</el-button>
          </template>
          <span v-else>{{ scope.row.tabs }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" :label="$t('table.actions')" width="120">
        <template slot-scope="scope">
          <el-button
            v-if="scope.row.edit"
            type="success"
            size="small"
            icon="el-icon-circle-check-outline"
            @click="confirmEdit(scope.row)"
          >确定</el-button>
          <el-button
            v-else
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="scope.row.edit=!scope.row.edit"
          >编辑标签</el-button>
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
  </div>
</template>

<script>
import waves from "../../directive/waves";

import { getWordList, updateWordTabs } from "@/api/word";

export default {
  name: "Word",
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
        filters: {
          word: undefined
        }
      }
    };
  },
  created() {
    this.getList();
  },
  methods: {
    //获取数据
    getList() {
      this.listLoading = true;
      getWordList(this.listQuery).then(res => {
        this.list = res.data.items;
        this.total = res.data.pagination.total;

        this.listLoading = false;
      });
    },
    //搜索
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },
    cancelEdit(row) {
      row.tabs = row.originalTabs;
      row.edit = false;
    },
    confirmEdit(row) {
      row.edit = false;
      row.originalTabs = row.tabs;
      updateWordTabs({ id: row.id, tabs: row.tabs }).then(res => {
        row.tabs = res.data.tabs;
        this.$message({
          message: "标签更新成功",
          type: "success"
        });
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
.edit-input {
  width: 80%;
  padding-right: 70px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
}
</style>
