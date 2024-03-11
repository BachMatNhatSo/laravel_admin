@extends('layouts.master')
@section('content')
    <button type="button" style="margin-left: 13px;" id="btnThem" class="btn btn-warning btn-lg" data-toggle="modal"
        data-target="#myModal">Thêm Sinh Viên</button>



    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-4">
            <form action="{{ route('importsv.processsv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group" style="margin-bottom: 0; ">
                    <label for="file" style="margin-left:15px;" class="col-form-label">Thêm bằng file Excel</label>
                    <div class="row" style="margin-left:10px;">
                        <div class="col">
                            <input type="file" class="form-control-file" id="file" name="file">
                        </div>
                        <div class="col">
                            <button type="submit" id="uploadButton" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">Điền Thông Tin</h4>
                </div>
                <div class="modal-body">
                    <form id="createBookForm">
                        <input type="hidden" id="id">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Tên Sinh Viên: </label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control" id="tensinhvien" name="tensinhvien"
                                    required placeholder="Duy Nhân">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Mã SV: </label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control" id="mssv" name="mssv" required
                                    placeholder="11911123">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Điện Thoại: </label>
                            <div class="col-sm-9">
                                <input type="number" required min="1" class="form-control" id="dienthoai"
                                    name="dienthoai" required placeholder="0123456">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Địa Chỉ</label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control" id="diachi" name="diachi" required
                                    placeholder="vd: Bạch Ngọc Sách">
                            </div>
                        </div>
                        <input id="btnsubmit" type="submit" value="Xác Nhận">
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12">
                    <table id="myTable" class="table table-bordered table-striped dataTable dtr-inline"
                        aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Tên Sinh Viên</td>
                                <td>Mã Sinh Viên</td>
                                <td>SĐT</td>
                                <td>Địa chỉ</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            //get all data
            var dataTable = $('#myTable').DataTable({
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/users/get',
                    type: 'GET',
                    dataSrc: function(data) {
                        return data;
                    }
                },
                columns: [{
                        data: 'id'
                    }, {
                        data: 'tensinhvien'
                    },
                    {
                        data: 'mssv'
                    },
                    {
                        data: 'dienthoai'
                    },
                    {
                        data: 'diachi'
                    }, {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<button class="btnUpdate" data-id="${row.id}" data-toggle="modal" data-target="#myModal"><i class="fas fa-edit"></i></button> 
                            <button class="btnDelete" data-id="${row.id}"> <i class="fa fa-trash"></i></button>`;
                        }
                    }
                ]
            });
            //clear text
            function clearText() {
                $('#id').val('');
                $('#tensinhvien').val('');
                $('#mssv').val('');
                $('#dienthoai').val('');
                $('#diachi').val('');
            }
            //get id of btnupdate
            $('#myTable').on('click', '.btnUpdate', function() {
                $('#id').val($(this).data('id'));
                var rowdata = dataTable.row($(this).parents('tr')).data();
                $('#tensinhvien').val(rowdata.tensinhvien);
                $('#mssv').val(rowdata.mssv);
                $('#dienthoai').val(rowdata.dienthoai);
                $('#diachi').val(rowdata.diachi);
                $('#modal-title').text('Cập Nhật');
            });
            $('#btnThem').click(function() {
                $('#modal-title').text('Thêm Mới');
                clearText();
            });
            //insert and update
            $('#createBookForm').on('submit', function(event) {
                event.preventDefault();
                //get from data
                var formdata = {
                    tensinhvien: $('#tensinhvien').val(),
                    mssv: $('#mssv').val(),
                    dienthoai: $('#dienthoai').val(),
                    diachi: $('#diachi').val(),
                };
                var id = $('#id').val();
                var url = "";
                var type = "";

                if (id) {
                    url = '/users/update/' + id;
                    type = "PUT";
                } else {
                    url = '/users';
                    type = 'POST';
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: type,
                    data: formdata,
                    success: function(response) {
                        Swal.fire({
                            title: "Success!!",
                            text: "You clicked the button!",
                            icon: "success"
                        });
                        dataTable.ajax.reload();
                        $('#createBookForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        // Error occurred while creating book
                        console.log(xhr.response);
                        // Show error message or perform any other error handling
                    }
                });

            });
            //delete
            $('#myTable').on('click', '.btnDelete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete the record.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '/users/delete/' + id,
                            type: 'DELETE',
                            success: function() {
                                Swal.fire({
                                    title: 'Delete success!!',
                                    text: 'You clicked the button!',
                                    icon: 'success'
                                });
                                dataTable.ajax.reload();
                            }
                        });
                    }
                });
            });





            //////////end/////////////
        });
        document.getElementById('uploadButton').addEventListener('click', function() {
            // Show SweetAlert notification
            Swal.fire({
                title: "Success!!",
                text: "You clicked the upload button!",
                icon: "success"
            });
        });
    </script>
@endsection
