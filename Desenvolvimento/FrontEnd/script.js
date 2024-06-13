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

