<?php
include 'header.php';
?>

<div class="container">
    <section class="comunicado">
        <h3>Fale conosco!</h3>
        <p>Participe da nossa comunidade e compartilhe suas experiências e sugestões para melhorar o Sinalize.</p>
    </section>

    <?php if (isset($_SESSION['user_id'])) { ?>
        <div class="comentario-form">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="textarea-container">
                    <textarea name="comentario" id="comentario" cols="30" rows="5"></textarea>
                </div>
                <input type="submit" name="submit" value="Enviar">
                <select name="topico">
                    <option value="">Tópico</option>
                    <option value="Avaliações">Avaliações</option>
                    <option value="Sugestões">Sugestões</option>
                    <option value="Dúvidas">Dúvidas</option>
                </select>
            </form>
        </div>
    <?php } else { ?>
        <p class="login-message">Você precisa estar logado para comentar.</p>
    <?php } ?>
</div>

<div class="comentarios-section">
    <section class="comentarios">
        <h2>Comentários</h2>
        <?php include 'comentarios.php'; ?>
    </section>
</div>

<section class="contato">
    <h3>Esperamos que sua experiência tenha sido agradável. Qualquer coisa estamos à disposição.</h3>
    <a href="mailto:sinalize.projeto.senacrs@gmail.com?subject=Comentários sobre aplicativo">Encaminhar e-mail</a>
</section>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.curtir-btn').click(function(){
        var comentario_id = $(this).data('comentario-id');
        var button = $(this);
        
        $.ajax({
            url: 'curtir.php',
            method: 'POST',
            data: { comentario_id: comentario_id },
            success: function(response){
                if (!isNaN(response) && parseInt(response) >= 0) {
                    var curtidas = parseInt(response);
                    var span = button.siblings('.curtidas');
                    span.text(curtidas + ' curtidas');
                    button.toggleClass('curtido'); // Alterna a classe 'curtido'
                } else {
                    console.error("Erro ao receber número de curtidas: " + response);
                }
            },
            error: function(xhr, status, error) {
                console.error("Erro na requisição AJAX: " + error);
            }
        });
    });
});

</script>
