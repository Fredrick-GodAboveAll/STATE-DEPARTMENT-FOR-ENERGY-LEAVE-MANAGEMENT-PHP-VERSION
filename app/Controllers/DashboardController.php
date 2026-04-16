<?php
namespace App\Controllers;
use App\Core\Session;
class DashboardController extends Controller
{
 public function index()
 {
 $title = 'Dashboard';
 $currentPage = 'dashboard';
 $content = '../app/Views/dashboard/index.php';
 include '../app/Views/layouts/admin.php';
 }
}
