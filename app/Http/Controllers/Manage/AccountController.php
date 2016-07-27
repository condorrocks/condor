<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        logger()->info(__METHOD__);

        # $this->authorize('manageAccounts');

        // BEGIN
        $accounts = auth()->user()->accounts;

        return view('manage.accounts.index', compact('accounts'));
    }
}
