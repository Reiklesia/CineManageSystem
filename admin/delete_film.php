<?php
session_start();
if(!isset($_SESSION['admin'])) header('Location: login.php');

require_once '../includes/db_connect.php';
$id = intval($_GET['id']);
$conn->query("DELETE FROM films WHERE id=$id");
header('Location: dashboard.php');
exit;
