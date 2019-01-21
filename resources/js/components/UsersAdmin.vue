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
                <a href="#" class="btn btn-success mb-2" @click="newModal"><i class="fas fa-plus-circle"></i> Thêm TK</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="table">
                <thead class="thead-light">
                    <tr>
                        <th style="width:10px"></th>
                        <th class="text-center" style="width:10px">STT</th>
                        <th class="width-200">Tên</th>
                        <th class="width-200">Email</th>
                        <th>Vai trò</th>
                        <th>Cập nhật</th>
                        <th class="text-center" colspan="2">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="index">
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center">{{ index + 1 }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role.name }}</td>
                        <td>{{ user.updated_at | myDateTimeFormat }}</td>
                        <td class="text-center"><a href="#" class="text-primary" @click="editModal(user)">
                            <i class="fas fa-user-edit"></i></a>
                        </td>
                        <td class="text-center"><a href="#" class="text-danger" @click="deleteUser(user.id)">
                            <i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalUserAdmin" tabindex="-1" role="dialog"
        data-backdrop="static" data-keyboard="false"
        aria-label="modalUserAdmin" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 v-show="!editMode" class="modal-title">Tạo mới</h4>
                        <h4 v-show="editMode" class="modal-title">Sửa TK</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser() : createUser()">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="Tên TK" class="form-control"
                                v-validate="'required|max:50'" :class="{ 'is-invalid': errors.has('name') }">
                                <div v-show="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
                            </div>
                            <div class="form-group">
                                <input v-model="form.email" type="text" name="email" placeholder="Email" class="form-control"
                                v-validate="'required|email'" :class="{ 'is-invalid': errors.has('email') || form.errors.has('email')}">
                                <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" placeholder="Password" class="form-control"
                                v-validate="{ required: !editMode, min: 6 }" :class="{ 'is-invalid': errors.has('password') }" />
                                <div v-show="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>
                            </div>
                            <div class="form-group">
                                <select name="role_id" v-model="form.role_id" id="role_id" class="form-control" @change="onChangeSel()"
                                :class="{ 'is-invalid': !selected }">
                                    <option value="" disabled>=== Chọn vai trò ===</option>
                                    <option v-for="(u_type, index) in user_types" :key="index" :value="u_type.id">{{ u_type.name }}</option>
                                </select>
                                <div v-show="!selected" class="invalid-feedback">Hãy chọn vai trò</div>
                            </div>
                            <div class="form-group" v-show="isCreatedStudent && !editMode">
                                <hr><h5>Thông tin đoàn viên</h5>
                                <input v-model="form.student_id" type="number" name="student_id" placeholder="MSSV" class="form-control"
                                v-validate="{ required: isCreatedStudent, regex: /^([0-9]{10})$/ }"
                                :class="{ 'is-invalid': errors.has('student_id') || form.errors.has('student_id') }">
                                <div v-show="errors.has('student_id')" class="invalid-feedback">{{ errors.first('student_id') }}</div>
                                <has-error :form="form" field="student_id"></has-error>
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
            users: {},
            user_types: {},
            form: new Form({
                id: '',
                name: '',
                email: '',
                password: '',
                role_id: '',
                student_id: '',
            }),
            isCreatedStudent: false,
            selected: false,
            submitted: false,
        }
    },
    methods: {
        loadUsers(){
            this.$Progress.start();
            axios.get('api/user_admin').then(({data}) => (this.users = data.data));
            this.$Progress.set(80);
        },
        loadUserTypes(){
            axios.get('api/indexWithoutSchoolLeaderAccs').then(({data}) => (this.user_types = data));
            this.$Progress.finish();
        },
        newModal(){
            this.selected = false;
            this.editMode = false;
            this.form.reset();
            $('#modalUserAdmin').modal('show');
        },
        editModal(user){
            this.editMode = true;
            this.form.reset();
            $('#modalUserAdmin').modal('show');
            this.form.fill(user);
            this.form.id = user.id;
            this.selected = true;
        },
        createUser(){
            this.$Progress.start();
            //check if all field is valid in vee-validate
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.form.post('api/user_admin')
                    .then(response => {
                        if(response.data.isSuccess){
                            //set event to reload users
                            Fire.$emit('ReloadUser');
                            $('#modalUserAdmin').modal('hide');
                            toast({
                                type: 'success',
                                title: 'Tạo TK thành công'
                            });
                        }
                    })
                    .catch(() => {
                        //do sth with error
                    });
                }
                if(!result){
                    //do sth with error
                }
            });
            this.$Progress.finish();
        },
        onChangeSel(){
            this.isCreatedStudent = this.form.role_id != 'adm' && this.form.role_id != 'sch';
            this.selected = true;
        },
        deleteUser(user_id){
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
                    this.form.delete('api/user_admin/' + user_id)
                    .then(() => {
                        //set event to reload users
                        Fire.$emit('ReloadUser');
                        if (result.value) {
                            Swal('Đã xóa!', 'Đã xóa user thành công.', 'success');
                        }
                    })
                    .catch(() => {
                        Swal('Failed!', 'Đã có lỗi xảy ra!', 'warning');
                    });
                }
            })
        },
        updateUser(){
            this.$Progress.start();
            this.form.put('api/user_admin/' + this.form.id)
            .then(() => {
                $('#modalUserAdmin').modal('hide');
                toast({
                    type: 'success',
                    title: 'Sửa user thành công'
                });
                //set event to reload users
                Fire.$emit('ReloadUser');
                this.$Progress.finish();
            })
            .catch(() => {
                this.$Progress.fail();
            });
        }
    },
    created(){
        this.loadUsers();
        this.loadUserTypes();
        Fire.$on('ReloadUser', ()=>{
            this.loadUsers();
        });
    }
}
</script>