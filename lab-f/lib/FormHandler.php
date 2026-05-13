<?php

class FormHandler {

    private array $encoders;
    private CookieManager $cookies;

    public function __construct(array $encoders, CookieManager $cookies) {
        $this->encoders = $encoders;
        $this->cookies = $cookies;
    }

    public function handleRequest(): array {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $inputText = $_POST["input_text"] ?? "";
            $inputFormat = $_POST["input_format"] ?? "tsv";
            $outputFormat = $_POST["output_format"] ?? "json";

            $this->cookies->save($inputText, $inputFormat, $outputFormat);

            $output = $this->convert($inputText, $inputFormat, $outputFormat);

        } else {
            $inputText = $this->cookies->getInputText();
            $inputFormat = $this->cookies->getInputFormat();
            $outputFormat = $this->cookies->getOutputFormat();
            $output = "";
        }

        return [
            "inputText" => $inputText,
            "inputFormat" => $inputFormat,
            "outputFormat" => $outputFormat,
            "outputText" => $output
        ];
    }

    private function convert(string $text, string $in, string $out): string {

        $encoderIn = $this->find($in);
        $encoderOut = $this->find($out);

        if (!$encoderIn || !$encoderOut) return "Format error";

        $data = $encoderIn->decode($text);

        if ($in === $out) {
            return $encoderIn->encode($data);
        }

        return $encoderOut->encode($data);
    }

    private function find(string $format): ?EncoderInterface {
        foreach ($this->encoders as $e) {
            if ($e->supports($format)) return $e;
        }
        return null;
    }
}
