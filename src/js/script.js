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

$(document).ready(function () {

    var submitbutton = $("input[name=submit]");
    submitbutton.prop('disabled', true);
    $("* mark").hide();
    var selectOption = true,
        customer_firstname = true,
        customer_lastname = true,
        customer_email = true,
        customer_address = true,
        customer_postalCode = true,
        customer_country = true,
        card_name = true,
        card_number = true,
        card_cvv = true,
        bill_firstname = true,
        bill_lastname = true,
        bill_address = true,
        bill_postalCode = true,
        bill_country = true;

    $("#address_checkbox input").click(function () {
        if (this.checked) {
            var firstname = $("#customer_Firstname input").val();
            var lastname = $("#customer_Lastname input").val();
            var address = $("#customer_Address input").val();
            var postalCode = $("#customer_PostalCode input").val();
            var country = $("#customer_Country input").val();
            $("#bill_firstname input").val(firstname);
            $("#bill_lastname input").val(lastname);
            $("#bill_address input").val(address);
            $("#bill_postalCode input").val(postalCode);
            $("#bill_country input").val(country);
            bill_firstname = false;
            bill_lastname = false;
            bill_address = false;
            bill_postalCode = false;
            bill_country = false;
            submitbutton.prop('disabled',
                selectOption ||
                customer_firstname ||
                customer_lastname ||
                customer_email ||
                customer_address ||
                customer_postalCode ||
                customer_country ||
                card_name ||
                card_number ||
                card_cvv ||
                bill_firstname ||
                bill_lastname ||
                bill_address ||
                bill_postalCode ||
                bill_country);
        } else {
            $("#paper p input").val("");
            bill_firstname = true;
            bill_lastname = true;
            bill_address = true;
            bill_postalCode = true;
            bill_country = true;
            submitbutton.prop('disabled',
                selectOption ||
                customer_firstname ||
                customer_lastname ||
                customer_email ||
                customer_address ||
                customer_postalCode ||
                customer_country ||
                card_name ||
                card_number ||
                card_cvv ||
                bill_firstname ||
                bill_lastname ||
                bill_address ||
                bill_postalCode ||
                bill_country);
        }
    });

    $("#customer_Firstname input").focusout(function () {
        customer_firstname = checkifempty(this.value);
        fadeMark("customer_Firstname", customer_firstname, "Firstname can't be empty!");
        submitbutton.prop('disabled',
            selectOption ||
            customer_firstname ||
            customer_lastname ||
            customer_email ||
            customer_address ||
            customer_postalCode ||
            customer_country ||
            card_name ||
            card_number ||
            card_cvv ||
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#customer_Lastname input").focusout(function () {
        customer_lastname = checkifempty(this.value);
        fadeMark("customer_Lastname", customer_lastname, "Lastname can't be empty!");
        submitbutton.prop('disabled',
            selectOption ||
            customer_firstname ||
            customer_lastname ||
            customer_email ||
            customer_address ||
            customer_postalCode ||
            customer_country ||
            card_name ||
            card_number ||
            card_cvv ||
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#customer_Email input").focusout(function () {
        customer_email = checkifempty(this.value.match(/^.+@.+\..+$/));
        fadeMark("customer_Email", customer_email, "Email does not match conditions!");
        submitbutton.prop('disabled',
            selectOption ||
            customer_firstname ||
            customer_lastname ||
            customer_email ||
            customer_address ||
            customer_postalCode ||
            customer_country ||
            card_name ||
            card_number ||
            card_cvv ||
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#customer_Address input").focusout(function () {
        customer_address = checkifempty(this.value);
        fadeMark("customer_Address", customer_address, "Address can't be empty!");
        submitbutton.prop('disabled',
            selectOption ||
            customer_firstname ||
            customer_lastname ||
            customer_email ||
            customer_address ||
            customer_postalCode ||
            customer_country ||
            card_name ||
            card_number ||
            card_cvv ||
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#customer_PostalCode input").focusout(function () {
        customer_postalCode = checkifempty(this.value.match(/^\d{4}$/));
        fadeMark("customer_PostalCode", customer_postalCode, "Postal Code has to be 4 digits!");
        submitbutton.prop('disabled',
            selectOption ||
            customer_firstname ||
            customer_lastname ||
            customer_email ||
            customer_address ||
            customer_postalCode ||
            customer_country ||
            card_name ||
            card_number ||
            card_cvv ||
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $("#customer_Country input").focusout(function () {
        customer_country = checkifempty(this.value.match(/^[A-Za-z]{2}$/));
        fadeMark("customer_Country", customer_country, "Country has to be two Characters!");
        submitbutton.prop('disabled',
            selectOption ||
            customer_firstname ||
            customer_lastname ||
            customer_email ||
            customer_address ||
            customer_postalCode ||
            customer_country ||
            card_name ||
            card_number ||
            card_cvv ||
            bill_firstname ||
            bill_lastname ||
            bill_address ||
            bill_postalCode ||
            bill_country);
    });

    $('#billId').on('change', function() {
        selectedOption = this.value;
        if (selectedOption == "") {
            selectOption = true;
            card_name = false;
            card_number = false;
            card_cvv = false;
            bill_firstname = false;
            bill_lastname = false;
            bill_address = false;
            bill_postalCode = false;
            bill_country = false;
        } else if (selectedOption == "card") {
            selectOption = false;
            bill_firstname = false;
            bill_lastname = false;
            bill_address = false;
            bill_postalCode = false;
            bill_country = false;
            $("#card_name input").focusout(function () {
                card_name = checkifempty(this.value);
                fadeMark("card_name", card_name, "Cardname can't be empty!");
                submitbutton.prop('disabled',
                    selectOption ||
                    customer_firstname ||
                    customer_lastname ||
                    customer_email ||
                    customer_address ||
                    customer_postalCode ||
                    customer_country ||
                    card_name ||
                    card_number ||
                    card_cvv ||
                    bill_firstname ||
                    bill_lastname ||
                    bill_address ||
                    bill_postalCode ||
                    bill_country);
            });

            $("#card_number input").focusout(function () {
                card_number = checkifempty(this.value.match(/^(\d{4}(\s|-){1}){3}(\d{4})$/));
                fadeMark("card_number", card_number, "Card Number does not match condition!");
                submitbutton.prop('disabled',
                    selectOption ||
                    customer_firstname ||
                    customer_lastname ||
                    customer_email ||
                    customer_address ||
                    customer_postalCode ||
                    customer_country ||
                    card_name ||
                    card_number ||
                    card_cvv ||
                    bill_firstname ||
                    bill_lastname ||
                    bill_address ||
                    bill_postalCode ||
                    bill_country);
            });

            $("#card_cvv input").focusout(function () {
                card_cvv = checkifempty(this.value.match(/^\d{3}$/));
                fadeMark("card_cvv", card_cvv, "CVV has to be 3 Digits!");
                submitbutton.prop('disabled',
                    selectOption ||
                    customer_firstname ||
                    customer_lastname ||
                    customer_email ||
                    customer_address ||
                    customer_postalCode ||
                    customer_country ||
                    card_name ||
                    card_number ||
                    card_cvv ||
                    bill_firstname ||
                    bill_lastname ||
                    bill_address ||
                    bill_postalCode ||
                    bill_country);
            });
        } else {
            selectOption = false;
            card_name = false;
            card_number = false;
            card_cvv = false;
            $("#bill_firstname input").focusout(function () {
                bill_firstname = checkifempty(this.value);
                fadeMark("bill_firstname", bill_firstname, "Firstname can't be empty!");
                submitbutton.prop('disabled',
                    selectOption ||
                    customer_firstname ||
                    customer_lastname ||
                    customer_email ||
                    customer_address ||
                    customer_postalCode ||
                    customer_country ||
                    card_name ||
                    card_number ||
                    card_cvv ||
                    bill_firstname ||
                    bill_lastname ||
                    bill_address ||
                    bill_postalCode ||
                    bill_country);
            });

            $("#bill_lastname input").focusout(function () {
                bill_lastname = checkifempty(this.value);
                fadeMark("bill_lastname", bill_lastname, "Lastname can't be empty!");
                submitbutton.prop('disabled',
                    selectOption ||
                    customer_firstname ||
                    customer_lastname ||
                    customer_email ||
                    customer_address ||
                    customer_postalCode ||
                    customer_country ||
                    card_name ||
                    card_number ||
                    card_cvv ||
                    bill_firstname ||
                    bill_lastname ||
                    bill_address ||
                    bill_postalCode ||
                    bill_country);
            });

            $("#bill_address input").focusout(function () {
                bill_address = checkifempty(this.value);
                fadeMark("bill_address", bill_address, "Address can't be empty!");
                submitbutton.prop('disabled',
                    selectOption ||
                    customer_firstname ||
                    customer_lastname ||
                    customer_email ||
                    customer_address ||
                    customer_postalCode ||
                    customer_country ||
                    card_name ||
                    card_number ||
                    card_cvv ||
                    bill_firstname ||
                    bill_lastname ||
                    bill_address ||
                    bill_postalCode ||
                    bill_country);
            });

            $("#bill_postalCode input").focusout(function () {
                bill_postalCode = checkifempty(this.value.match(/^\d{4}$/));
                fadeMark("bill_postalCode", bill_postalCode, "Postal Code has to be 4 Digits!");
                submitbutton.prop('disabled',
                    selectOption ||
                    customer_firstname ||
                    customer_lastname ||
                    customer_email ||
                    customer_address ||
                    customer_postalCode ||
                    customer_country ||
                    card_name ||
                    card_number ||
                    card_cvv ||
                    bill_firstname ||
                    bill_lastname ||
                    bill_address ||
                    bill_postalCode ||
                    bill_country);
            });

            $("#bill_country input").focusout(function () {
                bill_country = checkifempty(this.value.match(/^[A-Za-z]{2}$/));
                fadeMark("bill_country", bill_country, "Country has to be two Characters!");
                submitbutton.prop('disabled',
                    selectOption ||
                    customer_firstname ||
                    customer_lastname ||
                    customer_email ||
                    customer_address ||
                    customer_postalCode ||
                    customer_country ||
                    card_name ||
                    card_number ||
                    card_cvv ||
                    bill_firstname ||
                    bill_lastname ||
                    bill_address ||
                    bill_postalCode ||
                    bill_country);
            });
        }
    });
    var submitbutton = $("input[name=register]");
    submitbutton.prop('disabled', true);
    $("* mark").hide();
    var user_firstname = true,
        user_lastname = true,
        user_email = true,
        user_address = true,
        user_postalCode = true,
        user_country = true,
        user_name = true,
        user_password = true,
        user_retype = true;

    $("#user_Firstname input").focusout(function () {
        user_firstname = checkifempty(this.value);
        fadeMark("user_Firstname", user_firstname, "Firstname can't be empty!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });

    $("#user_Lastname input").focusout(function () {
        user_lastname = checkifempty(this.value);
        fadeMark("user_Lastname", user_lastname, "Lastname can't be empty!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });

    $("#user_Email input").focusout(function () {
        user_email = checkifempty(this.value.match(/^.+@.+\..+$/));
        fadeMark("user_Email", user_email, "Email does not match conditions!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });

    $("#user_Address input").focusout(function () {
        user_address = checkifempty(this.value);
        fadeMark("user_Address", user_address, "Address can't be empty!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });

    $("#user_PostalCode input").focusout(function () {
        user_postalCode = checkifempty(this.value.match(/^\d{4}$/));
        fadeMark("user_PostalCode", user_postalCode, "Postal Code has to be 4 digits!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });

    $("#user_Country input").focusout(function () {
        user_country = checkifempty(this.value.match(/^[A-Za-z]{2}$/));
        fadeMark("user_Country", user_country, "Country has to be two Characters!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });

    $("#user_Username input").focusout(function () {
        user_name = checkifempty(this.value);
        fadeMark("user_Username", user_name, "Username can't be empty!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });

    $("#user_Password input").focusout(function () {
        user_password = checkifempty(this.value.match(/^\d*[A-Za-z]+\d*[A-Za-z]*$/));
        fadeMark("user_Password", user_password, "Password can't be empty or is not valid (only digits and characters!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });

    $("#user_Retype input").focusout(function () {
        user_retype = checkifempty(this.value.match($("#user_Password input").val()));
    //"Does not match with Password!"
        fadeMark("user_Retype", user_retype, "Does not match with Password Field!");
        submitbutton.prop('disabled',
            user_firstname ||
            user_lastname ||
            user_email ||
            user_address ||
            user_postalCode ||
            user_country ||
            user_name ||
            user_password ||
            user_retype);
    });
});

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

