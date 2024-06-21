<?php
    include 'header.php';
?>

<?php
    

    if(isset($_POST['executar'])) {
        exec('python seu_script.py');
        echo "Script executado com sucesso!";
    }
?>
    <main class="d-flex justify-content-center">
        <div class="col-lg-3 d-flex justify-content-end align-items-center">
            <button id="btn-executar" class="btn-header">
                <p>Dale</p>
            </button>
        </div>
    </main>
<?php
    include 'footer.php';
?>
