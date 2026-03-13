<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Menu;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Requests\StoreMenuRequest;
use App\Modules\Seg\Requests\UpdateMenuRequest;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $sistemaId = $request->get('id_sistema');

        $sistemas = Sistema::where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $menus = Menu::with('sistema')
            ->when($sistemaId, function ($query) use ($sistemaId) {
                $query->where('id_sistema', $sistemaId);
            })
            ->orderBy('id_sistema')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('seg.menus.index', compact('menus', 'sistemas', 'sistemaId'));
    }

    public function create()
    {
        $sistemas = Sistema::where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        return view('seg.menus.create', compact('sistemas'));
    }

    public function store(StoreMenuRequest $request)
    {
        Menu::create($request->validated());

        return redirect()
            ->route('seg.menus.index')
            ->with('success', 'Menú creado correctamente.');
    }

    public function edit(Menu $menu)
    {
        $sistemas = Sistema::where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        return view('seg.menus.edit', compact('menu', 'sistemas'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return redirect()
            ->route('seg.menus.index')
            ->with('success', 'Menú actualizado correctamente.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()
            ->route('seg.menus.index')
            ->with('success', 'Menú eliminado correctamente.');
    }
}