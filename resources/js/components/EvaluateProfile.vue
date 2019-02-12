<template>
    <div class="wrap-table">
        <div class="note-info">
            <div class="row">
                <div class="col-sm-6"><p><span>Tên: </span>{{ student_info.name }}</p></div>
                <div class="col-sm-6"><p><span>MSSV: </span>{{ student_info.mssv }}</p></div>
                <div class="col-sm-6"><p><span>Chi đoàn: </span>{{ student_info.class_room_id }}</p></div>
                <div class="col-sm-6"><p><span>Khoa: </span>{{ student_info.faculty_name }}</p></div>
            </div>
        </div>
        <div class="note-warning">
            <div class="row">
                <div class="col-sm"><p><span>ĐV: </span>Đoàn viên</p></div>
                <div class="col-sm"><p><span>CĐ: </span>Bí thư chi đoàn</p></div>
                <div class="col-sm"><p><span>Khoa: </span>Bí thư đoàn khoa</p></div>
                <div class="col-sm"><p><span>Trường: </span>Bí thư đoàn trường</p></div>
            </div>
        </div>
        <form action="">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" style="min-width:60%" class="text-center">Nội dung</th>
                            <th rowspan="2" style="width:140px" class="text-center">ĐV tự dánh giá</th>
                            <th colspan="4" class="text-center">Đánh Giá</th>
                        </tr>
                        <tr>
                            <th class="text-center">ĐV</th>
                            <th class="text-center">CĐ</th>
                            <th class="text-center">Khoa</th>
                            <th class="text-center">Trường</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" style="font-weight:700"><span>I. </span> Nội dung đoàn viên đăng ký thực hiện theo yêu cầu chung của đoàn trường<span> (Tối đa: 70đ)</span></td>
                        </tr>
                        <tr v-for="(cri_man, index) in ls_cri_mand" :key="'cri_man'+index">
                            <td><span>{{ index+1 }}. </span>{{ cri_man.content }}</td>
                            <td class="text-center p-1">
                                <!-- <input type="text" class="form-control"
                                :value="(cri_man.pivot != null) ? 'no null' :"> -->
                                <select :name="'cri_man_selfassess_'+index" :id="'cri_man_selfassess_'+index" class="form-control">
                                    <option value="" :selected="cri_man.pivot == null" disabled>- Chọn ĐG -</option>
                                    <option v-for="(self_assess, index) in opts_selfassess"
                                    :key="index" :value="self_assess.k"
                                    :selected="(cri_man.pivot != null) ? self_assess.k == cri_man.pivot.self_assessment : null"
                                    >{{ self_assess.v }}</option>
                                </select>
                            </td>
                            <td class="text-center p-1">
                                <select :name="'cri_man_markstu_'+index" :id="'cri_man_markstu_'+index" class="form-control">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    :selected="(cri_man.pivot != null) ? mark == cri_man.pivot.mark_student : null"
                                    >{{ mark }}</option>
                                </select>
                            </td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="font-weight:700"><span>II. </span> Nội dung đoàn viên tự đăng ký thực hiên<span> (Tối đa: 30đ)</span></td>
                        </tr>
                        <tr v-for="(cri_self, index) in ls_cri_self" :key="'cri_self'+index">
                            <td class="p-1">
                                <span style="margin: 5px;">
                                    {{ index+1 }}. {{ cri_self.content }}
                                </span>
                                <textarea class="form-control" rows="3" :name="'cri_self_content_'+index" :id="'cri_self_content_'+index"
                                v-model="cri_self.pivot.content_regis"></textarea>
                            </td>
                            <td class="text-center p-1">
                                <!-- <input type="text" class="form-control"> -->
                                <select :name="'cri_self_selfassess_'+index" :id="'cri_self_selfassess_'+index" class="form-control">
                                    <option value="" :selected="cri_self.pivot == null" disabled>- Chọn ĐG -</option>
                                    <option v-for="(self_assess, index) in opts_selfassess"
                                    :key="index" :value="self_assess.k"
                                    :selected="(cri_self.pivot != null) ? self_assess.k == cri_self.pivot.self_assessment : null"
                                    >{{ self_assess.v }}</option>
                                </select>
                            </td>
                            <td class="text-center p-1">
                                <select :name="'cri_self_markstu_'+index" :id="'cri_self_markstu_'+index" class="form-control">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    :selected="(cri_self.pivot != null) ? mark == cri_self.pivot.mark_student : null"
                                    >{{ mark }}</option>
                                </select>
                            </td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-success">Xác nhận</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            student_id: this.$route.params.student_id,
            student_info: {},
            ls_cri_mand: {},
            ls_cri_self: {},
            opts_selfassess: [
                { k: 'tb', v: 'Trung bình' },
                { k: 'k', v: 'Khá' },
                { k: 't', v: 'Tốt' }
            ],
            opts_mark: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        }
    },
    methods: {
        loadListCriteria(){
            this.$Progress.start();
            axios.get('/api/getUserStudentInfoByStuId/' + this.student_id).then(({data}) => (this.student_info = data[0]));
            axios.get('/api/getMarkCriMan/' + this.student_id).then(({data}) => (this.ls_cri_mand = data));
            axios.get('/api/getMarkCriSel/' + this.student_id).then(({data}) => (this.ls_cri_self = data));
        }
    },
    created() {
        this.loadListCriteria();
    },
}
</script>
<style scoped>
tr td{
    vertical-align: middle;
}
select{
    padding: .375rem 0 .375rem .5rem;
}
.form-control{
    width: -webkit-fill-available;
}
</style>
