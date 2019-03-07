<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        :placeholder="$t('table.title')"
        v-model="listQuery.filters.title"
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
      <router-link :to="'/app_content/index/create'">
        <el-button
          class="filter-item"
          style="margin-left: 10px;"
          type="primary"
          icon="el-icon-edit"
        >{{ $t('table.add') }}</el-button>
      </router-link>
      <router-link :to="'/app_content/cat'">
        <el-button
          class="filter-item"
          style="margin-left: 10px;"
          type="success"
          icon="el-icon-edit-outline"
        >分类</el-button>
      </router-link>
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
      <el-table-column :label="$t('table.photo')" align="center" width="120">
        <template slot-scope="scope">
          <img v-if="scope.row.photo" width="100%" :src="setting.domain+scope.row.photo">
          <span v-else>-</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.title')" align="center" width="180">
        <template slot-scope="scope">
          <span>{{scope.row.title}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.summary')" align="center">
        <template slot-scope="scope">
          <span>{{scope.row.summary}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.extra')" align="center" min-width="160">
        <template slot-scope="scope">
          <span>{{scope.row.extra}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.campus')" align="center" min-width="160">
        <template slot-scope="scope">
          <span>{{scope.row.campus}}</span>
        </template>
      </el-table-column>
      <el-table-column :label="$t('table.updatedAt')" align="center" width="160">
        <template slot-scope="scope">
          <span>{{scope.row.updatedAt}}</span>
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
  </div>
</template>

<script>
import waves from "../../directive/waves";
import { getContentList, deleteContent } from "@/api/content";
import { mapGetters } from "vuex";

export default {
  name: "Content",
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
          title: undefined
        }
      },
      temp: {},
      sortOptions: [
        { label: "ID Ascending", key: "ascend" },
        { label: "ID Descending", key: "descend" }
      ]
    };
  },
  computed: {
    ...mapGetters(["setting"])
  },
  created() {
    this.getList();
  },
  watch: {
    // 监听创建或编辑跳转回来，进行刷新
    $route(to, from) {
      this.$router.go(0);
    }
  },
  methods: {
    //获取数据
    getList() {
      this.listLoading = true;
      getContentList(this.listQuery).then(res => {
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
    handleUpdate(row) {
      this.$router.push({ path: `/app_content/index/edit/${row.id}` })
    },
    handleDelete(row) {
      this.$notify({
        title: this.$t("table.success"),
        message: this.$t("table.delete_success_tips"),
        type: "success",
        duration: 2000
      });
      deleteContent({ id: row.id }).then(res => {
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
    }
  }
};
</script>

<style>
</style>
