<?php
namespace App\Controllers;

class LeaveController extends Controller
{
    public function index()
    {
        $title = 'Leave Overview';
        $currentPage = 'leave_overview';
        $content = '../app/Views/leave_management/index.php';
        include '../app/Views/layouts/admin.php';
    }

    public function leave_records()
    {
        $title = 'Leave Records';
        $currentPage = 'leave_records';
        $content = '../app/Views/leave_management/leave_records.php';
        include '../app/Views/layouts/admin.php';
    }

    public function leave_types()
    {
        $title = 'Leave Types';
        $currentPage = 'leave_types';
        $content = '../app/Views/leave_management/leave_types.php';
        include '../app/Views/layouts/admin.php';
    }

    public function leave_reports()
    {
        $title = 'Leave Reports';
        $currentPage = 'leave_reports';
        $content = '../app/Views/leave_management/leave_reports.php';
        include '../app/Views/layouts/admin.php';
    }

    public function leave_policies()
    {
        $title = 'Leave Policies';
        $currentPage = 'leave_policies';
        $content = '../app/Views/leave_management/leave_policies.php';
        include '../app/Views/layouts/admin.php';
    }
}

