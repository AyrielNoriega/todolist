<?php

    $SERVER = "localhost";
    $USUARIO = "root";
    $CONTRASEÑA = "";
    $BASEDATOS = "totoListDB";

    $conexion = new mysqli( $SERVER, $USUARIO, $CONTRASEÑA, $BASEDATOS );
        if ( $conexion->connect_error ) {
            die( "Falló al conectar a MySQL: " . $conexion->connect_error . " - " . $conexion->connect_errno );
        }

        