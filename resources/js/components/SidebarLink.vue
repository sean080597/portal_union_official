<template>
    <ul class="list-unstyled components" id="test">
        <li class="active">
            <router-link to="/">Trang Chủ</router-link>
        </li>
        <li v-if="isAdmin">
            <a href="#quan-ly-admin1" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">Quản lý</a>
            <ul class="collapse list-unstyled" id="quan-ly-admin1">
                <li><router-link to="/students-admin">Đoàn viên</router-link></li>
                <li><router-link to="/classrooms-admin">Lớp</router-link></li>
                <li><router-link to="/faculties-admin">Khoa</router-link></li>
                <li><router-link to="/users-admin">Tài khoản</router-link></li>
            </ul>
        </li>
        <li>
            <a href="#thong-tin-dv1" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">Thông tin đoàn viên</a>
            <ul class="collapse list-unstyled" id="thong-tin-dv1">
                <li v-if="isNotSchool"><router-link :to="getUserProfile">Thông tin cá nhân</router-link></li>
                <li v-if="isClass"><router-link :to="getClassProfile">Thông tin lớp</router-link></li>
                <li v-if="isFaculty"><router-link :to="getFacultyProfile">Thông tin khoa</router-link></li>
                <li v-if="isSchool"><router-link to="/faculties">Thông tin trường</router-link></li>
            </ul>
        </li>
        <li>
            <a href="#ql-dg1" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                Kiểm tra đánh giá
            </a>
            <ul class="collapse list-unstyled" id="ql-dg1">
                <li v-if="isClass">
                    <router-link :to="getClassReport">Kiểm tra lớp</router-link>
                </li>
                <li v-if="isFaculty"><router-link :to="getFacultyReport">Kiểm tra khoa</router-link></li>
                <li v-if="isSchool"><router-link to="/report-school">Kiểm tra toàn bộ</router-link></li>
            </ul>
        </li>
        <li>
            <a href="#ql-cv1" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                Công việc của tôi
            </a>
            <ul class="collapse list-unstyled" id="ql-cv1">
                <li v-if="isNotSchool"><router-link :to="getStudentReport">Công việc của tôi</router-link></li>
                <li v-if="isClass"><router-link :to="getClassTask">Công việc của tôi (lớp)</router-link></li>
                <li v-if="isFaculty"><router-link :to="getFacultyTask">Công việc của tôi (khoa)</router-link></li>
                <li v-if="isSchool"><router-link to="/mytask-school">Công việc của tôi (trường)</router-link></li>
            </ul>
        </li>
        <li v-if="isSchool"><router-link to="/create-event-score-board">Cài đặt đánh giá</router-link></li>
        <li v-if="isSchool"><router-link to="/statistic">Thống kê</router-link></li>
    </ul>
</template>
<script>
export default {
    data() {
        return {
            curUser:this.$gate.user,
        }
    },
    computed: {
        isAdmin(){
            if(this.$gate.isAdmin()){
                return true
            }
            return false
        },
        isNotSchool(){
            if(this.$gate.isAccSchool() || this.$gate.isAdmin()){
                return false
            }
            return true
        },
        isSchool(){
            if(this.$gate.isAdmin() || this.$gate.isAccSchool()){
                return true
            }
            return false
        },
        isFaculty(){
            if(this.$gate.isAccFaculty()){
                return true
            }
            return false
        },
        isClass(){
            if(this.$gate.isAccClass()){
                return true
            }
            return false
        },
        isStudent(){
            if(this.$gate.isAccStudent()){
                return true
            }
            return false
        },
        getUserProfile(){
            if(!this.isAdmin){
                return {path : '/student-profile/' + this.curUser.student.id}
            }
            return {path : '/student-profile/'}
        },
        getClassProfile(){
            return {path : '/student-profile/' + this.curUser.student.class_room_id}
        },
        getFacultyProfile(){
            return {path : '/student-profile/' + this.curUser.get_faculty.id}
        },
        getStudentReport(){
            let date = new Date()
            let year = date.getFullYear()
            return {path : '/bang-danh-gia/' + this.curUser.student.id + '/' + year}
        },
        getClassReport(){
            return {path : '/report-classroom/' + this.curUser.student.class_room_id}
        },
        getFacultyReport(){
            return {path : '/report-faculty/' + this.curUser.get_faculty.id}
        },
        getClassTask(){
            return {path : '/mytask-classroom/' + this.curUser.student.class_room_id}
        },
        getFacultyTask(){
            return {path : '/mytask-faculty/' + this.curUser.get_faculty.id}
        }
    },
    created() {
        
    },
}
</script>