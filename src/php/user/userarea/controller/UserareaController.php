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

    public function changeCustomer(string $fname, string $lname, string $addr, int $pc, string $mail, string $cntry) {
        $username = $this->model->getUser()['username'];
        if (checkUserExistence($username) && checkLogin()) {
            $success = $this->model->changeCustomer(
                htmlspecialchars($fname),
                htmlspecialchars($lname),
                htmlspecialchars($addr),
                htmlspecialchars($pc),
                htmlspecialchars($mail),
                htmlspecialchars($cntry));
            if (!$success) {
                $user = $this->updateSession($username);
                $this->model->setInfo("Customer data has been updated and is spread as follows:");
                $this->model->setDisplay($user->render());
            } else {
                createErrorUrl("QueryFailed");
            }
        } else {
            $this->model->setInfo("Something went wrong. Are you logged in?");
        }
    }

    private function updateSession($username) {
        $customerData = $this->model->getCustomer($username);
        $customer = new Customer(
            $customerData["firstname"],
            $customerData["lastname"],
            $customerData["address"],
            $customerData["postalcode"],
            $customerData["email"],
            $customerData["country"]);
        $user = new User($customer, $username);
        $_SESSION['user'] = $user->toArray();
        return $user;
    }

    public function addProduct() {
        $forms =  new AddProductForms(getLanguage(["en", "de"]), "userarea");
        $this->model->setDisplay($forms->render());
    }

    public function deleteProduct() {
        //$forms =  new DeleteProductForms(getLanguage(["en", "de"]), "userarea");
        //$this->model->setDisplay($forms->render());
    }

    public function updateProduct() {
        //$forms =  new UpdateProductForms(getLanguage(["en", "de"]), "userarea");
        //$this->model->setDisplay($forms->render());
    }

}