<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InvalidOrderException extends Exception
{

    public function render(Request $request)
    {
        return Redirect::back()
            ->withInput()
            ->withErrors([
                'message' => $this->getMessage(),
            ])->with('danger', $this->getMessage());
    }
}
