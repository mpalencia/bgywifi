
$(function() {
    $('#addResidentials').on('hidden.bs.modal', function () {
      //$('#addResFrm')[0].reset();
      window.location.href="";
    });
    $('#addSecurity').on('hidden.bs.modal', function () {
      //$('#addSecFrm')[0].reset();
      window.location.href="";
    });
    $('#editResidentials').on('hidden.bs.modal', function () {
      //$('#editResFrm')[0].reset();
      window.location.href="";
    });
    $('#editSecurity').on('hidden.bs.modal', function () {
      //$('#editSecFrm')[0].reset();
      window.location.href="";
    });

	var req=['last_name','first_name','contact_no','address','password','confirm_password','username'];
    var brgyWifiApp ={

        getLongLat:function(e){
            window.open("getLongLat", "", "width=1200, height=600");
        },

        getBaseUrl:function(){
            return $('#baseUrl').val(); 
        },

        postAjax: function(module,param,callback,method){
            var url = brgy.getBaseUrl()+'/'+module;
            if(typeof method === 'undefined'){
            	method = 'POST';
            }
            $.ajax({
                type: method,
                url: url,
                data: param,
                async: true,
                success: function (data) {
                    //console.log("Success!!");
                    //var obj = jQuery.parseJSON(data)
                    return callback(data);
                }
            });
        },
        
        submitLogin:function(formId){
            if($('#username').val() == '' || $('#password').val() == ''){
                brgy.showAlertify('Error', '<span class="red-bold">Please enter your Username/Password</span>');
                return false;
            }

            var param = {'username':$('#username').val(),'password':$('#password').val()};
                url = 'admin/login';
            
            brgy.showBlockUI('Processing, please wait...');
            brgy.postAjax(url, param, function(data){
                
            	
            	var d = JSON.parse(data);
            	if(d.msgCode == 1){
            		window.location.href=brgy.getBaseUrl()+'/dashboard';
            		return true;
            	}else{
            		$.unblockUI();
            		 brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+d.msg+'</span>');
            	}
            	
            	
            });
        },
        showBlockUI:function(msg){

            if(typeof msg === 'undefined'){
                msg = '<img src="assets/img/loader.gif" width="100px;"/>';
            }
            
            $.blockUI({ css: { 
                border: 'none', 
                padding: '15px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .5, 
                color: '#fff'
                
            }, message: msg }); 
        },
        clearForm:function(formId){
            $(formId)[0].reset();
        },
        showAlertify:function(title,msg,type){
            
            if(typeof type === 'undefined'){
                //default is alert
                alertify.defaults.glossary.title = title;
                alertify.alert(msg);
                
            }else if(type != 'alert'){
                
                alertify.set('notifier','position', 'top-right');
                alertify.notify(msg, type, 3, function(){  console.log('dismissed'); });
            }else{
                alertify.defaults.glossary.title = title;
                alertify.alert(msg);
            }

            $('.ajs-ok').on('click', function(){
                window.location.href="";
            });

            $('.ajs-close').on('click', function(){
                window.location.href="";
            });
        },
        showAlertifyNoRefresh:function(title,msg,type){
            
            if(typeof type === 'undefined'){
                //default is alert
                alertify.defaults.glossary.title = title;
                alertify.alert(msg);
                
            }else if(type != 'alert'){
                
                alertify.set('notifier','position', 'top-right');
                alertify.notify(msg, type, 3, function(){  console.log('dismissed'); });
            }else{
                alertify.defaults.glossary.title = title;
                alertify.alert(msg);
            }
        },
        showElement:function(elementToHide,elementToShow){
            $(elementToHide).addClass('hide');
            $(elementToShow).removeClass('hide');

            //close all posible window dialogs
            alertify.closeAll();
        },

        editActionTaken:function(formId,modalId){
            var url='admin/actionTaken';

            var param = {};

            if($('.action_taken_type').val() == "0" && $('.caution_action_taken_type').val() == "0" && $('#action_taken_type_unidentified').val() == "0"){

                $('.actionTakenFieldAlert').fadeIn();
                return false;
            }

            
            var action_take_type_id = $('#action_taken_type_unidentified').val();

            if($('.caution_action_taken_type').val() != "0") {
                action_take_type_id = $('.caution_action_taken_type').val();
            }

            if($('.action_taken_type').val() != "0") {
                action_take_type_id = $('#action_taken_type').val();
            }

            $('#actionTakenFieldAlert').fadeOut();
            $(formId+' input').each(
                function(index){  
                    var input = $(this);
                    param[input.attr('id')] = input.val();
                }
            )
            param['action_taken_type_id'] = action_take_type_id;
            $(modalId).modal('hide');
            brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){

                if(data.msgCode == 1){
                    //$(modalId).modal('hide');
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            });
        },

        editIssueActionTaken:function(formId,modalId){
            var url='admin/issueActionTaken';

            var param = {};

            if($('.issue_action_taken').val() == ''){

                $('.actionTakenFieldAlert').fadeIn();
                return false;
            }

            var issue_action_take_type_id = $('#action_taken').val();

            $('#actionTakenFieldAlert').fadeOut();
            $(formId+' input').each(
                function(index){  
                    var input = $(this);
                    param[input.attr('id')] = input.val();
                }
            )
            param['issue_action_take_type_id'] = issue_action_take_type_id;
            //$(modalId).modal('hide');
            brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){
                
                if(data.msgCode == 1){
                    
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            });
        },

        editMarkAsUpdate:function(formId,modalId){
            var url='admin/updateAlertType';

            var param = {};

            if($('.emergency_type_id').val() == "0"){

                $('.editMarkAsUpdateAlert').fadeIn();
                return false;
            }

            $('#actionTakenFieldAlert').fadeOut();
            $(formId+' input').each(
                function(index){  
                    var input = $(this);
                    param[input.attr('id')] = input.val();
                }
            )
            param['emergency_type_id'] = $('.emergency_type_id').val();
            $(modalId).modal('hide');
            brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){
                console.log(data);
                if(data.msgCode == 1){
                    //$(modalId).modal('hide');
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            });
        },

        markIssueAsResolved:function(formId,modalId){
            $issueId = $('#issue_id').val();
            
            var url='admin/updateIssue/'+$issueId;

            var param = {};

            brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){
                
                if(data.msgCode == 1){
                    //$(modalId).modal('hide');
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            }, 'put');
        },

        reopenIssue:function(formId,modalId){
            $issueId = $('#issue_id').val();
            
            var url='admin/reopenIssue/'+$issueId;

            var param = {};

            brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){
                
                if(data.msgCode == 1){
                    //$(modalId).modal('hide');
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            }, 'put');
        },

        reopenEmergency:function(formId,modalId){
            $emergencyId = $('#emergency_id').val();
            
            var url='admin/reopenEmergency/'+$emergencyId;

            var param = {};

            brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){
                
                if(data.msgCode == 1){
                    //$(modalId).modal('hide');
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            }, 'put');
        },

        reopenCaution:function(formId,modalId){
            $cautionId = $('#caution_id').val();
            
            var url='admin/reopenCaution/'+$cautionId;

            var param = {};

            brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){
                
                if(data.msgCode == 1){
                    //$(modalId).modal('hide');
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            }, 'put');
        },
        
        addUser:function(formId, modalId, userRole, address){
        	var url='residential/add';
        	if(userRole == 'security'){
        		var url='security/add';
        	}
        	
        	var param = {};
        	
        	for(var i=0,l=req.length; i < l ; i++){
            	if($(formId+' #'+req[i]).val() == ''){
        			brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+$('label[for="'+req[i]+'"]').html()+ ' is required.</span>');
                    return false;
                }
            }
        	var password = $('#password').val(), confirm_password = $('#confirm_password').val();
        	if(password != confirm_password){
                brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">Password did not match.</span>');
                return false;
            }
        	
        	$(formId+' input').each(
    		    function(index){  
    		        var input = $(this);
    		        param[input.attr('id')] = input.val();
    		    }
    		)
            
            var isNullAddress = false;
            var addresses = [];
    		$('.address').each(
                function(index){  
                    var input = $(this);
                    if(input.val() == '') {
                        brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+$('label[for=address]').html()+ ' is required.</span>');
                        isNullAddress = true;
                    }
                    addresses.push(input.val());
                }
            )
            param['address'] = addresses;

            var long_lat = [];
            $('.long-lat').each(
                function(index){  
                    var input = $(this);
                    if(input.val() == '') {
                        brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+$('label[for=address]').html()+ ' is required.</span>');
                        isNullAddress = true;
                    }
                    long_lat.push(input.val());
                }
            )
            param['long_lat'] = long_lat;
            if(!isNullAddress)
            {
                brgy.showBlockUI('Saving, please wait...');
                brgy.postAjax(url, param, function(data){
                    
                    if(data.msgCode == 1){
                       // $(modalId).modal('hide');
                        brgy.showAlertify('Success', data.msg);
                    }else{
                        brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                    }
                    $.unblockUI();
                });    
            }
        	
        },
        editUser:function(formId, modalId, userRole){
        	var url='residential/edit';
        	if(userRole == 'security'){
        		var url='security/edit';
        	}
        	var param = {};
        	
        	for(var i=0,l=req.length; i < l ; i++){
            	if($(formId+' #'+req[i]).val() == ''){
            		
            		if(req[i] != 'password' && req[i] != 'confirm_password'){
            			brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+$('label[for="'+req[i]+'"]').html()+ ' is required.</span>');
                        return false;
            		}
            	}
            }
        	var password = $('#epassword').val(), confirm_password = $('#econfirm_password').val();

        	if(password != confirm_password){
                brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">Password did not match.</span>');
                return false;
            }
        	

        	$(formId+' input').each(
    		    function(index){  
    		        var input = $(this);
                    if(input.attr('id')  != 'epassword' && input.attr('id')  != 'econfirm_password' && input.attr('id')  != 'eemail'){
                        param[input.attr('id')] = input.val();    
                    }
    		        
    		    }
    		)
            param['email'] = $('#eemail').val();
            param['contact_no'] = $('#econtact_no').val();
            param['home_owner_id'] = $('.homeOwnerId').val();
    		param['password'] = password;
            
        	brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){
            	var param = {}, url='residential/edit';
            	if(data.msgCode == 1){
            		//$(modalId).modal('hide');
            		brgy.showAlertify('Success', data.msg);
            	}else{
            		brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
            	}
            	
            	$.unblockUI();
            });
        },
        editUserAddress:function(formId, modalId, userRole){
            var url='residential/editAddress';
            if(userRole == 'security'){
                var url='security/editAddress';
            }
            var param = {};
            
            param['addressId'] = $('#eaddress_id').val();
            param['address'] = $('#eaddress').val();
            param['long_lat'] = $('#elong_lat').val();
            param['home_owner_id'] = $('#ehome_owner_id').val();

            brgy.showBlockUI('Saving, please wait...');
            brgy.postAjax(url, param, function(data){
                console.log(data);
                var param = {}, url='residential/edit';
                if(data.msgCode == 1){
                    //$(modalId).modal('hide');
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                
                $.unblockUI();
            });
        },

        getUserById:function(id, formId, modalId){
        	var param = {'id': id}, url='user/get';
        	brgy.showBlockUI('Retrieving information, please wait...');
            brgy.postAjax(url, param, function(data){
            	if(typeof data.msgCode === 'undefined'){
            		$(formId+' input#id').val(data.id);
            		$(formId+' input#first_name').val(data.first_name);
            		$(formId+' input#last_name').val(data.last_name);
                    if(data.contact_no != null){
            		  $(formId+' input#econtact_no').val(data.contact_no.substring(2));
                    }
                    $(formId+' input#eemail').val(data.email);
                    $.each( data.home_owner_address, function( key, value ) {
                        $(formId+' input.address').val(value.address);
                    });
            		$(formId+' input#address').val(data);
            		$(formId+' input#username').val(data.username);
            		$(modalId).modal('show')
            	}
            	$.unblockUI();
         
            });
        	
    	},
        getUserAddressById:function(id, formId, modalId){
            var param = {'id': id}, url='user/get';
            brgy.showBlockUI('Retrieving information, please wait...');
            brgy.postAjax(url, param, function(data){
                if(typeof data.msgCode === 'undefined'){

                    $.each( data.home_owner_address, function( key, value ) {
                        console.log(value);
                        $('#bleh').append('<input name="homeOwnerId "type="text" class="homeOwnerId form-control" value="'+value.home_owner_id+'"><input name="addressId[] "type="hidden" class="addressId form-control" value="'+value.id+'"><input name="addressId[] "type="hidden" class="addressId form-control" value="'+value.id+'"><input name="address[]"type="text" class="userAddress form-control" value="'+value.address+'" placeholder="Address">&nbsp;&nbsp;<input value="'+value.latitude+','+value.longitude+'" data-toggle="modal"  href="#myModal2" name="long_lat[]" onclick="initialize(this)" id="long_lat" type="text" class="user-long-lat form-control" placeholder="Add Latitude and Longitude" readonly="readonly">&nbsp;&nbsp;');//<a href="#" class="pull-right remove-field"  style="color:red"><i class="fa fa-times"></i> Remove</a>
                    });

                    $(modalId).modal('show')
                }

                $.unblockUI();
         
            });
            
        },
        getUserAddress:function(id, formId, modalId){
            var param = {'id': id}, url='user/getAddress/'+id;
            brgy.showBlockUI('Retrieving information, please wait...');
            brgy.postAjax(url, param, function(data){
                
                console.log(data);
                $('#bleh').html('<input name="homeOwnerId "type="hidden" id="ehome_owner_id" class="homeOwnerId form-control" value="'+data.home_owner_id+'"><input name="addressId" id="eaddress_id" type="hidden" class="addressId form-control" value="'+data.id+'"><input name="address" id="eaddress" type="text" class="userAddress form-control" value="'+data.address+'" placeholder="Address">&nbsp;&nbsp;<input value="'+data.latitude+','+data.longitude+'" data-toggle="modal"  href="#myModal2" name="long_lat[]" onclick="initialize(this)" id="elong_lat" type="text" class="user-long-lat form-control" placeholder="Add Latitude and Longitude" readonly="readonly">&nbsp;&nbsp;');//<a href="#" class="pull-right remove-field"  style="color:red"><i class="fa fa-times"></i> Remove</a>
                $(modalId).modal('show')
                $.unblockUI();
         
            });
            
        },

        addAddress:function(formId, modalId){
            var param = {};
            $(formId+' input').each(
                function(index){  
                    var input = $(this);
                    param[input.attr('id')] = input.val();
                }
            )
            var url='residential/postAddress';
            brgy.showBlockUI('Saving');
            brgy.postAjax(url, param, function(data){
                
                
                /*$('#bleh').append('<input name="homeOwnerId "type="hidden" class="homeOwnerId form-control" value="'+data.home_owner_id+'"><input name="addressId[] "type="hidden" class="addressId form-control" value="'+data.id+'"><input name="addressId[] "type="hidden" class="addressId form-control" value="'+data.id+'"><input name="address[]"type="text" class="userAddress form-control" value="'+data.address+'" placeholder="Address">&nbsp;&nbsp;<input value="'+data.latitude+','+data.longitude+'" data-toggle="modal"  href="#myModal2" name="long_lat[]" onclick="initialize(this)" id="long_lat" type="text" class="user-long-lat form-control" placeholder="Add Latitude and Longitude" readonly="readonly">&nbsp;&nbsp;');//<a href="#" class="pull-right remove-field"  style="color:red"><i class="fa fa-times"></i> Remove</a>*/
                if(data.msgCode == 1){
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
         
            });
            
        },
        setAddressId: function(id)
        {
            $('#addressToDelete').val(id);
        },
        deleteUserById:function(id){
        	var param = {'id': id}, url='user/delete';
        	brgy.showBlockUI('Deleting information, please wait...');
            brgy.postAjax(url, param, function(data){
            	if(data.msgCode == 1){
            		brgy.showAlertify('Success', data.msg);
            	}else{
            		brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
            	}
            	$.unblockUI();
            	
            });
        	
    	},
    	deleteEventById:function(id){
        	var param = {'id': id}, url='event/delete';
        	brgy.showBlockUI('Deleting event, please wait...');
            brgy.postAjax(url, param, function(data){
            	if(data.msgCode == 1){
            		brgy.showAlertify('Success', data.msg);
            	}else{
            		brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
            	}
            	$.unblockUI();
            	
            });
        	
    	},

        deleteAddress:function(){
            var param = {'id': $('#addressToDelete').val()}, url='residential/deleteAddress/'+$('#addressToDelete').val();
            brgy.showBlockUI('Deleting address, please wait...');
            brgy.postAjax(url, param, function(data){
                if(data.msgCode == 1){
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
                
            });
            
        },
    	sendMessage: function(){
    		var to_user_id = $('#home_owner_id').val(), msg = $('#message').val();
            if(msg == ''){
                brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">Message cannot be empty</span>');
                $.unblockUI();
            }
            else{
        		var param = {'to_user_id': to_user_id,'message':msg}, url='admin/message/send';
            	brgy.showBlockUI('Sending message, please wait...');
                brgy.postAjax(url, param, function(d){
                    
                	if(d.msgCode == 1){
                		brgy.showAlertify('Success', d.msg);
                	}else{
                		brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+d.msg+'</span>');
                	}
                	$.unblockUI();
                	
                });
            }
    	},
    	deleteMessage:function(id){
        	var param = {'id': id}, url='admin/message/delete';
        	brgy.showBlockUI('Deleting event, please wait...');
            brgy.postAjax(url, param, function(data){
            	if(data.msgCode == 1){
            		brgy.showAlertify('Success', data.msg);
            	}else{
            		brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
            	}
            	$.unblockUI();
            	
            });
        	
    	},

        uploadAdvertisement:function(){
            
            var param = {'image': $('#tempFile').val()}, url='admin/advertisement/upload';
            brgy.showBlockUI('Uploading image...');
            brgy.postAjax(url, param, function(data){
                console.log(data);
                if(data.msgCode == 1){
                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
                
            });
            
        }
    }
    brgy = brgyWifiApp;
});
