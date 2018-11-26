function getBillDiv() {
    var selectedOption = document.getElementById("billId").value;
    if (selectedOption == "") {
        document.getElementById("paper").classList.add("hidden");
        document.getElementById("card").classList.add("hidden");
        $("#card p input").prop('required', false);
        $("#bill p input").prop('required', false);
    } else if (selectedOption == "card") {
        document.getElementById("card").classList.remove("hidden");
        $("#card p input").prop('required', true);
        document.getElementById("paper").classList.add("hidden");
        $("#bill p input").prop('required', false);
    } else {
        document.getElementById("paper").classList.remove("hidden");
        $("#bill p input").prop('required', true);
        document.getElementById("card").classList.add("hidden");
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
        fadeMark("customer_Firstname", customer_firstname);
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
        fadeMark("customer_Lastname", customer_lastname);
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
        fadeMark("customer_Email", customer_email);
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
        fadeMark("customer_Address", customer_address);
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
        fadeMark("customer_PostalCode", customer_postalCode);
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
        fadeMark("customer_Country", customer_country);
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
                fadeMark("card_name", card_name);
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
                fadeMark("card_number", card_number);
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
                fadeMark("card_cvv", card_cvv);
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
                fadeMark("bill_firstname", bill_firstname);
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
                fadeMark("bill_lastname", bill_lastname);
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
                fadeMark("bill_address", bill_address);
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
                fadeMark("bill_postalCode", bill_postalCode);
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
                fadeMark("bill_country", bill_country);
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



});

function checkifempty(val) {
    return !val;
}

function fadeMark(component_id, value) {
    var hashtag = "#";
    var mark = " mark";
    var target = hashtag + component_id + mark;
    if (value) {
        $(target).fadeIn(1000);
    } else {
        $(target).fadeOut(1000);
    }
}

