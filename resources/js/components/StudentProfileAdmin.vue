<template>
    <div class="container">
        <form @submit.prevent="submitChangeInfoStudent">
            <div class="row">
                <div class="input-group mb-3 col-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text">MSSV</span>
                    </div>
                    <input type="text" class="form-control" :value="student_info.mssv" disabled>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">Thông tin cá nhân</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="image">Hình Ảnh</label>
                                <div class="wrap-avatar mb-1">
                                    <img :src="'/theme/images/img_avatar1.png'" alt="anh" style="width:30%">
                                </div>
                                <input type="file" id="image" class="form-control-file border">
                            </div>
                            <div class="form-group">
                                <label for="name">Họ Tên</label>
                                <input type="text" class="form-control" id="name" placeholder="Nguyễn Văn A" :value="student_info.name">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="birthday">Ngày sinh</label>
                                        <input type="date" class="form-control" id="birthday" :value="student_info.birthday">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sex">Giới tính</label>
                                        <select name="sex" id="sex" class="form-control">
                                            <option value="-1" disabled>=== Chọn giới tính ===</option>
                                            <option value="1" :selected="student_info.sex">Nam</option>
                                            <option value="0" :selected="!student_info.sex">Nữ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="union_date">Ngày vào đoàn</label>
                                        <input type="date" class="form-control" id="union_date" :value="student_info.union_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="hometown">Quê quán</label>
                                        <input type="text" class="form-control" id="hometown" :value="student_info.hometown">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="ethnic">Dân tộc</label>
                                        <input type="text" class="form-control" id="ethnic" :value="student_info.ethnic">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="religion">Tôn giáo</label>
                                        <input type="text" class="form-control" id="religion" :value="student_info.religion">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="form-check-inline">
                                        <label for="is_submit" class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id="is_submit" :checked="student_info.is_submit">
                                            Nộp sổ đoàn</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="phone">SĐT</label>
                                        <input type="number" class="form-control" id="phone" :value="student_info.phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="nguyenvana@gmail.com" required
                                :value="student_info.email">
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <textarea name="address" id="address" rows="3" class="form-control" v-text="student_info.address"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">Thông tin khác</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="faculty_id">Đoàn khoa</label>
                                <select name="faculty_id" id="faculty_id" class="form-control">
                                    <option value="" disabled>=== Chọn Khoa / Viện ===</option>
                                    <option v-for="(faculty, index) in faculties" :key="index" :value="faculty.id"
                                    :selected="faculty.id == student_info.faculty_id"
                                    >{{ faculty.name }} <span v-if="faculty.note !== null">/ {{ faculty.note }}</span></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="class-room">Chi đoàn</label>
                                <select name="class-room" id="class-room" class="form-control">
                                    <option value="" disabled>=== Chọn Lớp ===</option>
                                    <option v-for="(classroom, index) in classrooms" :key="index" :value="classroom.id"
                                    :selected="classroom.id == student_info.class_room_id">{{ classroom.id }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Thong tin nhan than -->
                    <div v-if="relations.length > 0">
                        <div class="card" v-for="(relation, index) in relations" :key="index">
                            <div class="card-header bg-secondary text-white" v-if="relation.role == 1">Thông tin Cha</div>
                            <div class="card-header bg-secondary text-white" v-else>Thông tin Mẹ</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label :for="(relation.role == 1) ? 'father_name' : 'mother_name'">Họ tên</label>
                                    <input type="text" class="form-control" :name="(relation.role == 1) ? 'father_name' : 'mother_name'"
                                    :id="(relation.role == 1) ? 'father_name' : 'mother_name'" :value="relation.name">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label :for="(relation.role == 1) ? 'father_birthday' : 'mother_birthday'">Ngày sinh</label>
                                            <input type="date" class="form-control" :name="(relation.role == 1) ? 'father_birthday' : 'mother_birthday'"
                                            :id="(relation.role == 1) ? 'father_birthday' : 'mother_birthday'" :value="relation.birthday">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label :for="(relation.role == 1) ? 'father_phone' : 'mother_phone'">Điện thoại</label>
                                            <input type="number" class="form-control" :name="(relation.role == 1) ? 'father_phone' : 'mother_phone'"
                                            :id="(relation.role == 1) ? 'father_phone' : 'mother_phone'" :value="relation.phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label :for="(relation.role == 1) ? 'father_job' : 'mother_job'">Công việc</label>
                                    <input type="text" class="form-control" :name="(relation.role == 1) ? 'father_job' : 'mother_job'"
                                    :id="(relation.role == 1) ? 'father_job' : 'mother_job'" :value="relation.job">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="card">
                            <div class="card-header bg-secondary text-white">Thông tin Cha</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="father-name">Họ tên</label>
                                    <input type="text" class="form-control" id="father-name">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="father-birthday">Ngày sinh</label>
                                            <input type="date" class="form-control" id="father-birthday">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="father-phone">Điện thoại</label>
                                            <input type="number" class="form-control" id="father-phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="father-job">Công việc</label>
                                    <input type="text" class="form-control" id="father-job">
                                </div>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header bg-secondary text-white">Thông tin Mẹ</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="mother-name">Họ tên</label>
                                    <input type="text" class="form-control" id="mother-name">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mother-birthday">Ngày sinh</label>
                                            <input type="date" class="form-control" id="mother-birthday">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="mother-phone">Điện thoại</label>
                                            <input type="number" class="form-control" id="mother-phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mother-job">Công việc</label>
                                    <input type="text" class="form-control" id="mother-job">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End thong tin nhan than -->
                </div>
                <button type="submit" class="btn btn-success mx-auto mt-3">Lưu thông tin</button>
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
            faculty_id: '',
            faculties: {},
            classrooms: {},
            relations: {},
        }
    },
    methods: {
        loadStudentInfo(){
            this.$Progress.start();
            axios.get('/api/getUserStudentInfoByStuId/' + this.student_id).then(({data}) => (
                this.student_info = data[0], this.$Progress.increase(20), this.faculty_id = data[0].faculty_id
            )).then(() => {
                axios.get('/api/getAllClassroomsByFacultyID/' + this.faculty_id).then(({data}) => (
                    this.classrooms = data, this.$Progress.increase(20)
                ));
            });
            axios.get('/api/getAllFaculties').then(({data}) => (
                this.faculties = data, this.$Progress.increase(20)
            ));
            axios.get('/api/getRelationsByStuId/' + this.student_id).then(({data}) => (
                this.relations = data, this.$Progress.finish()
            ));
        },
        submitChangeInfoStudent(){
            Swal('Sorry!', 'Doing!', 'error');
        }
    },
    created() {
        this.loadStudentInfo();
    },
}
</script>