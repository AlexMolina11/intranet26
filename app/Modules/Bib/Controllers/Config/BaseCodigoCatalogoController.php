<?php

namespace App\Modules\Bib\Controllers\Config;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCodigoCatalogoController extends Controller
{
    protected string $modelClass;
    protected string $viewPath;
    protected string $routePrefix;
    protected string $pluralTitle;
    protected string $singularTitle;

    public function index()
    {
        $items = $this->modelClass::query()
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view($this->viewPath . '.index', [
            'items' => $items,
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function create()
    {
        return view($this->viewPath . '.create', [
            'routePrefix' => $this->routePrefix,
            'pluralTitle' => $this->pluralTitle,
            'singularTitle' => $this->singularTitle,
        ]);
    }

    public function store(FormRequest $request)
    {
        $this->modelClass::create($request->validated());

        return redirect()
            ->route($this->routePrefix . '.index')
            ->with('success', $this->singularTitle . ' creado correctamente.');
    }
}