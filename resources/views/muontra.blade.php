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
                        @csrf
                        <input type="hidden" id="id">
                        <div class="form-group row">
                            <label for="inputSinhVien" class="col-sm-3 col-form-label">Tên Sinh Viên: </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="sinhvien" name="sinhvien">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSinhVien" class="col-sm-3 col-form-label">Tên Sách: </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="sach" name="sach">
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
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
                        </div> --}}
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
                                <td>Tên Sách</td>
                                <td>Ngày Mượn</td>
                                <td>Ngày Trả</td>
                                <td>Tình Trạng</td>
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
            var dataTable = $('#myTable').DataTable({
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/muonsach/get',
                    type: 'GET',
                    dataSrc: function(data) {
                        return data;
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'tensinhvien'
                    }, {
                        data: 'tensach'
                    }, {
                        data: 'ngaymuon'
                    }, {
                        data: 'ngaytra'
                    }, {
                        data: 'tinhtrang',
                        render: function(data, type, row, meta) {
                            if (data == 0) {
                                return 'Chưa Trả';
                            } else {
                                return 'Đã Trả';
                            }
                        }
                    }

                ]
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/getIds',
                type: 'GET',
                success: function(data) {
                    // Populate dropdown for Sinh Viên
                    $('#sinhvien').append($('<option>').val('').text('Choose Sinh Viên'));
                    // Populate dropdown for Sách
                    $('#sach').append($('<option>').val('').text('Choose Sách'));

                    data.jointable.forEach(function(item) {
                        $('#sinhvien').append($('<option>').val(item.id).text(item
                            .tensinhvien));
                        $('#sach').append($('<option>').val(item.id).text(item.tensach));
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
            $('#createBookForm').on('submit', function() {
                var formdata = {
                    sinhvien: $('#sinhvien').val(),
                    sach: $('#sach').val()
                };

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/muonsach/them',
                    type: "POST",
                    data: formdata,
                    success: function() {
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

        });
    </script>
@endsection
