@extends('Dashbord.layout.App')
@section('title')
    <title>Calender</title>
    <style>

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/locales-all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.css"/> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}

@endsection
@section('content')
    <div class="pagetitle">

        <div >
            <div class="pagetitle col">
                <h1>Calender</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a>Home</a></li>
                        <li class="breadcrumb-item active">Calender</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>
    @include('model')
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-sm-12"></div>
            <div class="col-lg-6 col-sm-12">

                <div class="card p-5">

                    <div class="card-body " >
                        <div id="calendar" ></div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var events = @json($events);
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev, next today',
                    center: 'title',
                    right: 'month',
                },
                events: events,
                // selectable: true,
                // selectHelper: true,
                // displayEventTime: false,
                // editable: true,
                // nextDayThreshold: '00:00:00',
                eventClick: function(event) {
                    $('#name').empty();
                    $('#name').append(event.title);
                    $('#des').empty();
                    $('#des').append(event.des);
                    $('#time').empty();
                    $('#time').append(event.time);
                    $('#date').empty();
                    $('#date').append(moment(event.start).format('YYYY/MM/DD '));
                    $('#editModal').modal('toggle');
                }
            });





        });
    </script>
@endsection

