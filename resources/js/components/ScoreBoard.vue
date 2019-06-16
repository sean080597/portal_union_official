<template>
<div>
    <div class="wrap-table" v-if="checkToShow">
        <div class="note-info">
            <div class="row">
                <div class="col-sm-6"><p><span>Tên: </span>{{student_info.name}}</p></div>
                <div class="col-sm-6"><p><span>MSSV: </span>{{student_info.mssv}}</p></div>
                <div class="col-sm-6"><p><span>Chi đoàn: </span>{{student_info.class_room_id}}</p></div>
                <div class="col-sm-6"><p><span>Khoa: </span>{{student_info.faculty_name}}</p></div>
            </div>
        </div>
        <div class="note-warning" v-show="isShowedSchoolInfo">
            <div class="row">
                <div class="col-sm"><p><span>ĐV: </span>Đoàn viên</p></div>
                <div class="col-sm"><p><span>CĐ: </span>Bí thư chi đoàn</p></div>
                <div class="col-sm"><p><span>Khoa: </span>Bí thư đoàn khoa</p></div>
                <div class="col-sm"><p><span>Trường: </span>Bí thư đoàn trường</p></div>
            </div>
        </div>
        <form @submit.prevent="submitForm">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" style="min-width:60%" class="text-center">Nội dung</th>
                            <th rowspan="2" style="width:10%" class="text-center">Minh Chứng</th>
                            <th rowspan="2" style="width:140px" class="text-center">Xếp loại</th>
                            <th rowspan="2" style="width:70px" class="text-center">Điểm</th>
                            <th colspan="4" class="text-center">Đánh Giá</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="width:5%">ĐV</th>
                            <th class="text-center" style="width:5%">CĐ</th>
                            <th class="text-center" style="width:5%">Khoa</th>
                            <th class="text-center" style="width:5%">Trường</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" style="font-weight:700"><span>I. </span> Nội dung đoàn viên đăng ký thực hiện theo yêu cầu chung của đoàn trường<span> (Tối đa: 70đ)</span></td>
                        </tr>
                        <tr v-for="(activity, index) in form.school_activities" :key="'school-activity-'+index" >
                            <td>
                                <span>{{ index+1 }}. </span>
                                <span>{{ activity.title }}</span>
                            </td>
                            <td class="text-center"><a href="#" data-toggle="modal" data-target="#manage-activities-modal" class="text-primary" @click="manageActivities($event)">Minh chứng</a></td>
                            <td class="text-center p-1">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    style="max-width:150px"
                                    v-model="schoolScoreOnChange[index]"
                                    disabled>
                            </td>
                            <td class="text-center">
                                <input
                                    type="text"  style="max-width:50px"
                                    class="form-control m-0 text-right"
                                    v-model="activity.pivot.average_score"
                                    @change="onChangeSchoolScore(index,activity.pivot.average_score)"
                                    disabled
                                >
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-success btn-light"
                                    data-toggle="modal" data-target="#manage-activities-modal" 
                                    v-if="activity.pivot.confirmingStudent" 
                                    :disabled="isDisabledStudent"
                                    @click="[loadImageOfSchoolsActivities(activity.pivot.schools_activity_id),populateModal(index,'school','student')]"
                                ><i class="fas fa-check"></i></button>
                                <button 
                                    type="button"
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    class="btn btn-outline-danger btn-light" 
                                    v-else :disabled="isDisabledStudent"
                                    @click="[loadImageOfSchoolsActivities(activity.pivot.schools_activity_id),populateModal(index,'school','student')]"
                                ><i class="far fa-circle"></i></button>
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-success btn-light"
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-if="activity.pivot.confirmingClass" 
                                    :disabled="isDisabledClass"
                                    @click="[loadImageOfSchoolsActivities(activity.pivot.schools_activity_id),populateModal(index,'school','class')]"
                                ><i class="fas fa-check"></i></button>
                                <button 
                                    type="button" 
                                    class="btn btn-outline-danger btn-light"
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-else :disabled="isDisabledClass"
                                    @click="[loadImageOfSchoolsActivities(activity.pivot.schools_activity_id),populateModal(index,'school','class')]"
                                ><i class="far fa-circle"></i></button>
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-success btn-light"
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-if="activity.pivot.confirmingFaculty" 
                                    :disabled="isDisabledFaculty"
                                    @click="[loadImageOfSchoolsActivities(activity.pivot.schools_activity_id),populateModal(index,'school','faculty')]"
                                ><i class="fas fa-check"></i></button>
                                <button 
                                    type="button" 
                                    class="btn btn-outline-danger btn-light"
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-else :disabled="isDisabledFaculty"
                                    @click="loadImageOfSchoolsActivities(activity.pivot.schools_activity_id),populateModal(index,'school','faculty')"
                                ><i class="far fa-circle"></i></button>
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" 
                                    class="btn btn-outline-success btn-light" 
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-if="activity.pivot.confirmingSchool" 
                                    :disabled="isDisabledSchool"
                                    @click="[loadImageOfSchoolsActivities(activity.pivot.schools_activity_id),populateModal(index,'school','school')]"
                                ><i class="fas fa-check"></i></button>
                                <button 
                                    type="button"
                                    class="btn btn-outline-danger btn-light" 
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-else :disabled="isDisabledSchool"
                                    @click="[loadImageOfSchoolsActivities(activity.pivot.schools_activity_id),populateModal(index,'school','school')]"
                                ><i class="far fa-circle"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" style="font-weight:700"><span>II. </span> Nội dung đoàn viên tự đăng ký thực hiên<span> (Tối đa: 30đ)</span></td>
                        </tr>
                        <tr v-for="(activity, index) in form.self_activities" :key="'self-activity-'+index">
                            <td class="p-1">
                                <span style="margin: 5px;">
                                    {{ index+1 }}. {{ activity.title }}
                                </span>
                                <textarea 
                                    class="form-control" rows="3"
                                    :disabled="isDisabledStudent"
                                    v-model="activity.pivot.activity_content"
                                ></textarea>
                            </td>
                            <td class="text-center"><a href="#" class="text-primary">Minh chứng</a></td>
                            <td class="text-center p-1">
                                <input type="text" class="form-control" style="max-width:150px" v-model="selfScoreOnChange[index]" disabled>
                            </td>
                            <td class="text-center">
                                <input
                                    type="text"  style="max-width:50px"
                                    v-model="activity.pivot.average_score"
                                    class="form-control mb-0 text-right"
                                    @change="onChangeSelfScore(index,activity.pivot.average_score)"
                                    disabled
                                >
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" class="btn btn-outline-success btn-light" 
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-if="activity.pivot.confirmingStudent"
                                    :disabled="isDisabledStudent"
                                    @click="[loadImageOfSelfActivities(activity.pivot.self_activity_id),populateModal(index,'self','student')]"
                                ><i class="fas fa-check"></i></button>
                                <button 
                                    type="button" class="btn btn-outline-danger btn-light" 
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-else
                                    :disabled="isDisabledStudent"
                                    @click="[loadImageOfSelfActivities(activity.pivot.self_activity_id),populateModal(index,'self','student')]"
                                    ><i class="far fa-circle"></i></button>
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" class="btn btn-outline-success btn-light" 
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-if="activity.pivot.confirmingClass"
                                    :disabled="isDisabledClass"
                                    @click="[loadImageOfSelfActivities(activity.pivot.self_activity_id),populateModal(index,'self','class')]"
                                ><i class="fas fa-check"></i></button>
                                <button 
                                    type="button" class="btn btn-outline-danger btn-light" 
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-else
                                    :disabled="isDisabledClass"
                                    @click="[loadImageOfSelfActivities(activity.pivot.self_activity_id),populateModal(index,'self','class')]"
                                ><i class="far fa-circle"></i></button>
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" class="btn btn-outline-success btn-light" 
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-if="activity.pivot.confirmingFaculty"
                                    :disabled="isDisabledFaculty"
                                    @click="[loadImageOfSelfActivities(activity.pivot.self_activity_id),populateModal(index,'self','faculty')]"
                                ><i class="fas fa-check"></i></button>
                                <button 
                                    type="button" class="btn btn-outline-danger btn-light" v-else
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    :disabled="isDisabledFaculty"
                                    @click="[loadImageOfSelfActivities(activity.pivot.self_activity_id),populateModal(index,'self','faculty')]"
                                ><i class="far fa-circle"></i></button>
                            </td>
                            <td class="text-center">
                                <button 
                                    type="button" class="btn btn-outline-success btn-light" 
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    v-if="activity.pivot.confirmingSchool"
                                    :disabled="isDisabledSchool"
                                    @click="populateModal(index,'self','school')"
                                ><i class="fas fa-check"></i></button>
                                <button 
                                    type="button" class="btn btn-outline-danger btn-light" v-else
                                    data-toggle="modal" data-target="#manage-activities-modal"
                                    :disabled="isDisabledSchool"
                                    @click="populateModal(index,'self','school')"
                                ><i class="far fa-circle"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Xác nhận</button>
                </div>
            </div>
        </form>
    </div>
    <div class="mb-5" v-else>
        <not-found></not-found>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="manage-activities-modal">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Quản lý minh chứng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="mb-2">
                    <div class="form-group clearfix">
                        <input type="file" class="float-left" @change="uploadImage">
                        <button v-show="displayBtnUpload" type="buttom" class="btn btn-primary mb-2 mr-2 float-right" @click.prevent="moveImage">Add</button>
                    </div>
                    <div><span> Tổng số minh chứng: {{formModal.totalImages}}</span></div>
                </div>
                <div class="container-fluid">
                    <div class="card shadow mb-2" v-for="(li,index) in  formModal.currentImages">
                        <div class="card-body">
                            <div class="card-title float-left">
                                <h4 class="text-primary">Minh chứng {{index+1}}</h4>
                            </div>
                            <button class="btn btn-danger float-right" @click="deleteImageClick(li,index)"><i class="fas fa-trash-alt"></i></button>
                        </div>
                        <img class="card-img" :src="'/theme/activity_images/'+li" alt="Card image">
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" @click="confirmScore">Xác nhận</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>

            </div>
        </div>
        </div>
    <!-- End Modal -->
</div>
</template>
<script>
export default {
    data(){
        return {
            checkToShow : false, //show score board page if it has a student
            isShowedSchoolInfo : false, // show email of fac, class, school
            student_info : {},   // infomation of student
            schoolScoreOnChange: [],
            selfScoreOnChange: [],
            year: this.$route.params.year,
            displayBtnUpload: false,
            deleteImages: [],

            //------------
            images: [],
            image:'',
            form: new Form({
                student_id : this.$route.params.student_id,
                self_activities : {},    
                school_activities : {}, //school's activities
            }),
            formModal: new Form({
                index: null,
                typeActivity: '',
                typeConfirm: '',
                n_images: 0,
                images:[],
                image: '',
                newImages:[], //anh dc them
                currentImages:[], //anh dc load len
                preImage:'',
                nowImage:'',
                totalImages:0
            })

        }
    },
    computed:{
        isDisabledStudent(){
            //enabled doan vien
            return !this.checkFoD('stu')
        },
        isDisabledClass(){
            //enabled doan vien
            return !this.checkFoD('cla')
        },
        isDisabledFaculty(){
            //enabled doan vien
            return !this.checkFoD('fac')
        },
        isDisabledSchool(){
            //enabled doan vien
            return !this.checkFoD('sch')
        },
        totalImages(){

        }
    },
    created() {
        this.loadStudent()
    },
    mounted() {
        
    },
    methods: {
        //-------------------------  set onchange for average score -------------------------------
        avgMark(mark){
            const D = 3
            const C = 5
            const B = 7
            const A = 9
            let result = "Kém"
            switch(true){
                case (mark < D):
                    result = "Kém"
                    break
                case (mark < C):
                    result = "Yếu"
                    break
                case (mark < B):
                    result = "Trung Bình"
                    break
                case (mark < A):
                    result = "Khá"
                    break
                default:
                    result = "Giỏi"
            }
            return result
        },
        onChangeSchoolScore(index, score){
            this.schoolScoreOnChange[index] = this.avgMark(score)
            this.$forceUpdate() 
        },
        onChangeSelfScore(index, score){
            this.selfScoreOnChange[index] = this.avgMark(score)
            this.$forceUpdate() 
        },
        //-------------------------  end set self assessment ---------------------------
        //load data of student
        loadStudent(){
            this.$Progress.start()
            axios.get('/api/getUserStudentInfoByStuId/' + this.form.student_id)
            .then((data) => {
                this.student_info = data.data[0]
                this.checkToShow = true
                this.loadDataForFage(this.form.student_id,this.year)
                this.$Progress.finish()
            })
        },

        loadDataForFage(id,year){
            axios.get('/api/showScore/' + id + '/' + year)
            .then((data) => {
                this.form.school_activities = data.data['school']
                this.form.self_activities = data.data['self']
                let schoolScore = data.data['school']
                for(let index in schoolScore){
                    this.schoolScoreOnChange[index] = this.avgMark(schoolScore[index].pivot.average_score)
                }
                let selfScore = data.data['self']
                for(let index in selfScore){
                    this.selfScoreOnChange[index] = this.avgMark(selfScore[index].pivot.average_score)
                }
            })
        },

        // ----------------- image --------------------
        //caculate score => output average score
        totalScore(){
            let currentIndex = this.formModal.index
            let currentScore = ((this.formModal.totalImages*2) > 9)?10:this.formModal.totalImages*2
            if(this.formModal.typeActivity == 'school'){
                this.form.school_activities[currentIndex].pivot.average_score = currentScore
                this.schoolScoreOnChange[currentIndex] = this.avgMark(currentScore)
                this.$forceUpdate()
            }else{
                this.form.self_activities[currentIndex].pivot.average_score = currentScore
                this.selfScoreOnChange[currentIndex] = this.avgMark(currentScore)
                this.$forceUpdate()
            }
        },

        //get images from sv
        loadImageOfSchoolsActivities($id){
            
                this.images = []//old
                this.formModal.n_images = 0 //old
                this.formModal.totalImages = 0
                this.formModal.currentImages = []
                this.formModal.newImages = []
            axios.get('/api/showImagesSchoolActivity/'+$id)
            .then((data)=>{
                for(let item of data.data){
                    this.images.push(item.image) //old
                    this.formModal.n_images++ //old
                    this.formModal.currentImages.push(item.image)
                    this.formModal.totalImages++
                }
                this.$forceUpdate()
            })
        },

        //load images from sv
        loadImageOfSelfActivities($id){
            this.images = []
            this.formModal.n_images = 0 //old
            this.formModal.totalImages = 0
            this.formModal.currentImages = []
            this.formModal.newImages = []
            axios.get('/api/showImagesSelfActivity/'+$id)
            .then((data)=>{
                for(let item of data.data){
                    this.images.push(item.image)//old
                    this.formModal.n_images++//old
                    this.formModal.currentImages.push(item.image)
                    this.formModal.totalImages++
                }
                this.$forceUpdate()
            })
        },

        //get image from Form
        uploadImage(e){
            let file = e.target.files[0]
            let reader = new FileReader()
            reader.onloadend = (file) => {
                this.formModal.images.push(reader.result)//old
                this.formModal.image = reader.result//using
            }
            reader.readAsDataURL(file)
            this.displayBtnUpload = true
        },

        //move image to public file
        moveImage(){
            this.formModal.nowImage = this.formModal.image
            if(this.formModal.nowImage != this.formModal.preImage){
                this.formModal.put('/api/moveImage')
                .then((data)=>{
                    this.images.push(data.data.result)//old
                    this.formModal.n_images++//old
                    this.formModal.newImages.push(data.data.result)
                    this.formModal.currentImages.push(data.data.result)
                    this.formModal.preImage = this.formModal.image
                    this.formModal.totalImages++
                    this.displayBtnUpload = false
                    this.$forceUpdate()
                })
                .catch((error)=>{
                    console.log(error)
                })
            }else{
                console.log('the same image')
            }
        },

        //move image to recicle bin
        deleteImageClick(image,index){ 
            this.formModal.currentImages.splice(index,1)
            --this.formModal.totalImages
            this.deleteImages.push(image)
            this.$forceUpdate()

        },

        //delete images from server
        deleteImage(){
            if(this.deleteImages.length > 0){
                for(let image of this.deleteImages){
                    axios.delete('/api/deleteImagesSchoolActivity/'+ image)
                    .then((data)=>{
                        console.log(data.data.result)
                    })
                    .catch((errors)=>{
                        console.log('msg err')
                    })
                }
            }
        },

        //handle click button: manage acivites of student
        manageActivities(event){
            event.preventDefault();
        },

        //------------------------- set enabled or disabled for input with condition date and function user---------------
        checkDate(startDate, endDate){
            //Date: condition of date, allow enabled
            let newStartDate = new Date(startDate)
            let newEndDate = new Date(endDate)
            let currentDate = new Date()
            if(newStartDate.getTime() <= currentDate.getTime() && currentDate.getTime() <= newEndDate.getTime()){
                return 1
            }
            return 0
        },
        checkFunc( funcs, conFunc){
            //funcs: list functions of user
            //conFunc: condition of function
            for(let func of funcs){
                if(func == conFunc){
                    return 1
                }
            }
            return 0
        },
        checkFoD(colFunc){
            // check funtion and date together
            // column hold function
            // get condition date from database (include: startDate, endDate)
            // get func condition of user from database
            // get list funcs of user

            //example
            const listFunction = ['adm','cla']
            listFunction.push(this.student_info.role_id)
            console.log(listFunction)
            const startDate = '2019-04-22'
            const endDate = '2019-06-30' // ngay bat dau va ket thuc
            const conFunc = 'cla' //voi dieu kien la chuc nang class
            //end example

            const isRightDate = this.checkDate(startDate, endDate)
            const isRightFunction = this.checkFunc(listFunction, conFunc)
            //check date, check function of user and check col contain function of user
            if(isRightDate && isRightFunction && conFunc == colFunc){
                return true
            }
            return false
        },
        //-------------------------  end set enabled or disabled for input with condition date and function user---------------

        //------------------------- confirm ------------------------------------
        populateModal(index, typeActivity, typeConfirm){
            this.formModal.index = index
            this.formModal.typeActivity = typeActivity
            this.formModal.typeConfirm = typeConfirm
            this.$forceUpdate()
        },
        confirmScore(){
            this.deleteImage()
            this.totalScore()//tinh diem
            let index = this.formModal.index
            if(this.formModal.typeActivity == 'school'){
                let school = this.form.school_activities[index].pivot // info of school's activities
                for(let image of this.formModal.newImages){
                    axios.post('/api/storeImagesSchoolActivity/'+(index+1)+'/'+image)
                    .then((data)=> {
                        console.log(data)
                    })
                }
                if(this.formModal.typeConfirm == 'student'){
                    this.form.school_activities[index].pivot.confirmingStudent = true
                    axios.put('/api/updateSchoolsActivitiesScore/' + school.score_board_id + '/' + school.schools_activity_id ,{'field' : 'confirmingStudent', 'value' : school.confirmingStudent, 'average_score': school.average_score})
                    .then((data) => {
                        console.log(data.data.result)
                    })
                }else if(this.formModal.typeConfirm == 'class'){
                    this.form.school_activities[index].pivot.confirmingClass = true
                    axios.put('/api/updateSchoolsActivitiesScore/' + school.score_board_id + '/' + school.schools_activity_id ,{'field' : 'confirmingClass', 'value' : school.confirmingClass, 'average_score': school.average_score})
                    .then((data) => {
                        console.log(data.data.result)
                    })
                }else if(this.formModal.typeConfirm == 'faculty'){
                    this.form.school_activities[index].pivot.confirmingFaculty = true
                    axios.put('/api/updateSchoolsActivitiesScore/' + school.score_board_id + '/' + school.schools_activity_id ,{'field' : 'confirmingFaculty', 'value' : school.confirmingFaculty, 'average_score': school.average_score})
                    .then((data) => {
                        console.log(data.data.result)
                    })
                }else{
                    this.form.school_activities[index].pivot.confirmingSchool = true
                    axios.put('/api/updateSchoolsActivitiesScore/' + school.score_board_id + '/' + school.schools_activity_id ,{'field' : 'confirmingSchool', 'value' : school.confirmingSchool, 'average_score': school.average_score})
                    .then((data) => {
                        console.log(data.data.result)
                    })
                }
            }else{
                for(let image of this.formModal.newImages){
                    axios.post('/api/storeImagesSelfActivity/'+(index+1)+'/'+image)
                    .then((data)=> {
                        console.log(data)
                    })
                }    
                let self = this.form.self_activities[index].pivot // info of this student activities
                if(this.formModal.typeConfirm == 'student'){
                    this.form.self_activities[index].pivot.confirmingStudent = true
                    axios.put('/api/updateSelfActivitiesScore/' + self.score_board_id + '/' + self.self_activity_id ,{'field' : 'confirmingStudent', 'value' : self.confirmingStudent,'content' : self.activity_content, 'average_score' : self.average_score})
                    .then((data) => {
                        console.log(data.data.result)
                    })
                }else if(this.formModal.typeConfirm == 'class'){
                    this.form.self_activities[index].pivot.confirmingClass = true
                    axios.put('/api/updateSelfActivitiesScore/' + self.score_board_id + '/' + self.self_activity_id ,{'field' : 'confirmingClass', 'value' : self.confirmingClass,'content' : self.activity_content, 'average_score' : self.average_score})
                    .then((data) => {
                        console.log(data.data.result)
                    })
                }else if(this.formModal.typeConfirm == 'faculty'){
                    this.form.self_activities[index].pivot.confirmingFaculty = true
                    axios.put('/api/updateSelfActivitiesScore/' + self.score_board_id + '/' + self.self_activity_id ,{'field' : 'confirmingFaculty', 'value' : self.confirmingFaculty,'content' : self.activity_content, 'average_score' : self.average_score})
                    .then((data) => {
                        console.log(data.data.result)
                    })
                }else{
                    this.form.self_activities[index].pivot.confirmingSchool = true
                    axios.put('/api/updateSelfActivitiesScore/' + self.score_board_id + '/' + self.self_activity_id ,{'field' : 'confirmingSchool', 'value' : self.confirmingSchool,'content' : self.activity_content, 'average_score' : self.average_score})
                    .then((data) => {
                        console.log(data.data.result)
                    })
                }
            }
            this.$forceUpdate()
            $('#manage-activities-modal').modal('hide')
        },

        //------------------------ end confirm ---------------------------------

        //------------------------ submit form ---------------------------------
        submitForm(){
            let totalScore = this.caculateTotalScore()
            let currentRole = [0,0,1,0] //use function
            let score_board_id = this.form.school_activities[0].pivot.score_board_id
            axios.put('/api/score_board/' + score_board_id,{
                'averageScore':totalScore, 
                'confirmingStudent':currentRole[0],
                'confirmingClass':currentRole[1],
                'confirmingFaculty':currentRole[2],
                'confirmingSchool':currentRole[3]
                })
            .then((data) => {
                if(data.data.result) {
                    toast({
                        type: 'success',
                        title: data.data.result
                    });
                }
            })
            
        },
        caculateTotalScore(){
            let totalScore = 0
            for(let score of this.form.school_activities){
                totalScore += score.pivot.average_score
            }
            for(let score of this.form.self_activities){
                totalScore += score.pivot.average_score
            }
            return totalScore
        },

        
        //======================================================================
    },
}
</script>
<style scoped>
tr td{
    vertical-align: middle;
}
select{
    padding: .375rem 0 .375rem .5rem;
}
.form-control{
    width: -webkit-fill-available;
}

.delete-image {
    border-radius: 50%;
    position: absolute;
    right:5px;
    top:5px;
}

.carousel-control-prev,
.carousel-control-next {
    top:30px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
  height: 50px;
  width: 100px;
  outline: black;
  background-size: 90%, 90%;
  border-radius: 50%;
  background-image: none;
}
.carousel-control-next-icon:after
{
  content: '>';
  font-size: 55px;
  color: black;
}

.carousel-control-prev-icon:after {
  content: '<';
  font-size: 55px;
  color: black;
}
</style>
