@extends('layouts.admin.layer')
@section('title', 'Course Preview | Driving School')
@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item">Course Preview ></li>
                        <li class="breadcrumb-item active">{{ !blank($getCourses) ? $getCourses->title : '' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- course area start -->
    <div class="course-area">

        <div class="container bg-white py-3">

            <a href="{{ url('admin/course/course-preview') }}" class="btn btn-primary btn-sm mb-3"><i
                    class="fa fa-arrow-left"></i>&nbsp;Back</a>

            @php
                $playerson = (int) preg_replace('/[^0-9]/', '', $lession_complete);
                $maxplayers = (int) preg_replace('/[^0-9]/', '', $getModuleHistory[0]->total_lession);
                $percentage = ($playerson / $maxplayers) * 100;
                $percentage = number_format($percentage, 2);
            @endphp
            {{-- <div class="progress my-5">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100" style="width:{{ $percentage }}%">
                </div>
                <label for="progress" class="progressLabel">{{ $percentage }}% Completed.</label>
            </div> --}}

            <div class="row" style="margin-left: 0;">
                <div class="col-2">
                    @php
                        $previous_id = 0;
                        if (!blank($previous_record)):
                            $previous_id = $previous_record->id;
                        endif;
                    @endphp

                    @if (Request::segment(5) == 0 && Request::segment(6) == 2)
                        <a href="javascript:void(0)" class="btn btn-success btn-zoomed btn-prev ButtonWidth">
                            <i class="fa fa-arrow-circle-o-left"></i> Previous
                        </a>
                    @else
                        <a href="{{ url('admin/course/preview/' . Request::segment(4) . '/' . Request::segment(5) . '/' . $previous_id . '/1') }}"
                            class="btn btn-success btn-zoomed btn-prev ButtonWidth">
                            <i class="fa fa-arrow-circle-o-left"></i> Previous
                        </a>
                    @endif

                </div>

                <div class="col-2">
                    <a href="javascript:void(0);" onclick="chooseBook()" class="btn btn-primary">Select Book
                        or Chapter</a>
                </div>

                <div class="col-2">
                    <select class="book_page form-control"
                        style="height: 46px !important; width: 100%; margin: 0px; border-radius: 10px;"
                        onchange="changeLession(this.value)">
                        <option value="">Select Lession</option>
                        @if (!blank(getCourseLession($course_id, $module_id)))
                            @foreach (getCourseLession($course_id, $module_id) as $lession)
                                <option value="{{ $lession->id }}"
                                    {{ Request::segment(6) == $lession->id ? 'selected' : '' }}>
                                    {{ $lession->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-4 voice_div">
                    @php
                        $audio_disable = '';
                        if (isset($getCourseLession->lesson_type) && (Request::segment(6) == 0 || $getCourseLession->lesson_type == 'video' || $getCourseLession->audio != '' || $getCourseLession->lesson_type != 'pdf')):
                            $audio_disable = 'pointer-events:none';
                        endif;
                    @endphp
                    @if (!blank($getCourseLession) && $getCourseLession->audio != '')
                        <audio controls="" autoplay="" style="width:100%;margin-top:2px;">
                            <source
                                src="{{ asset('storage/app/public/files/' . $module_id . '/' . $getCourseLession->audio) }}"
                                type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    @else
                        <audio controls="" autoplay="" style="width:100%;margin-top:2px; {{ $audio_disable }}">
                            <source src="#" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    @endif
                </div>
                <div class="col-2">
                    @php
                        $next_id = 0;
                        if (!blank($next_record)):
                            $next_id = $next_record->id;
                        endif;
                    @endphp
                    @if (Request::segment(6) == 0 && $forward == 2)
                        Module completed
                    @else
                        <a href="{{ url('admin/course/preview/' . Request::segment(4) . '/' . Request::segment(5) . '/' . $next_id . '/2') }}"
                            class="btn btn-success pull-right ButtonWidth">
                            Next&nbsp;<i class="fa fa-arrow-circle-o-right"></i>
                        </a>
                    @endif
                </div>
            </div>

            <hr>

            <div class="book-page" style="margin:0px;padding:0px;">

                <div class="with_bg_page">
                    @if (Request::segment(6) == '0' && $forward != '2')
                        <div class="row">
                            <a href="{{ url('admin/course/preview/' . Request::segment(4) . '/' . Request::segment(5) . '/' . $next_id . '/2') }}"
                                class="take_the_test">Lets start <i class="fa fa-arrow-right"></i></a>
                        </div>
                    @elseif (Request::segment(6) == 0 && $forward == 2)
                        @if ($lession_complete == $getModuleHistory[0]->total_lession && $getModuleHistory[0]->module_status == 1)
                            <div class="row" style="text-align: center; display: block">
                                <h3>Congratulations</h3>
                                <p>You have completed the module
                                <p>
                            </div>
                        @endif
                    @else
                        @php
                            $extension = '';
                            if (isset($getCourseLession->text_pdf)):
                                $extension = pathinfo(storage_path('files/' . $module_id . '/' . $getCourseLession->text_pdf), PATHINFO_EXTENSION);
                            endif;
                        @endphp
                        @if (isset($getCourseLession->lesson_type) && $getCourseLession->lesson_type == 'video')
                            <video width="100%" controls>
                                <source
                                    src="{{ asset('storage/app/public/files/' . $module_id . '/' . $getCourseLession->video) }}"
                                    type="video/mp4">
                                Your browser does not support HTML video.
                            </video>
                        @elseif (isset($getCourseLession->lesson_type) && $getCourseLession->lesson_type == 'audio')
                            @if ($getCourseLession->text_pdf != '')
                                @if (in_array($extension, ['jpeg', 'jpg', 'png']))
                                    <img src="{{ asset('storage/app/public/files/' . $module_id . '/' . $getCourseLession->text_pdf) }}"
                                        class="img img-resposive">
                                @elseif (in_array($extension, ['doc', 'docx']))
                                    <iframe
                                        src="https://view.officeapps.live.com/op/view.aspx?src={{ url('storage/app/public/files/' . $module_id . '/' . $getCourseLession->text_pdf) }}"
                                        frameborder="0" style="width: 100%; min-height: 600px;"></iframe>
                                @else
                                    <iframe
                                        src="{{ asset('storage/app/public/files/' . $module_id . '/' . $getCourseLession->text_pdf) }}"
                                        width="100%" height="800px">
                                    </iframe>
                                @endif
                            @endif
                        @elseif (isset($getCourseLession->lesson_type) && $getCourseLession->lesson_type == 'pdf')
                            @if ($getCourseLession->text_pdf != '')
                                @if (in_array($extension, ['jpeg', 'jpg', 'png']))
                                    <img src="{{ asset('storage/app/public/files/' . $module_id . '/' . $getCourseLession->text_pdf) }}"
                                        class="img img-resposive">
                                @elseif (in_array($extension, ['doc', 'docx']))
                                    <iframe
                                        src="https://view.officeapps.live.com/op/view.aspx?src={{ url('storage/app/public/files/' . $module_id . '/' . $getCourseLession->text_pdf) }}"
                                        frameborder="0" style="width: 100%; min-height: 600px;"></iframe>
                                @else
                                    <iframe
                                        src="{{ asset('storage/files/' . $module_id . '/' . $getCourseLession->text_pdf) }}"
                                        width="100%" height="800px">
                                    </iframe>
                                @endif
                            @endif
                        @endif
                    @endif
                </div>
            </div>

            <div class="modal fade" id="chooseBook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Choose Book or a Chapter</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('admin/course/preview/course-module-change') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Book:</label>
                                    <input type="text" class="form-control select_book" name=""
                                        value="{{ getCourseName($course_id) }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="email">Chapter:</label>
                                    <select name="module_id" class="form-control select_module">
                                        <option value="">Select</option>
                                        @if (!blank($getCoursesModule))
                                            @foreach ($getCoursesModule as $module)
                                                <option value="{{ $module->id }}"
                                                    {{ Request::segment(5) == $module->id ? 'selected' : '' }}>
                                                    {{ $module->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <input type="hidden" value="{{ Request::segment(4) }}" name="courses_id" />
                                <button type="submit" class="mt-2 btn btn-primary pull-right go_module_btn">Go</button>
                            </form>
                            <div style="float:none;clear:both"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                aria-label="Close">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        a.take_the_test {
            background-color: #a61e4d;
            color: #eee;
            padding: 15px 25px;
            border: none;
            text-align: center;
            margin: 15px auto;
        }

        a.take_the_test:hover {
            background-color: #d6336c;
        }

        .course-area {
            padding: 30px 0px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .col-2,
        .col-4 {
            display: inline-block;
            vertical-align: middle;
        }

        .col-2 {
            width: 16%;
        }

        .col-4 {
            width: 33.333333%;
        }

        body .btn {
            border-radius: 10px;
        }

        .ButtonWidth {
            width: 70%;
        }
    </style>
    <script>
        // (function() {
        // if (window.localStorage) {
        // if (!localStorage.getItem('firstLoad')) {
        // localStorage['firstLoad'] = true;
        // window.location.reload();
        // } else
        // localStorage.removeItem('firstLoad');
        // }
        // })();

        function chooseBook() {
            $('#chooseBook').modal('show');
        }

        function changeLession(id) {
            let lesstionID = {{ Request::segment(5) }};
            let lessionProgress = 1;
            if (id > lesstionID) {
                lessionProgress = 2;
            }
            let urlPath = '{{ url('admin/course/preview/' . Request::segment(4) . '/' . Request::segment(5)) }}/' + id +
                '/' +
                lessionProgress;
            window.location.href = urlPath;
        }
    </script>
@endsection
