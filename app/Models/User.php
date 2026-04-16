<?php
namespace App\Models;
use PDO;
class User extends Model
{
 protected $table = 'users';
 public function findByEmail($email)
 {
 $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
 $stmt->execute([$email]);
 return $stmt->fetch(PDO::FETCH_OBJ);
 }
 public function create($data)
 {
 $sql = "INSERT INTO {$this->table} (name, email, password, role)
 VALUES (:name, :email, :password, :role)";
 $stmt = $this->db->prepare($sql);
 return $stmt->execute([
 'name' => $data['name'],
 'email' => $data['email'],
 'password' => $data['password'],
 'role' => $data['role'] ?? 'user'
 ]);
 }
 public function updateLastLogin($id)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET last_login = NOW() WHERE id = ?"
 );
 return $stmt->execute([$id]);
 }
 public function updatePassword($email, $newPassword)
 {
 $stmt = $this->db->prepare(
 "UPDATE {$this->table} SET password = ? WHERE email = ?"
 );
 return $stmt->execute([$newPassword, $email]);
 }
}