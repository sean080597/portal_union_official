<template>
<div>
    <div class="wrap-table" v-if="$gate.isAdminOrAccSchool()">
        <div class="note-info">
            <div class="row" v-for="(schAcc, index) in schoolLeaderAccs" :key="index">
                <p class="col-sm-4">
                    <span v-if="schAcc.role_id == 'sec'">Bí thư: </span>
                    <span v-else>Phó bí thư: </span>
                    {{ schAcc.name }}
                </p>
                <div class="col-sm-8 row">
                    <p class="col-5"><span>ĐT: </span>{{ schAcc.phone }}</p>
                    <p class="col-7 px-0"><span>Email: </span>{{ schAcc.email }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span    class="input-group-text bg-danger text-white">Lọc</span>
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
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead class="thead-light">
                    <tr>
                        <th>STT</th>
                        <th class="width-100">Khoa</th>
                        <th class="width-200">Bí thư</th>
                        <th class="width-200">Email</th>
                        <th class="width-100">Điện thoại</th>
                        <th class="width-80">Tác vụ</th>
                        <th class="width-100">Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(faculty, index) in faculties" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ faculty.name }}</td>
                        <td v-if="faculty.secretary != null">{{ faculty.secretary.name }}</td>
                        <td v-else></td>
                        <td v-if="faculty.secretary != null">{{ faculty.secretary.email }}</td>
                        <td v-else></td>
                        <td v-if="faculty.secretary != null">{{ faculty.secretary.phone }}</td>
                        <td v-else></td>
                        <td class="text-center text-primary">
                            <router-link :to="'/classrooms/' + faculty.id"><i class="far fa-eye"></i></router-link>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill badge-secondary">hello</span>
                        </td>
                    </tr>
                </tbody>
            </table>
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
            faculties: {},
            schoolLeaderAccs: {},
        }
    },
    methods: {
        loadFaculties(){
            this.$Progress.start();
            if(this.$gate.isAdminOrAccSchool()){
                axios.get('api/getSchoolLeaderAccs').then(({data}) => (
                    this.schoolLeaderAccs = data, this.$Progress.increase(30)
                ));
                axios.get('api/faculty_admin').then(({data}) => (
                    this.faculties = data.data, this.$Progress.finish()
                ));
            }else{
                this.$Progress.fail();
            }
        },
    },
    created() {
        this.loadFaculties();
    },
}
</script>