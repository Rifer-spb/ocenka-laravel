<?php

namespace App\Console\Commands\Notariat\ScanNotaries;

use App\Core\Helpers\PhoneHelper;
use App\Core\Helpers\StringHelper;
use App\Core\Models\Notary\NotaryRegion;
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

        return NotaryRegion::findByGroupName($regionName);
    }

    private static function parseIsNotWork(\DOMXPath $xpath): bool
    {
        $elements = self::queryByClass($xpath, 'notary__status');

        if (!$elements->length) {
            return false;
        }

        return trim($elements->item(0)->textContent) === 'Не действует';
    }

    private static function parseName(\DOMXPath $xpath): ?string
    {
        $elements = self::queryByClass($xpath, 'notary__name');

        if (!$elements->length) {
            return null;
        }

        return strip_tags(trim($elements->item(0)->textContent));
    }

    private static function parseAddress(\DOMXPath $xpath): ?string
    {
        $infoBlock = self::getInfoBlock($xpath, 0);

        return $infoBlock ? strip_tags(trim($infoBlock->childNodes->item(1)->textContent)) : null;
    }

    private static function parsePhones(\DOMXPath $xpath): array
    {
        $infoBlock = self::getInfoBlock($xpath, 1);

        if (!$infoBlock) {
            return [];
        }

        $phone = PhoneHelper::parseToNationalFormat(strip_tags($infoBlock->childNodes->item(1)->textContent));

        if (!$phone) {
            return [];
        }

        return [$phone];
    }

    private static function parseEmails(\DOMXPath $xpath): array
    {
        $infoBlock = self::getInfoBlock($xpath, 2);

        if (!$infoBlock) {
            return [];
        }

        $email = strip_tags(trim($infoBlock->childNodes->item(1)->textContent));

        return EmailValidator::isEmail($email) ? [$email] : [];
    }

    private static function parseSite(\DOMXPath $xpath): ?string
    {
        $infoBlock = self::getInfoBlock($xpath, 3);

        if (!$infoBlock) {
            return null;
        }

        $text = strip_tags(trim($infoBlock->childNodes->item(1)->textContent));

        return ResourceValidator::isResource($text) ? $text : null;
    }

    private static function getInfoBlock(\DOMXPath $xpath, int $index): ?\DOMNode
    {
        $infoElements = self::queryByClass($xpath, 'info');

        if (!$infoElements->length) {
            return null;
        }

        return $infoElements->item(0)->childNodes->item($index);
    }

    private static function queryByClass(\DOMXPath $xpath, string $className): \DOMNodeList
    {
        return $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' {$className} ')]");
    }
}
