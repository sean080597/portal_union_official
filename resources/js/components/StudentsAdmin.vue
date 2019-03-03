<template>
<div>
    <div class="wrap-table" v-if="$gate.isAdmin()">
        <div class="row">
            <div class="col-md-3 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-info text-white">Lọc</span>
                    </div>
                    <select name="state" id="maxRows" class="form-control">
                        <option value="10">10</option>
                        <option value="0" selected>Tất cả</option>
                    </select>
                </div>
            </div>
            <div class="col-md-9 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-info text-white">Tìm kiếm</span>
                    </div>
                    <input type="search" class="form-control" v-model="search" @keyup="searchit" aria-label="Search"/>
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" id="select-all">Chọn hết</button>
                    <button type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
            <div class="col-sm-9 mb-2">
                <router-link :to="'/student-profile-admin/'">
                    <a class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> Thêm đoàn viên</a>
                </router-link>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:10px"></th>
                        <th class="text-center">STT</th>
                        <th class="width-100">MSSV</th>
                        <th class="width-200">Tên</th>
                        <th class="width-80">Chi Đoàn</th>
                        <th class="width-200">Khoa</th>
                        <th class="width-80 text-center" colspan="3">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(student, index) in students.data" :key="index">
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center">{{ index + 1 }}</td>
                        <td>{{ student.mssv }}</td>
                        <td>{{ student.name }}</td>
                        <td>{{ student.class_room_id }}</td>
                        <td>{{ student.faculty_name }}</td>
                        <!-- <td class="text-center"><a href="#" class="text-secondary"><i class="fas fa-eye"></i></a></td> -->
                        <td class="text-center"><router-link :to="'/student-profile-admin/' + student.mssv" class="text-primary"><i class="fas fa-user-edit"></i></router-link></td>
                        <td class="text-center"><a href="#" class="text-danger"><i class="fas fa-trash-alt"></i></a></td>
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
            students: {},
            search: '',
        }
    },
    methods: {
        getResults(page = 1) {
            this.$Progress.start()
            if(this.search){
                axios.get('/api/findStudentAdmin?q=' + this.search + '&page=' + page)
                .then(response => {
                    this.students = response.data
                    this.$Progress.finish()
                })
            }else{
                axios.get('/api/student_admin?page=' + page)
                .then(response => {
                    this.students = response.data
                    this.$Progress.finish()
                })
            }
		},
        loadStudents(){
            this.$Progress.start();
            if(this.$gate.isAdmin()){
                axios.get('api/student_admin').then(({data}) => (this.students = data, this.$Progress.finish()));
                // axios.get('api/indexWithoutSchoolLeaderAccs').then(({data}) => (this.user_types = data));
            }
        },
        searchit: _.debounce(function() {
            this.$Progress.start()
            axios.get('/api/findStudentAdmin?&q=' + this.search)
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
        Fire.$on('ReloadStudent', ()=>{
            this.loadStudents();
        });
    },
}
</script>