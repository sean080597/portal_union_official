<template>
    <div class="container">
        <div class="row">
            <div class="form-group col-lg-12">
                <label>Chọn vai trò cho đánh giá</label>
                <select class="form-control" v-model="form.role">
                    <option value="stu">Sinh viên</option>
                    <option value="cla" :disabled="!isShowedOption">Chi đoàn lớp</option>
                    <option value="fac" :disabled="!isShowedOption">Chi đoàn khoa</option>
                    <option value="sch" :disabled="!isShowedOption">Đoàn trường</option>
                </select>
            </div>
            <div class="form-group col-lg-6 col-md-12">
                <label>Chọn ngày bắt đầu</label>
                <input type="date" class="form-control" v-model="form.startDate" @change="validateStartDate(form.startDate)">
                <span class="text-danger" v-if="invalidStartYear">Vui lòng chọn năm hiện tại</span>
            </div>
            <div class="form-group col-lg-6 col-md-12">
                <label>Chọn ngày kết thúc</label>
                <input type="date" class="form-control" v-model="form.endDate" @change="validateEndDate(form.startDate,form.endDate)">
                <span class="text-danger" v-if="invalidEndYear">Vui lòng chọn năm hiện tại</span>
                <span class="text-danger" v-if="invalidEndDate">Vui lòng chọn ngày sau ngày bắt đầu</span>
            </div>
            <div class="form-group col-lg-12">
                <button class="btn btn-success" :disabled="hasErrors" @click="updateTempData()">Xác nhận</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <AllScoreBoard></AllScoreBoard>
            </div>
        </div>    
    </div>
</template>

<script>
    import AllScoreBoard from './CreateAllScoreBoard.vue'
    export default {
        components:{
            AllScoreBoard,
        },
        data(){
            return {
                errorList:{
                    startYear: false,
                    endYear: false,
                    endDate: false
                },
                form: new Form({
                    role:"",
                    startDate: "",
                    endDate: "",
                    currentYear: ""
                })
            }
        },
        computed: {
            //------------------------ validate select option --------------
            isShowedOption(){
                if(this.isUpdatedCurrentYear()){
                    return true
                }
                return false
            },
            //==============================================================
            //------------------------ validate date -----------------------
            invalidStartYear(){
                if(this.errorList.startYear){
                    return true
                }
                return false
            },
            invalidEndYear(){
                if(this.errorList.endYear){
                    return true
                }
                return false
            },
            invalidEndDate(){
                if(this.errorList.endDate){
                    return true
                }
                return false
            },
            hasErrors(){
                let disabled = true
                let totalError = 0
                const hasAnyFieldNull = this.hasAnyFieldNull()
                const errors = Object.entries(this.errorList)
                for(const [index,error] of errors){
                    if(error == true){
                        totalError++
                    }
                }
                
                if(totalError == 0 && !hasAnyFieldNull){
                    disabled = false
                }
                return disabled
            }
            //=============================================================
        },
        created() {
            this.loadTempData()
        },
        mounted() {
            
        },
        methods: {
            //------------------ load Data -------------------------
            loadTempData(){
                this.$Progress.start()
                axios.get('/api/temps')
                .then((data) => {
                    this.form.role = data.data[0].value
                    this.form.startDate = data.data[1].value
                    this.form.endDate = data.data[2].value
                    this.form.currentYear = data.data[3].value
                    this.$Progress.finish()
                })
            },
            //======================================================

            //------------------ update data -----------------------
            updateTempData(){
                this.$Progress.start()
                const currentDate = new Date()
                const currentYear = currentDate.getFullYear()
                axios.put('/api/temps/role',{'value':this.form.role})
                .then(() => {
                    axios.put('/api/temps/startDate',{'value':this.form.startDate})
                    .then(() => {
                        axios.put('/api/temps/endDate',{'value':this.form.endDate})
                        .then(() => {
                            axios.put('/api/temps/currentYear',{'value':currentYear})
                            .then((data) => {
                                toast({
                                    type: 'success',
                                    title: data.data.result
                                });
                                this.loadTempData()
                                this.$Progress.finish()
                            })
                        })
                    })    
                })
                
                
                
            
            },
            //======================================================

            //------------------ validate date ---------------------

            validateStartDate(selectedDate){
                const isCurrentYear = this.isCurrentYear(selectedDate)
                if(!isCurrentYear){
                    this.errorList.startYear = true
                }else{
                    this.errorList.startYear = false
                }
            },

            validateEndDate(startDate, endDate){
                const isCurrentYear = this.isCurrentYear(endDate)
                const isAfterStartDate = this.isAfterStartDate(startDate,endDate)
                
                if(!isCurrentYear){
                    this.errorList.endYear = true
                }else{
                    this.errorList.endYear = false
                }

                if(!isAfterStartDate){
                    this.errorList.endDate = true
                }else{
                    this.errorList.endDate = false
                }

            },

            isCurrentYear(selectedDate){
                const currentDate = new Date()
                const currentYear = currentDate.getFullYear()

                const selectDate = new Date(selectedDate)
                const selectYear = selectDate.getFullYear()

                if(currentYear == selectYear){
                    return true
                }
                return false
            },

            isAfterStartDate(startDate, endDate){
                if(startDate < endDate){
                    return true
                }
                return false
            },
            //======================================================

            //---------------- validate null -----------------------
            hasAnyFieldNull(){
                const isRoleNull = (this.form.role == "" || this.form.role == null)
                const isStartDateNull = (this.form.startDate == "" || this.form.startDate == null)
                const isEndDateNull = (this.form.endDate == "" || this.form.endDate == null)
                if(isRoleNull || isStartDateNull || isEndDateNull){
                    return true
                }
                return false
            },
            //======================================================

            //-------------------- validate select option ----------

            isUpdatedCurrentYear(){
                const currentDate = new Date()
                const currentYear = currentDate.getFullYear()
                if(this.form.currentYear == currentYear){
                    return true
                }
                return false
            }
            //======================================================
        },
    }
</script>