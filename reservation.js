function validateReservationForm() {
  var form = document.forms["myForm"];

  let CurrentDate = new Date();
  let pickup_time = new Date(form["pickup_time"].value);
  let return_time = new Date(form["return_time"].value);
  CurrentDate.setHours(0, 0, 0, 0);
  pickup_time.setHours(0, 0, 0, 0);
  return_time.setHours(0, 0, 0, 0);
  if (pickup_time < CurrentDate) {
    alert("Pickup date must be greater than or equal the current date.");
    return false;
  }

  if (return_time < CurrentDate) {
    alert("Return date must be after the current date.");
    return false;
  }

  if (pickup_time > return_time) {
    alert("Pickup Time must be before the Return Time");
    return false;
  }

  var creditRadio = document.getElementById("credit");
  if (creditRadio.checked) {
    // Validate credit card details
    var cardNumber = form["card_number"].value.trim();
    var cardholderName = form["cardholder_name"].value.trim();
    var expirationDate = new Date(form["expiration_date"].value.trim());
    var cvv = form["cvv"].value.trim();

    if (cardNumber === "") {
      alert("Please Enter Card Number");
      return false;
    }
    if (cardholderName === "") {
      alert("Please Enter card Holder Name");
      return false;
    }
    if (expirationDate === "") {
      alert("Please Expiration Date");
      return false;
    }
    if (cvv === "") {
      alert("Please enter CVV.");
      return false;
    }

    if (cardNumber.length !== 16) {
      alert("Please enter a valid 16-digit credit card number.");
      return false;
    }

    var sum = 0;
    var isEven = false;

    for (var i = cardNumber.length - 1; i >= 0; i--) {
      var digit = parseInt(cardNumber.charAt(i), 10);

      if (isEven) {
        digit *= 2;
        if (digit > 9) {
          digit -= 9;
        }
      }

      sum += digit;
      isEven = !isEven;
    }

    if (sum % 10 !== 0) {
      alert("The credit card number is not valid.");
      return false;
    }

    var nameRegex = /^[A-Za-z\s]+$/;

    if (!nameRegex.test(cardholderName)) {
      alert(
        "Please enter a valid cardholder name with only letters and spaces."
      );
      return false;
    }
    if (expirationDate < CurrentDate) {
      alert("Invalid expiration date. Please enter a date in the future.");
      return false;
    }

    var regex = /^\d{3}$/;
    if (!regex.test(cvv)) {
      alert("Invalid CVV. Please enter a valid 3-digit number.");
      return false;
    }
  }

  return true;
}

function toggleCreditCardDetails() {
  var creditCardDetails = document.getElementById("creditCardDetails");
  var creditRadio = document.getElementById("credit");

  if (creditRadio.checked) {
    creditCardDetails.style.display = "block";
  } else {
    creditCardDetails.style.display = "none";
  }
}
