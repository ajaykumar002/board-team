var optionsHTML = "";
var data = [];

var designation = {
			1: "President",
			2: "Secretary",
			3: "Treasurer",
			4: "Dir.-Club Service",
			5: "Dir.-Vocational Service",
			6: "Dir.-Comm Development",
			7: "Dir.Comm Health",
			8: "Dir.Youth Service",
			9: "Dir.Int. Service",
			10: "Chair-Mem. Development",
			/*11: "Chair-Foundation",
			12: "Chair-DEI",
			13: "Chair-Public Image",
			14: "Sergeant at Arms"*/
		}

$("#rotaryClubListSearch").change(function(){
	var team_id = $(this).val();
	
	$.ajax({
		url:"ajax.php",
		method:"post",
		data:{
			"target":"getTeamDetails",
			"data":{"value":team_id}
		},
		success:function(res){
			var result = JSON.parse(res);
			var rotarianTableElement = $("#rotarianTable");
			data = result.data;
			var existTeamCount = $(data).length;
			if(existTeamCount > 0){
				rotarionHtml ="";
				rotarianRowCount =1;
				for(var i =0; i<existTeamCount;i++){
					rotarionHtml +=getRotarianHTML(rotarianRowCount);
					rotarianRowCount++;
				}
				rotarianTableElement.find('tbody').html(rotarionHtml);
				image();
				resetRotarian();
				$('.rotarianSearch').select2();
				$('.rotarianDesignation').select2();
		    	for(var col in data){
		    		if (data.hasOwnProperty(col)) {
		    			var index = parseInt(col)+1;
		    			$("#team_member_id_"+index).val(data[col].id)
		    			$("#rotarianSearch_"+index).val(data[col].member_id).trigger("change");	
		    			$("#rotarian_club_name"+index).val(data[col].club_name).trigger("change");
		    			$("#rotarian_call_name"+index).val(data[col].email_address).trigger("change");
		    			$("#rotarian_mobile"+index).val(data[col].phone_number).trigger("change");
		    			$("#rotarian_designation"+index).val(data[col].member_designation).trigger("change");
		    			$("#rotarian_classfication"+index).val(data[col].classfication).trigger("change");
		    			$("#team_member_id_"+index).val(data[col].id).trigger("change");		    			
		    		}
		    	}
	    	}else{
	    		
				rotarionHtml ="";
				rotarianRowCount =1;
				for(var i =0; i<10;i++){
					rotarionHtml +=getRotarianHTML(rotarianRowCount);
					rotarianRowCount++;
				}
				rotarianTableElement.find('tbody').html(rotarionHtml);
				image();
				resetRotarian();
				$('.rotarianSearch').select2();
				$('.rotarianDesignation').select2();
	    	}
	    }
			
	});
	
	
	
	/*$.ajax({
		url:"ajax.php",
		method:"post",
		data:{
			"target":"getRotarians",
			"data":{"value":club}
		},
		success:function(res){
			var data = JSON.parse(res);
			if (data.status == "success") {
				data = data.data;
				var rotarianOptionsHTML = "<option value =''>~~~ Select Rotarian ~~~</option>";
				$.each(data,function(index,value) {
					rotarianOptionsHTML += "<option value='"+value.key+"'>"+value.value+"</option>";
				});
				optionsHTML = rotarianOptionsHTML;
				$(".rotarianSearch").html(optionsHTML);
				$(".registerer_name").html(optionsHTML);
				$('.rotarianSearch').select2();
				$('.registerer_name').select2();
			}
		}
	});*/
});

/*$("#registerer_club").change(function(){
	var club = $(this).val();
	
	$.ajax({
		url:"ajax.php",
		method:"post",
		data:{
			"target":"getRotarians",
			"data":{"value":club}
		},
		success:function(res){
			var data = JSON.parse(res);
			if (data.status == "success") {
				data = data.data;
				var rotarianOptionsHTML = "<option value =''>~~~ Select Registerer ~~~</option>";
				$.each(data,function(index,value) {
					rotarianOptionsHTML += "<option value='"+value.key+"'>"+value.value+"</option>";
				});
				let optionsHTML = rotarianOptionsHTML;
				$(".registerer_name").html(optionsHTML);
				$('.registerer_name').select2();
			}
		}
	});
});
*/
$("#registerer_name").change(function(){

				calculateMemberRegistrationFee();
				var rotarianMemberId = $(this).val();
				var element = $(this);
				$.ajax({
					url:"ajax.php",
					method:"post",
					data:{
						"target":"getRotarianDetail",
						"data":{"value":rotarianMemberId}
					},
					success:function(res){
						var response = JSON.parse(res);
						if(response.status = "success"){
							var data = response.data;
							// console.log(data.mobile_no);
							
							$("#registerer_mobile").val(data.mobile_no);
							$("#registerer_email").val(data.email);

						}
					}
				});
			});
$("#rotarianRegister").on("submit",function(e){
	e.preventDefault();
	// var data = $("form").serializeArray();
	var data = new FormData(this);
	
		$('body').addClass("disabled blur");
		$('.loading').show();
	
	$.ajax({
		url:"ajax.php",
		method:"post",
		processData: false, // Prevent jQuery from processing the data
        contentType: false,
		data:data,
		success:function(res){
			var response = JSON.parse(res);
			// console.log(response);
			$('.loading').css("display","none");
			$('body').removeClass("disabled blur");	
			if(response.error ==1){
				clearErrors();
				var transactionErrors = response.data.transaction;
				var rotarianErrors = response.data.rotarian;
				var annErrors = response.data.ann;
				var annetteErrors = response.data.annette;
				if( Object.keys(transactionErrors).length > 0 )
					messagevalidation(transactionErrors);

				if( Object.keys(annErrors).length > 0 )
					messagevalidation(annErrors);

				if( Object.keys(annetteErrors).length > 0 )
					messagevalidation(annetteErrors);

						
				
			}else{
				alert("Rotarians are registered successfully!.");
				window.location.reload();
				$('.loading').css("display","none");
				$('body').removeClass("disabled blur");
			}
		}
	});
});


function messagevalidation(data){
	$.each(data,function(finder,error){
		console.log("finder:"+finder);
		console.log("error:"+error);

		$('[name="'+finder+'"]').closest('.form-group').append("<span class='error'>"+error+"</span>");
	})

}
function clearErrors() {
	$(".error").remove();
}

function toast(message) {
	var x = document.getElementById("snackbar");
	$("#snackbar").html(message);
  	x.className = "show";
  	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function image() {
	$(".rotarion_image").on("change",function(e){
		var file = e.target.files[0];
		var maxSizeInBytes = 1024 * 1024; // 1 MB
	    if (file && (file.size < maxSizeInBytes)) {
	        alert("File size minimum the limit of 1 MB.");
	        // Clear the selected file from the input element
	        e.target.value = '';
	    }
	});
} 
	
