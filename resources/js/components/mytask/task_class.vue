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
              <th class="text-center">STT</th>
              <th class="width-80">MSSV</th>
              <th class="width-200">Họ Tên</th>
              <th class="width-100 text-center">Ngày sinh</th>
              <th class="text-center">Điểm TB</th>
              <th class="width-80 text-center">Xếp Loại</th>
              <th class="width-80 text-center">Tình trạng</th>
              <th class="text-center">Tác vụ</th>
              <th class="text-center">Ghi chú</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(stu, index) in records.data" :key="index">
              <td class="text-center">{{ index + 1 }}</td>
              <td>{{stu.id}}</td>
              <td>{{stu.name}}</td>
              <td class="text-center">{{ stu.birthday | myDateFormat }}</td>
              <td class="text-center">{{stu.averageScore}}</td>
              <td class="text-center">{{caclRank(stu.averageScore)}}</td>
              <td class="text-center">
                <span class="badge badge-pill badge-success" v-if="stu.confirmingClass != 0">Đã đánh giá</span>
                <span class="badge badge-pill badge-warning" v-else>Chưa đánh giá</span>
              </td>
              <td class="text-center">
                <router-link :to="'/bang-danh-gia/' + stu.id + '/' + new Date().getFullYear()" class="text-primary">
                  <i class="far fa-eye"></i>
                </router-link>
              </td>
              <td class="text-center">
                <span class="badge badge-pill badge-secondary">note</span>
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
      classroom_id: this.$route.params.classroom_id,
      records: []
    };
  },

  methods: {
    getRecords() {
      axios.get("/api/getMyTaskByClassID/" + this.classroom_id).then(
        ({ data }) => (
          this.records = data
        )
      );
    },
    caclRank(score) {
        if(score > 84) return 'Xuất sắc'
        if(score > 69) return 'Khá'
        if(score > 49) return 'Trung bình'
        return 'Yếu'
    }
  },

  created() {
    this.getRecords();
  }
};
</script>
