<?php
require_once "./config/db.php";
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['repository'])) {
        echo "Preencha os campos obrigatórios!";
        return;
    }

    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    $repository = filter_input(INPUT_POST, 'repository', FILTER_VALIDATE_URL);

    if (!$repository) {
        echo "URL do repositório inválida!";
        return;
    }

    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            echo "Tipo de arquivo não permitido. Apenas JPEG, PNG e GIF são aceitos.";
            return;
        }

        if ($fileSize > 2 * 1024 * 1024) { // Limite de 2MB
            echo "O tamanho do arquivo deve ser menor que 2MB.";
            return;
        }

        $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $image = $imagePath;
        } else {
            echo "Erro ao fazer upload da imagem.";
            return;
        }
    }

    $stmt = $conn->prepare("INSERT INTO posts (title, content, image, repository) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $title, PDO::PARAM_STR);
    $stmt->bindParam(2, $content, PDO::PARAM_STR);
    $stmt->bindParam(3, $image, PDO::PARAM_STR);
    $stmt->bindParam(4, $repository, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao criar o post: " . implode(", ", $stmt->errorInfo());
    }
}

