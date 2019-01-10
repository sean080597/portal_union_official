<template>
    <div class="wrap-table">
        <div class="note-info">
            <div class="row">
                <p class="col-sm-4" v-if="facultyAccounts.secretary != null"><span>Bí thư: </span>{{ facultyAccounts.secretary.name }}</p>
                <p class="col-sm-4" v-else><span>Bí thư: </span></p>
                <div class="col-sm-8 row">
                    <p class="col-5" v-if="facultyAccounts.secretary != null"><span>ĐT: </span>{{ facultyAccounts.secretary.phone }}</p>
                    <p class="col-sm-4" v-else><span>ĐT: </span></p>
                    <p class="col-7 px-0" v-if="facultyAccounts.secretary != null"><span>Email: </span>{{ facultyAccounts.secretary.email }}</p>
                    <p class="col-sm-4" v-else><span>Email: </span></p>
                </div>
            </div>
            <div class="row">
                <p class="col-sm-4" v-if="facultyAccounts.deputy_secretary1 != null"><span>Bí thư: </span>{{ facultyAccounts.deputy_secretary1.name }}</p>
                <p class="col-sm-4" v-else><span>Bí thư: </span></p>
                <div class="col-sm-8 row">
                    <p class="col-5" v-if="facultyAccounts.deputy_secretary1 != null"><span>ĐT: </span>{{ facultyAccounts.deputy_secretary1.phone }}</p>
                    <p class="col-sm-4" v-else><span>ĐT: </span></p>
                    <p class="col-7 px-0" v-if="facultyAccounts.deputy_secretary1 != null"><span>Email: </span>{{ facultyAccounts.deputy_secretary1.email }}</p>
                    <p class="col-sm-4" v-else><span>Email: </span></p>
                </div>
            </div>
            <div class="row">
                <p class="col-sm-4" v-if="facultyAccounts.deputy_secretary2 != null"><span>Bí thư: </span>{{ facultyAccounts.deputy_secretary2.name }}</p>
                <p class="col-sm-4" v-else><span>Bí thư: </span></p>
                <div class="col-sm-8 row">
                    <p class="col-5" v-if="facultyAccounts.deputy_secretary2 != null"><span>ĐT: </span>{{ facultyAccounts.deputy_secretary2.phone }}</p>
                    <p class="col-sm-4" v-else><span>ĐT: </span></p>
                    <p class="col-7 px-0" v-if="facultyAccounts.deputy_secretary2 != null"><span>Email: </span>{{ facultyAccounts.deputy_secretary2.email }}</p>
                    <p class="col-sm-4" v-else><span>Email: </span></p>
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
                    <input type="text" class="form-control" id="table-search" />
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
                    <tr v-for="(classroom, index) in classrooms" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ classroom.id }}</td>
                        <td v-if="classroom.secretary != null">{{ classroom.secretary.name }}</td>
                        <td v-else></td>
                        <td v-if="classroom.secretary != null">{{ classroom.secretary.email }}</td>
                        <td v-else></td>
                        <td v-if="classroom.secretary != null">{{ classroom.secretary.phone }}</td>
                        <td v-else></td>
                        <td class="text-center text-primary">
                            <a href="#"><i class="far fa-eye"></i></a>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-secondary">hello</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            faculty_id: this.$route.params.faculty_id,
            classrooms: {},
            facultyAccounts: {},
        }
    },
    methods: {
        loadClassrooms(){
            this.$Progress.start();
            axios.get('/api/getFacultyAccounts/' + this.faculty_id).then(({data}) => (this.facultyAccounts = data));
            axios.get('/api/getClassroomsClient/' + this.faculty_id).then(({data}) => (this.classrooms = data.data));
            this.$Progress.finish();
        },
    },
    created() {
        this.loadClassrooms();
    },
}
</script>