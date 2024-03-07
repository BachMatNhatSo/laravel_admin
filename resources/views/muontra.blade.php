@extends('layouts.master')
@section('content')
    <button type="button" style="margin-left: 13px;" id="btnThem" class="btn btn-warning btn-lg" data-toggle="modal"
        data-target="#myModal">Thêm</button>
    <div class="form-group row" style="margin-left:15px;">
        <label for="fromDate" class="col-sm-0 col-form-label">FromDate: </label>
        <div class="col-sm-2">
            <input type="date" id="fromDate" name="fromDate" class="form-control">
        </div>
        <label for="toDate" class="col-sm-0 col-form-label">ToDate: </label>
        <div class="col-sm-2">
            <input type="date" id="toDate" name="toDate" class="form-control">
        </div>
    </div>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Điền Thông Tin</h4>
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
                            <label for="inputSinhVien" required class="col-sm-3 col-form-label">Ngày Mượn: </label>
                            <div class="col-sm-9">
                                <input type="date" id="ngaymuon" name="ngaymuon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSinhVien" required class="col-sm-3 col-form-label">Ngày Trả: </label>
                            <div class="col-sm-9">
                                <input type="date" id="ngaytra" name="ngaytra">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSinhVien" class="col-sm-3 col-form-label">Tình Trạng: </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="tinhtrang" name="tinhtrang">
                                    <option value="0">Đang Mượn</option>
                                    <option value="1">Đã Trả</option>
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
                            var formattedDate = day + '-' + month + '-' + year;

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
                            var formattedDate = day + '-' + month + '-' + year;

                            return formattedDate;
                        }
                    }, {
                        data: 'tinhtrang',
                        render: function(data, type, row, meta) {
                            if (data == 0) {
                                return 'Đang Mượn';
                            } else {
                                return 'Đã Trả';
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
            $('#fromDate, #toDate').on('change', function() {
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();;
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var minDate = fromDate ? new Date(fromDate) : null;
                        var maxDate = toDate ? new Date(toDate) : null;

                        var ngayMuon = new Date(moment(data[3], "DD-MM-YYYY").format(
                            "YYYY-MM-DD")); // Index 3 corresponds to "NgayMuon" column
                        ;
                        var ngayTra = new Date(moment(data[4], "DD-MM-YYYY").format(
                            "YYYY-MM-DD")); // Index 4 corresponds to "NgayTra" column
                        if ((minDate != null && maxDate != null) && (ngayMuon >= minDate && ngayMuon <=
                                maxDate)) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                );

                dataTable.draw();
                // Remove the custom search function after filtering
                $.fn.dataTable.ext.search.pop();
            });
            //fill data in 2 <select> sv and sach
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
            });
            //
            function clearText() {
                $('#id').val('');

            }
            $('#myTable').on('click', '.btnUpdate', function() {
                $('#id').val($(this).data('id'));
            });
            $('#btnThem').click(function() {
                clearText();
            });
            //insert and update mượn trả
            $('#createBookForm').on('submit', function(event) {
                event.preventDefault();
                var formdata = {
                    id_sinhvien: $('#sinhvien').val(),
                    id_sach: $('#sach').val(),
                    ngaymuon: $('#ngaymuon').val(),
                    ngaytra: $('#ngaytra').val(),
                    tinhtrang: $('#tinhtrang').val()
                };
                var id = $('#id').val();
                var url = '';
                var type = '';
                if (id) {
                    url = '/muonsach/capnhat/' + id;
                    type = 'PUT';
                } else {
                    url = '/muonsach/them';
                    type = "POST";
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: type,
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


            //deltele
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
