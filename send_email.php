<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

 
    $errors = [];
    
  
    if (empty($name)) {
        $errors[] = "O nome é obrigatório.";
    } elseif (strlen($name) < 2) {
        $errors[] = "O nome deve ter pelo menos 2 caracteres.";
    }

  
    if (empty($email)) {
        $errors[] = "O e-mail é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "O e-mail fornecido não é válido.";
    }

   
    if (empty($message)) {
        $errors[] = "A mensagem é obrigatória.";
    } elseif (strlen($message) < 10) {
        $errors[] = "A mensagem deve ter pelo menos 10 caracteres.";
    }

  
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
        exit; 
    }

  
    $to = "luizfelipefroisneves@gmail.com"; 
    $subject = "Nova mensagem de contato de $name";
    $body = "Nome: $name\n";
    $body .= "Email: $email\n";
    $body .= "Mensagem:\n$message\n";
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    
    if (mail($to, $subject, $body, $headers)) {
        echo "<p style='color: green;'>Mensagem enviada com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>Erro ao enviar mensagem. Tente novamente.</p>";
    }
} else {
    echo "<p style='color: red;'>Método de requisição inválido.</p>";
}
?>
