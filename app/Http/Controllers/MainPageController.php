<?php

namespace App\Http\Controllers;

use App\Models\SiteTemplate;

use Illuminate\View\View;

use function compact;
use function view;

class MainPageController extends Controller
{
    public function index(): View
    {
        $siteTemplates = SiteTemplate::whereIsActive(true)
            ->orderBy('created_at')
            ->limit(6)
            ->get();
        return view(
            'index',
            compact([
                'siteTemplates'
            ])
        );
    }
}
