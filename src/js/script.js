$(document).ready(function () {

    var submitbutton = $("input[name=submit]");
    var regbutton = $("input[name=register]");
    submitbutton.prop('disabled', true);
    regbutton.prop('disabled', true);
    $("* mark").hide();
    $('#billId').on('change', function() {

    });
    checkCustomerData(submitbutton);
    checkCreditCardData(submitbutton);
    checkUserData(regbutton);
    checkCustomerData(regbutton);
    handleAddressCheckbox();
    $('#billId').on('change', function() {
        selectedOption = this.value;
        if (selectedOption == "") {
            submitbutton.prop('disabled', true);
        } else if (selectedOption == "card") {
            checkCreditCardData(submitbutton);
        } else if (selectedOption == "paper"){
            checkBilladdressData(submitbutton);
        }
    });

});

function getBillDiv() {
    var selectedOption = document.getElementById("billId").value;
    if (selectedOption == "") {
        document.getElementById("paper").classList.add("hidden");
        document.getElementById("card").classList.add("hidden");
        $("#card p input").prop('required', false);
        $("#paper p input").prop('required', false);
    } else if (selectedOption == "card") {
        document.getElementById("card").classList.remove("hidden");
        $("#card p input").prop('required', true);
        document.getElementById("paper").classList.add("hidden");
        $("#paper p input").prop('required', false);
    } else if (selectedOption == "paper") {
        document.getElementById("paper").classList.remove("hidden");
        $("#paper p input").prop('required', true);
        $("#address_checkbox input").prop('required', false);
        document.getElementById("card").classList.add("hidden");
        $("#card p input").prop('required', false);
    }
}

function checkAmount() {
    var amout = document.getElementById("amount").value;
    if (amout < 1) {
        document.getElementById("amountAlert").innerHTML = "Amount can't be Zero or negative! Has been reset to 1";
        document.getElementById("amount").value = 1;
    } else {
        document.getElementById("amountAlert").innerHTML = "";
    }
}

function confirmForm() {
    return confirm("You are about to enter into a binding contract. Do you really want to continue?");
}

function cancleForm() {
    var str = "You are about to cancel. Continue?"
    return confirm(str);
}

function checkifempty(val) {
    return !val;
}

function fadeMark(component_id, value, text) {
    var hashtag = "#";
    var mark = " mark";
    var target = hashtag + component_id + mark;
    $(target).html(text);
    if (value) {
        $(target).fadeIn(1000);
    } else {
        $(target).fadeOut(1000);
    }
}

function checkCustomerData(button) {
    var firstname = true,
        lastname = true,
        email = true,
        address = true,
        postalCode = true,
        country = true;

    if (checkifempty($("#Firstname input").value)) {
        firstname = false;
    }

    if (checkifempty($("#Lastname input").value)) {
        firstname = false;
    }


    $("#Firstname input").focusout(function () {
        firstname = checkifempty(this.value);
        fadeMark("Firstname", firstname, "Firstname can't be empty!");
        button.prop('disabled',
            firstname ||
            lastname ||
            email ||
            address ||
            postalCode ||
            country);
    });

    $("#Lastname input").focusout(function () {
        lastname = checkifempty(this.value);
        fadeMark("Lastname", lastname, "Lastname can't be empty!");
        button.prop('disabled',
            firstname ||
            lastname ||
            email ||
            address ||
            postalCode ||
            country);
    });

    $("#Email input").focusout(function () {
        email = checkifempty(this.value.match(/^.+@.+\..+$/));
        fadeMark("Email", email, "Email does not match conditions!");
        button.prop('disabled',
            firstname ||
            lastname ||
            email ||
            address ||
            postalCode ||
            country);
    });

    $("#Address input").focusout(function () {
        address = checkifempty(this.value);
        fadeMark("Address", address, "Address can't be empty!");
        button.prop('disabled',
            firstname ||
            lastname ||
            email ||
            address ||
            postalCode ||
            country);
    });

    $("#PostalCode input").focusout(function () {
        postalCode = checkifempty(this.value.match(/^\d{4}$/));
        fadeMark("PostalCode", postalCode, "Postal Code has to be 4 digits!");
        button.prop('disabled',
            firstname ||
            lastname ||
            email ||
            address ||
            postalCode ||
            country);
    });

    $("#Country input").focusout(function () {
        country = checkifempty(this.value.match(/^[A-Za-z]{2}$/));
        fadeMark("Country", country, "Country has to be two Characters!");
        button.prop('disabled',
            firstname ||
            lastname ||
            email ||
            address ||
            postalCode ||
            country);
    });
}

function checkUserData(button) {
    var username = true,
    password = true,
    retype = true;

    $("#Username input").focusout(function () {
        username = checkifempty(this.value);
        fadeMark("Username", username, "Username can't be empty!");
        button.prop('disabled',
            username ||
            password ||
            retype);
    });

    $("#Password input").focusout(function () {
        password = checkifempty(this.value.match(/^\d*[A-Za-z]+\d*[A-Za-z]*$/));
        fadeMark("Password", password, "Password can't be empty or is not valid (only digits and characters!");
        button.prop('disabled',
            username ||
            password ||
            retype);
    });

    $("#Retype input").focusout(function () {
        retype = checkifempty(this.value.match($("#Password input").val()));
        fadeMark("Retype", retype, "Does not match with Password Field!");
        button.prop('disabled',
            username ||
            password ||
            retype);
    });
}

function checkCreditCardData(button) {
    var card_name = true,
        card_number = true,
        card_cvv = true;

    $("#card_name input").focusout(function () {
        card_name = checkifempty(this.value);
        fadeMark("card_name", card_name, "Cardname can't be empty!");
        button.prop('disabled',
            card_name ||
            card_number ||
            card_cvv);
    });

    $("#card_number input").focusout(function () {
        card_number = checkifempty(this.value.match(/^(\d{4}(\s|-){1}){3}(\d{4})$/));
        fadeMark("card_number", card_number, "Card Number does not match condition!");
        button.prop('disabled',
            card_name ||
            card_number ||
            card_cvv);
    });

    $("#card_cvv input").focusout(function () {
        card_cvv = checkifempty(this.value.match(/^\d{3}$/));
        fadeMark("card_cvv", card_cvv, "CVV has to be 3 Digits!");
        button.prop('disabled',
            card_name ||
            card_number ||
            card_cvv);
    });
}

function handleAddressCheckbox() {
    $("#address_checkbox input").click(function () {
        if (this.checked) {
            var firstname = $("#Firstname input").val();
            var lastname = $("#Lastname input").val();
            var address = $("#Address input").val();
            var postalCode = $("#PostalCode input").val();
            var country = $("#Country input").val();
            $("#bill_firstname input").val(firstname);
            $("#bill_lastname input").val(lastname);
            $("#bill_address input").val(address);
            $("#bill_postalCode input").val(postalCode);
            $("#bill_country input").val(country);
        } else {
            $("#paper p input").val("");
        }
    });
}

function checkBilladdressData(button) {
    var bill_firstname = true,
    bill_lastname = true,
    bill_address = true,
    bill_postalCode = true,
    bill_country = true;

    $("#bill_firstname input").focusout(function () {
        bill_firstname = checkifempty(this.value);
        fadeMark("bill_firstname", bill_firstname, "Firstname can't be empty!");
        button.prop('disabled',
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#bill_lastname input").focusout(function () {
        bill_lastname = checkifempty(this.value);
        fadeMark("bill_lastname", bill_lastname, "Lastname can't be empty!");
        button.prop('disabled',
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#bill_address input").focusout(function () {
        bill_address = checkifempty(this.value);
        fadeMark("bill_address", bill_address, "Address can't be empty!");
        button.prop('disabled',
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#bill_postalCode input").focusout(function () {
        bill_postalCode = checkifempty(this.value.match(/^\d{4}$/));
        fadeMark("bill_postalCode", bill_postalCode, "Postal Code has to be 4 Digits!");
        button.prop('disabled',
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#bill_country input").focusout(function () {
        bill_country = checkifempty(this.value.match(/^[A-Za-z]{2}$/));
        fadeMark("bill_country", bill_country, "Country has to be two Characters!");
        button.prop('disabled',
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });
}