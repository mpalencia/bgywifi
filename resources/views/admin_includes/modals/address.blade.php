
<div class="modal fade rotate" id="editResidentialAddress">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Edit Address</h4>

            </div>
            <div class="modal-body">
			    <form name="editResAddFrm" id="editResAddFrm">
				  	<div class="form-group">
					    <!-- <div class="pull-right"><a href="#" class="add-field-update">Add Address</a></div> -->
						<div class="multi-field-wrapper">
						    <div class="multi-fields">
						      	<div class="multi-field">
						      		<div id="bleh"></div>
						      	</div>
						    </div>
					  	</div>
				  	</div>
				</form>
            </div>
            <div class="modal-footer">
            	<a href="#" data-dismiss="modal" class="btn">Cancel</a>
            	<button type="button" class="btn btn-primary" onclick="brgy.editUserAddress('#editResAddFrm','#editResidentialAddress','residential');">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade rotate" id="addAddress">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title">Add Address</h4>

            </div>
            <div class="modal-body">
            	<form name="addAddressForm" id="addAddressForm">

			    	<input name="home_owner_id"type="hidden" value="{{$resident->id}}" class="homeOwnerId form-control" id="home_owner_id">

				    <div class="form-group">
				    	<label>Address</label>
				    	<input name="address" id="address" type="text" class="userAddress form-control" value="" placeholder="Address">
				    </div>
				    <div class="form-group">
				    	<label>Latitude & Longitude</label>
				    	<input value="" data-toggle="modal"  href="#myModal2" name="long_lat[]" onclick="initialize(this)" id="long_lat" type="text" class="user-long-lat form-control" placeholder="Add Latitude and Longitude" readonly="readonly">
				    </div>
			    </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            	<button type="button" class="btn btn-primary" onclick="brgy.addAddress('#addAddressForm','#addAddress');">Save</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade rotate" id="deleteAddress">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Delete Address</h4>

            </div>
            <div class="modal-body">
                Are you sure you want to delete this address?
                <input type="hidden" id="addressToDelete"></input>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary"  onclick="brgy.deleteAddress()">Yes</button>
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
            <div class="modal-footer">	<a href="#" data-dismiss="modal" class="btn btn-primary">Okay</a>

            </div>
        </div>
    </div>
</div>
