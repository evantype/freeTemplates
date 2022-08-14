<?php

namespace App\Http\Controllers;

use App\Models\SiteTemplate;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function compact;
use function view;

class SiteTemplateController extends Controller
{
    public function listTemplates(Request $request): View
    {
        $siteTemplates = SiteTemplate::whereIsActive(true)
            ->orderBy('created_at')
            ->paginate(9);

        return view('site-templates', compact(['siteTemplates']));
    }
}
