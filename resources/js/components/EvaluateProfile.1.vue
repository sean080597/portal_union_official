<template>
<div>
    <div class="wrap-table" v-if="checkToShow">
        <div class="note-info">
            <div class="row">
                <div class="col-sm-6"><p><span>Tên: </span>{{ student_info.name }}</p></div>
                <div class="col-sm-6"><p><span>MSSV: </span>{{ student_info.mssv }}</p></div>
                <div class="col-sm-6"><p><span>Chi đoàn: </span>{{ student_info.class_room_id }}</p></div>
                <div class="col-sm-6"><p><span>Khoa: </span>{{ student_info.faculty_name }}</p></div>
            </div>
        </div>
        <div class="note-warning">
            <div class="row">
                <div class="col-sm"><p><span>ĐV: </span>Đoàn viên</p></div>
                <div class="col-sm"><p><span>CĐ: </span>Bí thư chi đoàn</p></div>
                <div class="col-sm"><p><span>Khoa: </span>Bí thư đoàn khoa</p></div>
                <div class="col-sm"><p><span>Trường: </span>Bí thư đoàn trường</p></div>
            </div>
        </div>
        <form @submit.prevent="submitEvaluation">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" style="min-width:60%" class="text-center">Nội dung</th>
                            <th rowspan="2" style="width:140px" class="text-center">ĐV tự dánh giá</th>
                            <th colspan="4" class="text-center">Đánh Giá</th>
                        </tr>
                        <tr>
                            <th class="text-center">ĐV</th>
                            <th class="text-center">CĐ</th>
                            <th class="text-center">Khoa</th>
                            <th class="text-center">Trường</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" style="font-weight:700"><span>I. </span> Nội dung đoàn viên đăng ký thực hiện theo yêu cầu chung của đoàn trường<span> (Tối đa: 70đ)</span></td>
                        </tr>
                        <tr v-for="(cri_man, index) in getListCriMan" :key="'cri_man'+index" >
                            <td>
                                <span>{{ index+1 }}. </span>
                                <span>{{ cri_man.content }}</span>
                                <div
                                    v-show="errors.has('errorCriMan'+(index+1))" 
                                    class="text-danger"
                                >
                                    Vui lòng nhập điểm (Từ 0 đến 10)
                                </div>
                            </td>
                            <td class="text-center p-1">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    style="max-width:150px" 
                                    v-model="form.cri_man.self_assessment[index]"
                                    disabled>
                            </td>
                            <td class="text-center p-1">
                                <input
                                    type="number"  style="max-width:50px" :name="'errorCriMan'+(index+1)"
                                    class="form-control p-0 text-center"
                                    v-validate="'required|between:0,10'"
                                    v-model="form.cri_man.mark_student[index]"
                                    @change="criManSelfAssessment(form.cri_man.mark_student[index], index)"
                                    :disabled="isDisabledStudent"
                                >
                            </td>
                            <td class="text-center">
                                <input
                                    type="number"  style="max-width:50px" :name="'errorCriMan'+(index+1)"
                                    class="form-control p-0 text-center"
                                    v-validate="'required|between:0,10'"
                                    v-model="form.cri_man.mark_classroom[index]"
                                    @change="criManSelfAssessment(form.cri_man.mark_classroom[index], index)"
                                    :disabled="isDisabledClass"
                                >
                            </td>
                            <td class="text-center">
                                <input
                                    type="number"  style="max-width:50px" :name="'errorCriMan'+(index+1)"
                                    class="form-control p-0 text-center"
                                    v-validate="'required|between:0,10'"
                                    v-model="form.cri_man.mark_faculty[index]"
                                    @change="criManSelfAssessment(form.cri_man.mark_faculty[index], index)"
                                    :disabled="isDisabledFaculty"
                                >
                            </td>
                            <td class="text-center">
                                <input
                                    type="number"  style="max-width:50px" :name="'errorCriMan'+(index+1)"
                                    class="form-control p-0 text-center"
                                    v-validate="'required|between:0,10'"
                                    v-model="form.cri_man.mark_school[index]"
                                    @change="criManSelfAssessment(form.cri_man.mark_school[index], index)"
                                    :disabled="isDisabledSchool"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="font-weight:700"><span>II. </span> Nội dung đoàn viên tự đăng ký thực hiên<span> (Tối đa: 30đ)</span></td>
                        </tr>
                        <tr v-for="(cri_self, index) in getListCriSel" :key="'cri_self'+index">
                            <td class="p-1">
                                <span style="margin: 5px;">
                                    {{ index+1 }}. {{ cri_self.content }}
                                </span>
                                <div
                                    v-show="errors.has('errorCriSef'+(index+1))" 
                                    class="text-danger"
                                >
                                    Vui lòng nhập điểm (Từ 0 đến 10)
                                </div>
                                <textarea 
                                    class="form-control" rows="3" :name="'criself_'+cri_self.id"
                                    v-validate="'required'" :class="{'textarea': true, 'is-invalid': errors.has('criself_'+cri_self.id) }"
                                    v-model="form.cri_self.content_regis[index]"
                                    :disabled="isDisabledStudent"
                                ></textarea>
                                <div v-show="errors.has('criself_'+cri_self.id)" class="invalid-feedback">Không được để trống</div>
                            </td>
                            <td class="text-center p-1">
                                <input type="text" class="form-control" style="max-width:150px" v-model="form.cri_self.self_assessment[index]" disabled>
                            </td>
                            <td class="text-center p-1">
                                <input
                                    type="number"  style="max-width:50px" :name="'errorCriSef'+(index+1)"
                                    class="form-control p-0 text-center"
                                    v-validate="'required|between:0,10'"
                                    v-model="form.cri_self.mark_student[index]"
                                    @change="criSelfSelfAssessment(form.cri_self.mark_student[index], index)"
                                    :disabled="isDisabledStudent"
                                >
                            </td>
                            <td class="text-center">
                                <input
                                    type="number"  style="max-width:50px" :name="'errorCriSef'+(index+1)"
                                    class="form-control p-0 text-center"
                                    v-validate="'required|between:0,10'"
                                    v-model="form.cri_self.mark_classroom[index]"
                                    @change="criSelfSelfAssessment(form.cri_self.mark_classroom[index], index)"
                                    :disabled="isDisabledClass"
                                >
                            </td>
                            <td class="text-center">
                                <input
                                    type="number"  style="max-width:50px" :name="'errorCriSef'+(index+1)"
                                    class="form-control p-0 text-center"
                                    v-validate="'required|between:0,10'"
                                    v-model="form.cri_self.mark_faculty[index]"
                                    @change="criSelfSelfAssessment(form.cri_self.mark_faculty[index], index)"
                                    :disabled="isDisabledFaculty"
                                >
                            </td>
                            <td class="text-center">
                                <input
                                    type="number"  style="max-width:50px" :name="'errorCriSef'+(index+1)"
                                    class="form-control p-0 text-center"
                                    v-validate="'required|between:0,10'"
                                    v-model="form.cri_self.mark_school[index]"
                                    @change="onChangeAssessment(form.cri_self.mark_school[index], index)"
                                    :disabled="isDisabledSchool"
                                >
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
</div>
</template>
<script>
export default {
    data() {
        return {
            student_info: {},
            checkToShow: false,
            form: new Form({
                student_id: this.$route.params.student_id,
                checkArray: [],
                cri_man:{
                    criteria_id: [],
                    self_assessment: [],
                    mark_student: [],
                    mark_classroom: [],
                    mark_faculty: [],
                    mark_school: []
                },
                cri_self:{
                    criteria_id: [],
                    content_regis: [],
                    self_assessment: [],
                    mark_student: [],
                    mark_classroom: [],
                    mark_faculty: [],
                    mark_school: []
                }
            }),
        }
    },
    computed: {
        getListCriMan(){
            return this.$store.getters.getMarkCriMan
        },
        getListCriSel(){
            return this.$store.getters.getMarkCriSel
        },
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
        }
    },
    created() {
        this.loadListCriteria()
        
    },
    mounted() {
        this.$store.dispatch('fetch_criteria')
    },
    methods: {
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
            const listFunction = []
            listFunction.push(this.student_info.role_id)
            console.log(listFunction)
            const startDate = '2019-04-22'
            const endDate = '2019-04-30'
            const conFunc = 'cla'
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
        
        //-------------------------  set self assessment -------------------------------
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

        criManSelfAssessment(mark, index){
            this.form.cri_man.self_assessment[index] = this.avgMark(mark)
            this.$forceUpdate()
        },

        criSelfSelfAssessment(mark, index){
            this.form.cri_self.self_assessment[index] = this.avgMark(mark)
            this.$forceUpdate()
        },
        //-------------------------  end set self assessment ---------------------------
        loadListCriteria(){
            this.$Progress.start();
            axios.get('/api/getUserStudentInfoByStuId/' + this.form.student_id).then(({data}) => (
                this.student_info = data[0],
                this.form.checkArray = this.$gate.isValidToShowMarks(data[0].class_room_id),
                this.checkToShow = this.$gate.isStudentProfilePagePassed(data[0].class_room_id)
            )).then(()=>{
                if(this.checkToShow){
                    axios.get('/api/getMarkCriMan/' + this.form.student_id).then(({data}) => (
                        data.forEach(e => {
                            this.form.cri_man.criteria_id.push(e.criteria_id),
                            this.form.cri_man.self_assessment.push(e.self_assessment),
                            this.form.cri_man.mark_student.push(e.mark_student),
                            this.form.cri_man.mark_classroom.push(e.mark_classroom),
                            this.form.cri_man.mark_faculty.push(e.mark_faculty),
                            this.form.cri_man.mark_school.push(e.mark_school)
                            this.a = 1
                        })
                    ));
                    axios.get('/api/getMarkCriSel/' + this.form.student_id).then(({data}) => (
                        data.forEach(e => {
                            this.form.cri_self.criteria_id.push(e.criteria_id),
                            this.form.cri_self.content_regis.push(e.content_regis),
                            this.form.cri_self.self_assessment.push(e.self_assessment),
                            this.form.cri_self.mark_student.push(e.mark_student),
                            this.form.cri_self.mark_classroom.push(e.mark_classroom),
                            this.form.cri_self.mark_faculty.push(e.mark_faculty),
                            this.form.cri_self.mark_school.push(e.mark_school),
                            this.$Progress.finish()
                        })
                    ));
                }else{
                    this.$Progress.fail()
                }
            });
        },
        submitEvaluation(){
            this.$Progress.start();
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.form.post('/api/submitEvaluation')
                    .then(response => {
                        if(response.data.success) {
                            toast({
                                type: 'success',
                                title: 'Đánh giá thành công'
                            });
                            this.$Progress.finish();
                        }
                    })
                    .catch(() => {
                        this.$Progress.fail();
                        Swal('Failed!', 'Đã có lỗi xảy ra!', 'warning');
                    });
                }else{
                    this.$Progress.fail();
                    toast({
                        type: 'error',
                        title: 'Có lỗi trong quá trình nhập'
                    })
                }
            });
        }
    }
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
</style>
