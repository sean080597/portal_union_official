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

        <div class="row">
            <div class="col-lg-9 row pr-0 mr-auto">
                <div class="col-sm-6 mb-2 pr-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Năm Học</span>
                        </div>
                        <select class="form-control">
                            <option value="2013-2014">2013-2014</option>
                            <option value="2014-2015">2014-2015</option>
                            <option value="2015-2016">2015-2016</option>
                            <option value="2016-2017">2016-2017</option>
                            <option value="2017-2018" selected>2017-2018</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 mb-2 pr-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Thống kê</span>
                        </div>
                        <select class="form-control">
                            <option value="3">Đoàn viên</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2">
                <select class="form-control">
                    <option value="-1">Tác vụ khác</option>
                </select>
            </div>
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
                    <input type="text" class="form-control" id="table-search" />
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="width-80">MSSV</th>
                        <th class="width-200">Họ Tên</th>
                        <th class="width-100 text-center">Ngày sinh</th>
                        <th class="text-center">SV</th>
                        <th class="text-center">Lớp</th>
                        <th class="text-center">Khoa</th>
                        <th class="text-center">Trường</th>
                        <th class="width-80 text-center">Xếp Loại</th>
                        <th class="width-80 text-center">Tình trạng</th>
                        <th class=" text-center">Tác vụ</th>
                        <th class="text-center">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>15110993</td>
                        <td>Trương Quốc Cẩm</td>
                        <td>10/10/1990</td>
                        <td class="text-center">100</td>
                        <td class="text-center">100</td>
                        <td class="text-center">100</td>
                        <td class="text-center">100</td>
                        <td class="text-center">Giỏi</td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-success">Hoàn thành</span>
                        </td>
                        <td class="text-center">
                            <a href="DGDV.html" class="text-primary"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-secondary">note</span>
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
            students: {},
            search: ''
        }
    },
    methods: {
        loadStudents(){
            this.$Progress.start();
            if(this.$gate.isStudentsPagePassed()){
                axios.get('/api/getStudentsClient/' + this.classroom_id).then(({data}) => (
                    this.students = data, this.$Progress.finish()
                ));
            }else{
                this.$Progress.fail();
            }
        },
    },
    created() {
        // this.loadStudents();
    },
}
</script>