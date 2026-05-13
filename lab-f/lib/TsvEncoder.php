<?php

class TsvEncoder implements EncoderInterface {

    public function supports(string $format): bool {
        return $format === 'tsv';
    }

    public function decode(string $input): array {
        $lines = preg_split('/\r\n|\r|\n/', trim($input));
        $header = explode("\t", array_shift($lines));

        $result = [];
        foreach ($lines as $line) {
            $row = explode("\t", $line);
            $result[] = array_combine($header, $row);
        }
        return $result;
    }

    public function encode(array $data): string {
        if (!$data) return '';

        $header = array_keys($data[0]);
        $out = [implode("\t", $header)];

        foreach ($data as $row) {
            $out[] = implode("\t", $row);
        }

        return implode("\n", $out);
    }
}
