<?php
require_once 'config.php';

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($keyword !== '') {
    $sql = "SELECT * FROM buku WHERE judul LIKE ?";
    $stmt = $mysqli->prepare($sql);
    $param = '%' . $keyword . '%';
    $stmt->bind_param("s", $param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM buku";
    $result = $mysqli->query($sql);
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border: none;
    }
    .table thead {
      background-color: #f1f1f1;
    }
    .badge {
      font-size: 0.9em;
    }
    .search-box {
      max-width: 500px;
      margin: auto;
    }
  </style>
</head>
<body>

  <div class="container mt-5">
    <div class="text-center mb-4">
      <h3><i class="bi bi-journal-bookmark-fill"></i> Daftar Buku Anda</h3>
      <p class="text-muted">Cari dan kelola koleksi buku kamu</p>
    </div>

    <!-- Pencarian -->
    <form method="GET" action="" class="search-box mb-4">
      <div class="input-group">
        <input type="text" class="form-control" name="keyword" placeholder="Cari judul buku..." value="<?= htmlspecialchars($keyword); ?>">
        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
        <?php if ($keyword): ?>
          <a href="buku.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i></a>
        <?php endif; ?>
      </div>
    </form>

    <div class="d-flex justify-content-end mb-3">
      <a href="add_book.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Buku</a>
    </div>

    <!-- Daftar Buku -->
    <div class="card shadow-sm">
      <div class="card-body">
        <?php if ($result->num_rows > 0): ?>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Judul</th>
                  <th>Penulis</th>
                  <th>Penerbit</th>
                  <th>Tahun</th>
                  <th>Stok</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['judul']); ?></td>
                    <td><?= htmlspecialchars($row['penulis']); ?></td>
                    <td><?= htmlspecialchars($row['penerbit']); ?></td>
                    <td><?= $row['tahun_terbit']; ?></td>
                    <td>
                      <span class="badge bg-secondary"><?= $row['stok']; ?> pcs</span>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-warning text-center">
            Tidak ada buku yang ditemukan <?= $keyword ? "untuk <strong>" . htmlspecialchars($keyword) . "</strong>" : "" ?>.
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($stmt)) $stmt->close();
$mysqli->close();
?>
