<?php

class UserareaView {

    private $model;

    public function __construct(UserareaModel $model) {
        $this->model=$model;
    }

    private function generateWelcomeHtml() {
        return "
            <h1>". $this->model->getHeaderText() . "</h1>
            <h2>". $this->model->getWelcomeText(). "</h2>
            <p> ". $this->model->getPText() ." </p>
            </br>
        ";
    }

    private function generateOptionButton(string $action, string $text) {
        $lang = getLanguage(["en", "de"]);
        $url = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
        $url = add_param($url, "page", get_param("page", "userarea"));
        $url = add_param($url, "action", $action);
        $link = "<a href='$url' class='button'>" . $this->model->t($text) . "</a>";
        return $link;
    }

    public function render() {
        $html = $this->generateWelcomeHtml();
        foreach ($this->model->getUserActions() as $action => $text) {
            $html = $html . $this->generateOptionButton($action, $text);
        }
        if (checkAdmin()) {
            $html = $html . "<p>" . $this->model->getAdminText() . "</p>";
            foreach ($this->model->getAdminActions() as $action => $text) {
                $html = $html . $this->generateOptionButton($action, $text);
            }
        }
        $t = $this->model->getInfo();
        if ($t != "") {
            $html = $html . "<p> $t </p>";
        }
        echo $html . $this->model->getDisplay();
    }

}