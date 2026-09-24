<?php

namespace Tests\Unit\Core\Validators;

use App\Core\Validators\ResourceValidator;
use Tests\TestCase;

class ResourceValidatorTest extends TestCase
{
    public function testHttps(): void
    {
        $this->assertTrue(ResourceValidator::isResource('https://example.com'));
    }

    public function testHttp(): void
    {
        $this->assertTrue(ResourceValidator::isResource('http://example.com'));
    }

    public function testWithPathQueryAndFragment(): void
    {
        $this->assertTrue(ResourceValidator::isResource('https://example.com/path/page?a=1&b=2#top'));
    }

    public function testWithPort(): void
    {
        $this->assertTrue(ResourceValidator::isResource('https://sub.example.com:8080/a'));
    }

    public function testEmpty(): void
    {
        $this->assertFalse(ResourceValidator::isResource(''));
    }

    public function testWithoutScheme(): void
    {
        $this->assertFalse(ResourceValidator::isResource('example.com'));
        $this->assertFalse(ResourceValidator::isResource('www.example.com'));
    }

    public function testSchemeWithoutHost(): void
    {
        $this->assertFalse(ResourceValidator::isResource('http://'));
    }

    public function testPlainText(): void
    {
        $this->assertFalse(ResourceValidator::isResource('not a url'));
    }

    public function testSpaceInHost(): void
    {
        $this->assertFalse(ResourceValidator::isResource('https://exa mple.com'));
    }

    public function testCyrillicDomainIsNotSupported(): void
    {
        $this->assertFalse(ResourceValidator::isResource('http://пример.рф'));
    }
}
