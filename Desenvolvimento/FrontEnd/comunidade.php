<?php
session_start();

include 'header.php';

?>

<div class="container d-flex justify-content-center p-1">
    <main class="main">
        <h3 class="row">Fale conosco!</h3>
        <a class="row" href="mailto:sinalize.projeto.senacrs@gmail.com?subject=Comentários sobre aplicativo">Encaminhar e-mail</a>
        <p>Esperamos que sua experiência com nosso aplicativo tenha sido agradável</p>

        <?php if (isset($_SESSION['user_id'])) {?>
            <h4>Deixe seu comentário</h4>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <textarea name="comentario" cols="30" rows="10"></textarea>
                <input type="submit" name="submit" value="Enviar Comentário">
            </form>
        <?php } else {?>
            <p>Você precisa estar logado para comentar.</p>
        <?php }?>

        <h4>Comentários</h4>
        <?php include 'comentarios.php'; ?>
    </main>
</div>

<?php
include 'footer.php';
?>