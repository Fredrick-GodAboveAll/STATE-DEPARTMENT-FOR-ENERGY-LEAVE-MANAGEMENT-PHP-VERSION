<?php
namespace App\Controllers;

class ApplicationsController extends Controller
{
    public function index()
    {
        $title = 'Calender';
        $currentPage = 'calender'; // Must match the view's $currentPage
        $content = '../app/Views/applications/apps_calender.php';
        include '../app/Views/layouts/admin.php';
    }

    // Add more methods as needed
}