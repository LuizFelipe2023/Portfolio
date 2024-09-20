<?php
require_once "./config/db.php";

$db = new Database();
$conn = $db->getConnection();

$posts = [];

$query = "SELECT title, content, image, repository FROM posts";
$stmt = $conn->prepare($query);

if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        $posts[] = $row;
    }
} else {
    echo "Erro ao buscar posts: " . implode(", ", $stmt->errorInfo());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div id="home" class="container-sm mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 text-center">
                <h2 class="line-title mb-4">Sobre Mim</h2>
                <div class="about-me mb-5">
                    <p class="mt-3" style="font-size: 1.1rem; line-height: 1.6;">
                        Olá! Sou Luiz Felipe Frois Neves, um desenvolvedor entusiasmado com 8 meses de experiência no mercado. Atualmente, estou estagiando no Fapeam, onde aplico minhas habilidades em <strong>PHP</strong>, <strong>MySQL</strong> e <strong>Laravel</strong> para desenvolver soluções inovadoras e eficientes que realmente fazem a diferença.
                    </p>
                    <p style="font-size: 1.1rem; line-height: 1.6;">
                        Além disso, domino <strong>JavaScript</strong>, <strong>Git</strong>, <strong>HTML</strong> e <strong>CSS</strong>, o que me permite criar aplicações completas e responsivas. Estou sempre em busca de novos desafios e oportunidades de aprendizado, pois acredito que a troca de conhecimento é essencial para o crescimento coletivo. Vamos nos conectar e explorar juntos como posso agregar valor à sua equipe com minha paixão e comprometimento!
                    </p>
                </div>

                <div class="card text-center my-5" style="box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); border-radius: 15px;">
                    <div class="card-body">
                        <h3 class="mb-4" style="font-weight: 700; letter-spacing: 1px;">Habilidades e Competências</h3>
                        <div class="row">
                            <div class="col-4 skill-icon mb-3">
                                <i class="fab fa-html5" style="font-size: 40px; color: #e34c26;"></i>
                                <p>HTML</p>
                            </div>
                            <div class="col-4 skill-icon mb-3">
                                <i class="fab fa-css3-alt" style="font-size: 40px; color: #1572b6;"></i>
                                <p>CSS</p>
                            </div>
                            <div class="col-4 skill-icon mb-3">
                                <i class="fab fa-js" style="font-size: 40px; color: #f7df1e;"></i>
                                <p>JavaScript</p>
                            </div>
                            <div class="col-4 skill-icon mb-3">
                                <i class="fab fa-php" style="font-size: 40px; color: #777bb4;"></i>
                                <p>PHP</p>
                            </div>
                            <div class="col-4 skill-icon mb-3">
                                <i class="fab fa-git" style="font-size: 40px; color: #f05033;"></i>
                                <p>Git</p>
                            </div>
                            <div class="col-4 skill-icon mb-3">
                                <i class="fab fa-laravel" style="font-size: 40px; color: #fb503b;"></i>
                                <p>Laravel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="projects" class="container-sm mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="row">
                <h2 class="text-center mb-5">Projetos</h2>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100" style="box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); border-radius: 15px;">
                            <img src="<?php echo $post->image; ?>" class="card-img-top" alt="<?php echo $post->title; ?>" style="border-top-left-radius: 15px; border-top-right-radius: 15px; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $post->title; ?></h5>
                                <p class="card-text">
                                    <?php echo nl2br($post->content); ?>
                                </p>
                                <?php if (!empty($post->repository)): ?>
                                    <a href="<?php echo $post->repository; ?>" target="_blank" class="btn btn-primary mt-3">
                                        Ver Repositório
                                    </a>
                                <?php else: ?>
                                    <p class="text-muted">Link do repositório não disponível.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>




    <div id="contact" class="container-sm mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 text-center">
                <h2 class="line-title mb-4">Contato</h2>
                <div class="card text-center" style="box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); border-radius: 15px;">
                    <div class="card-body">
                        <p class="mb-4" style="font-size: 1.1rem; line-height: 1.6;">
                            Se você deseja entrar em contato, sinta-se à vontade para me enviar um email!
                        </p>
                        <form action="send_email.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensagem</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                        <div class="mt-4">
                            <p>Ou envie um email diretamente para: <a href="mailto:seuemail@example.com">luizfelipefroisneves@gmail.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-light text-center py-3 mt-5">
        <p>&copy; <?php echo date("Y"); ?> Meu Portfólio. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>