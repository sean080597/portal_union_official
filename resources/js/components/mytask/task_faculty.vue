<template>
  <div>
    <div class="wrap-table">
      <div class="note-info">
        <span>Lưu ý:</span>
        <ul>
          <li>
            <p>Đây là lưu ý</p>
          </li>
        </ul>
      </div>
      <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered" id="table">
          <thead class="thead-light">
            <tr>
              <th>STT</th>
              <th class="width-100">Lớp</th>
              <th class="width-100">Bắt đầu</th>
              <th class="width-100">Kết thúc</th>
              <th class="width-80 text-center">Tình trạng</th>
              <th class="width-100 text-center">Tổng</th>
              <th class="width-80 text-center">Tác vụ</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in records.data" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ item.class_room_id }}</td>
              <td>11/11/{{ item.updated_at-1 }}</td>
              <td>11/11/{{ item.updated_at }}</td>
              <td class="text-center">
                <span
                  class="badge badge-pill badge-success"
                  v-if="item.evaluated == item.total"
                >Đã đánh giá</span>
                <span class="badge badge-pill badge-warning" v-else>Chưa đánh gía</span>
              </td>
              <td class="text-center">{{ item.evaluated }}/{{ item.total }}</td>
              <td class="text-center">
                <router-link :to="'/mytask-classroom/'+item.class_room_id" class="text-primary">
                  <i class="far fa-eye"></i>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fac_id: this.$route.params.fac_id,
      records: []
    };
  },
  methods: {
    getRecords() {
      axios
        .get("/api/getMyTaskByFaculty/" + this.fac_id)
        .then(({ data }) => (this.records = data));
    }
  },
  created() {
    this.getRecords();
  }
};
</script>
