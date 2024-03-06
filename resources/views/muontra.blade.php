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
                        <div class="form-group row">
                            <label for="inputSinhVien" class="col-sm-3 col-form-label">Ngày Mượn: </label>
                            <div class="col-sm-9">
                                <input type="date" id="ngaymuon" name="ngaymuon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSinhVien" class="col-sm-3 col-form-label">Ngày Trả: </label>
                            <div class="col-sm-9">
                                <input type="date" id="ngaytra" name="ngaytra">
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
                        data: 'ngaymuon',
                        render: function(data, type, row, meta) {
                            if (data === null || data === '') {
                                return ''; // Return an empty string if the date is null or empty
                            }

                            // Parse the date string to a Date object
                            var date = new Date(data);

                            // Extract day, month, and year components
                            var day = date.getDate().toString().padStart(2, '0');
                            var month = (date.getMonth() + 1).toString().padStart(2,
                                '0'); // Adding 1 because months are zero-based
                            var year = date.getFullYear();

                            // Format the date in "dd/mm/yyyy" format
                            var formattedDate = day + '/' + month + '/' + year;

                            return formattedDate;
                        }
                    }, {
                        data: 'ngaytra',
                        render: function(data, type, row, meta) {
                            if (data === null || data === '') {
                                return ''; // Return an empty string if the date is null or empty
                            }

                            // Parse the date string to a Date object
                            var date = new Date(data);

                            // Extract day, month, and year components
                            var day = date.getDate().toString().padStart(2, '0');
                            var month = (date.getMonth() + 1).toString().padStart(2,
                                '0'); // Adding 1 because months are zero-based
                            var year = date.getFullYear();

                            // Format the date in "dd/mm/yyyy" format
                            var formattedDate = day + '/' + month + '/' + year;

                            return formattedDate;
                        }
                    }, {
                        data: 'tinhtrang',
                        render: function(data, type, row, meta) {
                            if (data == 0) {
                                return 'Đã Trả';
                            } else {
                                return 'Chưa Trả';
                            }
                        }
                    }, {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<button class="btnUpdate" data-id="${row.id}" data-toggle="modal" data-target="#myModal">Update</button> 
                            <button class="btnDelete" data-id="${row.id}">Delete</button>`;
                        }
                    }

                ]
            });

            //



            $.get('/getIds', function(response) {
                var dropDownDataSV = response.dropDownDataSV;
                var dropdownsv = $('#sinhvien');
                $.each(dropDownDataSV, function(id, name) {
                    dropdownsv.append($('<option></option>').val(id).text(name));
                });

                var dropDownDataSach = response.dropDownDataSach;
                var dropdownSach = $('#sach');
                $.each(dropDownDataSach, function(id, name) {
                    dropdownSach.append($('<option></option>').val(id).text(name));
                });

                dropdownsv.on('change', function() {
                    selectedIdsv = $(this).val(); // Assign value to the variable
                    var selectedName = dropDownDataSV[selectedIdsv];
                    console.log('selected sinh vien id:' + selectedIdsv);
                    console.log('selected sinh vien name:' + selectedName);
                });

                dropdownSach.on('change', function() {
                    selectedIdsach = $(this).val(); // Assign value to the variable
                    var selectedName = dropDownDataSach[selectedIdsach];
                    console.log('selected sach id:' + selectedIdsach);
                    console.log('selected sach name:' + selectedName);
                });
            });
            $('#createBookForm').on('submit', function(event) {
                event.preventDefault();
                var formdata = {
                    id_sinhvien: selectedIdsv,
                    id_sach: selectedIdsach,
                    ngaymuon: $('#ngaymuon').val(),
                    ngaytra: $('#ngaytra').val(),
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
                            url: '/muonsach/xoa/' + id,
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

        });
    </script>
@endsection
