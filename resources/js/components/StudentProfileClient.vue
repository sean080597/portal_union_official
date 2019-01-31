<template>
<div>
    <div class="row" v-if="checkToShow">
        <div class="col-lg-3 d-flex flex-column align-items-center">
            <img class="img-fluid mb-3" :src="getProfileImage()" alt="Chania" width="120">
            <div class="note-success">
                <p>Cập nhật gần nhất: <br>{{ student_info.updated_at | myTimeDateFormat }}</p>
            </div>
            <div class="note-info">
                <p>Yêu cầu chỉnh sửa các thông tin khác xin liên hệ:</p>
                <ul>
                    <li><p>PHÒNG CÔNG TÁC SINH VIÊN</p></li>
                    <li><p>Trụ sở: 475A (số cũ:144/24) Điện Biên Phủ, P.25, Q.Bình Thạnh, TP.HCM</p></li>
                    <li><p>ĐT: (028) 3 5120782</p></li>
                    <li><p>Fax: (028) 3 5120784</p></li>
                    <li><a href="http://daotao.hutech.edu.vn/" target="_blank">daotao@hutech.edu.vn</a></li>
                </ul>
            </div>
            <div class="note-warning">
                <p>Lưu ý: <span class="text-danger">(*)</span> Dữ liệu không được phép để trống</p>
            </div>
        </div>
        <form @submit.prevent="submitChangeInfoStudent" class="col-lg-9 d-flex flex-column align-items-center">
            <div class="row info-section">
                <div class="col-md-6">Mã số sinh viên: <span class="font-weight-bold">{{ student_info.mssv }}</span> </div>
                <div class="col-md-6">Họ và tên: <span class="font-weight-bold">{{ student_info.name }}</span> </div>
                <div class="col-md-6">Lớp: <span class="font-weight-bold">{{ student_info.class_room_id }}</span> </div>
                <div class="col-md-6">Ngày sinh: <span>{{ student_info.birthday | myDateFormat }}</span> </div>
                <div class="col-md-6">Khoa: <span class="font-weight-bold">{{ student_info.faculty_name }}</span> </div>
                <div class="col-md-6">Niên khóa: <span>2015-2019</span> </div>
                <div class="col-md-6">Chuyên ngành: <span class="font-weight-bold">{{ student_info.faculty_name }}</span> </div>
            </div>
            <div class="info-section">
                <h5>Thông tin sinh viên</h5>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="sex">Giới tính <span class="text-danger">(*)</span></label>
                        <select name="sex" id="sex" class="form-control">
                            <option value="" disabled>=== Chọn giới tính ===</option>
                            <option value="1" :selected="student_info.sex">Nam</option>
                            <option value="0" :selected="!student_info.sex">Nữ</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="hometown">Nơi sinh: <span class="text-danger">(*)</span></label>
                        <select name="hometown" id="hometown" class="form-control">
                            <option value="-1" selected>Chọn Tỉnh / TP</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email: <span class="text-danger">(*)</span></label>
                        <input type="email" class="form-control" id="email" :value="student_info.email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phonenum">Điện thoại: <span class="text-danger">(*)</span></label>
                        <input type="number" class="form-control" id="phonenum" :value="student_info.phone">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="union_date">Ngày vào đoàn: <span class="text-danger">(*)</span></label>
                        <input type="date" class="form-control" id="union_date" :value="student_info.union_date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ethnic">Dân tộc:</label>
                        <input type="text" class="form-control" id="ethnic" :value="student_info.ethnic">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="religion">Tôn giáo:</label>
                        <input type="text" class="form-control" id="religion" :value="student_info.religion">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="vanhoa">Trình độ văn hóa: <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" id="vanhoa" value="12 / 12" disabled>
                    </div>
                </div>
            </div>
            <div class="info-section">
                <h5>Địa chỉ liên lạc</h5>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="tp">Tỉnh/TP <span class="text-danger">(*)</span></label>
                        <select name="tp" id="tp" class="form-control">
                            <option value="-1" selected>Chọn Tỉnh / TP</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="quan">Quận/ Huyện <span class="text-danger">(*)</span></label>
                        <select name="quan" id="quan" class="form-control">
                            <option value="-1" selected>Chọn Quận/ Huyện</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="address">Địa chỉ <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Số nhà, đường, phường/ xã"
                        :value="student_info.address">
                    </div>
                </div>
            </div>
            <div class="info-section">
                <h5>Thông tin nhân thân</h5>
                <!-- show if relations is not null -->
                <div class="row" v-if="relations.length > 0">
                    <div class="col-md-6" v-for="(relation, index) in relations" :key="index">
                        <div class="form-group">
                            <label for="father_name" v-if="relation.role == 1">Họ tên cha: <span class="text-danger">(*)</span></label>
                            <label for="mother_name" v-else>Họ tên mẹ: <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" :name="(relation.role == 1) ? 'father_name' : 'mother_name'"
                            :id="(relation.role == 1) ? 'father_name' : 'mother_name'" :value="relation.name">
                        </div>
                        <div class="form-group">
                            <label :for="(relation.role == 1) ? 'father_birthday' : 'mother_birthday'">Ngày sinh: <span class="text-danger">(*)</span></label>
                            <input type="date" class="form-control" :name="(relation.role == 1) ? 'father_birthday' : 'mother_birthday'"
                            :id="(relation.role == 1) ? 'father_birthday' : 'mother_birthday'" :value="relation.birthday">
                        </div>
                        <div class="form-group">
                            <label :for="(relation.role == 1) ? 'father_job' : 'mother_job'">Nghề nghiệp: </label>
                            <input type="text" class="form-control" :name="(relation.role == 1) ? 'father_job' : 'mother_job'"
                            :id="(relation.role == 1) ? 'father_job' : 'mother_job'" :value="relation.job">
                        </div>
                        <div class="form-group">
                            <label :for="(relation.role == 1) ? 'father_phone' : 'mother_phone'">Điện thoại: <span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control" :name="(relation.role == 1) ? 'father_phone' : 'mother_phone'"
                            :id="(relation.role == 1) ? 'father_phone' : 'mother_phone'" :value="relation.phone">
                        </div>
                    </div>
                </div>
                <div class="row" v-else>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="father_name">Họ tên cha: <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" name="father_name" id="father_name">
                        </div>
                        <div class="form-group">
                            <label for="father_birthday">Ngày sinh: <span class="text-danger">(*)</span></label>
                            <input type="date" class="form-control" name="father_birthday" id="father_birthday">
                        </div>
                        <div class="form-group">
                            <label for="father_job">Nghề nghiệp: </label>
                            <input type="text" class="form-control" name="father_job" id="father_job">
                        </div>
                        <div class="form-group">
                            <label for="father_phone">Điện thoại: <span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control" name="father_phone" id="father_phone">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tenme">Họ tên mẹ: <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" name="tenme" id="tenme">
                        </div>
                        <div class="form-group">
                            <label for="mother_birthday">Ngày sinh: <span class="text-danger">(*)</span></label>
                            <input type="date" class="form-control" name="mother_birthday" id="mother_birthday">
                        </div>
                        <div class="form-group">
                            <label for="mother_job">Nghề nghiệp: </label>
                            <input type="text" class="form-control" name="mother_job" id="mother_job">
                        </div>
                        <div class="form-group">
                            <label for="mother_phone">Điện thoại: <span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control" name="mother_phone" id="mother_phone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="info-section">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
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
            student_id: this.$route.params.student_id,
            student_info: {},
            relations: {},
            profile_image: '',
            checkToShow: false,
        }
    },
    methods: {
        loadStudentInfo(){
            this.$Progress.start();
            axios.get('/api/getUserStudentInfoByStuId/' + this.student_id).then(({data}) => (
                this.student_info = data[0],
                this.profile_image = (data[0].image != null) ? data[0].image : 'img_avatar1.png',
                this.$Progress.increase(40),
                this.checkToShow = this.$gate.isStudentProfilePagePassed(data[0].class_room_id)
            ));
            if(this.checkToShow){
                axios.get('/api/getRelationsByStuId/' + this.student_id).then(({data}) => (
                    this.relations = data, this.$Progress.finish()
                ));
            }
        },
        getProfileImage(){
            if(this.profile_image == 'img_avatar1.png'){
                return "/theme/images/img_avatar1.png";
            }else{
                return '/theme/images_profile/' + this.profile_image;
            }
        },
        submitChangeInfoStudent(){
            Swal('Sorry!', 'Doing!', 'error');
        },
    },
    created() {
        this.loadStudentInfo();
    },
}
</script>