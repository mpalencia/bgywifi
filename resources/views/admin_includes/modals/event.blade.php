<div class="modal fade" tabindex="-1" role="dialog" id="addEvent">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title">Add New Event</h4>
      </div>
      <div class="modal-body">
        
        	<form name="addEventFrm" id="addEventFrm">
        	  <div class="form-group">
			    <label for="home_owner_id">Choose Residential</label>
			  	<select class="form-control" name="home_owner_id" id="home_owner_id">
			  		<option></option>
			  	</select>
			  </div>
			  <div class="form-group">	
			    <label for="event_category">Event Category</label>
			    <select class="form-control" name="event_category" id="event_category">
			  		<option></option>
			  	</select>
			  </div>
			  <div class="form-group">
			    <label for="name">Event Name</label>
			    <input type="text" class="form-control" id="name" placeholder="Event Name">
			  </div>
			  <div class="form-group">
			    <label for="start">Start Date</label>
			    <div class='input-group date' id='start'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
			  </div>
			  <div class="form-group">
			    <label for="end">End Date</label>
			    <input type="date" class="form-control" id="end" placeholder="End Date">
			  </div>
			  <div class="form-group">	
			    <label for="status">Status</label>
			    <select class="form-control" name="status" id="status">
			  		<option value="0">Active</option>
			  		<option value="1">Not Active</option>
			  	</select>
			  </div>
			</form>

      </div>
      <div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	<button type="button" class="btn btn-primary" onclick="brgy.addEvent('#addEventFrm','#addEvent','events');">Save</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="editEvent">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title">Edit Event</h4>
      </div>
      <div class="modal-body">
        
        	<form name="editEventFrm" id="editEventFrm">
        	  <div class="form-group">
			    <label for="home_owner_id">Choose Residential</label>
			  	<select class="form-control" name="home_owner_id" id="home_owner_id">
			  		<option></option>
			  	</select>
			  </div>
			  <div class="form-group">	
			    <label for="event_category">Event Category</label>
			    <select class="form-control" name="event_category" id="event_category">
			  		<option></option>
			  	</select>
			  </div>
			  <div class="form-group">
			    <label for="name">Event Name</label>
			    <input type="text" class="form-control" id="name" placeholder="Event Name">
			  </div>
			  <div class="form-group">
			    <label for="start">Start Date</label>
			    <input type="date" class="form-control" id="start" placeholder="Start Date">
			  </div>
			  <div class="form-group">	
			    <label for="status">Status</label>
			    <select class="form-control" name="status" id="status">
			  		<option value="0">Active</option>
			  		<option value="1">Not Active</option>
			  	</select>
			  </div>
			</form>

      </div>
      <div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	<button type="button" class="btn btn-primary" onclick="brgy.editEvent('#editEventFrm','#editEvent','events');">Save</button>
      </div>
    </div>
  </div>
</div>