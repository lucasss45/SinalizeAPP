<?php
session_start();
include 'header.php';
?>

<link rel="stylesheet" href="comunidade.css">
<div class="container">
    <div class="email-section">
        <section class="comunicado">
            <div class="comunicado-principal">
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
                <div class="input-group">
                    <select name="topico" id="topico">
                        <option value="">--Tópico--</option>
                        <option value="Avaliações">Avaliações</option>
                        <option value="Sugestões">Sugestões</option>
                        <option value="Dúvidas">Dúvidas</option>
                    </select>
                    <input type="submit" name="submit" value="Enviar">
                </div>
            </form>
        </div>
    <?php } else {?>
        <p>Você precisa estar logado para comentar.</p>
    <?php }?>
</div>

    <div class="comentarios-section">
        <section class="comentarios">
            <h2>Comentários</h4>
            <?php include 'comentarios.php';?>
        </section>
    </div>
</div>

<?php include 'footer.php';?>

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
            }
        });
    });
});

</script>

