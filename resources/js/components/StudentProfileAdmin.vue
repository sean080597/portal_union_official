<template>
    <div class="container">
        <form @submit.prevent="submitChangeInfoStudent">
            <div class="row">
                <div class="input-group mb-3 col-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text">MSSV</span>
                    </div>
                    <input type="text" class="form-control" v-model="form.id" disabled>
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
                                <input type="file" id="image" class="form-control-file border" @change="updateProfile">
                            </div>
                            <div class="form-group">
                                <label for="name">Họ Tên</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nguyễn Văn A"
                                v-model="form.name">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="birthday">Ngày sinh</label>
                                        <input type="date" class="form-control" id="birthday" v-model="form.birthday">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sex">Giới tính</label>
                                        <select v-model="form.sex" name="sex" id="sex" class="form-control">
                                            <option value="-1" disabled>=== Chọn giới tính ===</option>
                                            <option value="1" :selected="form.sex">Nam</option>
                                            <option value="0" :selected="!form.sex">Nữ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="union_date">Ngày vào đoàn</label>
                                        <input type="date" class="form-control" id="union_date" v-model="form.union_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="hometown">Quê quán</label>
                                        <input type="text" class="form-control" id="hometown" v-model="form.hometown">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="ethnic">Dân tộc</label>
                                        <input type="text" class="form-control" id="ethnic" v-model="form.ethnic">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="religion">Tôn giáo</label>
                                        <input type="text" class="form-control" id="religion" v-model="form.religion">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <div class="form-check-inline">
                                        <label for="is_submit" class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id="is_submit"
                                            v-model="form.is_submit" :checked="form.is_submit">
                                            Nộp sổ đoàn</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="phone">SĐT</label>
                                        <input type="number" class="form-control" id="phone" v-model="form.phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="nguyenvana@gmail.com" required
                                v-model="form.email">
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <textarea name="address" id="address" rows="3" class="form-control" v-model="form.address"></textarea>
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
                                <select v-model="form.class_room_id" name="class-room" id="class-room" class="form-control">
                                    <option value="" disabled>=== Chọn Lớp ===</option>
                                    <option v-for="(classroom, index) in classrooms" :key="index" :value="classroom.id"
                                    :selected="classroom.id == student_info.class_room_id">{{ classroom.id }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Thong tin nhan than -->
                    <div class="card">
                        <div class="card-header bg-secondary text-white">Thông tin Cha</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="father_name">Họ tên</label>
                                <input type="text" class="form-control" id="father_name" name="father_name" v-model="form.father_name">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="father_birthday">Ngày sinh</label>
                                        <input type="date" class="form-control" id="father_birthday" name="father_birthday" v-model="form.father_birthday">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="father_phone">Điện thoại</label>
                                        <input type="number" class="form-control" id="father_phone" name="father_phone" v-model="form.father_phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="father_job">Công việc</label>
                                <input type="text" class="form-control" id="father_job" name="father_job" v-model="form.father_job">
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header bg-secondary text-white">Thông tin Mẹ</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="mother_name">Họ tên</label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name" v-model="form.mother_name">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="mother_birthday">Ngày sinh</label>
                                        <input type="date" class="form-control" id="mother_birthday" name="mother_birthday" v-model="form.mother_birthday">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="mother_phone">Điện thoại</label>
                                        <input type="number" class="form-control" id="mother_phone" name="mother_phone" v-model="form.mother_phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mother_job">Công việc</label>
                                <input type="text" class="form-control" id="mother_job" name="mother_job" v-model="form.mother_job">
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
            form: new Form({
                id: this.$route.params.student_id,
                name: '',
                birthday: '',
                sex: '',
                hometown: '',
                union_date: '',
                religion: '',
                is_submit: '',
                phone: '',
                email: '',
                address: '',
                image: '',
                class_room_id: '',
                father_name: '',
                father_birthday: '',
                father_phone: '',
                father_job: '',
                mother_name: '',
                mother_birthday: '',
                mother_phone: '',
                mother_job: '',
            })
        }
    },
    methods: {
        loadStudentInfo(){
            this.$Progress.start();
            axios.get('/api/getUserStudentInfoByStuId/' + this.student_id).then(({data}) => (
                this.student_info = data[0], this.$Progress.increase(20),
                this.faculty_id = data[0].faculty_id,
                this.form.name = data[0].name,
                this.form.birthday = data[0].birthday,
                this.form.sex = data[0].sex,
                this.form.hometown = data[0].hometown,
                this.form.union_date = data[0].union_date,
                this.form.religion = data[0].religion,
                this.form.is_submit = data[0].is_submit,
                this.form.phone = data[0].phone,
                this.form.email = data[0].email,
                this.form.address = data[0].address,
                this.form.class_room_id = data[0].class_room_id
            )).then(() => {
                axios.get('/api/getAllClassroomsByFacultyID/' + this.faculty_id).then(({data}) => (
                    this.classrooms = data, this.$Progress.increase(20)
                ));
            });
            axios.get('/api/getAllFaculties').then(({data}) => (
                this.faculties = data, this.$Progress.increase(20)
            ));
            axios.get('/api/getRelationsByStuId/' + this.student_id).then(({data}) => (
                this.relations = data,
                this.assignRelationsInfo(this.form, data),
                this.$Progress.finish()
            ));
        },
        assignRelationsInfo(form, relations){
            $.each(relations, function (index, value) {
                if(value.role == 1){
                    form.father_name = value.name,
                    form.father_birthday = value.birthday,
                    form.father_phone = value.phone,
                    form.father_job = value.job
                }else{
                    form.mother_name = value.name,
                    form.mother_birthday = value.birthday,
                    form.mother_phone = value.phone,
                    form.mother_job = value.job
                }
            })
        },
        updateProfile(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onloadend = (file) => {
                this.form.image = reader.result;
            }
            reader.readAsDataURL(file);
        },
        submitChangeInfoStudent(){
            this.form.put('/api/updateProfile')
            .then(()=>{

            })
            .catch(()=>{

            });
        },
    },
    created() {
        this.loadStudentInfo();
    },
}
</script>