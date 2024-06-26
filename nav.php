<?php
$url = 'http://' . $_SERVER['HTTP_HOST'] . '/gestionadministrativa';
?>



<?php //Necesita : menu_usuario.css , menu_usuario.js, font raleway ( google fonts ) ?>
<div id='nav-reponsive'>
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
    </svg>
</div>
<nav id="nav-gestionadministrativa">

    <div class="nav-box">
        <div class="nav-box-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
            </svg>
            <span>
                <?php echo $usuario; ?>
            </span>
        </div>
    </div>

    <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 100 || $_SESSION['rol'] == 101) { ?>
        <div class="nav-box" id="nav-options">
            <div class="nav-box-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-gear-fill" viewBox="0 0 16 16">
                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                </svg>

                <span>OPCIONES</span>
            </div>


            <ul class="nav-dropdown">
                <?php if ($_SESSION['rol'] == 1) { ?>
                    <li><a href="<?php echo $url ?>/calendario/frontend/">CALENDARIO</a></li>
                    <li><a href="<?php echo $url ?>/facturas/frontend/">FACTURAS</a></li>
                    <li><a href="<?php echo $url ?>/usuarios/frontend/">USUARIOS</a></li>
                    <li><a href="<?php echo $url ?>/matriculas/frontend/">MATRICULAS</a></li>

                <?php } ?>
            </ul>


        </div>
    <?php } ?>

    <div class="nav-box">
        <?php
        echo "<a href='$url/salir.php'>";
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-power" viewBox="0 0 16 16">
            <path d="M7.5 1v7h1V1h-1z" />
            <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
        </svg>
        SALIR
        </a>
    </div>
</nav>