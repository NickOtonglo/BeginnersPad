function telephoneValidation(telephone)
{
  // var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
  // var phoneno = /^\d{10}$/;
  var phoneNo = /^\+?{13}$/;
  if((telephone.value.match(phoneNo)){
    return true;
  }
  else {
    alert("Not a valid phone number");
    return false;
  }
}