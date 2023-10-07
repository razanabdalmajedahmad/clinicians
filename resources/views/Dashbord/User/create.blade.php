@extends('Dashbord.layout.App')
@section('title')
    <title>create new user</title>
    {{-- jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endsection
@section('content')
    <div class="d-flex justify-content-between">
        <div class="pagetitle col">
            <h1>Users</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a>Home</a></li>
                    <li class="breadcrumb-item ">Users</li>
                    <li class="breadcrumb-item active"><a>Create new user</a></li>
                </ol>
            </nav>
        </div>
        <div>
            <a class="btn btn-primary" href="{{ route('user_list') }}">Back</a>
        </div>
    </div>

    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                <div class="card p-5">
                    <div class="card-body">
                        <div class="alert alert-danger mt-1" hidden id="alert-error">

                        </div>
                        <form id="form">
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-md-3 col-form-label">name</label>
                                <div class="col-sm-8 col-md-12">
                                    <input type="text" class="form-control" name="name" >
                                    <span class="invalid-feedback" id="invalid_feedback_name">
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-md-3 col-form-label">email</label>
                                <div class="col-sm-8 col-md-12">
                                    <input type="text" class="form-control" name="email" >
                                    <span class="invalid-feedback" id="invalid_feedback_email">
                                    </span>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-md-3 col-form-label">Role</label>
                                <div class="col-sm-8 col-md-12">
                                    <select name="role" class="form-control" id="">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" id="invalid_feedback_role">
                                    </span>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-md-3 col-form-label">password</label>
                                <div class="col-sm-8 col-md-12">
                                    <input type="password" class="form-control" name="password" >
                                    <span class="invalid-feedback" id="invalid_feedback_password">
                                    </span>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-4 col-md-3 col-form-label">Re-enter Password</label>
                                <div class="col-sm-8 col-md-12">
                                    <input type="password" class="form-control" name="renewpassword">
                                    <span class="invalid-feedback" id="invalid_feedback_renewpassword">
                                    </span>
                                </div>

                            </div>


                            <div class="text-center">
                                <button class="btn btn-primary" id="btn-save">Submit</button>
                                <div class="spinner-border text-primary" role="status" hidden>
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endsection
@section('script')
    <script src=" https://ajax.googleapis.com/ajax/libs/jQuery/3.3.1/jQuery.min.js "></script>


    <script>
        $('#form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.append('_token', "{{ csrf_token() }}")
            $.ajax({
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                url: "{{ route('user_createnew_post') }}",
                data: formData,
                beforeSend: function() {
                    $('.invalid-feedback').empty()
                    $('#alert-error').attr('hidden', 'hidden')
                    $('#btn-save').attr('hidden', 'hidden')
                    $('.spinner-border').attr('hidden', false)
                },
                complete: function() {
                    $('#btn-save').attr('hidden', false)
                    $('.spinner-border').attr('hidden', 'hidden')
                },
                success: function(data) {
                    if (data.status) {
                        window.location.href = "{{ route('user_list') }}";
                        $('#alert-error').attr('hidden', true)
                    } else {
                        $('.invalid-feedback').css('display', 'none')
                        $('#alert-error').attr('hidden', false)
                        $('#alert-error').empty()
                        $('#alert-error').append( data.message)


                    }
                },
                error: function(xhr) {
                    $('#alert-error').attr('hidden', true)
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#invalid_feedback_' + key).empty()
                        $('#invalid_feedback_' + key).append(value)
                        $('.invalid-feedback').css('display', 'inline')
                    });
                }
            });
        })
    </script>

@endsection
