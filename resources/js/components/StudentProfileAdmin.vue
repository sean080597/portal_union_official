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
                                    <img :src="getProfileImage()" alt="profile image" style="width:30%" id="update-profile-img">
                                </div>
                                <input type="file" id="image" class="form-control-file border" @change="updateImageProfile">
                            </div>
                            <div class="form-group">
                                <label for="name">Họ Tên</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nguyễn Văn A"
                                v-model="form.name" v-validate="'required|max:50'" :class="{ 'is-invalid': errors.has('name') }">
                                <div v-show="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
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
                                        <input type="text" class="form-control" id="phone" name="phone"
                                        v-model="form.phone" maxlength="10"
                                        onkeypress="return event.keyCode>47 && event.keyCode<58 ? true : false"
                                        onkeydown="return event.keyCode == 69 || event.keyCode == 189 ? false : true"
                                        v-validate="'numeric|min:10'"  :class="{ 'is-invalid': errors.has('phone')}">
                                        <div v-show="errors.has('phone')" class="invalid-feedback">{{ errors.first('phone') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input v-model="form.email" type="text" name="email" placeholder="nguyenvana@gmail.com" class="form-control"
                                v-validate="'required|email'" :class="{ 'is-invalid': errors.has('email') || form.errors.has('email')}">
                                <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <textarea name="address" id="address" rows="3" class="form-control" v-model="form.address"
                                v-validate="'required|min:10|max:100'" :class="{'textarea': true, 'is-invalid': errors.has('address') }"></textarea>
                                <div v-show="errors.has('address')" class="invalid-feedback">{{ errors.first('address') }}</div>
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
                                <select name="faculty_id" id="faculty_id" v-model="faculty_id" class="form-control"
                                @change="filtedClassrooms">
                                    <option value="" disabled>=== Chọn Khoa / Viện ===</option>
                                    <option v-for="(faculty, index) in faculties" :key="index" :value="faculty.id"
                                    :selected="faculty.id == student_info.faculty_id"
                                    >{{ faculty.name }} <span v-if="faculty.note !== null">/ {{ faculty.note }}</span></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="class_room">Chi đoàn</label>
                                <select v-model="form.class_room_id" name="class_room" id="class_room" class="form-control"
                                v-validate="'required'" :class="{'is-invalid': form.class_room_id == ''}">
                                    <option value="" disabled>=== Chọn Lớp ===</option>
                                    <option v-for="(classroom, index) in classrooms" :key="index" :value="classroom.id"
                                    :selected="classroom.id == student_info.class_room_id">{{ classroom.id }}</option>
                                </select>
                                <div v-show="errors.has('class_room')" class="invalid-feedback">{{ errors.first('class_room') }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Thong tin nhan than -->
                    <div class="card">
                        <div class="card-header bg-secondary text-white">Thông tin Cha</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="father_name">Họ tên</label>
                                <input type="text" class="form-control" id="father_name" name="father_name" v-model="form.father_name"
                                v-validate="'alpha_spaces'" :class="{ 'is-invalid': errors.has('father_name')}">
                                <div v-show="errors.has('father_name')" class="invalid-feedback">{{ errors.first('father_name') }}</div>
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
                                        <input type="text" class="form-control" id="father_phone" name="father_phone"
                                        v-model="form.father_phone" maxlength="10"
                                        onkeypress="return event.keyCode>47 && event.keyCode<58 ? true : false"
                                        onkeydown="return event.keyCode == 69 || event.keyCode == 189 ? false : true"
                                        v-validate="'numeric|min:10'"  :class="{ 'is-invalid': errors.has('father_phone')}">
                                        <div v-show="errors.has('father_phone')" class="invalid-feedback">{{ errors.first('father_phone') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="father_job">Công việc</label>
                                <input type="text" class="form-control" id="father_job" name="father_job" v-model="form.father_job"
                                v-validate="'alpha_spaces'" :class="{ 'is-invalid': errors.has('father_job')}">
                                <div v-show="errors.has('father_job')" class="invalid-feedback">{{ errors.first('father_job') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-2">
                        <div class="card-header bg-secondary text-white">Thông tin Mẹ</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="mother_name">Họ tên</label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name" v-model="form.mother_name"
                                v-validate="'alpha_spaces'" :class="{ 'is-invalid': errors.has('mother_name')}">
                                <div v-show="errors.has('mother_name')" class="invalid-feedback">{{ errors.first('mother_name') }}</div>
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
                                        <input type="text" class="form-control" id="mother_phone" name="mother_phone"
                                        v-model="form.mother_phone" maxlength="10"
                                        onkeypress="return event.keyCode>47 && event.keyCode<58 ? true : false"
                                        onkeydown="return event.keyCode == 69 || event.keyCode == 189 ? false : true"
                                        v-validate="'numeric|min:10'"  :class="{ 'is-invalid': errors.has('mother_phone')}">
                                        <div v-show="errors.has('mother_phone')" class="invalid-feedback">{{ errors.first('mother_phone') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mother_job">Công việc</label>
                                <input type="text" class="form-control" id="mother_job" name="mother_job" v-model="form.mother_job"
                                v-validate="'alpha_spaces'" :class="{ 'is-invalid': errors.has('mother_job')}">
                                <div v-show="errors.has('mother_job')" class="invalid-feedback">{{ errors.first('mother_job') }}</div>
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
            all_classrooms: {},
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
            }),
            oldProfileImage: '',
            isFirstLoading: true,
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
                this.form.class_room_id = data[0].class_room_id,
                this.form.image = (data[0].image != null) ? data[0].image : 'img_avatar1.png',
                //set old image
                this.oldProfileImage = (data[0].image != null) ? '/theme/images_profile/' + data[0].image : '/theme/images/img_avatar1.png'
            ));
            axios.get('/api/getAllFaculties').then(({data}) => (
                this.faculties = data, this.$Progress.increase(20)
            ));
            axios.get('/api/getAllClassrooms').then(({data}) => (
                this.all_classrooms = data, this.$Progress.increase(20)
            )).then(() => { this.filtedClassrooms() });
            axios.get('/api/getRelationsByStuId/' + this.student_id).then(({data}) => (
                this.relations = data,
                this.assignRelationsInfo(this.form, data),
                this.$Progress.increase(20)
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
        updateImageProfile(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if(file != null){
                if (file['type'] == "image/jpeg" || file['type'] == "image/jpg" || file['type'] == "image/png"){
                    if(file['size'] < 2097153){
                        reader.onloadend = (file) => {
                            this.form.image = reader.result;
                        }
                        reader.readAsDataURL(file);
                        $("#update-profile-img").attr("src", window.URL.createObjectURL(file));
                    }else{
                        Swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Kích thước file không vượt quá 2MB'
                        });
                        $("#image").val(null);
                        $("#update-profile-img").attr("src", this.oldProfileImage);
                    }
                }else{
                    Swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Vui lòng chọn file ảnh'
                    });
                    $("#image").val(null);
                    $("#update-profile-img").attr("src", this.oldProfileImage);
                }
            }else{
                $("#update-profile-img").attr("src", this.oldProfileImage);
            }
        },
        submitChangeInfoStudent(){
            this.$Progress.start();
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.form.put('/api/updateProfile')
                    .then(()=>{
                        toast({type: 'success', title: 'Đã sửa thông tin thành công!'});
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    });
                }else{
                    // Swal('error', 'Chưa điền đầy đủ thông tin!', 'error');
                    this.$Progress.fail();
                }
            });
        },
        getProfileImage(){
            if(this.form.image == 'img_avatar1.png'){
                return "/theme/images/img_avatar1.png";
            }else{
                return (this.form.image.length > 200) ? this.form.image : '/theme/images_profile/' + this.form.image;
            }
        },
        filtedClassrooms(){
            if(!this.isFirstLoading){
                //reset select option
                this.form.class_room_id = '';
            }else{
                this.isFirstLoading = false;
            }
            this.classrooms = this.all_classrooms.filter(el => el.faculty_id == this.faculty_id);
        }
    },
    created() {
        this.loadStudentInfo();
    },
}
</script>