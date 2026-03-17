<?php
namespace App\Controllers;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $content = '../app/Views/dashboard/index.php';
        include '../app/Views/layouts/admin.php';
    }

}