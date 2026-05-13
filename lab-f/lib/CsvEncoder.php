<?php

class CsvEncoder implements EncoderInterface {

    public function supports(string $format): bool {
        return $format === 'csv';
    }

    public function decode(string $input): array {
        $lines = preg_split('/\r\n|\r|\n/', trim($input));
        $header = str_getcsv(array_shift($lines), ',');

        $result = [];
        foreach ($lines as $line) {
            $row = str_getcsv($line, ',');
            $result[] = array_combine($header, $row);
        }
        return $result;
    }

    public function encode(array $data): string {
        if (!$data) return '';

        $header = array_keys($data[0]);
        $out = [implode(',', $header)];

        foreach ($data as $row) {
            $out[] = implode(',', $row);
        }

        return implode("\n", $out);
    }
}
