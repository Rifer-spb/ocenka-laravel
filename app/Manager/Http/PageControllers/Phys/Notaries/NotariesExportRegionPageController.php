<?php

namespace App\Manager\Http\PageControllers\Phys\Notaries;

use App\Core\Http\Controllers\AbstractController;
use Inertia\Inertia;
use Inertia\Response;

class NotariesExportRegionPageController extends AbstractController
{
    public function __invoke(): Response
    {
        return Inertia::render('manager/phys/notaries/pages/regionExport/index');
    }
}
