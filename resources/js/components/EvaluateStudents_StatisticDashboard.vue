<template>
<div>
    <div class="wrap-table" v-if="$gate.isClassroomPagePassed()">
        <div class="note-info">
            <span>Lưu ý:</span>
            <ul>
                <li>
                    <p>Đây là lưu ý</p>
                </li>
            </ul>
        </div>

        <!-- <div class="row">
            <div class="col-md-3 mb-2">
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
            <div class="col-md-9">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-info text-white">Tìm kiếm</span>
                    </div>
                    <input type="text" class="form-control" id="table-search" />
                </div>
            </div>
        </div> -->

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead class="thead-light">
                    <tr>
                        <th>STT</th>
                        <th class="width-400">Tên đợt</th>
                        <th class="width-100">Bắt đầu</th>
                        <th class="width-100">Kết thúc</th>
                        <th class="width-80">Tình trạng</th>
                        <th class="width-100">Tổng</th>
                        <th class="width-80">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in ls_evaluation.data" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>Đánh giá đoàn viên năm học {{ item.updated_at-1 }}-{{ item.updated_at }}</td>
                        <td>11/11/{{ item.updated_at-1 }}</td>
                        <td>11/11/{{ item.updated_at }}</td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-success" v-if="item.notnull == ls_evaluation.total_quantity">Hoàn thành</span>
                            <span class="badge badge-pill badge-warning" v-else>Chưa xong</span>
                        </td>
                        <td class="text-center">{{ item.notnull }}/{{ ls_evaluation.total_quantity }}</td>
                        <td class="text-center">
                            <router-link :to="'/evaluate-students-detail/'+classroom_id+'?y='+item.updated_at" class="text-primary">
                                <i class="far fa-eye"></i>
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination-container">
                <nav>
                    <ul class="pagination justify-content-end"></ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="mb-5" v-else>
        <not-found></not-found>
    </div>
</div>
</template>
<script>
export default {
    data() {
        return {
            classroom_id: this.$route.params.classroom_id,
            ls_evaluation: {}
        }
    },
    methods: {
        loadLsEvaluation(){
            this.$Progress.start();
            if(this.$gate.isStudentsPagePassed()){
                axios.get('/api/getStatisticStudentsDashboard/' + this.classroom_id).then(({data}) => (
                    this.ls_evaluation = data, this.$Progress.finish()
                ));
            }else{
                this.$Progress.fail();
            }
        }
    },
    created() {
        this.loadLsEvaluation();
    },
}
</script>