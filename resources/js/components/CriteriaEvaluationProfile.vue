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
                <div class="col-sm"><p><span>ĐV: </span>đoàn viên</p></div>
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
                            <th rowspan="2" style="min-width:60%">Nội dung</th>
                            <th rowspan="2" style="width:140px" class="text-center">ĐV tự dánh giá</th>
                            <th colspan="4">Đánh Giá</th>
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
                        <tr v-for="(cri_man, index) in ls_cri_mand" :key="index">
                            <td><span>{{ index+1 }}. </span>{{ cri_man.content }}</td>
                            <td class="text-center p-1">
                                <input type="text" class="form-control">
                            </td>
                            <td class="text-center p-1">
                                <select name="sel_mark_stu" id="sel_mark_stu" class="form-control" style="padding:.375rem .5rem">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="font-weight:700"><span>II. </span> Nội dung đoàn viên tự đăng ký thực hiên<span> (Tối đa: 30đ)</span></td>
                        </tr>
                        <tr>
                            <td class="p-1">
                                <textarea class="form-control" rows="3" id=""></textarea>
                            </td>
                            <td class="text-center p-1">
                                <input type="text" class="form-control">
                            </td>
                            <td class="text-center p-1">
                                <input type="number" value="0" style="width:55px" class="form-control">
                            </td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="p-1">
                                <textarea class="form-control" rows="3" id=""></textarea>
                            </td>
                            <td class="text-center p-1">
                                <input type="text" class="form-control">
                            </td>
                            <td class="text-center p-1">
                                <input type="number" value="0" style="width:55px" class="form-control">
                            </td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <td class="p-1">
                                <textarea class="form-control" rows="3" id=""></textarea>
                            </td>
                            <td class="text-center p-1">
                                <input type="text" class="form-control">
                            </td>
                            <td class="text-center p-1">
                                <input type="number" value="0" style="width:55px" class="form-control">
                            </td>
                            <td class="text-center align-text"></td>
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
        }
    },
    methods: {
        loadListCriteria(){
            axios.get('/api/getUserStudentInfoByStuId/' + this.student_id).then(({data}) => (this.student_info = data[0]));
            axios.get('/api/criteria_mandatory').then(({data}) => (this.ls_cri_mand = data));
            axios.get('/api/criteria_selfregis').then(({data}) => (this.ls_cri_self = data));
        }
    },
    created() {
        this.loadListCriteria();
    },
}
</script>