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