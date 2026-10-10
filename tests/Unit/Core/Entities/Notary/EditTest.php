<?php

namespace Tests\Unit\Core\Entities\Notary;

use App\Core\Entities\Notary\Notary;
use App\Core\Entities\Notary\NotaryUpdateData;
use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\Site;
use PHPUnit\Framework\Attributes\CoversMethod;
use Tests\TestCase;

#[CoversMethod(Notary::class, 'edit')]
class EditTest extends TestCase
{
    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessFulled()
    {
        $notary = Notary::factory()
            ->withEmail('email@test.ru')
            ->create();

        $notary->edit(
            new NotaryUpdateData(
                [new Email($email = 'another-email@test.ru')],
                new Site($site = 'https://site.ru'),
                true,
                $comment = 'Comment',
            )
        );

        $this->assertCount(1, $notary->emails);
        $this->assertEquals($email, $notary->emails[0]->email);
        $this->assertEquals($site, $notary->site);
        $this->assertTrue($notary->use_digital_report);
        $this->assertEquals($comment, $notary->comment);
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function testSuccessWithNotFull()
    {
        $notary = Notary::factory()
            ->state([
                'site' => 'https://site.ru',
                'use_digital_report' => true,
                'comment' => 'Comment',
            ])
            ->withEmail('email@test.ru')
            ->create();

        $notary->edit(new NotaryUpdateData([], null, null, null));

        $this->assertCount(0, $notary->emails);
        $this->assertNull($notary->site);
        $this->assertNull($notary->use_digital_report);
        $this->assertNull($notary->comment);
    }
}
