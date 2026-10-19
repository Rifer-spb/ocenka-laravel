<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Attributes\TestClass;
use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Entities\Call\CommentTemplate\Name;
use App\Core\Entities\Call\CommentTemplate\Text;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Services\Call\CallCommentTemplateService;
use App\Manager\Http\Requests\Legal\Call\CommentTemplate\TemplateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tests\Feature\Manager\Http\Controllers\Legal\Call\CommentTemplate\CreateTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Call\CommentTemplate\DeleteTest;
use Tests\Feature\Manager\Http\Controllers\Legal\Call\CommentTemplate\UpdateTest;

class CallCommentTemplateController extends AbstractController
{
    public function __construct(
        private CallCommentTemplateService $service
    )
    {
        $this->middleware($this->checkOwn(...))->except(['create']);
    }

    /**
     * @param TemplateRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[TestClass(CreateTest::class)]
    public function create(TemplateRequest $request)
    {
        $this->service->create(
            $this->getUserId(),
            new Name($request->name),
            new Text($request->text),
        );

        return back()->with('success', 'Успешно добавлено');
    }

    /**
     * @param CallCommentTemplate $template
     * @param TemplateRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    #[TestClass(UpdateTest::class)]
    public function update(CallCommentTemplate $template, TemplateRequest $request)
    {
        $this->service->update(
            $template->id,
            new Name($request->name),
            new Text($request->text),
        );

        return back()->with('success', 'Успешно обновлено');
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(DeleteTest::class)]
    public function delete(CallCommentTemplate $template)
    {
        $this->service->delete($template->id);

        return back()->with('success', 'Успешно удалено');
    }

    private function checkOwn(Request $request, \Closure $next)
    {
        /** @var CallCommentTemplate $template */
        $template = $request->route('template');

        $isOwner = $template->legal_id == $this->getUserId();

        if (! $isOwner) {
            abort(404);
        }

        return $next($request);
    }
}
