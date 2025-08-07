<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::redirect('/','/admin');

require __DIR__.'/auth.php';
