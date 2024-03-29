<?php
date_default_timezone_set('America/Bogota');
setlocale(LC_TIME, 'es_VE.UTF-8', 'esp');
session_start();

$usuario = trim($_SESSION['usuario']);
$rol     = $_SESSION['rol'];

if (isset($_SESSION['logged']) === FALSE) {
    header("Location: login.php");
}

define('SITE_ROOT', realpath(dirname(__FILE__)));
if ($rol != 1) {
    echo '<script>alert("No tiene permisos para acceder a esta página")</script>';
    header('Location: /gestionadministrativa/');
} else {

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>CALENDARIO</title>
        <link rel="icon" href="../../vendor/images/icon-home.png" type="image/png">
        <link rel="stylesheet" type="text/css" href="css/fullcalendar.min.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/home.css">
        <link rel="stylesheet" href="../../vendor/css/menu_usuario.css">
        <link rel="stylesheet" href="../../nav_responsive.css">

    </head>

    <body>
        <div class="inv_index">
            <?php require '../../nav.php'; ?>
            <div class="btn btn-actions">
                <a href="../../" class="btn btn-danger btn-lg" <?php if ($_SESSION['rol'] == 27) {
                    echo 'style="display: none;"';
                } ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                    </svg>
                    Atrás</a>&nbsp;
            </div>
            <br>

        </div>

        <?php require_once '../../nav.php'; ?>
        <?php
        include('../../config.php');

        $SqlEventos   = ("SELECT * FROM eventoscalendar");
        $resulEventos = mysqli_query($con, $SqlEventos);

        ?>
        <div class="mt-5"></div>

        <div class="container">
            <div class="row">
                <div class="col msjs">
                    <?php
                    include('msjs.php');
                    ?>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3 class="text-center" id="title">Eventos Programados</h3>
                </div>
            </div>
        </div>



        <div id="calendar"></div>


        <?php
        include('modalNuevoEvento.php');
        include('modalUpdateEvento.php');
        ?>

        <script src="../../vendor/js/menu_usuario.js"></script>
        <script src="js/jquery-3.0.0.min.js"> </script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script type="text/javascript" src="js/moment.min.js"></script>
        <script type="text/javascript" src="js/fullcalendar.min.js"></script>
        <script src='locales/es.js'></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#calendar").fullCalendar({
                    header: {
                        left: "prev,next today",
                        center: "title",
                        right: "month,agendaWeek,agendaDay"
                    },
                    locale: 'es',
                    defaultView: "month",
                    navLinks: true,
                    editable: true,
                    eventLimit: true,
                    selectable: true,
                    selectHelper: false,

                    //Nuevo Evento
                    select: function (start, end) {
                        $("#exampleModal").modal();
                        $("input[name=fecha_inicio]").val(start.format('DD-MM-YYYY'));

                        var valorFechaFin = end.format("DD-MM-YYYY");
                        var F_final = moment(valorFechaFin, "DD-MM-YYYY").subtract(1, 'days').format('DD-MM-YYYY'); //Le resto 1 dia
                        $('input[name=fecha_fin').val(F_final);

                    },

                    events: [
                        <?php
                        while ($dataEvento = mysqli_fetch_array($resulEventos)) { ?>
                                  {
                                _id: '<?php echo $dataEvento['id']; ?>',
                                title: '<?php echo $dataEvento['evento']; ?>',
                                start: '<?php echo $dataEvento['fecha_inicio']; ?>',
                                end: '<?php echo $dataEvento['fecha_fin']; ?>',
                                color: '<?php echo $dataEvento['color_evento']; ?>'
                            },
                        <?php } ?>
                    ],


                    //Eliminar Evento
                    eventRender: function (event, element) {
                        element
                            .find(".fc-content")
                            .prepend("<span id='btnCerrar'; class='closeon material-icons'>&#xe5cd;</span>");

                        //Eliminar evento
                        element.find(".closeon").on("click", function () {

                            var pregunta = confirm("Deseas Borrar este Evento?");
                            if (pregunta) {

                                $("#calendar").fullCalendar("removeEvents", event._id);

                                $.ajax({
                                    type: "POST",
                                    url: 'deleteEvento.php',
                                    data: { id: event._id },
                                    success: function (datos) {
                                        $(".alert-danger").show();

                                        setTimeout(function () {
                                            $(".alert-danger").slideUp(500);
                                        }, 3000);

                                    }
                                });
                            }
                        });
                    },


                    //Moviendo Evento Drag - Drop
                    eventDrop: function (event, delta) {
                        var idEvento = event._id;
                        var start = (event.start.format('DD-MM-YYYY'));
                        var end = (event.end.format("DD-MM-YYYY"));

                        $.ajax({
                            url: 'drag_drop_evento.php',
                            data: 'start=' + start + '&end=' + end + '&idEvento=' + idEvento,
                            type: "POST",
                            success: function (response) {
                                // $("#respuesta").html(response);
                            }
                        });
                    },

                    //Modificar Evento del Calendario
                    eventClick: function (event) {
                        var idEvento = event._id;
                        $('input[name=idEvento').val(idEvento);
                        $('input[name=evento').val(event.title);
                        $('input[name=fecha_inicio').val(event.start.format('DD-MM-YYYY'));
                        $('input[name=fecha_fin').val(event.end.format("DD-MM-YYYY"));

                        $("#modalUpdateEvento").modal();
                    },


                });


                //Oculta mensajes de Notificacion
                setTimeout(function () {
                    $(".alert").slideUp(300);
                }, 3000);


            });

        </script>


        <!--------- WEB DEVELOPER ------>
        <!--------- URIAN VIERA   ----------->
    <!--------- PORTAFOLIO:  https://blogangular-c7858.web.app  -------->

    </body>

    </html>
<?php } ?>