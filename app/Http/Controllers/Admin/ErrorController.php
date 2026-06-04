<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class ErrorController extends Controller
{
    /**
     * Show error page. If a message id is provided, pass it to the view.
     *
     * @param string|null $message_id
     */
    public function index(?string $message_id = null)
    {
        return response()->view('admin.error', ['message_id' => $message_id]);
    }
}
