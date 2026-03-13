<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Menu;
use App\Modules\Seg\Models\MenuItem;
use App\Modules\Seg\Models\Permiso;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Requests\StoreMenuItemRequest;
use App\Modules\Seg\Requests\UpdateMenuItemRequest;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(Request $request)
    {
        $sistemaId = $request->get('id_sistema');
        $menuId = $request->get('id_menu');

        $sistemas = Sistema::where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $menus = Menu::when($sistemaId, function ($query) use ($sistemaId) {
                $query->where('id_sistema', $sistemaId);
            })
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $items = MenuItem::with(['sistema', 'menu', 'padre'])
            ->when($sistemaId, function ($query) use ($sistemaId) {
                $query->where('id_sistema', $sistemaId);
            })
            ->when($menuId, function ($query) use ($menuId) {
                $query->where('id_menu', $menuId);
            })
            ->orderBy('id_sistema')
            ->orderBy('id_menu')
            ->orderBy('id_menu_item_padre')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(15)
            ->withQueryString();

        return view('seg.menu-items.index', compact('items', 'sistemas', 'menus', 'sistemaId', 'menuId'));
    }

    public function create()
    {
        $sistemas = Sistema::where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $menus = Menu::orderBy('orden')->orderBy('nombre')->get();
        $padres = MenuItem::whereNull('id_menu_item_padre')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();
        $permisos = Permiso::orderBy('codigo')->get();

        return view('seg.menu-items.create', compact('sistemas', 'menus', 'padres', 'permisos'));
    }

    public function store(StoreMenuItemRequest $request)
    {
        $data = $request->validated();

        $menu = Menu::findOrFail($data['id_menu']);

        if ((int) $menu->id_sistema !== (int) $data['id_sistema']) {
            return back()
                ->withErrors(['id_menu' => 'El menú seleccionado no pertenece al sistema indicado.'])
                ->withInput();
        }

        if (!empty($data['id_menu_item_padre'])) {
            $padre = MenuItem::findOrFail($data['id_menu_item_padre']);

            if ((int) $padre->id_menu !== (int) $data['id_menu']) {
                return back()
                    ->withErrors(['id_menu_item_padre' => 'El submenú padre debe pertenecer al mismo menú.'])
                    ->withInput();
            }
        }

        if (!empty($data['permiso_requerido'])) {
            $permiso = Permiso::where('codigo', $data['permiso_requerido'])->first();

            if (!$permiso || (int) $permiso->id_sistema !== (int) $data['id_sistema']) {
                return back()
                    ->withErrors(['permiso_requerido' => 'El permiso requerido debe pertenecer al mismo sistema.'])
                    ->withInput();
            }
        }

        MenuItem::create($data);

        return redirect()
            ->route('seg.menu-items.index')
            ->with('success', 'Opción de menú creada correctamente.');
    }

    public function edit(MenuItem $menuItem)
    {
        $sistemas = Sistema::where('activo', true)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $menus = Menu::orderBy('orden')->orderBy('nombre')->get();
        $padres = MenuItem::where('id_menu', $menuItem->id_menu)
            ->whereNull('id_menu_item_padre')
            ->where('id_menu_item', '!=', $menuItem->id_menu_item)
            ->orderBy('orden')
            ->orderBy('nombre')
            ->get();

        $permisos = Permiso::orderBy('codigo')->get();

        return view('seg.menu-items.edit', compact('menuItem', 'sistemas', 'menus', 'padres', 'permisos'));
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem)
    {
        $data = $request->validated();

        $menu = Menu::findOrFail($data['id_menu']);

        if ((int) $menu->id_sistema !== (int) $data['id_sistema']) {
            return back()
                ->withErrors(['id_menu' => 'El menú seleccionado no pertenece al sistema indicado.'])
                ->withInput();
        }

        if (!empty($data['id_menu_item_padre'])) {
            $padre = MenuItem::findOrFail($data['id_menu_item_padre']);

            if ((int) $padre->id_menu !== (int) $data['id_menu']) {
                return back()
                    ->withErrors(['id_menu_item_padre' => 'El submenú padre debe pertenecer al mismo menú.'])
                    ->withInput();
            }
        }

        if (!empty($data['permiso_requerido'])) {
            $permiso = Permiso::where('codigo', $data['permiso_requerido'])->first();

            if (!$permiso || (int) $permiso->id_sistema !== (int) $data['id_sistema']) {
                return back()
                    ->withErrors(['permiso_requerido' => 'El permiso requerido debe pertenecer al mismo sistema.'])
                    ->withInput();
            }
        }

        $menuItem->update($data);

        return redirect()
            ->route('seg.menu-items.index')
            ->with('success', 'Opción de menú actualizada correctamente.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()
            ->route('seg.menu-items.index')
            ->with('success', 'Opción de menú eliminada correctamente.');
    }
}