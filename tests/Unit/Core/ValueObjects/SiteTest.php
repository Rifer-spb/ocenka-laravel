<?php

namespace Tests\Unit\Core\ValueObjects;

use App\Core\ValueObjects\Site;
use Tests\TestCase;

class SiteTest extends TestCase
{
    public function testSuccess(): void
    {
        $site = new Site('https://laravel.com');

        $this->assertEquals('https://laravel.com', $site->getValue());
    }

    public function testInvalid(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный адрес сайта.');

        new Site('invalid-url');
    }

    public function testEmpty(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Некорректный адрес сайта.');

        new Site('');
    }
}
