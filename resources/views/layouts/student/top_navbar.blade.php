<div class="row mb-3">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
		<ul id="main-navigation">
			<li><a href="{{ url('/student/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="{{ url('/student/course-lists') }}" class="{{ Request::segment(2) == 'course-lists' ? 'active' : '' }}"><i class="fa fa-file"></i> Courses</a></li>
			<li><a href="{{ url('/student/quiz') }}" class="{{ Request::segment(2) == 'quiz' ? 'active' : '' }}"><i class="fa fa-file"></i>&nbsp;Quiz/Test</a>
			</li>
			<li><a href="{{ url('/student/document') }}" class="{{ Request::segment(2) == 'document' ? 'active' : '' }}"><i class="fa fa-files-o"></i>
					Documents</a></li>
			<li><a href="{{ url('/student/certificate') }}" class="{{ Request::segment(2) == 'certificate' ? 'active' : '' }}"><i
						class="fa fa-bars"></i>&nbsp;Certificate</a></li>
			<li><a href="{{ url('/student/report') }}" class="{{ Request::segment(2) == 'report' ? 'active' : '' }}"><i
			class="fa fa-bars"></i>&nbsp;Report</a></li>
		</ul>
	</div>
</div>
