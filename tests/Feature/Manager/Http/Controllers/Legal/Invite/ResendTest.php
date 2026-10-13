<?php

namespace Tests\Feature\Manager\Http\Controllers\Legal\Invite;

use App\Core\Entities\User\Legal\Legal;
use App\Core\Jobs\SendMailJob;
use App\Core\Entities\Invite\Invite;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ResendTest extends TestCase
{
    public function testWithAnotherInviteId()
    {
        $legal = Legal::factory()->create();
        $invite = Invite::factory()->withWait()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($legal)->post($route);
        $response->assertStatus(404);
    }

    public function testSuccess()
    {
        Queue::assertNothingPushed();

        $invite = Invite::factory()->withWait()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($invite->legal)->post($route);

        $response->assertSessionHas(['success' => 'Заявка успешно отправлена повторно']);
        Queue::assertPushed(SendMailJob::class);
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.legal.invites.reSend', ['invite' => $invite->id]);
    }
}
