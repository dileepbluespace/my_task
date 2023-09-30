@extends('layout.master')

{{-- content start --}}
@section('content')
    <div class="container-fluid p-0 ">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="white_card card_height_100 mb_30">
                    <div class="white_card_header">
                        <div class="box_header m-0">
                            <div class="main-title">
                                <h3 class="m-0">Data table</h3>
                            </div>
                        </div>
                    </div>
                    <div class="white_card_body">
                        <div class="QA_section">
                            <div class="white_box_tittle list_header">
                                <h4>Table</h4>
                                <div class="box_right d-flex lms_block">
                                    {{-- <div class="serach_field_2">
                                    <div class="search_inner">
                                        <form Active="#">
                                            <div
                                                class="search_field">
                                                <input
                                                    type="text"
                                                    placeholder="Search content here...">
                                            </div>
                                            <button
                                                type="submit">
                                                <i
                                                    class="ti-search"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div> --}}
                                    <div class="add_button ms-2">
                                        <a href="#" id="" class="btn_1 addCustomer">Add New</a>
                                    </div>
                                </div>
                            </div>
                            <div class="QA_table mb_30">
                                <table class="table lms_table_active " id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Age</th>
                                            <th scope="col">Salary</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
            </div>
        </div>
    </div>
    <a href=""></a>
@endsection
{{-- content end --}}

{{-- modal start  --}}
@section('modal')
    {{-- add and edit customer modal --}}
    <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('customer.store') }}" id="myform" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Please enter name">
                                    <div class="text-danger" id="name_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Age <span class="text-danger">*</span></label>
                                    <input type="number"pattern="\d{2}" min="10" max="99" class="form-control"
                                        name="age" id="age" placeholder="Please enter age">
                                    <div class="text-danger" id="age_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Salary<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="salary" id="salary"
                                        placeholder="Please enter salary">
                                    <div class="text-danger" id="salary_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Phone <span class="text-danger">*</span></label><br>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                        placeholder="Please enter phone">
                                    <div class="text-danger" id="phone_error"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                            <button type="submit" id="save_btn" class="btn_1 "></button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
{{-- modal end  --}}

{{-- script satrt --}}
@section('script')
    <script>
        $(document).ready(function() {

            //add customer 
            $(document).on('click', '.addCustomer', function() {
                $('#save_btn').text('');
                $('#save_btn').text('Save');
                $('#modal_title').text('');
                $('#modal_title').text('Add Customer');
                $('#myform')[0].reset();
                $('#name_error').text('');
                $('#age_error').text('');
                $('#salary_error').text('');
                $('#phone_error').text('');
                $('#addCustomer').modal('show');
            });

            //validation
            function validation() {
                var name = $('#name').val();
                if (name != '') {
                    $('#name_error').text('');
                }
                var age = $('#age').val();
                if (name != '') {
                    $('#age_error').text('');
                }
                var salary = $('#salary').val();
                if (name != '') {
                    $('#salary_error').text('');
                }

                var phone = $('#phone').val();
                if (phone != '') {
                    $('#phone_error').text('');
                }
            };
            //store customer
            $('#myform').on('submit', function(e) {
                e.preventDefault();
                validation();

                var formData = new FormData(this);
                $.ajax({
                    type: 'post',
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Toast.fire({
                                icon: 'success',
                                title: response.success,
                                })
                            $('#addCustomer').modal('hide');
                            $('#datatable').DataTable().draw();
                        } else if (response.update) {
                            Toast.fire({
                                icon: 'success',
                                title: response.update,
                                })
                            $('#addCustomer').modal('hide');
                            $('#datatable').DataTable().draw();
                        } else {
                            var errors = response.errors;
                            // errors and display them on the page
                            $.each(errors, function(key, value) {
                                $('#' + key + '_error').text(value[0]);
                            });
                        }
                    }

                })

            });

            //edit
            $(document).on('click', '.edit', function() {
                $('#save_btn').text('');
                $('#save_btn').text('Update');
                $('#modal_title').text('');
                $('#modal_title').text('Update Customer');
                $('#myform')[0].reset();
                $('#name_error').text('');
                $('#age_error').text('');
                $('#salary_error').text('');
                $('#phone_error').text('');
                var editUrl = $(this).attr('data-edit');
                var updateUrl = $(this).attr('data-update');
                $('#myform').attr('action', '');
                $('#myform').attr('action', updateUrl);

                $.ajax({
                    type: 'get',
                    url: editUrl,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        $('#name').val(response.name);
                        $('#age').val(response.age);
                        $('#salary').val(response.salary);
                        $('#phone').val(response.phone);
                        

                    }

                })
                $('#addCustomer').modal('show');
            });
            //showing data
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                ajax: {
                    url: '{{ route('customer.index') }}',
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [{
                        data: 'sr_number',
                        name: 'sr_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'age',
                        name: 'age'
                    },
                    {
                        data: 'salary',
                        name: 'salary'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            //status
            $(document).on('click', '.changestatus', function(){
                var url = $(this).attr('data-url');
                var status = $(this).attr('data-status');

                $.ajax({
                    type: 'post',
                    url: url,
                    dataType: 'json',
                    data:{
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response){
                        $('#datatable').DataTable().draw();
                                Toast.fire({
                                icon: 'success',
                                title: response.success,
                            })
                    }
                })
            })
            //delete 
            $(document).on('click', '.delete', function() {
                var url = $(this).attr('data-url');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: url,
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                $('#datatable').DataTable().draw();
                                Toast.fire({
                                icon: 'warning',
                                title: response.success,
                                })
                            }
                        })

                    }
                })

            })
        });
    </script>
@endsection
{{-- script end --}}
