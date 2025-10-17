<?php 
    function addFecha() {
        $fecha = date("Y");

        return $fecha;
    }

    function parseFecha() {
        global $proyectos;
        
        // Fecha en JSON formato YYYY/mm/dd para su correcta transformacion a d/m/Y
        foreach($proyectos as $producto) {
            $timestamp = strtotime($producto['fecha']);
            $producto['fecha'] = date("d/m/Y", $timestamp);
        }
        unset($producto);
    }
?>