<?php

class YamlEncoder implements EncoderInterface {

    public function supports(string $format): bool {
        return $format === 'yaml';
    }

    public function decode(string $input): array {
        return yaml_parse($input) ?: [];
    }

    public function encode(array $data): string {
        return yaml_emit($data);
    }
}
