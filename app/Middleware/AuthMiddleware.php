<?php
namespace App\Middleware;
use App\Core\Session;
class AuthMiddleware
{
 public function handle()
 {
 if (!Session::has('user_id')) {
 Session::flash('error', 'Please log in first.');
 header('Location: /login');
 exit;
 }
 }
}
