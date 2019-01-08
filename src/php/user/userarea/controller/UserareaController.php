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
        $forms =  new UserareaCustomerForm(getLanguage(["en", "de"]), "userarea");
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
        $form =  new AddProductForm(getLanguage(["en", "de"]), "userarea");
        $this->model->setDisplay($form->render());
    }

    public function deleteProduct() {
        $form =  new DeleteProductForm(getLanguage(["en", "de"]), "userarea");
        $this->model->setDisplay($form->render());
    }

    public function updateProduct(string $prodName = "", $load = false) {
        $productData = [];
        if ($load) {
            $productData = Product::getProductData(htmlspecialchars($prodName));
        }
        $form =  new SearchProductForm(getLanguage(["en", "de"]), "userarea", $load, $productData);
        $this->model->setDisplay($form->render());
    }

    public function addProductToDB($type, $pEN, $pDE, $price, $dEN="", $dDE="") {
        if (checkAdmin()) {
            $success = $this->model->addProduct(
                htmlspecialchars($type),
                htmlspecialchars($pEN),
                htmlspecialchars($pDE),
                htmlspecialchars($price),
                htmlspecialchars($dEN),
                htmlspecialchars($dDE)
            );
            if (!$success) {
                $this->model->setInfo("Successfully created new product.");
                $prod = Product::getSingleProduct(getLanguage(["en", "de"]), $pEN);
                $product = new Product($prod['realName'], $prod['name'], $prod['price'], $prod['descr']);
                $this->model->setDisplay($product->render());
            } else {
               createErrorUrl("ProductAddQueryFailed");
            }
        } else {
            $this->model->setInfo("Something went wrong. Are you logged in?");
        }
    }

    public function updateProd($oldName, $pEN, $pDE, $price, $dEN="", $dDE="") {
        if (checkAdmin()) {
            $success = $this->model->updateProduct(
                htmlspecialchars($oldName),
                htmlspecialchars($pEN),
                htmlspecialchars($pDE),
                htmlspecialchars($price),
                htmlspecialchars($dEN),
                htmlspecialchars($dDE)
            );
            if (!$success) {
                $this->model->setInfo("Successfully updated product.");
                $prod = Product::getSingleProduct(getLanguage(["en", "de"]), $pEN);
                $product = new Product($prod['realName'], $prod['name'], $prod['price'], $prod['descr']);
                $this->model->setDisplay($product->render());
            } else {
                createErrorUrl("ProductUpdateQueryFailed");
            }
        } else {
            $this->model->setInfo("Something went wrong. Are you logged in?");
        }
    }

    public function deleteProductsFromDB(array $prod) {
        if (checkAdmin()) {
            foreach ($prod as $item) {
                $success = $this->model->deleteProduct(htmlspecialchars($item));
                if ($success) {
                    createErrorUrl("ProductDeleteQueryFailed" . " Product Name: " . $prod);
                }
            }
            if (!$success) {
                $this->model->setInfo("Successfully deleted products.");
            }
        } else {
            $this->model->setInfo("Something went wrong. Are you logged in?");
        }
    }
}