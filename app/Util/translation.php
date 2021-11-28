<?php

function t(string $key, array $data = []): string
{
    return json_encode([
        'key' => $key,
        'data' => $data,
    ]);
}
