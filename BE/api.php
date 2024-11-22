<?php
include_once 'db.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';


// READ ALL tp kategori buat di home
if ($method === 'GET' && $action === 'read_all') {
  $kategori = $_GET['kategori'] ?? null;

  if ($kategori) {
    $stmt = $conn->prepare("SELECT * FROM resep WHERE kategori = ?");
    $stmt->execute([$kategori]);
  } else {
    $stmt = $conn->query("SELECT * FROM resep");
  }

  $resep = $stmt->fetchAll(PDO::FETCH_ASSOC);
  sendResponse($resep);
}


function sendResponse($data, $status = 200)
{
  http_response_code($status);
  header('Content-Type: application/json');
  echo json_encode($data);
  exit();
}

// CREATE
if ($method === 'POST' && $action === 'create') {
  $nama = $_POST['nama'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];
  $bahan = $_POST['bahan'];
  $langkah = $_POST['langkah'];


  $foto = $_FILES['foto'];
  $foto_path = 'uploads/' . basename($foto['name']);
  if (move_uploaded_file($foto['tmp_name'], $foto_path)) {
    $stmt = $conn->prepare("INSERT INTO resep (nama, kategori, deskripsi, bahan, langkah, foto) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $kategori, $deskripsi, $bahan, $langkah, $foto_path]);
    sendResponse(["message" => "Resep berhasil ditambahkan"]);
  } else {
    sendResponse(["message" => "Gagal mengunggah foto"], 400);
  }
}


// READ ALL
if ($method === 'GET' && $action === 'read_all') {
  $stmt = $conn->query("SELECT * FROM resep");
  $resep = $stmt->fetchAll(PDO::FETCH_ASSOC);
  sendResponse($resep);
}

// READ pke id
if ($method === 'GET' && $action === 'read_id') {
  $id = $_GET['id'] ?? null;
  if (!$id) {
    sendResponse(["message" => "ID tidak diberikan"], 400);
  }

  $stmt = $conn->prepare("SELECT * FROM resep WHERE id = ?");
  $stmt->execute([$id]);
  $resep = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($resep) {
    sendResponse($resep);
  } else {
    sendResponse(["message" => "Resep tidak ditemukan"], 404);
  }
}

// UPDATE
if ($method === 'POST' && $action === 'update') {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];
  $bahan = $_POST['bahan'];
  $langkah = $_POST['langkah'];


  if (isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];
    $foto_path = 'uploads/' . basename($foto['name']);
    if (move_uploaded_file($foto['tmp_name'], $foto_path)) {
      $stmt = $conn->prepare("UPDATE resep SET nama=?, kategori=?, deskripsi=?, bahan=?, langkah=?, foto=? WHERE id=?");
      $stmt->execute([$nama, $kategori, $deskripsi, $bahan, $langkah, $foto_path, $id]);
    } else {
      sendResponse(["message" => "Gagal mengunggah foto"], 400);
    }
  } else {
    $stmt = $conn->prepare("UPDATE resep SET nama=?, kategori=?, deskripsi=?, bahan=?, langkah=? WHERE id=?");
    $stmt->execute([$nama, $kategori, $deskripsi, $bahan, $langkah, $id]);
  }

  sendResponse(["message" => "Resep berhasil diperbarui"]);
}


// DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $action === 'delete') {
  parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $params);
  $id = $params['id'] ?? null;

  if (!$id) {
    sendResponse(["message" => "ID tidak diberikan"], 400);
  }

  $stmt = $conn->prepare("DELETE FROM resep WHERE id = ?");
  $stmt->execute([$id]);

  if ($stmt->rowCount() > 0) {
    sendResponse(["message" => "Resep berhasil dihapus"]);
  } else {
    sendResponse(["message" => "Resep tidak ditemukan atau gagal menghapus"], 400);
  }
}
