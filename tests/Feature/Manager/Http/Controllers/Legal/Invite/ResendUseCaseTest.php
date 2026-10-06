<?php

namespace Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Jobs\SendMailJob;
use App\Core\Entities\Invite\Invite;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ResendUseCaseTest extends TestCase
{
    public function testSuccess()
    {
        Queue::assertNothingPushed();

        $invite = Invite::factory()->withWait()->create();
        $url = $this->getRoute($invite->id);

        $response = $this->actingAs($invite->legal)->post($url);

        $response->assertSessionHas(['success' => 'Заявка успешно отправлена повторно']);
        Queue::assertPushed(SendMailJob::class);
    }

    private function getRoute(int $id): string
    {
        return route('manager.legal.settings.invites.reSend', ['invite' => $id]);
    }
}
