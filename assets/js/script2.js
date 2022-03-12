/* Changing Text Animation Area  */
var doctor="best doctors";
var clinics="best clinics";
var hospital="best hospitals";


var textChange=["Find the "+doctor.fontcolor("#09e5ab")+" in Afghanistan","Find the "+hospital.fontcolor("#09e5ab")+" in Afghanistan","Find the "+clinics.fontcolor("#09e5ab")+" in Afghanistan"];
var counter=0;
document.getElementById("m1").innerHTML=textChange[counter];


setInterval(change,4000);

function change(){
	document.getElementById("m1").innerHTML=textChange[counter];
	counter++;

	if(counter>=textChange.length){counter=0;}
}




/* Login Modal Body Content   */



function patientRegisterBody(){
document.getElementById('Login-Body').style.display="none";
document.getElementById('doc-reg-body').style.display="none";
document.getElementById('forgot-password').style.display="none";
document.getElementById('Register-Body').style.display="block";


}

function loginBody(){
document.getElementById('Register-Body').style.display="none";
document.getElementById('Login-Body').style.display="block";
document.getElementById('forgot-password').style.display="none";
document.getElementById('doc-reg-body').style.display="none";

}

function doctorRegisterBody(){
	document.getElementById('Login-Body').style.display="none";
	document.getElementById('Register-Body').style.display="none";
	document.getElementById('doc-reg-body').style.display="block";

}

function forgotPassword(){
	document.getElementById('Login-Body').style.display="none";

	document.getElementById('forgot-password').style.display="block";
}



/*  Section Counter               */
$('.label-counter').each(function () {
	$(this).prop('Counter',0).animate({
		Counter: $(this).text()
	}, {
		duration: 5000,
		easing: 'swing',
		step: function (now) {
			$(this).text(Math.ceil(now));
		}
	});
});

/* MOHA-Employee Dashboard Counter Area */




/*-----------------
	 Doctor Dashboard
-----------------------*/

//Dashboard

function dashboard(){
    document.getElementById('appointmentTab').style.display="none";
    document.getElementById('apptTab').className="none";
    document.getElementById('mypatientTab').style.display="none";
    document.getElementById('myPatient').className="none";
    document.getElementById('scheduleTiming').style.display="none";
    document.getElementById('schdTime').className="none";
    document.getElementById('profile').className="none";
    document.getElementById('profileSettingTab').style.display="none";
    document.getElementById('socialMediaTab').style.display="none";
    document.getElementById('social').className="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('changePass').className="none";

    document.getElementById('dashboardTab').style.display="block";
    document.getElementById('dashTab').className="active";

}


//Appointment Tab Dashboard


function appointmentDashboard(){
    
    document.getElementById('mypatientTab').style.display="none";
    document.getElementById('myPatient').className="none";
    document.getElementById('dashboardTab').style.display="none";
    document.getElementById('dashTab').className="none";
    document.getElementById('scheduleTiming').style.display="none";
    document.getElementById('schdTime').className="none";
    document.getElementById('profile').className="none";
    document.getElementById('profileSettingTab').style.display="none";
    document.getElementById('socialMediaTab').style.display="none";
    document.getElementById('social').className="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('changePass').className="none";

    document.getElementById('apptTab').className="active";
    document.getElementById('appointmentTab').style.display="block";

}

//My Patient List
function patientList(){

    document.getElementById('dashboardTab').style.display="none";
    document.getElementById('dashTab').className="none";
    document.getElementById('apptTab').className="none";
    document.getElementById('appointmentTab').style.display="none";
    document.getElementById('scheduleTiming').style.display="none";
    document.getElementById('schdTime').className="none";
    document.getElementById('profile').className="none";
    document.getElementById('profileSettingTab').style.display="none";
    document.getElementById('socialMediaTab').style.display="none";
    document.getElementById('social').className="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('changePass').className="none";

    document.getElementById('mypatientTab').style.display="block";
    document.getElementById('myPatient').className="active";

}

//Schedule Timing
function schedule(){
    document.getElementById('dashboardTab').style.display="none";
    document.getElementById('dashTab').className="none";
    document.getElementById('apptTab').className="none";
    document.getElementById('appointmentTab').style.display="none";

    document.getElementById('mypatientTab').style.display="none";
    document.getElementById('myPatient').className="none";
    document.getElementById('profile').className="none";
    document.getElementById('profileSettingTab').style.display="none";
    document.getElementById('socialMediaTab').style.display="none";
    document.getElementById('social').className="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('changePass').className="none";


    document.getElementById('scheduleTiming').style.display="block";
    document.getElementById('schdTime').className="active";
}


//Profile Settings
function docotrProfileSetting(){
    document.getElementById('dashboardTab').style.display="none";
    document.getElementById('dashTab').className="none";
    document.getElementById('apptTab').className="none";
    document.getElementById('appointmentTab').style.display="none";

    document.getElementById('mypatientTab').style.display="none";
    document.getElementById('myPatient').className="none";


    document.getElementById('scheduleTiming').style.display="none";
    document.getElementById('schdTime').className="none";
    document.getElementById('socialMediaTab').style.display="none";
    document.getElementById('social').className="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('changePass').className="none";

    document.getElementById('profile').className="active";
    document.getElementById('profileSettingTab').style.display="block";


}

//Social Media Setting

function socialMedia(){
    document.getElementById('dashboardTab').style.display="none";
    document.getElementById('dashTab').className="none";
    document.getElementById('apptTab').className="none";
    document.getElementById('appointmentTab').style.display="none";

    document.getElementById('mypatientTab').style.display="none";
    document.getElementById('myPatient').className="none";


    document.getElementById('scheduleTiming').style.display="none";
    document.getElementById('schdTime').className="none";

    document.getElementById('profile').className="none";
    document.getElementById('profileSettingTab').style.display="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('changePass').className="none";

    document.getElementById('socialMediaTab').style.display="block";
    document.getElementById('social').className="active";

}


//Change Password Tab
function changePassword(){
    document.getElementById('dashboardTab').style.display="none";
    document.getElementById('dashTab').className="none";
    document.getElementById('apptTab').className="none";
    document.getElementById('appointmentTab').style.display="none";

    document.getElementById('mypatientTab').style.display="none";
    document.getElementById('myPatient').className="none";


    document.getElementById('scheduleTiming').style.display="none";
    document.getElementById('schdTime').className="none";

    document.getElementById('profile').className="none";
    document.getElementById('profileSettingTab').style.display="none";

    document.getElementById('socialMediaTab').style.display="none";
    document.getElementById('social').className="none";

    document.getElementById('changePasswordTab').style.display="block";
    document.getElementById('changePass').className="active";

}



/*-----------------
	 Patient Dashboard
-----------------------*/

//Dashboard

function patientDashboard(){
    document.getElementById('favouritesTab').style.display="none";
    document.getElementById('patFavourites').className="none";
    document.getElementById('patientProfileSettingTab').style.display="none";
    document.getElementById('patientProfileSetting').className="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('patientPassword').className="none";

    document.getElementById('patDashboard').style.display="block";
    document.getElementById('dashPat').className="active";


}

//Patient Favourites
function patientFavourites(){
    document.getElementById('patDashboard').style.display="none";
    document.getElementById('dashPat').className="none";
    document.getElementById('patientProfileSettingTab').style.display="none";
    document.getElementById('patientProfileSetting').className="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('patientPassword').className="none";

    document.getElementById('favouritesTab').style.display="block";
    document.getElementById('patFavourites').className="active";


}


//Patient Profile Setting

function profileSetting(){
    document.getElementById('patDashboard').style.display="none";
    document.getElementById('dashPat').className="none";

    document.getElementById('favouritesTab').style.display="none";
    document.getElementById('patFavourites').className="none";
    document.getElementById('changePasswordTab').style.display="none";
    document.getElementById('patientPassword').className="none";

    document.getElementById('patientProfileSettingTab').style.display="block";
    document.getElementById('patientProfileSetting').className="active";
    

}

//Change Password

function patientChangePassword(){

    document.getElementById('patDashboard').style.display="none";
    document.getElementById('dashPat').className="none";

    document.getElementById('favouritesTab').style.display="none";
    document.getElementById('patFavourites').className="none";

    document.getElementById('patientProfileSettingTab').style.display="none";
    document.getElementById('patientProfileSetting').className="none";

    document.getElementById('changePasswordTab').style.display="block";
    document.getElementById('patientPassword').className="active";


}



