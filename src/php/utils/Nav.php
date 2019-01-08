<?php


class Nav {
    private $elements = array (
        "rods" => array("nav-left", "rods", "Fishing Rods"),
        "reels" => array("nav-left", "reels", "Reels"),
        "lures" => array("nav-left", "lures","Lures"),
        "lines" => array("nav-left", "lines","Fishing Lines"),
        "accessories" => array("nav-left", "accessories","Accessories"),
        "about" => array("nav-left", "about","About"),
        "login" => array("nav-right", "login","Login")
    );
    
    private $html;
    private $t;
    
    public function __construct(string $lang) {
        $this->html = "<nav><ul>";
    }

    public function render() {
        $this->appendListItems();
        $this->appendLanguages();
        $this->appendShoppingChart();
        $this->appendUserArea();
        $this->appendItem("</nav></ul>");
        return $this->html;

    }

    private function appendShoppingChart() {
        $class = "nav-right";
        $lang = getLanguage(["en", "de"]);
        $urlBase = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
        $url = add_param($urlBase, "page", "cart");
        $cart = $_SESSION["cart"];
        $content = translate("Cart") .": " . $cart->getNbrItems();
        $listItem = "<li class='$class' id='cart'><a href='$url' alt='cart'>$content</a></li>";
        $this->appendItem($listItem);
    }
    
    private function appendItem(string $html) {
        $this->html = $this->html . $html;
    }
    
    private function appendListItems() {
        $lang = getLanguage(["en", "de"]);
        $urlBase = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
        foreach ($this->elements as $item) {
            $class = $item[0];
            if (checkLogin() && $item[1] == "login") {
                $url = add_param($urlBase, "page", "logout");
                $content = translate("Logout");
            } else {
                $url = add_param($urlBase, "page", $item[1]);
                $content = translate($item[2]);
            }

            $listItem = "<li class='$class'><a href='$url' alt='$item[1]'>$content</a></li>";
            $this->appendItem($listItem);
        }
    }

    private function appendLanguages() {
        $urlDE = htmlspecialchars($_SERVER['PHP_SELF']) . "?lang=de";
        $urlEN = htmlspecialchars($_SERVER['PHP_SELF']) . "?lang=en";
        $uri = htmlspecialchars($_SERVER['REQUEST_URI']);

        if (strpos($uri, 'lang=en') !== false) {
            $urlDE = str_replace('lang=en', 'lang=de', $uri);
            $urlEN = $uri;
        } else if (strpos($uri, 'lang=de') !== false) {
            $urlEN = str_replace('lang=de', 'lang=en', $uri);
            $urlDE = $uri;
        }
        $listItemDE = "<li class='nav-right'><a href='$urlDE' alt='langDE'> DE </a></li>";
        $listItemEN = "<li class='nav-right'><a href='$urlEN' alt='langEN'> EN </a></li>";
        $this->appendItem($listItemDE);
        $this->appendItem($listItemEN);
    }

    private function appendUserArea() {
        if (checklogin()) {
            $lang = getLanguage(["en", "de"]);
            $urlBase = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
            $url = add_param($urlBase, "page", "userarea");
            $userarea = "<li class='nav-right'><a href='$url' alt='userarea'> ". translate("Userarea") ." </a></li>";
            $this->appendItem($userarea);
        }
    }
}