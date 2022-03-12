

    let degreeCount=1;
    let experienceCount=1;
    let clinicCount=1;

    $('.clinic-info').each(
        function() {
            clinicCount=($(this).find('.clinic-cont')).length;
        }
    );
    $('.education-info').each(
        function() {
            degreeCount=($(this).find('.education-cont')).length;
        }
    );
    $('.experience-info').each(
        function() {
            experienceCount=($(this).find('.experience-cont')).length;
        }
    );

// Pricing Options Show

$('#pricing_select input[name="rating_option"]').on('click', function() {
    if ($(this).val() == 'price_free') {
        $('#custom_price_cont').hide();
    }
    if ($(this).val() == 'custom_price') {
        $('#custom_price_cont').show();
    }
    else {
    }
});

    if (clinicCount==0){
        clinicCount++;
        var educationcontent = '<div class="row form-row clinic-cont">' +
            '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
            '<div class="col-12 col-md-6 col-lg-6">' +
            '<div class="form-group">' +
            '<label>Clinic Name</label>' +
            '<input type="hidden" name="firstClinic" class="form-control">' +
            '<input type="text" name="cliName" class="form-control" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6 col-lg-6">' +
            '<div class="form-group">' +
            '<label>Clinic Address</label>' +
            '<input type="text" name="cliAddress" class="form-control" required>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';

        $(".clinic-info").append(educationcontent);

    }
    if (degreeCount==0){
        degreeCount++;

        var educationcontent = '<div class="row form-row education-cont">' +
            '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>Degree</label>' +
            '<input type="hidden" name="newEducation" class="form-control">'+
            '<input type="text" name="docDegree" class="form-control" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>College/Institute</label>' +
            '<input type="text" name="docCollege" class="form-control">' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>Year of Completion</label>' +
            '<input type="number" name="docCompletion" class="form-control">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';

        $(".education-info").append(educationcontent);

    }

    if (experienceCount==0){
        experienceCount++;

        var experiencecontent = '<div class="row form-row experience-cont">' +
            '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>Hospital Name</label>' +
            '<input type="hidden" name="firstExperience" class="form-control">' +
            '<input type="text" name="hosName" class="form-control" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>From</label>' +
            '<input type="date" name="startDate" class="form-control" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>To</label>' +
            '<input type="date" name="endDate" class="form-control" required>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';

        $(".experience-info").append(experiencecontent);
    }

    // Clinic Add More

    $(".clinic-info").on('click','.trash', function () {
        clinicCount--;
        $(this).closest('.clinic-cont').remove();
        return false;
    });

    $(".add-clinic").on('click', function () {

        if (clinicCount>3){
            $('.cliCounter').addClass('d-block');
        }else {
            clinicCount++;

            var educationcontent = '<div class="row form-row clinic-cont">' +
                '<div class="col-12 col-md-10 col-lg-11">' +
                '<div class="row form-row">' +
                '<div class="col-12 col-md-6 col-lg-6">' +
                '<div class="form-group">' +
                '<label>Clinic Name</label>' +
                '<input type="hidden" name="newclinic" class="form-control">' +
                '<input type="text" name="newclinicName[]" class="form-control" required>' +
                '</div>' +
                '</div>' +
                '<div class="col-12 col-md-6 col-lg-6">' +
                '<div class="form-group">' +
                '<label>Clinic Address</label>' +
                '<input type="text" name="newclinicAddress[]" class="form-control" required>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
                '</div>';

            $(".clinic-info").append(educationcontent);
        }
        return false;
    });

// Education Add More

$(".education-info").on('click','.trash', function () {
    degreeCount--;
    $(this).closest('.education-cont').remove();
    return false;
});

$(".add-education").on('click', function () {

    if (degreeCount>3){
        $('.eduCounter').addClass('d-block');
    }else {
        degreeCount++;

        var educationcontent = '<div class="row form-row education-cont">' +
            '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>Degree</label>' +
            '<input type="hidden" name="addNewDegrees" class="form-control">' +
            '<input type="text" name="degree[]" class="form-control" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>College/Institute</label>' +
            '<input type="text" name="college[]" class="form-control">' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6 col-lg-4">' +
            '<div class="form-group">' +
            '<label>Year of Completion</label>' +
            '<input type="number" name="completion[]" class="form-control">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
            '</div>';

        $(".education-info").append(educationcontent);
    }
    return false;
});

    // Experience Add More

    $(".experience-info").on('click','.trash', function () {
        experienceCount--;
        $(this).closest('.experience-cont').remove();
        return false;
    });

    $(".add-experience").on('click', function () {
        
        if (experienceCount>2){
            $('.hosCounter').addClass('d-block');

        } else {
            experienceCount++;

            var experiencecontent = '<div class="row form-row experience-cont">' +
                '<div class="col-12 col-md-10 col-lg-11">' +
                '<div class="row form-row">' +
                '<div class="col-12 col-md-6 col-lg-4">' +
                '<div class="form-group">' +
                '<label>Hospital Name</label>' +
                '<input type="hidden" name="addNewExpierence" class="form-control">' +
                '<input type="text" name="hospitalName[]" class="form-control" required>' +
                '</div>' +
                '</div>' +
                '<div class="col-12 col-md-6 col-lg-4">' +
                '<div class="form-group">' +
                '<label>From</label>' +
                '<input type="date" name="docStart[]" class="form-control" required>' +
                '</div>' +
                '</div>' +
                '<div class="col-12 col-md-6 col-lg-4">' +
                '<div class="form-group">' +
                '<label>To</label>' +
                '<input type="date" name="docEnd[]" class="form-control" required>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="#" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
                '</div>';

            $(".experience-info").append(experiencecontent);
        }
        return false;
    });







