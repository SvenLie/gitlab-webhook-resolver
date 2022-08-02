<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface EventControllerInterface
{
    public function reactToEvent(Request $request);
}

