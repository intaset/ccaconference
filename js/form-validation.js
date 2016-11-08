// Wait for the DOM to be ready
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='registration']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      title: {
        required: true,
      },
      First_Name: "required",
      Last_Name: "required",
      affiliation: "required",
      address: "required",
      country: "required",
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      Session_Chair: "required",
      student: "required",
      Date_of_Payment_Transaction: "required",
      file: "required",
      Do_you_need_an_official_Paper_Acceptance_Letter: "required",
      Do_you_need_an_official_Invitation_Letter: "required",
      Do_you_need_an_official_Certificate_of_Attendance: "required",
      Do_you_need_an_official_Paid_Invoice: "required",
      Registrant_Agreement: "required"
    },
    // Specify validation error messages
    messages: {
      title: "Please select your prefix",
      First_Name: "Please enter your first name",
      Last_Name: "Please enter your last name",
      affiliation: "Please specify the name of your institution",
      address: "Please specify your address",
      country: "Please select your country",
      email: "Please enter a valid email address",
      Session_Chair: "Please specify an answer",
      student: "Please specify an answer",
      Date_of_Payment_Transaction: "Please specify the date of your payment transaction.",
      file: "Please upload your receipt",
      Do_you_need_an_official_Paper_Acceptance_Letter: "Please specify an answer",
      Do_you_need_an_official_Invitation_Letter: "Please specify an answer",
      Do_you_need_an_official_Certificate_of_Attendance: "Please specify an answer",
      Do_you_need_an_official_Paid_Invoice: "Please specify an answer",
      Registrant_Agreement: "Please agree to the terms and regulations",
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});