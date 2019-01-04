<?php

class Translator {

    private const DEFAULT_LANG = ["en", "de"];
    private $lang;

    public function __construct(string $lang) {
        if (in_array($lang, self::DEFAULT_LANG)) {
            $this->lang = $lang;
        } else {
            $this->lang = self::DEFAULT_LANG[0];
        }
    }

    // Singleton
    public function t(string $str): string {
        require "php/languages/". $this->lang . ".php";
        if (isset($messages[$str])) {
            return $messages[$str];
        } else {
            return $str;
        }
    }
}