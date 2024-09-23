<?php
session_start();
require_once "./config/db.php";

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    $errors = [];

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        $errors[] = "Todos os campos são obrigatórios.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido.";
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode("<br>", $errors)]);
        exit();
    } else {
        $query = "INSERT INTO messages (name, email, phone, message) VALUES (:name, :email, :phone, :message)";
        $stmt = $conn->prepare($query);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone); 
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => "Mensagem salva com sucesso!"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Erro ao salvar a mensagem. Tente novamente."]);
        }
        exit();
    }
}
?>
