<div class="modal fade" tabindex="-1" role="dialog" id="addSecurity">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        	<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        	<h4 class="modal-title">Add New Security</h4>
      </div>
      <div class="modal-body">

        	<form name="addSecFrm" id="addSecFrm">
			  <div class="form-group">
			    <label for="first_name">First Name</label>
			    <input type="text" class="form-control" id="first_name" placeholder="First Name">
			  </div>
			  <div class="form-group">
			    <label for="last_name">Last Name</label>
			    <input type="text" class="form-control" id="last_name" placeholder="Last Name">
			  </div>
			  <div class="form-group">
			    <label for="username">Username</label>
			    <input type="text" class="form-control" id="username" placeholder="Username">
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" id="password" placeholder="Password">
			  </div>
			  <div class="form-group">
			    <label for="confirm_password">Confirm Password</label>
			    <input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password">
			  </div>
			</form>

      </div>
      <div class="modal-footer">
        	<button type="button" class="btn btn-default close-modal-btn" data-dismiss="modal">Close</button>
        	<button type="button" class="btn btn-primary" onclick="brgy.addUser('#addSecFrm','#addSecurity','security');">Save</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="editSecurity">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title">Edit Security</h4>
      </div>
      <div class="modal-body">

        	<form name="editSecFrm" id="editSecFrm">
			  <div class="form-group">
			    <label for="first_name">First Name</label>
			    <input type="hidden" class="form-control" id="id">
			    <input type="text" class="form-control" id="first_name" placeholder="First Name">
			  </div>
			  <div class="form-group">
			    <label for="last_name">Last Name</label>
			    <input type="text" class="form-control" id="last_name" placeholder="Last Name">
			  </div>
			  <div class="form-group">
			    <label for="username">Username</label>
			    <input type="text" class="form-control" id="username" placeholder="Username">
			  </div>
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" id="epassword" placeholder="Password">
			  </div>
			  <div class="form-group">
			    <label for="confirm_password">Confirm Password</label>
			    <input type="password" class="form-control" id="econfirm_password" placeholder="Confirm Password">
			  </div>
			</form>

      </div>
      <div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	<button type="button" class="btn btn-primary" onclick="brgy.editUser('#editSecFrm','#editSecurity','security');">Save</button>
      </div>
    </div>
  </div>
</div>
