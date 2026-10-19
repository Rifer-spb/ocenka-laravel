<?php

namespace Tests\Unit\Core\Entities\User\Legal\ValueObjects;

use App\Core\Entities\User\Legal\ValueObjects\RegistryTemplate;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(RegistryTemplate::class)]
class RegistryTemplateTest extends TestCase
{
    public function testEmptyString(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Указан пустой шаблон.');

        new RegistryTemplate('');
    }

    public function testWhitespaceOnly(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Указан пустой шаблон.');

        new RegistryTemplate('   ');
    }

    public function testWhitespaceOnlyTabs(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Указан пустой шаблон.');

        new RegistryTemplate("\t\t");
    }

    public function testWhitespaceOnlyNewlines(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Указан пустой шаблон.');

        new RegistryTemplate("\n\n");
    }

    public function testSuccess(): void
    {
        $template = new RegistryTemplate($value = 'Шаблон реестра');

        $this->assertSame($value, $template->getValue());
    }

    public function testTrim(): void
    {
        $template = new RegistryTemplate('  Шаблон реестра  ');

        $this->assertSame('Шаблон реестра', $template->getValue());
    }

    public function testTrimTabsAndNewlines(): void
    {
        $template = new RegistryTemplate("\t\nШаблон реестра\n\t");

        $this->assertSame('Шаблон реестра', $template->getValue());
    }
}
