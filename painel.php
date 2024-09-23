<?php
session_start();
require_once "./config/db.php";

$db = new Database();
$conn = $db->getConnection();

$messages = [];
$query = "SELECT * FROM messages ORDER BY created_at DESC";
$stmt = $conn->prepare($query);

if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        $messages[] = $row;
    }
} else {
    echo "Erro ao buscar mensagens: " . implode(", ", $stmt->errorInfo());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Mensagens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="./css/painel.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Frois Dev Studio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#home">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Sobre Mim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projects">Projetos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

        <div class="container content mt-5 mb-5">
         <h2 class="text-center mb-4">Mensagens Enviadas</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Mensagem</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                                <td><?php echo $message->id; ?></td>
                                <td><?php echo htmlspecialchars($message->name); ?></td>
                                <td><?php echo htmlspecialchars($message->email); ?></td>
                                <td><?php echo htmlspecialchars($message->phone); ?></td> 
                                <td><?php echo nl2br(htmlspecialchars($message->message)); ?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($message->created_at)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="index.php" class="btn btn-primary mt-3">Voltar</a>
        </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Meu Portfólio. Todos os direitos reservados.</p>
    </footer>

    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/Portuguese.json' 
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
