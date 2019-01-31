<template>
<div>
    <div class="wrap-table" v-if="$gate.isAdmin()">
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
                <a href="#" class="btn btn-success mb-2" @click="newModal"><i class="fas fa-plus-circle"></i> Thêm khoa</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:10px"></th>
                        <th class="text-center" style="width:10px">STT</th>
                        <th class="width-100">MÃ Khoa</th>
                        <th class="width-200">Tên Khoa</th>
                        <th>Note</th>
                        <th class="text-center" colspan="2">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(faculty, index) in faculties" :key="faculty.id">
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center">{{ index + 1 }}</td>
                        <td>{{ faculty.id | upText}}</td>
                        <td>{{ faculty.name }}</td>
                        <td>{{ faculty.note }}</td>
                        <td class="text-center">
                            <a href="#" class="text-primary" @click="editModal(faculty)"><i class="fas fa-user-edit"></i></a>
                        </td>
                        <td class="text-center">
                            <a href="#" class="text-danger" @click="deleteFaculty(faculty.id)"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalFacultyAdmin" tabindex="-1" role="dialog"
        data-backdrop="static" data-keyboard="false"
        aria-label="modalFacultyAdmin" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 v-show="!editMode" class="modal-title">Tạo mới</h4>
                        <h4 v-show="editMode" class="modal-title">Sửa khoa</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form @submit.prevent="editMode ? updateFaculty() : createFaculty()">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.id" type="text" name="id" placeholder="Mã khoa"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('id') }">
                                <has-error :form="form" field="id"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="Tên khoa"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.note" type="text" name="note" placeholder="Note"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('note') }">
                                <has-error :form="form" field="note"></has-error>
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

    <div class="mb-5" v-else>
        <not-found></not-found>
    </div>
</div>

</template>

<script>
export default {
    data() {
        return {
            editMode: true,
            faculties: {},
            form: new Form({
                idToUpdate: '',
                id: '',
                name: '',
                note: '',
            }),
        }
    },
    methods: {
        loadFaculties(){
            this.$Progress.start();
            if(this.$gate.isAdmin()){
                axios.get('api/faculty_admin').then(({data}) => (this.faculties = data.data));
            }
            this.$Progress.finish();
        },
        createFaculty(){
            this.$Progress.start();
            this.form.post('api/faculty_admin')
            .then(() => {
                //set event to reload faculties
                Fire.$emit('ReloadFaculty');
                $('#modalFacultyAdmin').modal('hide');
                toast({
                    type: 'success',
                    title: 'Tạo khoa thành công'
                });
            })
            .catch(() => {
                Swal('Failed!', 'Đã có lỗi xảy ra!', 'warning');
            });
            this.$Progress.finish();
        },
        deleteFaculty(faculty_id){
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
                    this.form.delete('api/faculty_admin/' + faculty_id)
                    .then(() => {
                        //set event to reload faculties
                        Fire.$emit('ReloadFaculty');
                        if (result.value) {
                            Swal('Đã xóa!', 'Đã xóa khoa thành công.', 'success');
                        }
                    })
                    .catch(() => {
                        Swal('Failed!', 'Đã có lỗi xảy ra!', 'warning');
                    });
                }
            })
        },
        updateFaculty(){
            this.$Progress.start();
            this.form.put('api/faculty_admin/' + this.form.idToUpdate)
            .then(() => {
                $('#modalFacultyAdmin').modal('hide');
                toast({
                    type: 'success',
                    title: 'Sửa khoa thành công'
                });
                //set event to reload faculties
                Fire.$emit('ReloadFaculty');
                this.$Progress.finish();
            })
            .catch(() => {
                this.$Progress.fail();
            });
        },
        newModal(){
            this.editMode = false;
            this.form.reset();
            $('#modalFacultyAdmin').modal('show');
        },
        editModal(faculty){
            this.editMode = true;
            this.form.reset();
            $('#modalFacultyAdmin').modal('show');
            this.form.fill(faculty);
            this.form.idToUpdate = faculty.id;
        }
    },
    created() {
        this.loadFaculties();
        Fire.$on('ReloadFaculty', ()=>{
            this.loadFaculties();
        });
        // setInterval(() => this.loadFaculties(), 3000);
    },
}
</script>
