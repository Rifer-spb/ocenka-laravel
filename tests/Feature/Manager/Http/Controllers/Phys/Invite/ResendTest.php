<?php

namespace Tests\Feature\Manager\Http\Controllers\Phys\Invite;

use App\Core\Entities\User\Phys\Phys;
use App\Core\Jobs\SendMailJob;
use App\Core\Entities\Invite\Invite;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ResendTest extends TestCase
{
    public function testWithAnotherInviteId()
    {
        $phys = Phys::factory()->create();
        $invite = Invite::factory()->create();
        $route = $this->getRoute($invite);

        $response = $this->actingAs($phys)->post($route);
        $response->assertStatus(404);
    }

    public function testSuccess()
    {
        Queue::assertNothingPushed();

        $invite = Invite::factory()->withWait()->create();
        $url = $this->getRoute($invite);

        $response = $this->actingAs($invite->phys)->post($url);

        $response->assertSessionHas(['success' => 'Заявка успешно отправлена повторно']);
        Queue::assertPushed(SendMailJob::class);
    }

    private function getRoute(Invite $invite): string
    {
        return route('manager.phys.invites.reSend', ['invite' => $invite->id]);
    }
}
