@extends('layouts.dashboard')
@section('content_dashboard')
 
 
<link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/fullcalendar.min.css')}}"/>
 
<div class="col-md-12" style="padding:20px;">
  
	<div class="col-md-12">
		<div class="panel box-v4">
			<div class="panel-heading bg-white border-none">
				<h4><span class="icon-notebook icons"></span> Agenda</h4>
			</div>
			<div class="panel-body padding-0">
				<div class="calendar">
                                          
				</div>
			</div>
		</div> 
	</div>
</div>
 

<!-- Modal -->
<div class="modal fade" id="eventContent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	   
		<blockquote class="blockquote-reverse">
			<p>Kode Pelanggan</p>
			<footer id="eventCustomer"></footer>
		</blockquote>
		
		<blockquote class="blockquote-reverse">
			<p>Alamat</p>
			<footer id="eventAddress"></footer>
		</blockquote>
		
		<blockquote class="blockquote-reverse">
			<p>Mulai</p>
			<footer id="startTime"></footer>
		</blockquote>
		
		<blockquote class="blockquote-reverse">
			<p>Selesai</p>
			<footer id="endTime"></footer>
		</blockquote>
		
		<blockquote class="blockquote-reverse">
			<p>Teknisi</p>
			<footer id="eventInfo"></footer>
		</blockquote>
		
		 
		 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('/miminium/js/jquery.min.js') }}"></script> 
<script src="{{ asset('/miminium/js/plugins/moment.min.js') }}"></script> 
<script src="{{ asset('/miminium/js/plugins/fullcalendar.min.js')}}"></script>
 
 
<script type="text/javascript">
	 "use strict";
	 
	 var today = moment().format('YYYY-MM-DD');
		 // start: Calendar =========
         $(".calendar").fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: today,
            businessHours: true, // display business hours
            editable: true,
            events: <?php echo json_encode($model);?>,
    eventRender: function (event, element) {
        element.attr('href', 'javascript:void(0);');
        element.click(function() {
            $("#eventTitle").html(event.title);
            $("#eventCustomer").html(event.customer);
            $("#startTime").html(event.mulai);
            $("#endTime").html(event.selesai);
            $("#eventAddress").html(event.address);
            $("#eventInfo").html(event.description);
            $("#eventContent").modal();
        });
    }
        });
        // end : Calendar========== 
	
</script>
@endsection
 