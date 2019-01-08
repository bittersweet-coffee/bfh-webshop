<?php

class UserareaModel {

    private $headerText = "Userarea";
    private $welcomeText = "Welcome";
    private $pText = "In this section you have the following options";
    private $user;
    private $userActions = array(
        "changeCustomerData" => "Change customer data",
        "changeUserData" => "Change user data",
        "logout" => "Logout");
    private $adminActions = array(
        "addProduct" => "Add a new Product",
        "deleteProduct" => "Delete a Product",
        "updateProduct" => "Update a Product"
    );
    private $adminText = "As shopadmin you have the following options";
    private $display;
    private $info = "";

    public function __construct(array $user) {
        $this->user=$user;
    }

    public function t(string $t) {
        return translate($t);
    }

    public function getHeaderText(): string{
        return translate($this->headerText);
    }

    public function getPText(): string
    {
        return translate($this->pText);
    }

    public function getWelcomeText(): string {
        return translate($this->welcomeText) . " " . $this->user['username'];
    }

    public function getUserActions(): array {
        return $this->userActions;
    }

    public function getAdminActions(): array {
        return $this->adminActions;
    }

    public function getAdminText(): string {
        return translate($this->adminText);
    }

    public function setDisplay($display): void {
        $this->display = $display;
    }

    public function getDisplay() {
        return $this->display;
    }

    public function getUser(): array {
        return $this->user;
    }

    public function setInfo(string $text): void {
        $this->info = $text;
    }

    public function getInfo() {
        return translate($this->info);
    }

    public function changePassword($username, $password) {
        return User::changePassword($username,$password);
    }

    public function changeCustomer(string $fname, string $lname, string $addr, int $pc, string $mail, string $cntry) {
        return Customer::updateCustomer($this->user['username'], $fname, $lname, $addr, $pc, $mail, $cntry);
    }

    public function getCustomer($username){
        return Customer::getCustomer($username);
    }

    public function addProduct($type, $pEN, $pDE, $price, $dEN="", $dDE="") {
        return Product::storeProduct($type, $pEN, $pDE, $price, $dEN, $dDE);
    }

    public function updateProduct($old_name, $pEN, $pDE, $price, $dEN="", $dDE="") {
        return Product::updateProduct($old_name, $pEN, $pDE, $price, $dEN, $dDE);
    }

    public function deleteProduct($prod) {
        return Product::deleteProduct($prod);
    }

}