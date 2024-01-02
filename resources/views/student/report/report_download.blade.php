<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            padding: 50px;
            width: 700px;
            margin: 0 auto;
            font-size: 14px;
            line-height: 22px;
        }

        * {
            margin: 0px;
            padding: 0px;
        }

        img {
            max-width: 100%;
        }

        h3 {
            margin-bottom: 15px;
        }

        p {
            margin-bottom: 15px;
            font-size: 14px;
        }

        table {
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
        }

        table.datatable {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table.datatable td,
        table.datatable th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            font-size: 14px;
        }

        table.datatable tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <h3>Texas Driver Education Program or Organized Instruction</h3>
    <table class="datatable" style="100%">
        <thead>
            <th style="width: 140px">Texas Course Title</th>
            <th>Unit Time</th>
            <th>POI Instruction(Topics)</th>
        </thead>
        <tbody>
            @if (!blank($getCourseModule))
                @foreach ($getCourseModule as $val)
                    <tr>
                        <td style="width: 140px">Unit: {{ $val['name'] }}</td>
                        <td>{{ $val['duration'] }}</td>
                        <td>{!! $val['description'] !!}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h3>Teacher of Record</h3>
    <p>By my signature, I certify that I am responsible for all classroom Instruction RECORDED ON THIS FORM and TAUGHT
        by the TA-Full Instructors on this document, Further, I am responsible for the issuance of the completion
        certificates for this student, and the maintenance of the DE-964 form and all records surrounding this course,
        in compliance with law and rule in the state of Texas.</p>

    <table class="datatable" style="100%">
        <thead>
            <tr>
                <th>Lic#</th>
                <th>Cirtified</th>
                <th>Printed Name of Instructor</th>
                <th>Instructor Signature</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ isset($getLicense->get_license) ? $getLicense->get_license->license : '--' }}</td>
                <td>DET</td>
                <td>Sana Shaikh</td>
                <td width="180px"><img src="{{ public_path('images/signature.jpg') }}" alt="Instructor Signature">
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <h2>Drive Safe Driving School</h2>
    <p>
        2214 w Walnut Hill Ln Irving, TX 75038<br />
        +12143105000 | drivesafedrivingschool.com
    </p>

    <h2>INDIVIDUAL STUDENT RECORD(ISR)</h2>
    <p>(TEXAS TEA THEEN DRIVER EDUCATION ONLINE COURSE)</p>
    <br>

    <p>ISR GENERATED ON: DATE <br>COURSE VERSION:#4</P>

    <p><b>STUDENT:</b> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
    <p><b>DOB:</b> {{ Auth::user()->dob }}</p>
    <p><b>ADDRESS:</b> {{ Auth::user()->address1 }}</p>
    <p><b>CITY/STATE/ZIP:</b> {{ Auth::user()->city_town }}/{{ Auth::user()->postcode }}</p>
    <p><b>PHONE:</b> {{ Auth::user()->mobile_no }}</p>

    <br>
    <p>COURSE CONTENT (INSTRUCTION)</p>
    <table class="datatable">
        <thead>
            <tr>
                <th>Unit #</th>
                <th>Date Completed</th>
                <th>Time Spent(miniutes)</th>
                <th>Assesment Grade</th>
                <th>Make-up-date</th>
            </tr>
        </thead>
        <tbody>
            @php
                $end_date = '';
                $count = 1;
                $exam_percentage = 0;
            @endphp
            @if (!blank($getCourseActivities))
                @foreach ($getCourseActivities as $val)
                    @php
                        $datetime_1 = $val->start_date_time;
                        $datetime_2 = $val->end_date_time;

                        $start_datetime = new DateTime($datetime_1);
                        $diff = $start_datetime->diff(new DateTime($datetime_2));
                    @endphp
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $val->completed_date }}</td>
                        <td>{{ $diff->h }}:{{ $diff->i }}:{{ $diff->s }}</td>
                        <td>{{ $val->exam_percentage }}/100</td>
                        <td>{{ $val->created_at }}</td>
                    </tr>
                    @php
                        $count++;
                        $end_date = $val->completed_date;
                        $exam_percentage += $val->exam_percentage;
                    @endphp
                @endforeach
            @endif
        </tbody>
    </table>
    <p><b>Average Completion Grade Earned:
            {{ $exam_percentage > 0 ? number_format($exam_percentage / ($count - 1), 2) : 0 }}%</b></p>
    <p><b>Start Date: {{ date('d M Y', strtotime($getCoursePurchase->created_at)) }}</b></p>
    <p><b>End Date: {{ isset($end_date) && $end_date != '' ? date('d M Y', strtotime($end_date)) : '' }}</b></p>
    <br>

    <p><b>Signature of Student</b></p>
    <p>Hereby my signature, I certify that the information I have completed on this record are true and correct to my
        knowledge.</p>
    <br>

    <table class="datatable">
        <thead>
            <tr>
                <th>Lic#</th>
                <th>Cirtified</th>
                <th>Printed Name of Instructor</th>
                <th>Instructor Signature</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ isset($getLicense->get_license) ? $getLicense->get_license->license : '--' }}</td>
                <td>DET</td>
                <td>Sana Shaikh</td>
                <td width="180px"><img src="{{ public_path('images/signature.jpg') }}" alt="Instructor Signature"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
