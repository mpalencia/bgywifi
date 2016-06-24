<div class="modal fade" tabindex="-1" role="dialog" id="addResidentials">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title">Add New Residential</h4>
      </div>
      <div class="modal-body">

        	<form name="addResFrm" id="addResFrm">
			  <div class="form-group">
			    <label for="first_name">First Name</label>
			    <input type="text" class="form-control" id="first_name" placeholder="First Name">
			  </div>
			  <div class="form-group">
			    <label for="last_name">Last Name</label>
			    <input type="text" class="form-control" id="last_name" placeholder="Last Name">
			  </div>
			  <div class="form-group">
				   	<label for="address">Address & Longtitude, Latitude</label>
			    <div class="pull-right"><a href="#" class="add-field">Add Address</a></div>
				<div class="multi-field-wrapper">
				    <div class="multi-fields">
				      <div class="multi-field">
				        <input name="address[]"type="text" class="address form-control"  placeholder="Address">&nbsp;&nbsp;
				        <input  data-toggle="modal"  href="#myModal2" name="long_lat[]" onclick="initialize(this)" id="long_lat" type="text" class="long-lat form-control" placeholder="Add Latitude and Longitude" readonly="readonly">
				        <a href="#" class="pull-right remove-field"  style="color:red"><i class="fa fa-times"></i> Remove</a>
				        <!-- <a data-toggle="modal"  class="add-geo-field" href="#myModal2" class="btn btn-primary">Add <i class="fa fa-map-marker"></i> in Google Maps </a> -->
				      </div>
				    </div>
			  	</div>
			  </div>
			  <div class="form-group">
			    <label for="email">Email</label>
			    <input type="text" class="form-control" id="email" placeholder="Email">
			  </div>
		      <div class="form-group">
				<label for="contact_no">Contact Number</label>
				<!-- <input type="text" class="form-control" id="contact_no" placeholder="Contact Number" max="15"> -->
				<div class="input-group">
			      <div class="input-group-addon">+63</div>
			      <input type="text" class="form-control" id="contact_no" placeholder="Contact Number" maxlength="10">
			    </div>
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
        	<button type="button" class="btn btn-default add-resident-close" data-dismiss="modal">Close</button>
        	<button type="button" class="btn btn-primary" onclick="brgy.addUser('#addResFrm','#addResidentials','residential', '.address');">Save</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="editResidentials">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	<h4 class="modal-title">Edit Residential</h4>
      </div>
      <div class="modal-body">

        	<form name="editResFrm" id="editResFrm">
			  <div class="form-group">
			    <label for="first_name">First Name</label>
			    <input type="hidden" class="form-control" id="id">
			    <input type="text" class="form-control" id="first_name" placeholder="First Name">
			  </div>
			  <div class="form-group">
			    <label for="last_name">Last Name</label>
			    <input type="text" class="form-control" id="last_name" placeholder="First Name">
			  </div>
			  <div class="form-group">
			    <label for="email">Email</label>
			    <input type="text" class="form-control" id="eemail" placeholder="Email">
			  </div>
				<div class="form-group">
				   <label for="contact_no">Contact Number</label>
					<div class="input-group">
				      <div class="input-group-addon">+63</div>
				      <input type="text" class="form-control" id="econtact_no" placeholder="Contact Number" maxlength="10">
				    </div>
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
        	<button type="button" class="btn btn-primary" onclick="brgy.editUser('#editResFrm','#editResidentials','residential');">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade rotate" id="myModal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title">Add longitude and latitude</h4>

            </div>
            <div class="modal-body">

          <div id="map_canvas" style="margin:0px; padding:0px;width: 865px; height: 550px"></div>

            </div>
            <div class="modal-footer">  <a href="#" data-dismiss="modal" class="btn btn-primary">Okay</a>

            </div>
        </div>
    </div>
</div>
