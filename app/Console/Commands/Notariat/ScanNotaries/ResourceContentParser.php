<?php

namespace App\Console\Commands\Notariat\ScanNotaries;

use App\Core\Entities\Notary\NotaryRegion;
use App\Core\Finders\NotaryRegionFinder;
use App\Core\Helpers\PhoneHelper;
use App\Core\Helpers\StringHelper;
use App\Core\Validators\EmailValidator;
use App\Core\Validators\ResourceValidator;

class ResourceContentParser
{
    public static function parse(string $parseUrl): ?NotaryParseResult
    {
        $html = @file_get_contents($parseUrl);

        if (!$html) {
            return null;
        }

        $dom = self::buildDomDocument($html);
        $xpath = new \DOMXPath($dom);

        return new NotaryParseResult(
            region: self::parseRegion($xpath),
            isNotWork: self::parseIsNotWork($xpath),
            name: self::parseName($xpath),
            address: self::parseAddress($xpath),
            phones: self::parsePhones($xpath),
            emails: self::parseEmails($xpath),
            site: self::parseSite($xpath),
        );
    }

    private static function buildDomDocument(string $html): \DOMDocument
    {
        $normalizedHtml = mb_encode_numericentity(
            htmlspecialchars_decode(
                htmlentities($html, ENT_NOQUOTES, 'UTF-8', false),
                ENT_NOQUOTES
            ),
            [0x80, 0x10FFFF, 0, ~0],
            'UTF-8'
        );

        $dom = new \DOMDocument();
        @$dom->loadHTML($normalizedHtml);

        return $dom;
    }

    private static function parseRegion(\DOMXPath $xpath): ?NotaryRegion
    {
        $elements = self::queryByClass($xpath, 'notary__place');

        if (!$elements->length) {
            return null;
        }

        $regionName = StringHelper::replaceQuotes($elements->item(0)->textContent);

        return NotaryRegionFinder::findByGroupName($regionName);
    }

    private static function parseIsNotWork(\DOMXPath $xpath): bool
    {
        $elements = self::queryByClass($xpath, 'notary__status');

        if (!$elements->length) {
            return false;
        }

        $text = self::cleanRow($elements->item(0)->textContent);

        return mb_stripos($text, 'Не действует') !== false;
    }

    private static function parseName(\DOMXPath $xpath): ?string
    {
        $elements = self::queryByClass($xpath, 'notary__name');

        if (!$elements->length) {
            return null;
        }

        return self::cleanRow($elements->item(0)->textContent);
    }

    private static function parseAddress(\DOMXPath $xpath): ?string
    {
        $block = self::findInfoBlockByHeader($xpath, 'Адрес');

        if (!$block) {
            return null;
        };

        $p = $xpath->query('.//p', $block)->item(0);

        return $p ? self::cleanRow($p->textContent) : null;
    }

    private static function parsePhones(\DOMXPath $xpath): array
    {
        $block = self::findInfoBlockByHeader($xpath, 'Телефон');

        if (!$block) {
            return [];
        }

        $links = $xpath->query('.//a[starts-with(@href, "tel:")]', $block);

        $phones = [];

        foreach ($links as $link) {
            $phone = PhoneHelper::parseToNationalFormat(
                self::cleanRow($link->textContent)
            );

            if ($phone) {
                $phones[] = $phone;
            }
        }

        return $phones;
    }

    private static function parseEmails(\DOMXPath $xpath): array
    {
        $block = self::findInfoBlockByHeader($xpath, 'Электронная почта');

        if (!$block) {
            return [];
        }

        $links = $xpath->query('.//a[starts-with(@href, "mailto:")]', $block);
        $emails = [];

        foreach ($links as $link) {
            $email = str_replace('mailto:', '', $link->getAttribute('href'));
            $email = trim(urldecode($email));

            if (EmailValidator::isEmail($email)) {
                $emails[] = $email;
            }
        }

        return $emails;
    }

    private static function parseSite(\DOMXPath $xpath): ?string
    {
        $link = $xpath->query("//a[@id='site_link']")->item(0);

        if (!$link) {
            return null;
        }

        $href = trim($link->getAttribute('href'));

        if ($href === '') {
            return null;
        }

        return ResourceValidator::isResource($href) ? $href : null;
    }

    private static function queryByClass(\DOMXPath $xpath, string $className): \DOMNodeList
    {
        return $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' {$className} ')]");
    }

    private static function cleanRow(string $value): string
    {
        return strip_tags(trim($value));
    }

    private static function findInfoBlockByHeader(\DOMXPath $xpath, string $headerText): ?\DOMNode
    {
        $blocks = $xpath->query(
            "//*[contains(concat(' ', normalize-space(@class), ' '), ' info__block ')]"
        );

        foreach ($blocks as $block) {
            $header = $xpath->query(
                ".//*[contains(concat(' ', normalize-space(@class), ' '), ' info__block-header-text ')]",
                $block
            )->item(0);

            if ($header && self::cleanRow($header->textContent) === $headerText) {
                return $block;
            }
        }

        return null;
    }
}
