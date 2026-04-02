<?php

namespace App\Modules\Seg\Support;

use Illuminate\Http\Request;

class ActiveSystemResolver
{
    public static function resolveCode(?Request $request): ?string
    {
        if (!$request || !$request->route()) {
            return null;
        }

        $routeName = $request->route()->getName();

        if (!$routeName) {
            return null;
        }

        if (in_array($routeName, ['dashboard', 'inicio'], true)) {
            return null;
        }

        if (str_starts_with($routeName, 'tik.')) {
            return 'TIK';
        }

        if (str_starts_with($routeName, 'bib.')) {
            return 'BIB';
        }

        if (str_starts_with($routeName, 'seg.')) {
            return 'INTRANET';
        }

        if (str_starts_with($routeName, 'org.')) {
            return 'INTRANET';
        }

        return null;
    }
}