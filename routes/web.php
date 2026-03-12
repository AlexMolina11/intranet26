<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/seg.php';
require __DIR__.'/org.php';
require __DIR__.'/tik.php';
require __DIR__.'/bib.php';
require __DIR__.'/mnt.php';
require __DIR__.'/veh.php';
require __DIR__.'/sgc.php';
require __DIR__.'/exp.php';

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('inicio');