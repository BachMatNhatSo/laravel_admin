@extends('layouts.master')
@section('content')
    <button type="button"style="margin-left: 13px;" id="btnThem" class="btn btn-warning btn-lg" data-toggle="modal"
        data-target="#myModal">Thêm
        Sách</button>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="">
        <div class="row">
            <div class="col-sm-4">
                <form action="{{ route('import.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="file" style="margin-left:15px;" class="col-form-label">Thêm bằng file Excel</label>
                        <div class="row " style="margin-left:12px;">
                            <div class="col">
                                <input type="file" class="form-control-file" id="file" name="file">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Tên Sách: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tensach" name="tensach" required
                                    placeholder="vd: Lạn kha kỳ duyên">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Tác Giả: </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tacgia" name="tacgia" required
                                    placeholder="vd: Chân phí sự">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Giá: </label>
                            <div class="col-sm-9">
                                <input type="number" min="1" class="form-control" id="giatien" name="giatien"
                                    required placeholder="vd: 1000">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Nhà Xuất Bản</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nhaxuatban" name="nhaxuatban" required
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
                                <td>Sách </td>
                                <td>Tác Giả</td>
                                <td>Giá</td>
                                <td>Nhà Sản Xuất</td>
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
                    url: '/getdbbook',
                    method: 'GET',
                    dataSrc: function(data) {
                        return data;
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'tensach'
                    },
                    {
                        data: 'tacgia'
                    },
                    {
                        data: 'giatien',
                        render: function(data, type, row) {
                            var giatien = parseFloat(data);
                            var formattedGiatien = giatien.toLocaleString('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            });
                            return formattedGiatien;
                        }
                    },
                    {
                        data: 'nhaxuatban'
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<button class="btnUpdate" data-id="${row.id}" data-toggle="modal" data-target="#myModal" >Update</button> 
                            <button class="btnDelete" data-id="${row.id}">Delete</button>`;
                        }
                    }
                ]
            });

            function lamsach() {
                $('#id').val('');
                $('#tensach').val('');
                $('#tacgia').val('');
            }

            $('#myTable').on('click', '.btnUpdate', function() {
                $('#id').val($(this).data('id'));
            });
            $('#btnThem').click(function() {
                lamsach();
            });
            $('#createBookForm').on('submit', function(event) {
                event.preventDefault();
                // Get form data
                var formData = {
                    tensach: $('#tensach').val(),
                    tacgia: $('#tacgia').val(),
                    giatien: $('#giatien').val(),
                    nhaxuatban: $('#nhaxuatban').val()
                };
                var id = $('#id').val();
                var url = "";
                var method = "";

                if (id) {
                    url = '/books/update/' + id;
                    method = "PUT";
                } else {
                    url = '/books';
                    method = "POST";
                }
                // Send AJAX request to create book
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    method: method,
                    data: formData,
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
                            url: '/books/delete/' + id,
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
