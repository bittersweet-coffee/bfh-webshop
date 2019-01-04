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
        $this->t = new Translator($lang);
        $this->html = "<nav><ul>";
    }
    
    private function appendItem(string $html) {
        $this->html = $this->html . $html;
    }
    
    private function appendListItems() {
        $lang = getLanguage(["en", "de"]);
        $urlBase = add_param(htmlspecialchars($_SERVER['PHP_SELF']), "lang", $lang);
        foreach ($this->elements as $item) {
            $class = $item[0];
            $url = add_param($urlBase, "page", $item[1]);
            $content = $this->t->t($item[2]);
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

    public function render() {
        $this->appendListItems();
        $this->appendLanguages();
        $this->appendItem("</nav></ul>");
        return $this->html;

    }
    
}