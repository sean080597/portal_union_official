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
                        <select class="form-control" disabled>
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
                        <select class="form-control" disabled>
                            <option value="3">Đoàn viên</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-2">
                <select class="form-control" disabled>
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
                    <input type="search" class="form-control" aria-label="Search" v-model="search" @keyup="searchit"/>
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
                    <tr v-for="(stu, index) in students.data" :key="index">
                        <td class="text-center">{{ index + 1 }}</td>
                        <td>{{ stu.id }}</td>
                        <td>{{ stu.name }}</td>
                        <td>{{ stu.birthday | myDateFormat }}</td>
                        <td class="text-center">{{ stu.mark_student }}</td>
                        <td class="text-center">{{ stu.mark_classroom }}</td>
                        <td class="text-center">{{ stu.mark_faculty }}</td>
                        <td class="text-center">{{ stu.mark_school }}</td>
                        <td class="text-center">{{ stu.rank }}</td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-success" v-if="stu.mark_student != null">Hoàn thành</span>
                            <span class="badge badge-pill badge-warning" v-else>Chưa xong</span>
                        </td>
                        <td class="text-center">
                            <router-link :to="'/evaluate-profile/'+stu.id" class="text-primary"><i class="fas fa-pencil-alt"></i></router-link>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-secondary">note</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :data="students" @pagination-change-page="getResults" :limit="3">
                <span slot="prev-nav">&lt; Prev</span>
	            <span slot="next-nav">Next &gt;</span>
            </pagination>
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
            year: this.$route.query.y,
            students: {},
            search: ''
        }
    },
    methods: {
        getResults(page = 1) {
            this.$Progress.start()
            if(this.search){
                axios.get('/api/findEvaluateClassroomStatistic?cla_id='+this.classroom_id+'&y='+this.year+'&q=' + this.search+'&page='+page)
                .then(response => {
                    this.students = response.data
                    this.$Progress.finish()
                })
            }else{
                axios.get('/api/getStatisticClassroomDetail/'+this.classroom_id+'?y='+this.year+'&page=' + page)
                .then(response => {
                    this.students = response.data
                    this.$Progress.finish()
                })
            }
		},
        loadStudents(){
            this.$Progress.start();
            if(this.$gate.isStudentsPagePassed()){
                axios.get('/api/getStatisticClassroomDetail/' + this.classroom_id + '?y='+this.year).then(({data}) => (
                    this.students = data, this.$Progress.finish()
                ));
            }else{
                this.$Progress.fail();
            }
        },
        searchit: _.debounce(function() {
            this.$Progress.start()
            axios.get('/api/findEvaluateClassroomStatistic?cla_id='+this.classroom_id+'&y='+this.year+'&q=' + this.search)
            .then((data) => {
                this.students = data.data
                this.$Progress.finish()
            })
            .catch(() => {
                this.$Progress.fail()
            })
        }, 1500)
    },
    created() {
        this.loadStudents();
    },
}
</script>