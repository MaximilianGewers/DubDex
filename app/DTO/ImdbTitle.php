<?php

namespace App\DTO;

class ImdbTitle
{
    public function __construct(
        public string $title,
        public string $url
    ) {}
}
