<?php
include '../config/koneksi.php';
$u=$_POST['username']; $p=$_POST['password']; $r=$_POST['role'];
$q=mysqli_query($koneksi,"SELECT * FROM petugas WHERE username='$u' AND role='$r'");
$d=mysqli_fetch_assoc($q);
if($d && $p==$d['password']){
 session_start(); $_SESSION['login']=$r;
 header('Location: ../admin/dashboard_'+$r+'.php');
}else echo 'Login gagal'; ?>