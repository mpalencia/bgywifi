<div class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="issue-homeowner"></span></h4>
        <h5 class="modal-title" id="myModalLabel"><span class="issue-date"></span></h5>
      </div>
      <div class="modal-body">
      	<h4 align="center"><span class="issue-title"></span></h4>
      	<span id="issue-action-taken"></span>
      	<hr>
      	<form name="editIssueActionTaken" id="editissueActionTakenForm">
      		<div class="alert alert-danger actionTakenFieldAlert" role="alert" id="actionTakenFieldAlert">Action Taken field is required.</div>
		  	<div class="form-group">
		  		<input type="hidden" class="form-control home_owner_id" id="home_owner_id">
		  		<input type="hidden" class="form-control security_guard_id" id="security_guard_id">
		  		<input type="hidden" class="form-control issue_id" id="issue_id">
          <input type="hidden" class="form-control issue_type" id="issue_type">
			    <label for="last_name">Action Taken</label>
  			    <input type="text" class="form-control action_taken" id="action_taken">
		  	</div>
		  	<button type="button" class="btn btn-primary btn-block issueActionTakenTypeBtn"  id="issueActionTakenTypeBtn" onclick="brgy.editIssueActionTaken('#editissueActionTakenForm','#issueModal');">Update</button>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="markAsResolvedBtn" onclick="brgy.markIssueAsResolved('#editissueActionTakenForm','#issueModal')" class="btn btn-success pull-left" data-toggle="button" aria-pressed="false" autocomplete="off">
          Mark as Resolved
        </button>
        <button type="button" id="resolvedLabel" onclick="brgy.reopenIssue('#editissueActionTakenForm','#issueModal')" class="btn btn-danger pull-left" data-toggle="button" aria-pressed="false" autocomplete="off">
          Reopen Issue
        </button>
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
