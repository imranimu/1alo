@extends('layouts.admin.layer')
@section('title', 'Dashboard | Driving School')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="#">Home</a>

                <span class="divider">
                    <i class="icon-angle-right arrow-icon"></i>
                </span>
            </li>
            <li class="active">Dashboard</li>
        </ul>
        <!--.breadcrumb-->
    </div>

    <div class="page-content">

        <div class="row-fluid first-box">

            <div class="span3">
                <div class="panel box1">

                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="span3 icon">
                                <i class="fa fa-home fa-5x"></i>
                            </div>
                            <div class="span9 text-right">
                                <div class="huge">
                                    <br />{{ getCoursesCount() }}
                                </div>
                                <div>Total Courses</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('admin/course/course-lists') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>

                </div>
            </div>

            <div class="span3">
                <div class="panel box2">
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="span3 icon">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="span9 text-right">
                                <div class="huge">
                                    <br />{{ getCoursesModuleCount() }}
                                </div>
                                <div>Total Module</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('admin/course/course-lists') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="panel box3">
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="span3 icon">
                                <i class="fa fa-inr fa-5x"></i>
                            </div>
                            <div class="span9 text-right">
                                <div class="huge">
                                    <br />{{ getCoursesLessonCount() }}
                                </div>
                                <div>Total Lesson</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('admin/course/course-lists') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="panel box4">
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="span3 icon">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="span9 text-right">
                                <div class="huge">
                                    <br />{{ getQuestionCount() }}
                                </div>
                                <div>Total Question</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('admin/question/exam-show') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="row-fluid second-box">

            <div class="span3">
                <div class="panel box1">

                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="span3 icon">
                                <i class="fa fa-home fa-5x"></i>
                            </div>
                            <div class="span9 text-right">
                                <div class="huge">
                                    <br />{{ getDocumentCount() }}
                                </div>
                                <div>Total Document</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('admin/document/show') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>

                </div>
            </div>

            <div class="span3">
                <div class="panel box2">
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="span3 icon">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="span9 text-right">
                                <div class="huge">
                                    <br />{{ getLicenseCount() }}
                                </div>
                                <div>Available License</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('admin/license/add-license') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="panel box3">
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="span3 icon">
                                <i class="fa fa-inr fa-5x"></i>
                            </div>
                            <div class="span9 text-right">
                                <div class="huge">
                                    <br />{{ getCertificateGenerateCount() }}
                                </div>
                                <div>Total Certificate Generate</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('admin/certificate') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="span3">
                <div class="panel box4">
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="span3 icon">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="span9 text-right">
                                <div class="huge">
                                    <br />{{ getTodayPaymentAmount() }}
                                </div>
                                <div>Today Payment</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('admin/payment/show') }}">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="row-fluid second-box">
            <div class="span8">
                <canvas id="chart"></canvas>
            </div>
            <div class="span4">
                <canvas id="oilChart" width="600" height="400"></canvas>
            </div>
        </div>
    </div>
    @php
        $month = getAllPaymentAmount()['month'] != '' ? implode(', ', getAllPaymentAmount()['month']) : '';
        $amount = getAllPaymentAmount()['amount'] != '' ? implode(', ', getAllPaymentAmount()['amount']) : '';
    @endphp
    <script>
        var data = {
            labels: [{!! $month !!}],
            datasets: [{
                label: "Payment History",
                backgroundColor: "rgba(255,99,132,0.2)",
                borderColor: "rgba(255,99,132,1)",
                borderWidth: 2,
                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                hoverBorderColor: "rgba(255,99,132,1)",
                data: [{!! $amount !!}],
            }]
        };

        var options = {
            maintainAspectRatio: false,
            scales: {
                y: {
                    stacked: true,
                    grid: {
                        display: true,
                        color: "rgba(255,99,132,0.2)"
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        };

        new Chart('chart', {
            type: 'bar',
            options: options,
            data: data
        });

        var oilCanvas = document.getElementById("oilChart");
        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;

        var oilData = {
            labels: [
                "Admin",
                "Student",
            ],
            datasets: [{
                data: [{{ getAllUserCount()['admin'] }}, {{ getAllUserCount()['student'] }}],
                backgroundColor: [
                    "#63FF84",
                    "#8463FF",
                ]
            }]
        };

        var pieChart = new Chart(oilCanvas, {
            type: 'pie',
            data: oilData
        });
    </script>

    <style>
        body #chart {
            height: 383px !important;
        }

        .box1 {
            color: white;
            background-color: #4ABDAC;
            border: 1px solid #4ABDAC;
            font-size: 15px;
        }

        .box1 a {
            color: #4ABDAC;
        }

        .box2 {
            color: white;
            background-color: #F7882F;
            border: 1px solid #F7882F;
            font-size: 15px;
        }

        .box2 a {
            color: #F7882F;
        }

        .box3 {
            color: white;
            background-color: #6C648B;
            border: 1px solid #6C648B;
            font-size: 15px;
        }

        .box3 a {
            color: #6C648B;
        }

        .box4 {
            color: white;
            background-color: #CF6766;
            border: 1px solid #CF6766;
            font-size: 15px;
        }

        .box4 a {
            color: #CF6766;
        }

        .panel-footer {
            padding: 10px 15px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            border-bottom-right-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        .span9.text-right {
            padding: 0 15px;
        }

        .span3.icon {
            padding: 0 15px;
        }

        .row-fluid.first-box {
            margin-top: 14px;
        }

        .row-fluid.second-box {
            margin-top: 24px;
        }
    </style>
@endsection
