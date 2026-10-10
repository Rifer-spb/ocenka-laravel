<?php

namespace App\Manager\Http\Controllers\Legal;

use App\Core\Entities\Call\CommentTemplate\CallCommentTemplate;
use App\Core\Http\Controllers\AbstractController;
use App\Core\Services\Call\CallCommentTemplateService;
use App\Manager\Http\Requests\Legal\Call\CommentTemplate\TemplateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function create(TemplateRequest $request)
    {
        $this->service->create($this->getUserId(), ...$request->validated());

        return back()->with('success', 'Успешно добавлено');
    }

    /**
     * @param CallCommentTemplate $template
     * @param TemplateRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(CallCommentTemplate $template, TemplateRequest $request)
    {
        $this->service->update($template->id, ...$request->validated());

        return back()->with('success', 'Успешно обновлено');
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
