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
                <a href="#" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalFacultyAdmin"><i class="fas fa-plus-circle"></i> Thêm khoa</a>
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
                    <tr>
                        <td class="text-center"><input type="checkbox"></td>
                        <td class="text-center">1</td>
                        <td>DTDT</td>
                        <td>Du Lịch</td>
                        <td>DT</td>
                        <td class="text-center"><a href="#" class="text-primary" data-toggle="modal" data-target="#modalFacultyAdmin"><i class="fas fa-user-edit"></i></a></td>
                        <td class="text-center"><a href="#" class="text-danger"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalFacultyAdmin" tabindex="-1" role="dialog"
        aria-label="modalFacultyAdmin" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <form action="">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Tạo mới</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="fac-id">Mã Khoa</label>
                                <input type="text" id="fac-id" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Tên Khoa</label>
                                <input type="text" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="note">Note</label>
                                <input type="text" id="note" class="form-control">
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" data-dismiss="modal">Lưu</button>
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
    mounted(){
        console.log('Faculty Mounted');
    }
}
</script>
