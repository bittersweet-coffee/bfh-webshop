<?php

class UserareaController {

    private $model;

    public function __construct(UserareaModel $model) {
        $this->model = $model;
    }

    public function none() {
        $this->model->setInfo("Select an option to perform it");
    }

    public function logout() {
        $this->model->setDisplay(displayLogoutMenu());
    }

    public function changeUserData() {
        $forms = new UserareaUserForm(getLanguage(["en", "de"]), "userarea");
        $this->model->setDisplay($forms->render());
    }

    public function changeCustomerData() {
        $forms =  new UserareaCustomerForms(getLanguage(["en", "de"]), "userarea");
        $this->model->setDisplay($forms->render());
    }

    public function changePassword(string $oldpw, $newpw) {
        $username = $this->model->getUser()['username'];
        if (checkUserExistence($username) && checkPassword($username, $oldpw)) {
            $success = $this->model->changePassword($username, $newpw);
            if (!$success) {
                $this->model->setInfo("Password successfully changed. You should log in again to check it.");
            } else {
                createErrorUrl("QueryFailed");
            }
        } else {
            $this->model->setInfo("Your old password does not seem to be correct.");
        }
    }



}