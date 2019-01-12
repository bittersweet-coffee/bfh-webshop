$(document).ready(function () {
    var btn = $("input[type=submit]");
    $("* mark").hide();
    checkCustomerData(btn);
    checkUserData(btn);
    handleAddressCheckbox();
    $('#billId').on('change', function() {
        selectedOption = this.value;
        if (selectedOption == "") {
            btn.prop('disabled', true);
        } else if (selectedOption == "card") {
            checkCreditCardData(btn);
        } else if (selectedOption == "paper"){
            checkBilladdressData(btn);
        }
    });
});

function addToCart(product) {
    $.ajax({
        type: 'GET',
        url: 'php/products/ShoppingCart.php',
        data: { actionCart: "add",
                product: product},
                success: function(response) {
                    var t = "";
                    var lang = getUrlParameter('lang');
                    if (lang == "de") {
                        t = "Korb: ";
                    } else {
                        t = "Cart: "
                    }
                    $("#cart a").html(t + response);
                }
    });
}

function addMore(name, price) {
    $.ajax({
        type: 'GET',
        url: 'php/products/ShoppingCart.php',
        data: { actionCart: "addMore",
            product: name},
            success: function(response) {
                var r = response.split(",").map(Number);
                var t = "";
                var lang = getUrlParameter('lang');
                if (lang == "de") {
                    t = "Korb: ";
                } else {
                    t = "Cart: "
                }
                $("#cart a").html(t + (Math.round(r[0] * 10)/10));
                var row_total = (Math.round((r[1] * price)*10)/10);
                setRowTotal(name, row_total);
                setAmount(name, (Math.round(r[1] * 10)/10));
                if (r[1] > 0) {
                    var id = "[id='" + name + "']" + " #remove button";
                    $(id).prop('disabled', false);
                }
                var total = $("#supertotal").html();
                total = parseInt(total) + parseInt(price);
                setTotal((Math.round(total*10))/10);
        }
    });
}

function setRowTotal(product, row_total) {
    var id = "[id='" + product + "']" + " #rowtotal";
    $(id).html(row_total);
}

function setAmount(product, amount) {
    var id = "[id='" + product + "']" + " #amount";
    $(id).html(amount);
}

function setTotal(total) {
    $("#supertotal").html(total)
}

function remove(name, price) {
    $.ajax({
        type: 'GET',
        url: 'php/products/ShoppingCart.php',
        data: { actionCart: "remove",
            product: name},
            success: function(response) {
                var r = response.split(",").map(Number);
                var t = "";
                var lang = getUrlParameter('lang');
                if (lang == "de") {
                    t = "Korb: ";
                } else {
                    t = "Cart: "
                }
                var amount_total = r[0];
                if (isNaN(amount_total)) {
                    amount_total = 0;
                }
                var amount = r[1];
                if (isNaN(amount)) {
                    amount = 0;
                }
                $("#cart a").html(t + (Math.round(amount_total *10)/10));
                var row_total = (Math.round((amount * price)*10)/10);
                setRowTotal(name, row_total);
                setAmount(name, amount);
                var total = $("#supertotal").html();
                var p = price;
                if (amount == 0) {
                    var id = "[id='" + name + "']" + " #remove button";
                    $(id).prop('disabled', true);
                }
                total = Math.round((parseInt(total) - parseInt(p))*10)/10;
                if (total <= 0) {
                    total = 0;
                }
                setTotal(total);
        }
    });
}

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

function confirmForm() {
    var lang = getUrlParameter('lang');
    if (lang == "de") {
        return confirm("Du bist dabei, einen verbindlichen Vertrag abzuschließen. " +
            "Willst du wirklich weitermachen?");
    } else {
        return confirm("You are about to enter into a binding contract. " +
            "Do you really want to continue?");
    }
}

function cancleForm() {
    var lang = getUrlParameter('lang');
    if (lang == "de") {
        return confirm("Du bist im Begriff, abzubrechen. Fortfahren?");
    } else {
        return confirm("You are about to cancel. Continue?");
    }
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

    $("#Firstname input").focusout(function () {
        firstname = checkifempty(this.value.match(/^[A-Za-z]+\d*\s*[A-Za-z]*\d*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Firstname", firstname, "Vorname kann nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("Firstname", firstname, "Firstname can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', firstname);
    });

    $("#Lastname input").focusout(function () {
        lastname = checkifempty(this.value.match(/^[A-Za-z]+\d*\s*[A-Za-z]*\d*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Lastname", lastname, "Nachname kann nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("Lastname", lastname, "Lastname can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', lastname);
    });

    $("#Email input").focusout(function () {
        email = checkifempty(this.value.match(/^.+@.+\..+$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Email", email, "E-Mail stimmt nicht mit den Bedingungen überein.");
        } else {
            fadeMark("Email", email, "Email does not match conditions.");
        }
        button.prop('disabled', email);
    });

    $("#Address input").focusout(function () {
        address = checkifempty(this.value.match(/^[A-Za-z]+\d*\s*\d*[A-Za-z]*\d*[A-Za-z]*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Address", address, "Adresse kann nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("Address", address, "Address can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', address);
    });

    $("#PostalCode input").focusout(function () {
        postalCode = checkifempty(this.value.match(/^\d{4}$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("PostalCode", postalCode, "Die Postleitzahl muss aus 4 Ziffern bestehen.");
        } else {
            fadeMark("PostalCode", postalCode, "Postal Code has to be 4 digits.");
        }
        button.prop('disabled', postalCode);
    });

    $("#Country input").focusout(function () {
        country = checkifempty(this.value.match(/^[A-Za-z]{2}$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Country", country, "Der Ländercode muss aus zwei Buchstaben bestehen.");
        } else {
            fadeMark("Country", country, "The country code must consist of two letters.");
        }
        button.prop('disabled', country);
    });
}

function checkUserData(button) {
    var username = true,
        password = true,
        oldpassword = true,
        newpassword = true,
        retype = true;

    $("#Username input").focusout(function () {
        username = checkifempty(this.value.match(/^[A-Za-z]+\d*[A-Za-z]*\d*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Username", username, "Der Benutzername darf nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("Username", username, "Username can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', username);
    });

    $("#Password input").focusout(function () {
        password = checkifempty(this.value.match(/^\d*[A-Za-z]+\d*[A-Za-z]*[!]*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Password", password, "Das Passwort darf nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("Password", password, "Password can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', password);
    });

    $("#Oldpassword input").focusout(function () {
        oldpassword = checkifempty(this.value.match(/^\d*[A-Za-z]+\d*[A-Za-z]*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Oldpassword", oldpassword, "Das Passwort darf nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("Oldpassword", oldpassword, "Password can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', oldpassword);
    });

    $("#Newpassword input").focusout(function () {
        newpassword = checkifempty(this.value.match(/^\d*[A-Za-z]+\d*[A-Za-z]*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Newpassword", newpassword, "Das Passwort darf nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("Newpassword", newpassword, "Password can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', newpassword);
    });

    $("#Retype input").focusout(function () {
        retype = checkifempty(this.value.match($("#Password input").val()));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Retype", retype, "Passt nicht zum Passwortfeld!");
        } else {
            fadeMark("Retype", retype, "Does not match with Password Field!");
        }
        button.prop('disabled', retype);
    });

    $("#Retype input").focusout(function () {
        retype = checkifempty(this.value.match($("#Newpassword input").val()));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("Retype", retype, "Passt nicht zum Passwortfeld!");
        } else {
            fadeMark("Retype", retype, "Does not match with Password Field!");
        }
        button.prop('disabled', retype);
    });
}

function checkCreditCardData(button) {
    var card_name = true,
        card_number = true,
        card_cvv = true;

    $("#card_name input").focusout(function () {
        card_name = checkifempty(this.value);
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("card_name", card_name, "Der Kartenname darf nicht leer sein!");
        } else {
            fadeMark("card_name", card_name, "Cardname can't be empty!");
        }
        button.prop('disabled', card_name);
    });

    $("#card_number input").focusout(function () {
        card_number = checkifempty(this.value.match(/^(\d{4}(\s|-){1}){3}(\d{4})$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("card_number", card_number, "Die Kartennummer stimmt nicht mit der Bedingung überein! " +
                "Zahlenblöcke müssen mit Leerzeichen oder Minus (-) getrennt werden.");
        } else {
            fadeMark("card_number", card_number, "The card number does not match the condition! " +
                "Number blocks must be separated with spaces or minus (-).");
        }
        button.prop('disabled', card_number);
    });

    $("#card_cvv input").focusout(function () {
        card_cvv = checkifempty(this.value.match(/^\d{3}$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("card_cvv", card_cvv, "CVV muss aus 3 Zahlen bestehen!");
        } else {
            fadeMark("card_cvv", card_cvv, "CVV has to be 3 numbers!");
        }
        button.prop('disabled', card_cvv);
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
        bill_firstname = checkifempty(this.value.match(/^[A-Za-z]+\d*\s*[A-Za-z]*\d*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("bill_firstname", bill_firstname, "Vorname kann nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("bill_firstname", bill_firstname, "Firstname can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', bill_firstname);
    });

    $("#bill_lastname input").focusout(function () {
        bill_lastname = checkifempty(this.value.match(/^[A-Za-z]+\d*\s*[A-Za-z]*\d*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("bill_firstname", bill_firstname, "Nachname kann nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("bill_firstname", bill_firstname, "Lastname can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', bill_firstname);
    });

    $("#bill_address input").focusout(function () {
        bill_address = checkifempty(this.value.match(/^[A-Za-z]+\d*\s*\d*[A-Za-z]*\d*[A-Za-z]*$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("bill_address", bill_address, "Adresse kann nicht leer sein. " +
                "Es sind nur Zahlen und Buchstaben erlaubt.");
        } else {
            fadeMark("bill_address", bill_address, "Address can't be empty. " +
                "Only numbers and letters are allowed.");
        }
        button.prop('disabled', bill_address);
    });

    $("#bill_postalCode input").focusout(function () {
        bill_postalCode = checkifempty(this.value.match(/^\d{4}$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("bill_postalCode", bill_postalCode, "Die Postleitzahl muss aus 4 Ziffern bestehen.");
        } else {
            fadeMark("bill_postalCode", bill_postalCode, "Postal Code has to be 4 digits.");
        }
        button.prop('disabled', bill_postalCode);
    });

    $("#bill_country input").focusout(function () {
        bill_country = checkifempty(this.value.match(/^[A-Za-z]{2}$/));
        var lang = getUrlParameter('lang');
        if (lang == "de") {
            fadeMark("bill_country", bill_country, "Der Ländercode muss aus zwei Buchstaben bestehen.");
        } else {
            fadeMark("bill_country", bill_country, "The country code must consist of two letters.");
        }
        button.prop('disabled', bill_country);
    });
}

//fond and copied from here : "https://davidwalsh.name/query-string-javascript"
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? name : decodeURIComponent(results[1].replace(/\+/g, ' '));
}
