<template>
<div>
    <div class="wrap-table" v-if="$gate.isStudentsPagePassed()">
        <div class="note-info">
            <div class="row" v-if="classroomLeaderAccs.secretary != null">
                <p class="col-sm-4"><span>Bí thư: </span>{{ classroomLeaderAccs.secretary.name }}</p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span>{{ classroomLeaderAccs.secretary.phone }}</p>
                    <p class="col-7 px-0"><span>Email: </span>{{ classroomLeaderAccs.secretary.email }}</p>
                </div>
            </div>
            <div class="row" v-else>
                <p class="col-sm-4"><span>Bí thư: </span></p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span></p>
                    <p class="col-7 px-0"><span>Email: </span></p>
                </div>
            </div>

            <div class="row" v-if="classroomLeaderAccs.deputy_secretary1 != null">
                <p class="col-sm-4"><span>Phó bí thư: </span>{{ classroomLeaderAccs.deputy_secretary1.name }}</p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span>{{ classroomLeaderAccs.deputy_secretary1.phone }}</p>
                    <p class="col-7 px-0"><span>Email: </span>{{ classroomLeaderAccs.deputy_secretary1.email }}</p>
                </div>
            </div>
            <div class="row" v-else>
                <p class="col-sm-4"><span>Phó bí thư: </span></p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span></p>
                    <p class="col-7 px-0"><span>Email: </span></p>
                </div>
            </div>

            <div class="row" v-if="classroomLeaderAccs.deputy_secretary2 != null">
                <p class="col-sm-4"><span>Phó bí thư: </span>{{ classroomLeaderAccs.deputy_secretary2.name }}</p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span>{{ classroomLeaderAccs.deputy_secretary2.phone }}</p>
                    <p class="col-7 px-0"><span>Email: </span>{{ classroomLeaderAccs.deputy_secretary2.email }}</p>
                </div>
            </div>
            <div class="row" v-else>
                <p class="col-sm-4"><span>Phó bí thư: </span></p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span></p>
                    <p class="col-7 px-0"><span>Email: </span></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-danger text-white">Lọc</span>
                    </div>
                    <select name="state" id="maxRows" class="form-control">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="0" selected>Tất cả</option>
                    </select>
                </div>
            </div>
            <div class="col-md-9">
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
                        <th>STT</th>
                        <th class="width-100">MSSV</th>
                        <th class="width-200">Họ Tên</th>
                        <th class="width-100">Ngày sinh</th>
                        <th class="width-200">Email</th>
                        <th class="width-100">Điện thoại</th>
                        <th class="width-80">Tác vụ</th>
                        <th class="width-100">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(student, index) in students.data" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ student.mssv }}</td>
                        <td>{{ student.name }}</td>
                        <td>{{ student.birthday | myDateFormat }}</td>
                        <td>{{ student.email }}</td>
                        <td>{{ student.phone }}</td>
                        <td class="text-center text-primary">
                            <router-link :to="'/student-profile/' + student.id"><i class="far fa-eye"></i></router-link>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-secondary">hello</span>
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
            students: {},
            classroomLeaderAccs: {},
            search: ''
        }
    },
    methods: {
        getResults(page = 1) {
            this.$Progress.start()
            if(this.search){
                axios.get('/api/findStudent?cla_id=' + this.classroom_id + '&q=' + this.search + '&page=' + page)
                .then(response => {
                    this.students = response.data
                    this.$Progress.finish()
                })
            }else{
                axios.get('/api/getStudentsClient/' + this.classroom_id + '?page=' + page)
                .then(response => {
                    this.students = response.data
                    this.$Progress.finish()
                })
            }
		},
        loadStudents(){
            this.$Progress.start();
            if(this.$gate.isStudentsPagePassed()){
                axios.get('/api/getClassroomAccs/' + this.classroom_id).then(({data}) => (
                    this.classroomLeaderAccs = data, this.$Progress.increase(30)
                ));
                axios.get('/api/getStudentsClient/' + this.classroom_id).then(({data}) => (
                    this.students = data, this.$Progress.finish()
                ));
            }else{
                this.$Progress.fail();
            }
        },
        searchit: _.debounce(function() {
            this.$Progress.start()
            axios.get('/api/findStudent?&cla_id=' + this.classroom_id + '&q=' + this.search)
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