<template>
    <div class="wrap-table">
        <div class="row">
            <div class="col-md-3 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-info text-white">Lọc</span>
                    </div>
                    <select name="state" id="maxRows" class="form-control">
                        <option value="10">10</option>
                        <option value="0" selected>Tất cả</option>
                    </select>
                </div>
            </div>
            <div class="col-md-9 mb-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-info text-white">Tìm kiếm</span>
                    </div>
                    <input type="text" class="form-control" id="table-search" />
                </div>
            </div>
            <div class="col-sm-3 mb-2">
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" id="select-all">Chọn hết</button>
                    <button type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
            <div class="col-sm-9 mb-2">
                <a href="#" class="btn btn-success mb-2" @click="newModal"><i class="fas fa-plus-circle"></i> Thêm Lớp</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:10px"></th>
                        <th class="text-center" style="width:10px">STT</th>
                        <th class="width">Lớp</th>
                        <th class="width">Khoa</th>
                        <th class="text-center" colspan="2">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(classroom, index) in classrooms" :key="classroom.id">
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center">{{ index + 1 }}</td>
                        <td>{{ classroom.id | upText}}</td>
                        <td>{{ classroom.faculty.name }} <span v-if="classroom.faculty.note !== null">/ {{ classroom.faculty.note }}</span></td>
                        <td class="text-center">
                            <a href="#" class="text-primary" @click="editModal(classroom)"><i class="fas fa-user-edit"></i></a>
                        </td>
                        <td class="text-center">
                            <a href="#" class="text-danger" @click="deleteClassRoom(classroom.id)"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalClassRoomAdmin" tabindex="-1" role="dialog"
        data-backdrop="static" data-keyboard="false"
        aria-label="modalClassRoomAdmin" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 v-show="!editMode" class="modal-title">Tạo mới</h4>
                        <h4 v-show="editMode" class="modal-title">Sửa lớp</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form @submit.prevent="editMode ? updateClassRoom() : createClassRoom()">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.id" type="text" name="id" placeholder="Tên lớp"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('id') }">
                                <has-error :form="form" field="id"></has-error>
                            </div>
                            <div class="form-group">
                                <select name="faculty_id" v-model="form.faculty_id" id="faculty_id" class="form-control" :class="{'is-invalid': form.errors.has('faculty_id')}">
                                    <option value="" disabled>=== Chọn Khoa / Viện ===</option>
                                    <option v-for="(faculty, index) in faculties" :key="index" :value="faculty.id">{{ faculty.name }} <span v-if="faculty.note !== null">/ {{ faculty.note }}</span></option>
                                </select>
                                <has-error :form="form" field="faculty_id"></has-error>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button v-show="!editMode" type="submit" class="btn btn-primary">Tạo</button>
                            <button v-show="editMode" type="submit" class="btn btn-success">Sửa</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    </div>
</template>
<script>
export default {
    data() {
        return {
            editMode: true,
            classrooms: {},
            faculties: {},
            form: new Form({
                idToUpdate: '',
                id: '',
                faculty_id: '',
            })
        }
    },
    methods: {
        loadClassrooms(){
            this.$Progress.start();
            axios.get('api/classroom_admin').then(({data}) => (this.classrooms = data.data));
            axios.get('api/faculty_admin').then(({data}) => (this.faculties = data.data));
            this.$Progress.finish();
        },
        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#modalClassRoomAdmin').modal('show');
        },
        editModal(classroom){
            this.editMode = true;
            this.form.reset();
            $('#modalClassRoomAdmin').modal('show');
            this.form.fill(classroom);
            this.form.idToUpdate = classroom.id;
        },
        createClassRoom(){
            this.$Progress.start();
            this.form.post('api/classroom_admin')
            .then(() => {
                //set event to reload faculties
                Fire.$emit('ReloadClassRoom');
                $('#modalClassRoomAdmin').modal('hide');
                toast({
                    type: 'success',
                    title: 'Tạo lớp thành công'
                });
            })
            .catch(() => {
                Swal('Failed!', 'Đã có lỗi xảy ra!', 'warning');
            });
            this.$Progress.finish();
        },
        deleteClassRoom(classroom_id){
            Swal({
                title: 'Bạn có chắc chắn muốn xóa?',
                text: "Bạn sẽ không thể hoàn lại dữ liệu này!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa!'
            }).then((result) => {
                if(result.value){
                    //send request to server
                    this.form.delete('api/classroom_admin/' + classroom_id)
                    .then(() => {
                        //set event to reload faculties
                        Fire.$emit('ReloadClassRoom');
                        if (result.value) {
                            Swal(
                            'Đã xóa!',
                            'Đã xóa lớp thành công.',
                            'success'
                            )
                        }
                    })
                    .catch(() => {
                        Swal('Failed!', 'Đã có lỗi xảy ra!', 'warning');
                    });
                }
            })
        },
        updateClassRoom(){
            this.$Progress.start();
            this.form.put('api/classroom_admin/' + this.form.idToUpdate)
            .then(() => {
                $('#modalClassRoomAdmin').modal('hide');
                toast({
                    type: 'success',
                    title: 'Sửa lớp thành công'
                });
                //set event to reload faculties
                Fire.$emit('ReloadClassRoom');
                this.$Progress.finish();
            })
            .catch(() => {
                this.$Progress.fail();
            });
        }
    },
    created(){
        this.loadClassrooms();
        Fire.$on('ReloadClassRoom', ()=>{
            this.loadClassrooms();
        });
    }

}
</script>