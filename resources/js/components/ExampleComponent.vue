<template>

  <el-container class="container">
    <el-header>Houses</el-header>
    <el-container>
      <el-aside width="200px">
        <form action="">
          <el-row>
            <label for="">Enable Autofiltering</label>
            <el-switch
              v-model="autofilter"
              active-text="enable"
              inactive-text="disable"
              style="padding-bottom: 10px"
            >
            </el-switch>

            <el-col
              v-for="(filter, index) in filters"
              :key="index"
              :span="24"
            >
              <label for="">{{`Filter by ${index}`}}: </label>
              <el-input
                :placeholder="`Filter by ${index}`"
                v-model="filters[index]"
                style="padding-bottom: 10px"
              ></el-input>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="12">
              <el-button
                v-if="!autofilter"
                :loading="loading"
                @click.prevent="fetchData(filters)"
                type="primary"
              >Search</el-button>
            </el-col>
            <el-col :span="12">
              <el-button
                :loading="loading"
                @click.prevent="resetFilters"
                type="secondary"
                style="padding: 12px 14px;"
              >Clear filter</el-button>

            </el-col>

          </el-row>
        </form>
      </el-aside>
      <el-main>

        <el-row>
          <el-col :span="24">
            <el-alert
              v-if="tableData.length === 0 && mounted"
              title="Houses not found"
              type="info"
            >
            </el-alert>

            <el-table
              v-else-if="tableData.length"
              :data="tableData"
              stripe
              style="width: 100%"
            >
              <el-table-column
                v-for="(label, index) in labels"
                :key="index"
                :prop="label"
                :label="label"
              >
              </el-table-column>
              <!--   <el-table-column
              prop="name"
              label="Name"
              width="180"
            >
            </el-table-column>
            <el-table-column
              prop="address"
              label="Address"
            >
            </el-table-column> -->
            </el-table>
          </el-col>
        </el-row>

      </el-main>
    </el-container>

  </el-container>

</template>

<script>
function getFiltersDefaults() {
  return {
    name: "",
    price: "",
    bedrooms: "",
    bathrooms: "",
    storeys: "",
    garages: ""
  };
}
export default {
  data() {
    return {
      autofilter: true,
      mounted: false,
      loading: false,
      labels: ["name", "price", "bedrooms", "bathrooms", "storeys", "garages"],
      filters: getFiltersDefaults(),
      tableData: []
    };
  },
  watch: {
    filters: {
      deep: true,
      immediate: true,
      handler(val) {
        if (!this.autofilter) {
          return;
        }
        this.fetchData(val);
      }
    }
  },
  mounted() {
    console.log("Component mounted.");
    this.autofilter = false;
  },
  methods: {
    async fetchData(params) {
      let { data } = await axios.get("/houses", {
        params
      });
      this.tableData = data;
      if (!this.mounted) {
        this.mounted = true;
      }
    },
    resetFilters() {
      this.filters = getFiltersDefaults();
    }
  }
};
</script>

<style lang="scss">
.container {
}
</style>