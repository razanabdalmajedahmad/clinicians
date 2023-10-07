@extends('Dashbord.layout.App')
@section('title')
    <title>create new Appointment</title>
    {{-- jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
@section('content')
    <div class="d-flex justify-content-between">
        <div class="pagetitle col">
            <h1>Appointments</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a>Home</a></li>
                    <li class="breadcrumb-item ">Appointments</li>
                    <li class="breadcrumb-item active"><a>Create new Appointment</a></li>
                </ol>
            </nav>
        </div>
        <div>
            <a class="btn btn-primary" href="{{ route('appointment_list') }}">Back</a>
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
                                    <input type="text" class="form-control" name="name">
                                    <span class="invalid-feedback" id="invalid_feedback_name">
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <label for="inputEmail3" class="col-sm-4 col-md-3 col-form-label">Description</label>
                                <div class="col-sm-8 col-md-12">
                                    <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>

                                    <span class="invalid-feedback" id="invalid_feedback_description">
                                    </span>
                                </div>


                            </div>
                            <div class="row mb-3">

                                <div class="col-md-6 col-sm-12">
                                    <label for="inputEmail3" class="col-sm-4 col-md-3 col-form-label">Date</label>
                                    <div class="col-sm-8 col-md-12">
                                        <input type="text" class="form-control" name="date" id="date">

                                        <span class="invalid-feedback" id="invalid_feedback_date">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="inputEmail3" class="col-sm-4 col-md-3 col-form-label">Time</label>
                                    <div class="col-sm-8 col-md-12">
                                        <input type="text" class="form-control" name="time" id="time">

                                        <span class="invalid-feedback" id="invalid_feedback_time">
                                        </span>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date", {
            minDate: "today",

        });
        flatpickr("#time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true

        });
    </script>


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
                url: "{{ route('appointment_createnew_post') }}",
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
                        window.location.href = "{{ route('appointment_list') }}";
                        $('#alert-error').attr('hidden', true)
                    } else {
                        $('.invalid-feedback').css('display', 'none')
                        $('#alert-error').attr('hidden', false)
                        $('#alert-error').empty()
                        $('#alert-error').append(data.message)


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
