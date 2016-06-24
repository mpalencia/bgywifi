<div class="modal fade" id="markasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="unidentified-homeowner"></span></h4>
        <h5 class="modal-title" id="myModalLabel"><span class="emergency-date"></span></h5>
      </div>
      <div class="modal-body">
        <h4 align="center"><span class="unidentified-title"></span></h4>
        <span id="unidentified-action-taken"></span>

        <form name="editMarkAsUpdate" id="editMarkAsUpdateForm">
          <div class="alert alert-danger editMarkAsUpdateAlert" role="alert" id="editMarkAsUpdateAlert">Emergency Type is required.</div>
          <div class="form-group">
            <input type="hidden" class="form-control home_owner_id" id="home_owner_id">
            <input type="hidden" class="form-control security_guard_id" id="security_guard_id">
            <input type="hidden" class="form-control unidentified_id" id="unidentified_id">
            <label for="last_name">Set Emergency Type</label>
            <select name="emergency_type_id" class="form-control emergency_type_id" id="emergency_type_id">
              <option value="0">Select Action Taken</option>
              @foreach($emergency_type as $et)
                <option value="<?=$et['id']?>"><?=$et['description']?></option>
              @endforeach
            </select>
          </div>
          <button type="button" class="btn btn-primary btn-block markAsUpdate"  id="markAsUpdateBtn" onclick="brgy.editMarkAsUpdate('#editMarkAsUpdateForm','#markasModal');">Update</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="unidentifiedModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="unidentified-homeowner"></span></h4>
        <h5 class="modal-title" id="myModalLabel"><span class="emergency-date"></span></h5>
      </div>
      <div class="modal-body">
        <h4 align="center"><span class="unidentified-title"></span></h4>
        <span id="unidentified-action-taken"></span>
      <div class="dataTable_wrapper">
        <table class="table table-striped table-bordered table-hover" id="unidentifiedUpdateAjax"></table>
      </div>
        <hr>
        <form name="editActionTaken" id="editUnidentifiedActionTakenForm">
          <div class="alert alert-danger actionTakenFieldAlert" role="alert" id="actionTakenFieldAlert">Action Taken field is required.</div>
        <div class="form-group">
          <input type="hidden" class="form-control home_owner_id" id="home_owner_id">
          <input type="hidden" class="form-control security_guard_id" id="security_guard_id">
          <input type="hidden" class="form-control unidentified_id" id="unidentified_id">
          <label for="last_name">Action Taken</label>
          <select name="actionTakenType" class="form-control action_taken_type_unidentified" id="action_taken_type_unidentified">
            <option value="0">Select Action Taken</option>
            @foreach($actionTakenType as $at)
              <option value="<?=$at['id']?>"><?=$at['message']?></option>
            @endforeach
          </select>
        </div>
        <button type="button" class="btn btn-primary btn-block actionTakenTypeBtn"  id="actionTakenTypeBtn" onclick="brgy.editActionTaken('#editUnidentifiedActionTakenForm','#unidentifiedModal');">Update</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="emergencyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="emergency-homeowner"></span></h4>
        <h5 class="modal-title" id="myModalLabel"><span class="emergency-date"></span></h5>
      </div>
      <div class="modal-body">
      	<h4 align="center"><span class="emergency-title"></span></h4>
      	<span id="emergency-action-taken"></span>
		  <div class="dataTable_wrapper">
			  <table class="table table-striped table-bordered table-hover" id="emergencyUpdateAjax"></table>
		  </div>
      	<hr>
      	<form name="editActionTaken" id="editEmergencyActionTakenForm">
      		<div class="alert alert-danger actionTakenFieldAlert" role="alert" id="actionTakenFieldAlert">Action Taken field is required.</div>
		  	<div class="form-group">
		  		<input type="hidden" class="form-control home_owner_id" id="home_owner_id">
		  		<input type="hidden" class="form-control security_guard_id" id="security_guard_id">
		  		<input type="hidden" class="form-control emergency_id" id="emergency_id">
			    <label for="last_name">Action Taken</label>
			    <select name="actionTakenType" class="form-control action_taken_type" id="action_taken_type">
		    		<option value="0">Select Action Taken</option>
			    	@foreach($actionTakenType as $at)
			    		<option value="<?=$at['id']?>"><?=$at['message']?></option>
			    	@endforeach
			    </select>
		  	</div>
		  	<button type="button" class="btn btn-primary btn-block actionTakenTypeBtn"  id="actionTakenTypeBtn" onclick="brgy.editActionTaken('#editEmergencyActionTakenForm','#emergencyModal');">Update</button>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="resolvedEmergencyLabel" onclick="brgy.reopenEmergency('#editEmergencyActionTakenForm','#emergencyModal')" class="btn btn-danger pull-left" data-toggle="button" aria-pressed="false" autocomplete="off">
          Reopen Issue
        </button>
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cautionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="caution-homeowner"></span></h4>
        <h5 class="modal-title" id="myModalLabel"><span class="caution-date"></span></h5>
      </div>
      <div class="modal-body">
      	<h4 align="center"><span class="caution-title"></span></h4>
      	<span id="caution-action-taken"></span>
		  <div class="dataTable_wrapper">
			  <table class="table table-striped table-bordered table-hover" id="cautionUpdateAjax"></table>
		  </div>
      	<hr>
      	<form name="editActionTaken" id="editCautionActionTakenForm">
      		<div class="alert alert-danger actionTakenFieldAlert" role="alert" id="actionTakenFieldAlert">Action Taken field is required.</div>
		  	<div class="form-group">
		  		<input type="hidden" class="form-control home_owner_id" id="home_owner_id">
		  		<input type="hidden" class="form-control security_guard_id" id="security_guard_id">
		  		<input type="hidden" class="form-control caution_id" id="caution_id">
			    <label for="last_name">Action Taken</label>
			    <select name="actionTakenType" class="form-control caution_action_taken_type" id="action_taken_type">
			    		<option value="0">Select Action Taken</option>
			    	@foreach($actionTakenType as $at)
			    		<option value="<?=$at['id']?>"><?=$at['message']?></option>
			    	@endforeach
			    </select>
		  	</div>
		  	<button type="button" class="btn btn-primary btn-block actionTakenTypeBtn"  id="actionTakenTypeBtn" onclick="brgy.editActionTaken('#editCautionActionTakenForm','#cautionModal');">Update</button>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="resolvedCautionLabel" onclick="brgy.reopenCaution('#editCautionActionTakenForm','#cautionModal')" class="btn btn-danger pull-left" data-toggle="button" aria-pressed="false" autocomplete="off">
          Reopen Issue
        </button>
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="addEmergencyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add New Emergency</span></h4>
      </div>
      <div class="modal-body">
        <form name="addEmergency" id="addEmergencyForm">
            <div class="alert alert-danger actionTakenFieldAlert" role="alert" id="actionTakenFieldAlert">Action Taken field is required.</div>
            <div class="form-group">
                <input type="hidden" class="form-control home_owner_id" id="home_owner_id">
                <input type="hidden" class="form-control security_guard_id" id="security_guard_id">
                <input type="hidden" class="form-control emergency_id" id="emergency_id">
                <label for="last_name">Action Taken</label>
                <select name="actionTakenType" class="form-control action_taken_type" id="action_taken_type">
                    <option value="0">Select Action Taken</option>
                    @foreach($actionTakenType as $at)
                        <option value="<?=$at['id']?>"><?=$at['message']?></option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn btn-primary btn-block actionTakenTypeBtn"  id="actionTakenTypeBtn" onclick="brgy.editActionTaken('#editEmergencyActionTakenForm','#emergencyModal');">Update</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="resolvedEmergencyLabel" onclick="brgy.reopenEmergency('#editEmergencyActionTakenForm','#emergencyModal')" class="btn btn-danger pull-left" data-toggle="button" aria-pressed="false" autocomplete="off">
          Reopen Issue
        </button>
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->