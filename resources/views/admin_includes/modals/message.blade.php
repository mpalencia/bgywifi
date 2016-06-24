<div class="modal fade" tabindex="-1" role="dialog" id="composeMsg">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title">Send a message</h4>
      </div>
      <div class="modal-body">

        	<form name="sendMessageFrm" id="sendMessageFrm">
        	  <div class="form-group">
			    <label for="home_owner_id">Choose Residential</label>
			  	<select class="form-control" name="home_owner_id" id="home_owner_id">
			  		<option value="0">Broadcast to all</option>
			  		@foreach($residentials as $k=>$v)
			  			<option value="{{$v->id}}">{{$v->first_name}} {{$v->last_name}}</option>
			  		@endforeach
			  	</select>
			  </div>

			  <div class="form-group">
			    <label for="name">Message</label>
			    <textarea class="form-control" name="message" id="message"></textarea>
			  </div>
			</form>

      </div>
      <div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="brgy.sendMessage('#sendMessageFrm','#sendMessage');">Send</button>
      </div>
    </div>
  </div>
</div>
