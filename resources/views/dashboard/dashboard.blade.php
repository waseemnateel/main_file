@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script>

        (function () {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('event_calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridDay,timeGridWeek,dayGridMonth'
                },
                buttonText: {
                    timeGridDay: "{{__('Day')}}",
                    timeGridWeek: "{{__('Week')}}",
                    dayGridMonth: "{{__('Month')}}"
                },
                themeSystem: 'bootstrap',
                navLinks: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                editable: true,
                dayMaxEvents: true,
                handleWindowResize: true,
                events: {!! json_encode($arrEvents) !!},
                locale: '{{basename(App::getLocale())}}',
                dayClick: function (e) {
                    var t = moment(e).toISOString();
                    $("#new-event").modal("show"), $(".new-event--title").val(""), $(".new-event--start").val(t), $(".new-event--end").val(t)
                },
                eventResize: function (event) {
                    var eventObj = {
                        start: event.start.format(),
                        end: event.end.format(),
                    };
                },
                viewRender: function (t) {
                    e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
                },
                eventClick: function (e, t) {
                    var title = e.title;
                    var url = e.url;

                    if (typeof url != 'undefined') {
                        $("#commonModal .modal-title").html(title);
                        $("#commonModal .modal-dialog").addClass('modal-md');
                        $("#commonModal").modal('show');
                        $.get(url, {}, function (data) {
                            $('#commonModal .modal-body').html(data);
                        });
                        return false;
                    }
                }
            });
            calendar.render();
        })();
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('HRM')}}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("Today's Not Clock In")}}</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="row g-3 flex-nowrap team-lists horizontal-scroll-cards">
                                @foreach($notClockIns as $notClockIn)

                                    <div class="col-auto">
                                        <img src="{{(!empty($notClockIn->user))? $notClockIn->user->profile : asset(Storage::url("uploads/avatar/avatar.png"))}}" alt="">

                                        <p class="mt-2">{{ $notClockIn->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('Event')}}</h5>
                        </div>
                        <div class="card-body">
                            <div id='event_calendar' class='calendar'></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>{{__('Staff')}}</h5>
                                <div class="row  mt-4">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-primary">
                                                <i class="ti ti-users"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Total Staff')}}</p>
                                                <h4 class="mb-0 text-success">{{ $countUser +   $countClient}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-info">
                                                <i class="ti ti-user"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Employee')}}</p>
                                                <h4 class="mb-0 text-primary">{{$countUser}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-danger">
                                                <i class="ti ti-user"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Client')}}</p>
                                                <h4 class="mb-0 text-danger">{{$countClient}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>{{__('Job')}}</h5>
                                <div class="row  mt-4">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-primary">
                                                <i class="ti ti-award"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Total Jobs')}}</p>
                                                <h4 class="mb-0 text-success">{{$activeJob + $inActiveJOb}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-info">
                                                <i class="ti ti-check"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Active Job')}}</p>
                                                <h4 class="mb-0 text-primary">{{$activeJob}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-danger">
                                                <i class="ti ti-x"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Inactive Job ')}}</p>
                                                <h4 class="mb-0 text-danger">{{$inActiveJOb}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <h5>{{__('Training')}}</h5>
                                <div class="row  mt-4">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-primary">
                                                <i class="ti ti-users"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Total Training')}}</p>
                                                <h4 class="mb-0 text-success">{{ $onGoingTraining +   $doneTraining}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-info">
                                                <i class="ti ti-user"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Trainer')}}</p>
                                                <h4 class="mb-0 text-primary">{{$countTrainer}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-danger">
                                                <i class="ti ti-user-check"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Active Training')}}</p>
                                                <h4 class="mb-0 text-danger">{{$onGoingTraining}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="theme-avtar bg-secondary">
                                                <i class="ti ti-user-minus"></i>
                                            </div>
                                            <div class="ms-2">
                                                <p class="text-muted text-sm mb-0">{{__('Done Training')}}</p>
                                                <h4 class="mb-0 text-secondary">{{$doneTraining}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">

                            <h5>{{__('Announcement List')}}</h5>
                        </div>
                        <div class="card-body" style="min-height: 295px;">
                            <div class="table-responsive">
                                @if(count($announcements) > 0)
                                    <table class="table align-items-center">
                                        <thead>
                                        <tr>
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Start Date')}}</th>
                                            <th>{{__('End Date')}}</th>

                                        </tr>
                                        </thead>
                                        <tbody class="list">
                                        @foreach($announcements as $announcement)
                                            <tr>
                                                <td>{{ $announcement->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat($announcement->start_date) }}</td>
                                                <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="p-2">
                                        No accouncement present yet.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('Meeting schedule')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @if(count($meetings) > 0)
                                    <table class="table align-items-center">
                                        <thead>
                                        <tr>
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Time')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list">
                                        @foreach($meetings as $meeting)
                                            <tr>
                                                <td>{{ $meeting->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                                <td>{{  \Auth::user()->timeFormat($meeting->time) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="p-2">
                                        No meeting scheduled yet.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection


