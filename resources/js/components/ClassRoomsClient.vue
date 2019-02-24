<template>
<div>
    <div class="wrap-table" v-if="$gate.isClassroomPagePassed()">
        <div class="note-info">
            <div class="row" v-if="facultyLeaderAccs.secretary != null">
                <p class="col-sm-4"><span>Bí thư: </span>{{ facultyLeaderAccs.secretary.name }}</p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span>{{ facultyLeaderAccs.secretary.phone }}</p>
                    <p class="col-7 px-0"><span>Email: </span>{{ facultyLeaderAccs.secretary.email }}</p>
                </div>
            </div>
            <div class="row" v-else>
                <p class="col-sm-4"><span>Bí thư: </span></p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span></p>
                    <p class="col-7 px-0"><span>Email: </span></p>
                </div>
            </div>

            <div class="row" v-if="facultyLeaderAccs.deputy_secretary1 != null">
                <p class="col-sm-4"><span>Phó bí thư: </span>{{ facultyLeaderAccs.deputy_secretary1.name }}</p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span>{{ facultyLeaderAccs.deputy_secretary1.phone }}</p>
                    <p class="col-7 px-0"><span>Email: </span>{{ facultyLeaderAccs.deputy_secretary1.email }}</p>
                </div>
            </div>
            <div class="row" v-else>
                <p class="col-sm-4"><span>Phó bí thư: </span></p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span></p>
                    <p class="col-7 px-0"><span>Email: </span></p>
                </div>
            </div>

            <div class="row" v-if="facultyLeaderAccs.deputy_secretary2 != null">
                <p class="col-sm-4"><span>Phó bí thư: </span>{{ facultyLeaderAccs.deputy_secretary2.name }}</p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span>{{ facultyLeaderAccs.deputy_secretary2.phone }}</p>
                    <p class="col-7 px-0"><span>Email: </span>{{ facultyLeaderAccs.deputy_secretary2.email }}</p>
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
                        <th class="width-100">Chi đoàn</th>
                        <th class="width-200">Bí thư</th>
                        <th class="width-200">Email</th>
                        <th class="width-100">Điện thoại</th>
                        <th class="width-80">Tác vụ</th>
                        <th class="width-100">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(classroom, index) in classrooms.data" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ classroom.id }}</td>
                        <td v-if="classroom.secretary != null">{{ classroom.secretary.name }}</td>
                        <td v-else></td>
                        <td v-if="classroom.secretary != null">{{ classroom.secretary.email }}</td>
                        <td v-else></td>
                        <td v-if="classroom.secretary != null">{{ classroom.secretary.phone }}</td>
                        <td v-else></td>
                        <td class="text-center text-primary">
                            <router-link :to="'/students/' + classroom.id"><i class="far fa-eye"></i></router-link>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-secondary">hello</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :data="classrooms" @pagination-change-page="getResults" :limit="3">
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
            faculty_id: this.$route.params.faculty_id,
            classrooms: {},
            facultyLeaderAccs: {},
            search: ''
        }
    },
    methods: {
        getResults(page = 1) {
            this.$Progress.start()
            if(this.search){
                axios.get('/api/findClassroom?fac_id=' + this.faculty_id + '&q=' + this.search + '&page=' + page)
                .then(response => {
                    this.classrooms = response.data
                    this.$Progress.finish()
                })
            }else{
                axios.get('/api/getClassroomsClient/'+this.faculty_id+'?page=' + page)
                .then(response => {
                    this.classrooms = response.data
                    this.$Progress.finish()
                })
            }
		},
        loadClassrooms(){
            this.$Progress.start()
            if(this.$gate.isClassroomPagePassed()){
                axios.get('/api/getFacultyLeaderAccs/' + this.faculty_id).then(({data}) => (
                    this.facultyLeaderAccs = data, this.$Progress.increase(30)
                ))
                axios.get('/api/getClassroomsClient/' + this.faculty_id).then(({data}) => (
                    this.classrooms = data, this.$Progress.finish()
                ))
            }else{
                this.$Progress.fail()
            }
        },
        searchit: _.debounce(function() {
            this.$Progress.start()
            axios.get('/api/findClassroom?fac_id=' + this.faculty_id + '&q=' + this.search)
            .then((data) => {
                this.classrooms = data.data
                this.$Progress.finish()
            })
            .catch(() => {
                this.$Progress.fail()
            })
        }, 1500)
    },
    created() {
        this.loadClassrooms()
    },
}
</script>