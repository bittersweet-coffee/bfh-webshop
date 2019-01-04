<?php

class ErrorPage {
    private $reason;

    public function __construct(string $reason="error") {
        $this->reason=$reason;
    }

    public function render() {
        $text = translate("An error has occurred");
        $header = "<h2> $text </h2>";
        $reasonText = translate("The reason seems to be this");
        $reason = "<p> $reasonText: '$this->reason' </p>";
        $tryAgainText = translate("Try it again. If it occurs again, contact the administrator");
        $tryAgain = "<p> $tryAgainText </p>";
        return "<div>" . $header . $reason . $tryAgain . "</div>";
    }
}