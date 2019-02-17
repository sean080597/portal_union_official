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
                        <tr v-for="(cri_man, index) in getListCriMan" :key="'cri_man'+index">
                            <td><span>{{ index+1 }}. </span>{{ cri_man.content }}</td>
                            <td class="text-center p-1">
                                <select :name="'cri_man_selfassess_'+cri_man.id" :id="'cri_man_selfassess_'+cri_man.id" class="form-control"
                                :disabled="checkArray[0]" v-model="form.cri_man.self_assessment[index]">
                                    <option value="" disabled>- Chọn ĐG -</option>
                                    <option v-for="(self_assess, index) in opts_selfassess"
                                    :key="index" :value="self_assess.k"
                                    >{{ self_assess.v }}</option>
                                </select>
                            </td>
                            <td class="text-center p-1">
                                <select :name="'cri_man_markstu_'+cri_man.id" :id="'cri_man_markstu_'+cri_man.id" class="form-control"
                                :disabled="checkArray[0]" v-model="form.cri_man.mark_student[index]">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    >{{ mark }}</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <select :name="'cri_man_markcla_'+cri_man.id" :id="'cri_man_markcla_'+cri_man.id" class="form-control"
                                :disabled="checkArray[1]" v-model="form.cri_man.mark_classroom[index]">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    >{{ mark }}</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <select :name="'cri_man_markfac_'+cri_man.id" :id="'cri_man_markfac_'+cri_man.id" class="form-control"
                                :disabled="checkArray[2]" v-model="form.cri_man.mark_faculty[index]">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    >{{ mark }}</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <select :name="'cri_man_marksch_'+cri_man.id" :id="'cri_man_marksch_'+cri_man.id" class="form-control"
                                :disabled="checkArray[3]" v-model="form.cri_man.mark_school[index]">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    >{{ mark }}</option>
                                </select>
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
                                <textarea class="form-control" rows="3" :name="'cri_self_content_'+cri_self.id" :id="'cri_self_content_'+cri_self.id"
                                v-model="form.cri_self.content_regis[index]" :disabled="checkArray[0]"></textarea>
                            </td>
                            <td class="text-center p-1">
                                <!-- <input type="text" class="form-control"> -->
                                <select :name="'cri_self_selfassess_'+cri_self.id" :id="'cri_self_selfassess_'+cri_self.id" class="form-control"
                                :disabled="checkArray[0]" v-model="form.cri_self.self_assessment[index]">
                                    <option value="" disabled>- Chọn ĐG -</option>
                                    <option v-for="(self_assess, index) in opts_selfassess"
                                    :key="index" :value="self_assess.k"
                                    >{{ self_assess.v }}</option>
                                </select>
                            </td>
                            <td class="text-center p-1">
                                <select :name="'cri_self_markstu_'+cri_self.id" :id="'cri_self_markstu_'+cri_self.id" class="form-control"
                                :disabled="checkArray[0]" v-model="form.cri_self.mark_student[index]">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    >{{ mark }}</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <select :name="'cri_self_markcla_'+cri_self.id" :id="'cri_self_markcla_'+cri_self.id" class="form-control"
                                :disabled="checkArray[1]" v-model="form.cri_self.mark_classroom[index]">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    >{{ mark }}</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <select :name="'cri_self_markfac_'+cri_self.id" :id="'cri_self_markfac_'+cri_self.id" class="form-control"
                                :disabled="checkArray[2]" v-model="form.cri_self.mark_faculty[index]">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    >{{ mark }}</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <select :name="'cri_self_marksch_'+cri_self.id" :id="'cri_self_marksch_'+cri_self.id" class="form-control"
                                :disabled="checkArray[3]" v-model="form.cri_self.mark_school[index]">
                                    <option v-for="(mark, index) in opts_mark"
                                    :key="index" :value="mark"
                                    >{{ mark }}</option>
                                </select>
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
            // student_id: this.$route.params.student_id,
            student_info: {},
            opts_selfassess: [
                { k: 'tb', v: 'Trung bình' },
                { k: 'k', v: 'Khá' },
                { k: 't', v: 'Tốt' }
            ],
            opts_mark: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            checkArray: [],
            checkToShow: false,
            form: new Form({
                student_id: this.$route.params.student_id,
                cri_man:{
                    self_assessment: [],
                    mark_student: [],
                    mark_classroom: [],
                    mark_faculty: [],
                    mark_school: []
                },
                cri_self:{
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
    methods: {
        loadListCriteria(){
            this.$Progress.start();
            axios.get('/api/getUserStudentInfoByStuId/' + this.form.student_id).then(({data}) => (
                this.student_info = data[0],
                this.checkArray = this.$gate.isValidToShowMarks(data[0].class_room_id),
                this.checkToShow = this.$gate.isStudentProfilePagePassed(data[0].class_room_id)
            )).then(()=>{
                if(this.checkToShow){
                    axios.get('/api/getMarkCriMan/' + this.form.student_id).then(({data}) => (
                        data.forEach(e => {
                            this.form.cri_man.self_assessment.push(e.self_assessment),
                            this.form.cri_man.mark_student.push(e.mark_student),
                            this.form.cri_man.mark_classroom.push(e.mark_classroom),
                            this.form.cri_man.mark_faculty.push(e.mark_faculty),
                            this.form.cri_man.mark_school.push(e.mark_school)
                        })
                    ));
                    axios.get('/api/getMarkCriSel/' + this.form.student_id).then(({data}) => (
                        data.forEach(e => {
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
            this.form.post('/api/submitEvaluation')
            .then(() => {
                
            })
            .catch(() => {
                Swal('Failed!', 'Đã có lỗi xảy ra!', 'warning');
            });
            this.$Progress.finish();
        }
    },
    created() {
        this.loadListCriteria();
    },
    mounted() {
        this.$store.dispatch('fetch_criteria');
    },
    computed: {
        getListCriMan(){
            return this.$store.getters.getMarkCriMan
        },
        getListCriSel(){
            return this.$store.getters.getMarkCriSel
        },
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
