@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo = \App\Models\Utility::GetLogo();
    $company_small_logo=Utility::getValByName('company_small_logo');
    $setting = \App\Models\Utility::colorset();
    $mode_setting = \App\Models\Utility::mode_layout();



@endphp

<nav class="dash-sidebar light-sidebar {{(isset($mode_setting['cust_theme_bg']) && $mode_setting['cust_theme_bg'] == 'on')?'transprent-bg':''}}">
    <div class="navbar-wrapper">
        <div class="m-header main-logo">
            <a href="#" class="b-brand">

{{--                <img src="{{ asset(Storage::url('uploads/logo/'.$logo)) }}" alt="{{ env('APP_NAME') }}" class="logo logo-lg" />--}}

                <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                     alt="{{ env('APP_NAME') }}" class="logo logo-lg nav-sidebar-logo" />


            </a>
        </div>
        <div class="navbar-content">
            @if(\Auth::user()->type != 'client')
                <ul class="dash-navbar">

                    <!--------------------- Start Dashboard ----------------------------------->

                    @if( Gate::check('show hrm dashboard') || Gate::check('show project dashboard') || Gate::check('show account dashboard'))
                        <li class="dash-item dash-hasmenu
                                {{ ( Request::segment(1) == null ||Request::segment(1) == 'dashboard' || Request::segment(1) == 'income report'
                                   || Request::segment(1) == 'report' || Request::segment(1) == 'reports-payroll' || Request::segment(1) == 'reports-leave' ||
                                    Request::segment(1) == 'reports-monthly-attendance') ?'active dash-trigger':''}}">
                            <a href="#!" class="dash-link "><span class="dash-micon"><i class="ti ti-home"></i></span><span class="dash-mtext">{{__('Dashboard')}}</span>
                                <span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                            <ul class="dash-submenu">
                                @if(\Auth::user()->show_account() == 1)
                                    <li class="dash-item dash-hasmenu {{ ( Request::segment(1) == null   || Request::segment(1) == 'report') ? ' active dash-trigger' : ''}}">
                                        <a class="dash-link" href="#">{{__('Accounting ')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            @can('show account dashboard')
                                                <li class="dash-item {{ ( Request::segment(1) == null || Request::segment(1) == 'account-dashboard') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('dashboard')}}">{{__(' Overview')}}</a>
                                                </li>
                                            @endcan
                                                @if( Gate::check('income report') || Gate::check('expense report') || Gate::check('income vs expense report') ||
                                                     Gate::check('tax report')  || Gate::check('loss & profit report') || Gate::check('invoice report') ||
                                                     Gate::check('bill report') || Gate::check('stock report') || Gate::check('invoice report') ||
                                                     Gate::check('manage transaction')||  Gate::check('statement report'))
                                                    <li class="dash-item dash-hasmenu
                                                              {{(Request::segment(1) == 'report')? 'active dash-trigger ' :''}}">

                                                        <a class="dash-link" href="#">{{__('Reports')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                                        <ul class="dash-submenu">
                                                            @can('expense report')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'report.expense.summary' ) ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{route('report.expense.summary')}}">{{__('Expense Summary')}}</a>
                                                                </li>
                                                            @endcan
                                                            @can('income vs expense report')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'report.income.vs.expense.summary' ) ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{route('report.income.vs.expense.summary')}}">{{__('Income VS Expense')}}</a>
                                                                </li>
                                                            @endcan
                                                            @can('statement report')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'report.account.statement') ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{route('report.account.statement')}}">{{__('Account Statement')}}</a>
                                                                </li>
                                                            @endcan
                                                            @can('invoice report')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'report.invoice.summary' ) ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{route('report.invoice.summary')}}">{{__('Invoice Summary')}}</a>
                                                                </li>
                                                            @endcan
                                                            @can('bill report')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'report.bill.summary' ) ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{route('report.bill.summary')}}">{{__('Bill Summary')}}</a>
                                                                </li>
                                                            @endcan

                                                                @can('stock report')
                                                                    <li class="dash-item {{ (Request::route()->getName() == 'report.product.stock.report' ) ? ' active' : '' }}">
                                                                        <a href="{{route('report.product.stock.report')}}" class="dash-link">{{ __('Product Stock') }}</a>
                                                                    </li>
                                                                @endcan
                                                            @can('loss & profit report')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'report.profit.loss.summary' ) ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{route('report.profit.loss.summary')}}">{{__('Profit & Loss')}}</a>
                                                                </li>
                                                            @endcan
                                                            @can('manage transaction')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'transaction.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transaction.edit') ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{ route('transaction.index') }}">{{__('Transaction')}}</a>
                                                                </li>
                                                            @endcan
                                                            @can('income report')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'report.income.summary' ) ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{route('report.income.summary')}}">{{__('Income Summary')}}</a>
                                                                </li>
                                                            @endcan
                                                            @can('tax report')
                                                                <li class="dash-item {{ (Request::route()->getName() == 'report.tax.summary' ) ? ' active' : '' }}">
                                                                    <a class="dash-link" href="{{route('report.tax.summary')}}">{{__('Tax Summary')}}</a>
                                                                </li>
                                                            @endcan
                                                        </ul>
                                                    </li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif

                                @if(\Auth::user()->show_hrm() == 1)
                                    <li class="dash-item dash-hasmenu">
                                        <a class="dash-link" href="#">{{__('HRM ')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            @can('show hrm dashboard')
                                                <li class="dash-item {{ (\Request::route()->getName()=='hrm.dashboard') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('hrm.dashboard')}}">{{__(' Overview')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage report')
                                                <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'reports-monthly-attendance' || Request::segment(1) == 'reports-leave' || Request::segment(1) == 'reports-payroll') ? 'active dash-trigger' : ''}}" href="#hr-report" data-toggle="collapse" role="button" aria-expanded="{{(Request::segment(1) == 'reports-monthly-attendance' || Request::segment(1) == 'reports-leave' || Request::segment(1) == 'reports-payroll') ? 'true' : 'false'}}">
                                                    <a class="dash-link" href="#">{{__('Reports')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                                    <ul class="dash-submenu">
                                                        <li class="dash-item {{ request()->is('reports-payroll') ? 'active' : '' }}">
                                                            <a class="dash-link" href="{{ route('report.payroll') }}">{{__('Payroll')}}</a>
                                                        </li>
                                                        <li class="dash-item {{ request()->is('reports-leave') ? 'active' : '' }}">
                                                            <a class="dash-link" href="{{ route('report.leave') }}">{{__('Leave')}}</a>
                                                        </li>
                                                        <li class="dash-item {{ request()->is('reports-monthly-attendance') ? 'active' : '' }}">
                                                            <a class="dash-link" href="{{ route('report.monthly.attendance') }}">{{ __('Monthly Attendance') }}</a>
                                                        </li>

                                                    </ul>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endif

                                @if(\Auth::user()->show_project() == 1)
                                    @can('show project dashboard')
                                        <li class="dash-item {{ (Request::route()->getName() == 'project.dashboard') ? ' active' : '' }}">
                                            <a class="dash-link" href="{{route('project.dashboard')}}">{{__('Project ')}}</a>
                                        </li>
                                    @endcan
                                @endif

                            </ul>
                        </li
                    @endif

                <!--------------------- End Dashboard ----------------------------------->


                    <!--------------------- Start HRM ----------------------------------->

                    @if(\Auth::user()->show_hrm() == 1)
                        @if( Gate::check('manage employee') || Gate::check('manage setsalary'))
                            <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'holiday-calender' || Request::segment(1) == 'reports-monthly-attendance' ||
                                Request::segment(1) == 'reports-leave' || Request::segment(1) == 'reports-payroll' || Request::segment(1) == 'leavetype' || Request::segment(1) == 'leave' ||
                                Request::segment(1) == 'attendanceemployee' || Request::segment(1) == 'document-upload' || Request::segment(1) == 'document' || Request::segment(1) == 'performanceType'  ||
                                    Request::segment(1) == 'branch' || Request::segment(1) == 'department' || Request::segment(1) == 'designation' || Request::segment(1) == 'employee'
                                    || Request::segment(1) == 'leave_requests' || Request::segment(1) == 'holidays' || Request::segment(1) == 'policies' || Request::segment(1) == 'leave_calender'
                                    || Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'travel' ||
                                    Request::segment(1) == 'promotion' || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning'
                                     || Request::segment(1) == 'termination' || Request::segment(1) == 'announcement' || Request::segment(1) == 'job' || Request::segment(1) == 'job-application' ||
                                      Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question'
                                       || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career' || Request::segment(1) == 'holiday' || Request::segment(1) == 'setsalary' ||
                                       Request::segment(1) == 'payslip' || Request::segment(1) == 'paysliptype' || Request::segment(1) == 'company-policy' || Request::segment(1) == 'job-stage'
                                       || Request::segment(1) == 'job-category' || Request::segment(1) == 'terminationtype' || Request::segment(1) == 'awardtype' || Request::segment(1) == 'trainingtype' ||
                                       Request::segment(1) == 'goaltype' || Request::segment(1) == 'paysliptype' || Request::segment(1) == 'allowanceoption' || Request::segment(1) == 'loanoption'
                                       || Request::segment(1) == 'deductionoption')?'active dash-trigger':''}}">
                                <a href="#!" class="dash-link "><span class="dash-micon"><i class="ti ti-user"></i></span><span class="dash-mtext">{{__('HRM System')}}</span><span class="dash-arrow">
                                        <i data-feather="chevron-right"></i></span>
                                </a>
                                <ul class="dash-submenu">
                                    <li class="dash-item  {{ (Request::segment(1) == 'employee' ? 'active dash-trigger' : '')}}   ">
                                        @if(\Auth::user()->type =='Employee')
                                            @php
                                                $employee=App\Models\Employee::where('user_id',\Auth::user()->id)->first();
                                            @endphp
                                            <a class="dash-link" href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt(\Auth::user()->id))}}">{{__('Employee')}}</a>
                                        @else
                                            <a href="{{route('employee.index')}}" class="dash-link">
                                                {{ __('Employee Setup') }}
                                            </a>
                                        @endif
                                    </li>

                                    <li class="dash-item dash-hasmenu  {{ (Request::segment(1) == 'setsalary' || Request::segment(1) == 'payslip') ? 'active dash-trigger' : ''}}">
                                        <a class="dash-link" href="#">{{__('Payroll Setup')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            @can('manage set salary')
                                                <li class="dash-item {{ (request()->is('setsalary*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{ route('setsalary.index') }}">{{__('Set salary')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage pay slip')
                                                <li class="dash-item {{ (request()->is('payslip*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('payslip.index')}}">{{__('Payslip')}}</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>

                                    <li class="dash-item dash-hasmenu  {{ (Request::segment(1) == 'leave' || Request::segment(1) == 'attendanceemployee') ? 'active dash-trigger' :''}}">
                                        <a class="dash-link" href="#">{{__('Leave Management Setup')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            @can('manage leave')
                                                <li class="dash-item {{ (Request::route()->getName() == 'leave.index') ?'active' :''}}">
                                                    <a class="dash-link" href="{{route('leave.index')}}">{{__('Manage Leave')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage attendance')
                                                <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'attendanceemployee') ? 'active dash-trigger' : ''}}" href="#navbar-attendance" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'attendanceemployee') ? 'true' : 'false'}}">
                                                    <a class="dash-link" href="#">{{__('Attendance')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                                    <ul class="dash-submenu">
                                                        <li class="dash-item {{ (Request::route()->getName() == 'attendanceemployee.index' ? 'active' : '')}}">
                                                            <a class="dash-link" href="{{route('attendanceemployee.index')}}">{{__('Mark Attendance')}}</a>
                                                        </li>
                                                        @can('create attendance')
                                                            <li class="dash-item {{ (Request::route()->getName() == 'attendanceemployee.bulkattendance' ? 'active' : '')}}">
                                                                <a class="dash-link" href="{{ route('attendanceemployee.bulkattendance') }}">{{__('Bulk Attendance')}}</a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>

                                    <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking') ? 'active dash-trigger' : ''}}" href="#navbar-performance" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking') ? 'true' : 'false'}}">
                                        <a class="dash-link" href="#">{{__('Performance Setup')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu {{ (Request::segment(1) == 'indicator' || Request::segment(1) == 'appraisal' || Request::segment(1) == 'goaltracking') ? 'show' : 'collapse'}}">
                                            @can('manage indicator')
                                                <li class="dash-item {{ (request()->is('indicator*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('indicator.index')}}">{{__('Indicator')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage appraisal')
                                                <li class="dash-item {{ (request()->is('appraisal*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('appraisal.index')}}">{{__('Appraisal')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage goal tracking')
                                                <li class="dash-item  {{ (request()->is('goaltracking*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('goaltracking.index')}}">{{__('Goal Tracking')}}</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>

                                    <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'trainer' || Request::segment(1) == 'training') ? 'active dash-trigger' : ''}}" href="#navbar-training" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'trainer' || Request::segment(1) == 'training') ? 'true' : 'false'}}">
                                        <a class="dash-link" href="#">{{__('Training Setup')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            @can('manage training')
                                                <li class="dash-item {{ (request()->is('training*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('training.index')}}">{{__('Training List')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage trainer')
                                                <li class="dash-item {{ (request()->is('trainer*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('trainer.index')}}">{{__('Trainer')}}</a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>

                                    <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'job' || Request::segment(1) == 'job-application' || Request::segment(1) == 'candidates-job-applications' || Request::segment(1) == 'job-onboard' || Request::segment(1) == 'custom-question' || Request::segment(1) == 'interview-schedule' || Request::segment(1) == 'career') ? 'active dash-trigger' : ''}}    ">
                                        <a class="dash-link" href="#">{{__('Recruitment Setup')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            @can('manage job')
                                                <li class="dash-item {{ (Request::route()->getName() == 'job.index' || Request::route()->getName() == 'job.create' ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('job.index')}}">{{__('Jobs')}}</a>
                                                </li>
                                            @endcan
                                            @can('create job')
                                                <li class="dash-item {{ ( Request::route()->getName() == 'job.create' ? 'active' : '')}} ">
                                                    <a class="dash-link" href="{{route('job.create')}}">{{__('Job Create')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage job application')
                                                <li class="dash-item {{ (request()->is('job-application*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('job-application.index')}}">{{__('Job Application')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage job application')
                                                <li class="dash-item {{ (request()->is('candidates-job-applications') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('job.application.candidate')}}">{{__('Job Candidate')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage job application')
                                                <li class="dash-item {{ (request()->is('job-onboard*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('job.on.board')}}">{{__('Job On-boarding')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage custom question')
                                                <li class="dash-item  {{ (request()->is('custom-question*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('custom-question.index')}}">{{__('Custom Question')}}</a>
                                                </li>
                                            @endcan
                                            @can('show interview schedule')
                                                <li class="dash-item {{ (request()->is('interview-schedule*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('interview-schedule.index')}}">{{__('Interview Schedule')}}</a>
                                                </li>
                                            @endcan
                                            @can('show career')
                                                <li class="dash-item {{ (request()->is('career*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('career',[\Auth::user()->creatorId(),'en'])}}">{{__('Career')}}</a></li>
                                            @endcan
                                        </ul>
                                    </li>

                                    <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'holiday-calender' || Request::segment(1) == 'holiday' || Request::segment(1) == 'policies' || Request::segment(1) == 'award' || Request::segment(1) == 'transfer' || Request::segment(1) == 'resignation' || Request::segment(1) == 'travel' || Request::segment(1) == 'promotion' || Request::segment(1) == 'complaint' || Request::segment(1) == 'warning' || Request::segment(1) == 'termination' || Request::segment(1) == 'announcement') ? 'active dash-trigger' : ''}}">
                                        <a class="dash-link" href="#">{{__('HR Admin Setup')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                        <ul class="dash-submenu">
                                            @can('manage award')
                                                <li class="dash-item {{ (request()->is('award*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('award.index')}}">{{__('Award')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage transfer')
                                                <li class="dash-item  {{ (request()->is('transfer*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('transfer.index')}}">{{__('Transfer')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage resignation')
                                                <li class="dash-item {{ (request()->is('resignation*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('resignation.index')}}">{{__('Resignation')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage travel')
                                                <li class="dash-item {{ (request()->is('travel*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('travel.index')}}">{{__('Trip')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage promotion')
                                                <li class="dash-item {{ (request()->is('promotion*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('promotion.index')}}">{{__('Promotion')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage complaint')
                                                <li class="dash-item {{ (request()->is('complaint*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('complaint.index')}}">{{__('Complaints')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage warning')
                                                <li class="dash-item {{ (request()->is('warning*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('warning.index')}}">{{__('Warning')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage termination')
                                                <li class="dash-item {{ (request()->is('termination*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('termination.index')}}">{{__('Termination')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage announcement')
                                                <li class="dash-item {{ (request()->is('announcement*') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('announcement.index')}}">{{__('Announcement')}}</a>
                                                </li>
                                            @endcan
                                            @can('manage holiday')
                                                <li class="dash-item {{ (request()->is('holiday*') || request()->is('holiday-calender') ? 'active' : '')}}">
                                                    <a class="dash-link" href="{{route('holiday.index')}}">{{__('Holidays')}}</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @can('manage event')
                                        <li class="dash-item {{ (request()->is('event*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{route('event.index')}}">{{__('Event Setup')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage meeting')
                                        <li class="dash-item {{ (request()->is('meeting*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{route('meeting.index')}}">{{__('Meeting')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage assets')
                                        <li class="dash-item {{ (request()->is('account-assets*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{route('account-assets.index')}}">{{__('Employees Asset Setup ')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage document')
                                        <li class="dash-item {{ (request()->is('document-upload*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{route('document-upload.index')}}">{{__('Document Setup')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage company policy')
                                        <li class="dash-item {{ (request()->is('company-policy*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{route('company-policy.index')}}">{{__('Company policy')}}</a>
                                        </li>
                                    @endcan

                                    <li class="dash-item {{ (Request::segment(1) == 'leavetype' || Request::segment(1) == 'document' || Request::segment(1) == 'performanceType' || Request::segment(1) == 'branch' || Request::segment(1) == 'department'
                                                                    || Request::segment(1) == 'designation' || Request::segment(1) == 'job-stage'|| Request::segment(1) == 'performanceType'  || Request::segment(1) == 'job-category' || Request::segment(1) == 'terminationtype' ||
                                                                Request::segment(1) == 'awardtype' || Request::segment(1) == 'trainingtype' || Request::segment(1) == 'goaltype' || Request::segment(1) == 'paysliptype' ||
                                                                 Request::segment(1) == 'allowanceoption' || Request::segment(1) == 'loanoption' || Request::segment(1) == 'deductionoption') ? 'active dash-trigger' : ''}}">
                                        <a class="dash-link" href="{{route('branch.index')}}">{{__('HRM System Setup')}}</a>
                                    </li>


                                    {{--                                    <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'leavetype' || Request::segment(1) == 'document' || Request::segment(1) == 'performanceType' || Request::segment(1) == 'branch' || Request::segment(1) == 'department' || Request::segment(1) == 'designation' || Request::segment(1) == 'job-stage'|| Request::segment(1) == 'performanceType'  || Request::segment(1) == 'job-category' || Request::segment(1) == 'terminationtype' ||--}}
                                    {{--                                                                Request::segment(1) == 'awardtype' || Request::segment(1) == 'trainingtype' || Request::segment(1) == 'goaltype' || Request::segment(1) == 'paysliptype' || Request::segment(1) == 'allowanceoption' || Request::segment(1) == 'loanoption' || Request::segment(1) == 'deductionoption') ? 'active dash-trigger' : ''}}">--}}
                                    {{--                                        <a class="dash-link" href="{{route('branch.index')}}">{{__('HRM System Setup')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>--}}
                                    {{--                                        <ul class="dash-submenu">--}}
                                    {{--                                            @can('manage branch')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('branch*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('branch.index')}}">{{__('Branch')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage department')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('department*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('department.index')}}">{{__('Department')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage designation')--}}

                                    {{--                                                <li class="dash-item {{ (request()->is('designation*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('designation.index')}}">{{__('Designation')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage leave type')--}}
                                    {{--                                                <li class="dash-item  {{ (Request::route()->getName() == 'leavetype.index' ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('leavetype.index')}}">{{__('Leave Type')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage document type')--}}
                                    {{--                                                <li class="dash-item {{ (Request::route()->getName() == 'document.index' ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('document.index')}}">{{__('Document Type')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage payslip type')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('paysliptype*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('paysliptype.index')}}">{{__('Payslip Type')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage allowance option')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('allowanceoption*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('allowanceoption.index')}}">{{__('Allowance Option')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage loan option')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('loanoption*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('loanoption.index')}}">{{__('Loan Option')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage deduction option')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('deductionoption*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('deductionoption.index')}}">{{__('Deduction Option')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage goal type')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('goaltype*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('goaltype.index')}}">{{__('Goal Type')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage training type')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('trainingtype*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('trainingtype.index')}}">{{__('Training Type')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage award type')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('awardtype*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('awardtype.index')}}">{{__('Award Type')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage termination type')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('terminationtype*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('terminationtype.index')}}">{{__('Termination Type')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage job category')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('job-category*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('job-category.index')}}">{{__('Job Category')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage job stage')--}}
                                    {{--                                                <li class="dash-item {{ (request()->is('job-stage*') ? 'active' : '')}}">--}}
                                    {{--                                                    <a class="dash-link" href="{{route('job-stage.index')}}">{{__('Job Stage')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('manage performance type')--}}
                                    {{--                                                <li class="dash-item {{ request()->is('performanceType*') ? 'active' : '' }}">--}}
                                    {{--                                                    <a class="dash-link" href="{{ route('performanceType.index') }}">{{__('Performance Type')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}
                                    {{--                                            @can('Manage Competencies')--}}
                                    {{--                                                <li class="dash-item {{ request()->is('competencies*') ? 'active' : '' }}">--}}
                                    {{--                                                    <a class="dash-link" href="{{ route('competencies.index') }}">{{__('Competencies')}}</a>--}}
                                    {{--                                                </li>--}}
                                    {{--                                            @endcan--}}

                                    {{--                                        </ul>--}}
                                    {{--                                    </li>--}}
                                </ul>
                            </li>
                        @endif
                    @endif

                <!--------------------- End HRM ----------------------------------->

                    <!--------------------- Start Account ----------------------------------->

                    @if(\Auth::user()->show_account() == 1)
                        @if( Gate::check('manage customer') || Gate::check('manage vender'))
                            <li class="dash-item dash-hasmenu {{ (Request::route()->getName() == 'print-setting' || Request::segment(1) == 'customer' || Request::segment(1) == 'vender' || Request::segment(1) == 'proposal' || Request::segment(1) == 'bank-account' || Request::segment(1) == 'bank-transfer' || Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note' || Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' ||
                                    Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type' || (Request::segment(1) == 'transaction') &&  Request::segment(2) != 'ledger' &&  Request::segment(2) != 'balance-sheet' &&  Request::segment(2) != 'trial-balance' || Request::segment(1) == 'goal' || Request::segment(1) == 'budget'|| Request::segment(1) ==
                                    'chart-of-account' || Request::segment(1) == 'journal-entry' || Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance' || Request::segment(1) == 'bill' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note')?' active dash-trigger':''}}">
                                <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-box"></i></span><span class="dash-mtext">{{__('Accounting System ')}}</span><span class="dash-arrow">
                                        <i data-feather="chevron-right"></i></span>
                                </a>
                                <ul class="dash-submenu">
                                    @if(Gate::check('manage customer'))
                                        <li class="dash-item {{ (Request::segment(1) == 'customer')?'active':''}}">
                                            <a class="dash-link" href="{{route('customer.index')}}">{{__('Customer')}}</a>
                                        </li>
                                    @endif
                                    @if(Gate::check('manage vender'))
                                        <li class="dash-item {{ (Request::segment(1) == 'vender')?'active':''}}">
                                            <a class="dash-link" href="{{ route('vender.index') }}">{{__('Vendor')}}</a>
                                        </li>
                                    @endif
                                    @if(Gate::check('manage proposal'))
                                        <li class="dash-item {{ (Request::segment(1) == 'proposal')?'active':''}}">
                                            <a class="dash-link" href="{{ route('proposal.index') }}">{{__('Proposal')}}</a>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage bank account') ||  Gate::check('manage bank transfer'))
                                        <li class="dash-item dash-hasmenu {{(Request::segment(1) == 'bank-account' || Request::segment(1) == 'bank-transfer')? 'active dash-trigger' :''}}">
                                            <a class="dash-link" href="#">{{__('Banking')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                            <ul class="dash-submenu">
                                                <li class="dash-item {{ (Request::route()->getName() == 'bank-account.index' || Request::route()->getName() == 'bank-account.create' || Request::route()->getName() == 'bank-account.edit') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{ route('bank-account.index') }}">{{__('Account')}}</a>
                                                </li>
                                                <li class="dash-item {{ (Request::route()->getName() == 'bank-transfer.index' || Request::route()->getName() == 'bank-transfer.create' || Request::route()->getName() == 'bank-transfer.edit') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('bank-transfer.index')}}">{{__('Transfer')}}</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage invoice') ||  Gate::check('manage revenue') ||  Gate::check('manage credit note'))
                                        <li class="dash-item dash-hasmenu {{(Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note')? 'active dash-trigger' :''}}">
                                            <a class="dash-link" href="#">{{__('Income')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                            <ul class="dash-submenu">
                                                <li class="dash-item {{ (Request::route()->getName() == 'invoice.index' || Request::route()->getName() == 'invoice.create' || Request::route()->getName() == 'invoice.edit' || Request::route()->getName() == 'invoice.show') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{ route('invoice.index') }}">{{__('Invoice')}}</a>
                                                </li>
                                                <li class="dash-item {{ (Request::route()->getName() == 'revenue.index' || Request::route()->getName() == 'revenue.create' || Request::route()->getName() == 'revenue.edit') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('revenue.index')}}">{{__('Revenue')}}</a>
                                                </li>
                                                <li class="dash-item {{ (Request::route()->getName() == 'credit.note' ) ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('credit.note')}}">{{__('Credit Note')}}</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage bill')  ||  Gate::check('manage payment') ||  Gate::check('manage debit note'))
                                        <li class="dash-item dash-hasmenu {{(Request::segment(1) == 'bill' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note')? 'active dash-trigger' :''}}">
                                            <a class="dash-link" href="#">{{__('Expense')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                            <ul class="dash-submenu">
                                                <li class="dash-item {{ (Request::route()->getName() == 'bill.index' || Request::route()->getName() == 'bill.create' || Request::route()->getName() == 'bill.edit' || Request::route()->getName() == 'bill.show') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{ route('bill.index') }}">{{__('Bill')}}</a>
                                                </li>
                                                <li class="dash-item {{ (Request::route()->getName() == 'payment.index' || Request::route()->getName() == 'payment.create' || Request::route()->getName() == 'payment.edit') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('payment.index')}}">{{__('Payment')}}</a>
                                                </li>
                                                <li class="dash-item  {{ (Request::route()->getName() == 'debit.note' ) ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('debit.note')}}">{{__('Debit Note')}}</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                    @if( Gate::check('manage chart of account') ||  Gate::check('manage journal entry') ||   Gate::check('balance sheet report') ||  Gate::check('ledger report') ||  Gate::check('trial balance report'))
                                        <li class="dash-item dash-hasmenu {{(Request::segment(1) == 'chart-of-account' || Request::segment(1) == 'journal-entry' || Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance')? 'active dash-trigger' :''}}">
                                            <a class="dash-link" href="#">{{__('Double Entry')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                            <ul class="dash-submenu">
                                                <li class="dash-item {{ (Request::route()->getName() == 'chart-of-account.index') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{ route('chart-of-account.index') }}">{{__('Chart of Accounts')}}</a>
                                                </li>
                                                <li class="dash-item {{ (Request::route()->getName() == 'journal-entry.edit' || Request::route()->getName() == 'journal-entry.create' || Request::route()->getName() == 'journal-entry.index' || Request::route()->getName() == 'journal-entry.show') ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{ route('journal-entry.index') }}">{{__('Journal Account')}}</a>
                                                </li>
                                                <li class="dash-item {{ (Request::route()->getName() == 'report.ledger' ) ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('report.ledger')}}">{{__('Ledger Summary')}}</a>
                                                </li>
                                                <li class="dash-item {{ (Request::route()->getName() == 'report.balance.sheet' ) ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('report.balance.sheet')}}">{{__('Balance Sheet')}}</a>
                                                </li>
                                                <li class="dash-item {{ (Request::route()->getName() == 'trial.balance' ) ? ' active' : '' }}">
                                                    <a class="dash-link" href="{{route('trial.balance')}}">{{__('Trial Balance')}}</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                    @if(\Auth::user()->type =='company')
                                        <li class="dash-item {{ (Request::segment(1) == 'budget')?'active':''}}">
                                            <a class="dash-link" href="{{ route('budget.index') }}">{{__('Budget Planner')}}</a>
                                        </li>
                                    @endif
                                    @if(Gate::check('manage goal'))
                                        <li class="dash-item {{ (Request::segment(1) == 'goal')?'active':''}}">
                                            <a class="dash-link" href="{{ route('goal.index') }}">{{__('Financial Goal')}}</a>
                                        </li>
                                    @endif
                                    @if(Gate::check('manage constant tax') || Gate::check('manage constant category') ||Gate::check('manage constant unit') ||Gate::check('manage constant payment method') ||Gate::check('manage constant custom field') )
                                        <li class="dash-item {{(Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')? 'active dash-trigger' :''}}">
                                            <a class="dash-link" href="{{ route('taxes.index') }}">{{__('Accounting Setup')}}</a>
                                            {{--                                            <ul class="dash-submenu">--}}
                                            {{--                                                @can('manage constant tax')--}}
                                            {{--                                                    <li class="dash-item {{ (Request::route()->getName() == 'taxes.index' ) ? ' active' : '' }}">--}}
                                            {{--                                                        <a class="dash-link" href="{{ route('taxes.index') }}">{{__('Taxes')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}
                                            {{--                                                @can('manage constant category')--}}
                                            {{--                                                    <li class="dash-item {{ (Request::route()->getName() == 'product-category.index' ) ? 'active' : '' }}">--}}
                                            {{--                                                        <a class="dash-link" href="{{route('product-category.index')}}">{{__('Category')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}
                                            {{--                                                @can('manage constant unit')--}}
                                            {{--                                                    <li class="dash-item {{ (Request::route()->getName() == 'product-unit.index' ) ? ' active' : '' }}">--}}
                                            {{--                                                        <a class="dash-link" href="{{route('product-unit.index')}}">{{__('Unit')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}
                                            {{--                                                @can('manage constant custom field')--}}
                                            {{--                                                    <li class="dash-item {{ (Request::route()->getName() == 'custom-field.index' ) ? 'active' : '' }}   ">--}}
                                            {{--                                                        <a class="dash-link" href="{{route('custom-field.index')}}">{{__('Custom Field')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}

                                            {{--                                            </ul>--}}
                                        </li>
                                    @endif

                                    @if(Gate::check('manage print settings'))
                                        <li class="dash-item {{ (Request::route()->getName() == 'print-setting') ? ' active' : '' }}">
                                            <a class="dash-link" href="{{ route('print.setting') }}">{{__('Print Settings')}}</a>
                                        </li>
                                    @endif

                                </ul>
                            </li>
                        @endif
                    @endif

                <!--------------------- End Account ----------------------------------->

                    <!--------------------- Start CRM ----------------------------------->

                    @if(\Auth::user()->show_crm() == 1)
                        @if( Gate::check('manage lead') || Gate::check('manage deal') || Gate::check('manage form builder'))
                            <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'deals' || Request::segment(1) == 'leads'  || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response')?' active dash-trigger':''}}">
                                <a href="#!" class="dash-link"
                                ><span class="dash-micon"><i class="ti ti-layers-difference"></i></span
                                    ><span class="dash-mtext">{{__('CRM System')}}</span
                                    ><span class="dash-arrow"><i data-feather="chevron-right"></i></span
                                    ></a>
                                <ul class="dash-submenu {{ (Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'leads'  || Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response' || Request::segment(1) == 'deals' || Request::segment(1) == 'pipelines')?'show':''}}">
                                    @can('manage lead')
                                        <li class="dash-item {{ (Request::route()->getName() == 'leads.list' || Request::route()->getName() == 'leads.index' || Request::route()->getName() == 'leads.show') ? ' active' : '' }}">
                                            <a class="dash-link" href="{{ route('leads.index') }}">{{__('Leads')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage deal')
                                        <li class="dash-item {{ (Request::route()->getName() == 'deals.list' || Request::route()->getName() == 'deals.index' || Request::route()->getName() == 'deals.show') ? ' active' : '' }}">
                                            <a class="dash-link" href="{{route('deals.index')}}">{{__('Deals')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage form builder')
                                        <li class="dash-item {{ (Request::segment(1) == 'form_builder' || Request::segment(1) == 'form_response')?'active open':''}}">
                                            <a class="dash-link" href="{{route('form_builder.index')}}">{{__('Form Builder')}}</a>
                                        </li>
                                    @endcan
                                    @if(\Auth::user()->type=='company' || \Auth::user()->type=='client')
                                        <li class="dash-item  {{ (Request::segment(1) == 'contract')?'active':''}}">
                                            <a class="dash-link" href="{{route('contract.index')}}">{{__('Contract')}}</a>
                                        </li>
                                    @endif
                                    @if(Gate::check('manage lead stage') || Gate::check('manage pipeline') ||Gate::check('manage source') ||Gate::check('manage label') || Gate::check('manage stage'))
                                        <li class="dash-item  {{(Request::segment(1) == 'stages' || Request::segment(1) == 'labels' || Request::segment(1) == 'sources' || Request::segment(1) == 'lead_stages' || Request::segment(1) == 'pipelines' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')? 'active dash-trigger' :''}}">
                                            <a class="dash-link" href="{{ route('pipelines.index') }}   ">{{__('CRM System Setup')}}</a>
                                            {{--                                            <ul class="dash-submenu">--}}
                                            {{--                                                @can('manage pipeline')--}}
                                            {{--                                                    <li class="dash-item  {{ (Request::route()->getName() == 'pipelines.index' ) ? ' active' : '' }}">--}}
                                            {{--                                                        <a class="dash-link" href="{{ route('pipelines.index') }}">{{__('Pipeline')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}
                                            {{--                                                @can('manage lead stage')--}}
                                            {{--                                                    <li class="dash-item {{ (Request::route()->getName() == 'lead_stages.index' ) ? 'active' : '' }}">--}}
                                            {{--                                                        <a class="dash-link" href="{{route('lead_stages.index')}}">{{__('Lead Stages')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}
                                            {{--                                                @can('manage stage')--}}
                                            {{--                                                    <li class="dash-item {{ (Request::route()->getName() == 'stages.index' ) ? 'active' : '' }}">--}}
                                            {{--                                                        <a class="dash-link" href="{{route('stages.index')}}">{{__('Deal Stages')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}
                                            {{--                                                @can('manage source')--}}
                                            {{--                                                    <li class="dash-item {{ (Request::route()->getName() == 'sources.index' ) ? ' active' : '' }}">--}}
                                            {{--                                                        <a class="dash-link" href="{{route('sources.index')}}">{{__('Sources')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}
                                            {{--                                                @can('manage label')--}}
                                            {{--                                                    <li class="dash-item {{ (Request::route()->getName() == 'labels.index' ) ? 'active' : '' }}">--}}
                                            {{--                                                        <a class="dash-link" href="{{route('labels.index')}}">{{__('Labels')}}</a>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                @endcan--}}
                                            {{--                                                <li class="dash-item {{ (Request::segment(1) == 'contractType')?'active open':''}}">--}}
                                            {{--                                                    <a class="dash-link" href="{{ route('contractType.index') }}">{{__('Contract Type')}}</a>--}}
                                            {{--                                                </li>--}}
                                            {{--                                            </ul>--}}
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif

                <!--------------------- End CRM ----------------------------------->

                    <!--------------------- Start Project ----------------------------------->

                    @if(\Auth::user()->show_project() == 1)
                        @if( Gate::check('manage project'))
                            <li class="dash-item dash-hasmenu {{ ( Request::segment(1) == 'project' || Request::segment(1) == 'bugs-report' || Request::segment(1) == 'bugstatus' || Request::segment(1) == 'project-task-stages' || Request::segment(1) == 'calendar' || Request::segment(1) == 'timesheet-list' || Request::segment(1) == 'taskboard' || Request::segment(1) == 'timesheet-list' || Request::segment(1) == 'taskboard' || Request::segment(1) == 'project' || Request::segment(1) == 'projects')
                            ? 'active dash-trigger' : ''}}">
                                <a href="#!" class="dash-link"
                                ><span class="dash-micon"><i class="ti ti-share"></i></span
                                    ><span class="dash-mtext">{{__('Project System')}}</span
                                    ><span class="dash-arrow"><i data-feather="chevron-right"></i></span
                                    ></a>
                                <ul class="dash-submenu">
                                    @can('manage project')
                                        <li class="dash-item  {{Request::segment(1) == 'project' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.list' ||Request::route()->getName() == 'projects.index' || Request::route()->getName() == 'projects.show' || request()->is('projects/*') ? 'active' : ''}}">
                                            <a class="dash-link" href="{{route('projects.index')}}">{{__('Projects')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage project task')
                                        <li class="dash-item {{ (request()->is('taskboard*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{ route('taskBoard.view', 'list') }}">{{__('Tasks')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage timesheet')
                                        <li class="dash-item {{ (request()->is('timesheet-list*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{route('timesheet.list')}}">{{__('Timesheet')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage bug report')
                                        <li class="dash-item {{ (request()->is('bugs-report*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{route('bugs.view','list')}}">{{__('Bug')}}</a>
                                        </li>
                                    @endcan
                                    @can('manage project task')
                                        <li class="dash-item {{ (request()->is('calendar*') ? 'active' : '')}}">
                                            <a class="dash-link" href="{{ route('task.calendar',['all']) }}">{{__('Task Calender')}}</a>
                                        </li>
                                    @endcan
                                    @if(\Auth::user()->type!='super admin')
                                        <li class="dash-item  {{ (Request::segment(1) == 'time-tracker')?'active open':''}}">
                                            <a class="dash-link" href="{{ route('time.tracker') }}">{{__('Tracker')}}</a>
                                        </li>
                                    @endif
                                    @if(Gate::check('manage project task stage') || Gate::check('manage bug status'))
                                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'bugstatus' || Request::segment(1) == 'project-task-stages') ? 'active dash-trigger' : ''}}">
                                            <a class="dash-link" href="#">{{__('Project System Setup')}}<span class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                            <ul class="dash-submenu">
                                                @can('manage project task stage')
                                                    <li class="dash-item  {{ (Request::route()->getName() == 'project-task-stages.index') ? 'active' : '' }}">
                                                        <a class="dash-link" href="{{route('project-task-stages.index')}}">{{__('Project Task Stages')}}</a>
                                                    </li>
                                                @endcan
                                                @can('manage bug status')
                                                    <li class="dash-item {{ (Request::route()->getName() == 'bugstatus.index') ? 'active' : '' }}">
                                                        <a class="dash-link" href="{{route('bugstatus.index')}}">{{__('Bug Status')}}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif

                <!--------------------- End Project ----------------------------------->



                    <!--------------------- Start User Managaement System ----------------------------------->

                    @if(\Auth::user()->type!='super admin' && ( Gate::check('manage user') || Gate::check('manage role')))
                        <li class="dash-item dash-hasmenu">
                            <a href="#!" class="dash-link {{ (Request::segment(1) == 'users' || Request::segment(1) == 'roles' || Request::segment(1) == 'clients')?' active dash-trigger':''}}"
                            ><span class="dash-micon"><i class="ti ti-users"></i></span
                                ><span class="dash-mtext">{{__('User Management')}}</span
                                ><span class="dash-arrow"><i data-feather="chevron-right"></i></span
                                ></a>
                            <ul class="dash-submenu">
                                @can('manage user')
                                    <li class="dash-item {{ (Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit') ? ' active' : '' }}">
                                        <a class="dash-link" href="{{ route('users.index') }}">{{__('User')}}</a>
                                    </li>
                                @endcan
                                @can('manage role')
                                    <li class="dash-item {{ (Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'roles.create' || Request::route()->getName() == 'roles.edit') ? ' active' : '' }} ">
                                        <a class="dash-link" href="{{route('roles.index')}}">{{__('Role')}}</a>
                                    </li>
                                @endcan
                                @can('manage client')
                                    <li class="dash-item {{ (Request::route()->getName() == 'clients.index' || Request::segment(1) == 'clients' || Request::route()->getName() == 'clients.edit') ? ' active' : '' }}">
                                        <a class="dash-link" href="{{ route('clients.index') }}">{{__('Client')}}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif

                <!--------------------- End User Managaement System----------------------------------->


                    <!--------------------- Start Products System ----------------------------------->

                    @if( Gate::check('manage product & service') || Gate::check('manage product & service'))
                        <li class="dash-item dash-hasmenu">
                            <a href="#!" class="dash-link ">
                                <span class="dash-micon"><i class="ti ti-shopping-cart"></i></span><span class="dash-mtext">{{__('Products System')}}</span><span class="dash-arrow">
                                        <i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="dash-submenu">
                                @if(Gate::check('manage product & service'))
                                    <li class="dash-item {{ (Request::segment(1) == 'productservice')?'active':''}}">
                                        <a href="{{ route('productservice.index') }}" class="dash-link">{{__('Product & Services')}}
                                        </a>
                                    </li>
                                @endif
                                @if(Gate::check('manage product & service'))
                                    <li class="dash-item {{ (Request::segment(1) == 'productstock')?'active':''}}">
                                        <a href="{{ route('productstock.index') }}" class="dash-link">{{__('Product Stock')}}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                <!--------------------- End Products System ----------------------------------->




                    @if(\Auth::user()->type!='super admin')
                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'support')?'active':''}}">
                            <a href="{{route('support.index')}}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-headphones"></i></span><span class="dash-mtext">{{__('Support System')}}</span>
                            </a>
                        </li>
                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'zoom-meeting')?'active':''}}">
                            <a href="{{route('zoom-meeting.index')}}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-user-check"></i></span><span class="dash-mtext">{{__('Zoom Meeting')}}</span>
                            </a>
                        </li>
                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'chats')?'active':''}}">
                            <a href="{{ url('chats') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-message-circle"></i></span><span class="dash-mtext">{{__('Messenger')}}</span>
                            </a>
                        </li>
                    @endif

                <!--------------------- Start System Setup ----------------------------------->

                    @if( Gate::check('manage company plan') || Gate::check('manage order') || Gate::check('manage company settings'))
                        <li class="dash-item dash-hasmenu">
                            <a href="#!" class="dash-link ">
                                <span class="dash-micon"><i class="ti ti-settings"></i></span><span class="dash-mtext">{{__('System Setup')}}</span><span class="dash-arrow">
                                        <i data-feather="chevron-right"></i></span>
                            </a>
                            <ul class="dash-submenu">
                                @if(Gate::check('manage company settings'))
                                    <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'company-setting') ? ' active' : '' }}">
                                        <a href="{{ route('company.setting') }}" class="dash-link">{{__('System Settings')}}</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                @endif

                <!--------------------- End System Setup ----------------------------------->



                </ul>
            @endif
            @if((\Auth::user()->type == 'client'))
                <ul class="dash-navbar">
                    @if(Gate::check('manage client dashboard'))

                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'dashboard') ? ' active' : '' }}">
                            <a href="{{ route('client.dashboard.view') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-home"></i></span><span class="dash-mtext">{{__('Dashboard')}}</span>
                            </a>
                        </li>

                    @endif

                    @if(Gate::check('manage deal'))
                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'deals') ? ' active' : '' }}">
                            <a href="{{ route('deals.index') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-rocket"></i></span><span class="dash-mtext">{{__('Deals')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(Gate::check('manage project'))
                        <li class="dash-item dash-hasmenu  {{ (Request::segment(1) == 'projects') ? ' active' : '' }}">
                            <a href="{{ route('projects.index') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-share"></i></span><span class="dash-mtext">{{__('Project')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(Gate::check('manage project task'))
                        <li class="dash-item dash-hasmenu  {{ (Request::segment(1) == 'taskboard') ? ' active' : '' }}">
                            <a href="{{ route('taskBoard.view', 'list') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-list-check"></i></span><span class="dash-mtext">{{__('Tasks')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(Gate::check('manage bug report'))
                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'bugs-report') ? ' active' : '' }}">
                            <a href="{{ route('bugs.view','list') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-bug"></i></span><span class="dash-mtext">{{__('Bugs')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(Gate::check('manage timesheet'))
                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'timesheet-list') ? ' active' : '' }}">
                            <a href="{{ route('timesheet.list') }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-clock"></i></span><span class="dash-mtext">{{__('Timesheet')}}</span>
                            </a>
                        </li>
                    @endif

                    @if(Gate::check('manage project task'))
                        <li class="dash-item dash-hasmenu {{ (Request::segment(1) == 'calendar') ? ' active' : '' }}">
                            <a href="{{ route('task.calendar',['all']) }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-calendar"></i></span><span class="dash-mtext">{{__('Task Calender')}}</span>
                            </a>
                        </li>
                    @endif

                    <li class="dash-item dash-hasmenu">
                        <a href="{{route('support.index')}}" class="dash-link {{ (Request::segment(1) == 'support')?'active':''}}">
                            <span class="dash-micon"><i class="ti ti-headphones"></i></span><span class="dash-mtext">{{__('Support')}}</span>
                        </a>
                    </li>

                </ul>
            @endif
        </div>
    </div>
</nav>
