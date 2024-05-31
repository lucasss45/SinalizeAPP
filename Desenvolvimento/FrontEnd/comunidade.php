<?php
session_start();
include 'header.php';
?>

<link rel="stylesheet" href="comunidade.css">
<div class="container">
    <div class="email-section">
        <section class="comunicado">
        <div class = "comunicado-principal">
            <h3>Fale conosco!</h3><br>
            <a href="mailto:sinalize.projeto.senacrs@gmail.com?subject=Comentários sobre aplicativo">Encaminhar e-mail</a>
        </div>
            <p>Esperamos que sua experiência com nosso aplicativo tenha sido agradável</p>
        </section>
    </div>

    <div class="texto-section">
        <?php if (isset($_SESSION['user_id'])) {?>
            <div class="comentario-form">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <div class="textarea-container">
                        <textarea name="comentario" id="comentario" cols="30" rows="5"></textarea>
                    </div>
                    <input type="submit" name="submit" value="Enviar">
                </form>
            </div>
        <?php } else {?>
            <p>Você precisa estar logado para comentar.</p>
        <?php }?>
    </div>

    <div class="comentarios-section">
        <section class="comentarios">
            <h4>Comentários</h4>
            <?php include 'comentarios.php';?>
        </section>
    </div>
</div>

<?php include 'footer.php';?>
