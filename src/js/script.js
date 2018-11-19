function getBillDiv() {
    var selectedOption = document.getElementById("billId").value;
    if (selectedOption == "") {
        document.getElementById("paper").classList.add("hidden");
        document.getElementById("card").classList.add("hidden");
    } else if (selectedOption == "card") {
        document.getElementById("card").classList.remove("hidden");
        document.getElementById("paper").classList.add("hidden");
    } else {
        document.getElementById("paper").classList.remove("hidden");
        document.getElementById("card").classList.add("hidden");
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