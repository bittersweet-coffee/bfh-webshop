function getBillDiv() {
    var selectedOption = document.getElementById("billId").value;
    if (selectedOption == "") {
        document.getElementById("paper").classList.add("hidden");
        document.getElementById("card").classList.add("hidden");
        document.getElementById("card_name").removeAttribute("required");
        document.getElementById("card_number").removeAttribute("required");
        document.getElementById("card_cvv").removeAttribute("required");
        document.getElementById("bill_firstname").removeAttribute("required");
        document.getElementById("bill_lastname").removeAttribute("required");
        document.getElementById("bill_address").removeAttribute("required");
        document.getElementById("bill_postalCode").removeAttribute("required");
        document.getElementById("bill_country").removeAttribute("required");

    } else if (selectedOption == "card") {
        document.getElementById("card").classList.remove("hidden");
        document.getElementById("card_name").setAttribute("required", "");
        document.getElementById("card_number").setAttribute("required", "");
        document.getElementById("card_cvv").setAttribute("required", "");
        document.getElementById("paper").classList.add("hidden");
        document.getElementById("bill_firstname").removeAttribute("required");
        document.getElementById("bill_lastname").removeAttribute("required");
        document.getElementById("bill_address").removeAttribute("required");
        document.getElementById("bill_postalCode").removeAttribute("required");
        document.getElementById("bill_country").removeAttribute("required");

    } else {
        document.getElementById("paper").classList.remove("hidden");
        document.getElementById("bill_firstname").setAttribute("required", "");
        document.getElementById("bill_lastname").setAttribute("required", "");
        document.getElementById("bill_address").setAttribute("required", "");
        document.getElementById("bill_postalCode").setAttribute("required", "");
        document.getElementById("bill_country").setAttribute("required", "");
        document.getElementById("card").classList.add("hidden");
        document.getElementById("card_name").removeAttribute("required");
        document.getElementById("card_number").removeAttribute("required");
        document.getElementById("card_cvv").removeAttribute("required");
    }
}

function getCustomerData() {
    var firstname = document.getElementById("customer_firstname").value;
    var lastname = document.getElementById("customer_lastname").value;
    var address = document.getElementById("customer_address").value;
    var postalCode = document.getElementById("customer_postalCode").value;
    var country = document.getElementById("customer_country").value;

    var checked = document.getElementById("address_checkbox");
    if (checked.checked) {
        document.getElementById("bill_firstname").value = firstname;
        document.getElementById("bill_lastname").value = lastname;
        document.getElementById("bill_address").value = address;
        document.getElementById("bill_postalCode").value = postalCode;
        document.getElementById("bill_country").value = country;
    } else {
        document.getElementById("bill_firstname").value = "";
        document.getElementById("bill_lastname").value = "";
        document.getElementById("bill_address").value = "";
        document.getElementById("bill_postalCode").value = "";
        document.getElementById("bill_country").value = "";
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