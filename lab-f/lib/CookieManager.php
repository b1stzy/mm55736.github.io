<?php

class CookieManager {

    public function save(string $text, string $in, string $out): void {
        $exp = time() + 7 * 24 * 3600;

        setcookie("input_text", $text, $exp, "/");
        setcookie("input_format", $in, $exp, "/");
        setcookie("output_format", $out, $exp, "/");
    }

    public function getInputText(): string {
        return $_COOKIE["input_text"] ?? "";
    }

    public function getInputFormat(): string {
        return $_COOKIE["input_format"] ?? "tsv";
    }

    public function getOutputFormat(): string {
        return $_COOKIE["output_format"] ?? "json";
    }
}
