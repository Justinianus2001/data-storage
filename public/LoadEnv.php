<?php

$lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES);

foreach ($lines as $env) {
    if (!empty($env)) {
        putenv($env);
    }
}