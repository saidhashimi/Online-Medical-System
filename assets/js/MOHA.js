(function($) {

	"use strict";

	

	$('#sidebarCollapse').on('click', function () {
	  $('#sidebar').toggleClass('active');
	  $('#mohaPageContent').toggleClass('active');
	 $('#listOfComponents').toggleClass('active');
	 $('#doctorRegistration').toggleClass('active');
	 $('#hospitalRegistration').toggleClass('active');
	 $('#clinicRegistration').toggleClass('active');
	 $('#medicalRegistration').toggleClass('active');
	 $('#medicineRegistration').toggleClass('active');
	 $('#doctorDeletion').toggleClass('active');
	 $('#hospitalDeletion').toggleClass('active');
	 $('#clinicDeletion').toggleClass('active');
	 $('#medicalDeletion').toggleClass('active');
	 $('#medicineDeletion').toggleClass('active');
	 $('#doctorView').toggleClass('active');
	 $('#hospitalView').toggleClass('active');
	 $('#clinicView').toggleClass('active');
	 $('#medicalView').toggleClass('active');
	 $('#medicineView').toggleClass('active');
	 $('#doctorUpdate').toggleClass('active');
	 $('#hospitalUpdate').toggleClass('active');
	 $('#clinicUpdate').toggleClass('active');
	 $('#medicalUpdate').toggleClass('active');
	 $('#medicineUpdate').toggleClass('active');
	 $('#mohaProfileSetting').toggleClass('active');
	 $('#mohaChangePassword').toggleClass('active');
  });



})(jQuery);
