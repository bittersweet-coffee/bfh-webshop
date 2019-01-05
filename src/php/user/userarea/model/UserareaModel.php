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
        return $this->pText;
    }

    public function getWelcomeText(): string {
        return translate($this->welcomeText) . $this->user['username'];
    }

    public function getUserActions(): array {
        return $this->userActions;
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

}