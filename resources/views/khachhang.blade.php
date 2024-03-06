@extends('layouts.master')
@section('content')
    <button type="button" id="btnThem" class ="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Thêm</button>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <form id="createBookForm">
                        <input type="hidden" id="id">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Tên Sinh Viên: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tensinhvien" name="tensinhvien" required
                                    placeholder="Duy Nhân">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Mã SV: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="mssv" name="mssv" required
                                    placeholder="11911123">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Điện Thoại: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="dienthoai" name="dienthoai" required
                                    placeholder="0123456">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Địa Chỉ</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="diachi" name="diachi" required
                                    placeholder="vd: Bạch Ngọc Sách">
                            </div>
                        </div>
                        <input id="btnsubmit" type="submit" value="Submit">
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
                    url: 'api/users',
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
                            return `<button class="btnUpdate" data-id="${row.id}" data-toggle="modal" data-target="#myModal">Update</button> 
                            <button class="btnDelete" data-id="${row.id}">Delete</button>`;
                        }
                    }
                ]
            });
            //clear text
            function clearText() {
                $('#id').val('');
                $('#tensinhvien').val('');
                $('#msssv').val('');
                $('#dienthoai').val('');
                $('#diachi').val('');
            }
            //get id of btnupdate
            $('#myTable').on('click', '.btnUpdate', function() {
                $('#id').val($(this).data('id'));
            });
            $('.btnThem').click(function() {
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
                    url = 'api/users/update/' + id;
                    type = "PUT";
                } else {
                    url = 'api/users';
                    type = 'POST';
                }
                $.ajax({
                    url: url,
                    type: type,
                    data: formdata,
                    success: function(response) {
                        Swal.fire({
                            title: "Add success!!",
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
                            url: 'api/users/delete/' + id,
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
    </script>
@endsection
