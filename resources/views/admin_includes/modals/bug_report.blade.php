
<div class="modal fade" id="bugReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Report a Bug</span></h5>
      </div>

      <div class="modal-body">
        <div class='col-md-12'>
          <div class="alert alert-danger addBugReportAlert" role="alert" id="addBugReportAlert">Bug field is required.</div>
          <div class="form-group">
              <label>Bug:</label>
              <textarea class="form-control add-text-bug" name="bug" placeholder="Bug"></textarea>
          </div>
        </div>
        <button type="button" class="btn btn-success btn-block sendBugReportAdd" id="sendBugReportAdd">Send Bug Report</button>
        </div>
      <div class="modal-footer">

        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="viewBugReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">View Bug Report</span></h5>
      </div>

      <div class="modal-body">
        <span id="view_bug"></span>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editBugReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Report a Bug</span></h5>
      </div>

      <div class="modal-body">

        <div class='col-md-12'>
          <div class="alert alert-danger editBugReportAlert" role="alert" id="editBugReportAlert">Bug field is required.</div>
          <input type="hidden" name="bug_id" id="bug_id" class="bug_id">
              <div class="form-group">
                  <label>Bug:</label>
                  <textarea class="form-control edit-text-bug" name="bug" placeholder="Bug"></textarea>
              </div>
        </div>
              <button type="button" class="btn btn-success btn-block sendBugReportEdit" id="sendBugReportEdit">Update Bug Report</button>

        </div>
      <div class="modal-footer">

        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
