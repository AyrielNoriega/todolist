<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendientes</title>
<!-- css boostrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">


</head>
<body>


<div class="container mt-5 text-center">

    <div class="row">
        
        <div class="col">
            <form action="" method="POST">
                <div class="form-row align-items-center">
                    <div class="col-8 m-1">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="text" class="form-control" name="pendiente" id="pendiente">
                        </div>
                    </div>
 
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-primary">Agregar Pendiente</button>
                    </div>
                </div>
            </form>

            <div id="mostrar_Todo_container">
                <form action="" method="POST" id="mostrar_Todo">
                    <input type="checkbox" name="mostrarTodo" onChange="MostrarTodo(this)"
                    <?php if( isset($_POST['mostrarTodo']) ) {
                        if ( $_POST['mostrarTodo'] == "on"  ) {
                            echo " checked" ;
                        }    
                    }
                    ?>>Mostrar todo
                </form>
            </div>
        </div>

    </div>
        <div class="row" id="todolist">
             <?php
                require ("conexion.php");

                if (isset($_POST['pendiente'])) {
                    $pendiente = $_POST['pendiente'];

                    if ( $pendiente !="" ) {
                        $sql = "INSERT INTO todotable(pendiente, completo) VALUES('$pendiente', false)";

                        if ($conexion->query($sql) == true) {
                            // echo '<div>
                            //             <form action="">
                            //                 <input type="checkbox"> ' . $pendiente . '
                            //             </form>
                            //      </div>';
                        }else {
                            die ("Error al insertar datos: " . $conexion->error );
                        }
                    }

                }else if(isset($_POST['completo'])){
                    $id = $_POST['completo'];

                    $sql = "UPDATE todotable SET completo = 1 WHERE id = $id";
                    if ($conexion->query($sql) == true) {
                        // echo '<div>
                          //             <form action="">
                        //                 <input type="checkbox"> ' . $pendiente . '
                        //             </form>
                        //      </div>';
                    }else {
                        die ("Error al insertar datos: " . $conexion->error );
                    }
                }else if(isset($_POST['eliminar'])){
                    $id = $_POST['eliminar'];

                    $sql = "DELETE FROM todotable WHERE id = $id";
                    if ($conexion->query($sql) == true) {
                        // echo '<div>
                          //             <form action="">
                        //                 <input type="checkbox"> ' . $pendiente . '
                        //             </form>
                        //      </div>';
                    }else {
                        die ("Error al insertar datos: " . $conexion->error );
                    }
                }
                

                //ORDENAR PENDIENTES EN TABLA
                
                if(isset( $_POST['mostrarTodo']) ){
                    $ordenar = $_POST['mostrarTodo'];

                    if ( $ordenar == "on" ) {

                        $sql = "SELECT * FROM todotable ORDER BY completo ASC";
                    }       
                }else{
                    $sql = "SELECT * FROM todotable WHERE completo = 0";
                }

                // obtencion de datos
                // $sql = "SELECT * FROM todotable WHERE completo = 0";
                $resultado = $conexion->query( $sql );

                ?>

                <div class="col">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Pendiente</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>


                <?php

                if ( $resultado->num_rows > 0 ) {
                    
                    while ( $row = $resultado->fetch_assoc() ) {

                        ?>
                            <tr>
                                <td>
                                    <form id="form<?php echo $row["id"] ?>" action="" method="POST">
                                        <input name="completo" value="<?php echo $row["id"] ?>" 
                                            id="<?php echo $row["id"] ?>" 
                                            type="checkbox" 
                                            onChange="completarPendiente(this)"
                                            <?php if ( $row["completo"] == 1 ) echo ' checked disabled class="text-muted" '; ?>
                                        >  <span  <?php if ( $row["completo"] == 1 ) echo 'class="text-muted" '; ?>>
                                                  <?php  echo $row["pendiente"] ?>
                                            </span> 
                                            
                                    </form>
                                </td>
                                <td>
                                    <form id="form_eliminar_<?php echo $row["id"] ?>" action="" method="POST">
                                        <input name="eliminar" value="<?php echo $row["id"] ?>" 
                                            type="hidden"/>
                                        <input type="submit" class="btn btn-warning" value="eliminar">
                                    </form>
                                </td>
                            </tr>
    
                        <?php
                    }

                    ?>

                    </tbody>
                        </table>
                            </div>

                        <?php
                }



                $conexion->close();

            ?>
      
        </div>
 
</div>


<script>

        function completarPendiente (e){
            var id = 'form' + e.id
            var formulario = document.getElementById( id );
            formulario.submit();
        }

        function MostrarTodo( e ){
            var formulario = document.getElementById( 'mostrar_Todo' );
            formulario.submit();
        }

</script>

</body>
</html>