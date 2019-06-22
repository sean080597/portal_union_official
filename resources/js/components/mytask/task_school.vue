<template>
  <div class="wrap-table">
    <div class="note-info">
      <span>Lưu ý:</span>
      <ul>
        <li>
          <p>Đây là lưu ý</p>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-lg-3 mb-2">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-danger text-white">Lọc</span>
          </div>
          <select name="state" id="maxRows" class="form-control">
            <option value="10">10</option>
            <option value="0" selected>Tất cả</option>
          </select>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-info text-white">Tìm kiếm</span>
          </div>
          <input type="text" class="form-control" id="table-search">
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover table-bordered" id="table">
        <thead class="thead-light">
          <tr>
            <th class="text-center">STT</th>
            <th class="width-400">Tên khoa</th>
            <th class="width-100 text-center">Tổng</th>
            <th class="width-100 text-center">Tình trạng</th>
            <th class="width-80 text-center">Tác vụ</th>
            <th class="width-200 text-center">Ghi chú</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(rec, index) in records" :key="rec.id">
            <td class="text-center">{{ index + 1 }}</td>
            <td>{{ rec.name }}</td>
            <td
              class="text-center"
            >{{ (rec.evaluated == null) ? '0' : rec.evaluated }}/{{ rec.class_qtt }}</td>
            <td class="text-center">
              <span class="badge badge-pill badge-success" v-if="rec.evaluated == rec.class_qtt">Đã đánh giá</span>
              <span class="badge badge-pill badge-warning" v-else>Chưa đánh giá</span>
            </td>
            <td class="text-center">
                <router-link :to="'/report-faculty/'+rec.id" class="text-primary">
                    <i class="far fa-eye"></i>
                </router-link>
            </td>
            <td class="text-center">
              <span class="badge badge-pill badge-secondary">{{ rec.note }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      records: []
    };
  },

  methods: {
    getRecords() {
      axios
        .get("/api/getMyTaskBySchool")
        .then(({ data }) => (this.records = data));
    }
  },

  created() {
    this.getRecords();
  }
};
</script>

