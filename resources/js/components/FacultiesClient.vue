<template>
    <div class="container-fluid">
        <div class="wrap-table">
            <div class="note-info">
                <span>Lưu ý:</span>
                <ul>
                    <li>
                        <p>Đây là lưu ý</p>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-3 mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark text-white">Lọc</span>
                        </div>
                        <select name="state" id="maxRows" class="form-control">
                            <option value="10">10</option>
                            <option value="0" selected>Tất cả</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark text-white">Tìm kiếm</span>
                        </div>
                        <input type="text" class="form-control" id="table-search" />
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th class="width-400">Tên đợt</th>
                            <th class="width-100">Bắt đầu</th>
                            <th class="width-100">Kết thúc</th>
                            <th class="width-80">Tình trạng</th>
                            <th class="width-100">Tổng</th>
                            <th class="width-80">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Đánh giá đoàn viên năm học 2013-2014</td>
                            <td>11/11/2013</td>
                            <td>11/11/2014</td>
                            <td class="text-center">
                                <span class="badge badge-pill badge-success">Hoàn thành</span>
                            </td>
                            <td class="text-center">11/14</td>
                            <td class="text-center">
                                <a href="TKKhoa.html" class="text-primary"><i class="far fa-eye"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
