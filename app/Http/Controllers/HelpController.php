<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display the main help page
     */
    public function index()
    {
        return view('admin.help.index');
    }

    /**
     * Display help for employees module
     */
    public function employees()
    {
        return view('admin.help.employees');
    }

    /**
     * Display help for projects module
     */
    public function projects()
    {
        return view('admin.help.projects');
    }

    /**
     * Display help for clients module
     */
    public function clients()
    {
        return view('admin.help.clients');
    }

    /**
     * Display help for attendance module
     */
    public function attendance()
    {
        return view('admin.help.attendance');
    }

    /**
     * Display help for settings module
     */
    public function settings()
    {
        return view('admin.help.settings');
    }

    /**
     * Display help for getting started
     */
    public function gettingStarted()
    {
        return view('admin.help.getting-started');
    }

    /**
     * Display help for dashboard
     */
    public function dashboard()
    {
        return view('admin.help.dashboard');
    }

    /**
     * Display help for bank accounts
     */
    public function bankAccounts()
    {
        return view('admin.help.bank-accounts');
    }

    /**
     * Display help for project employees
     */
    public function projectEmployees()
    {
        return view('admin.help.project-employees');
    }
}
