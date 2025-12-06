<?php

    if(!empty($_POST["btn_nuevoprod"])){

        $imagen_prod = $_FILES["imagen_prod"]["tmp_name"];
        $imagen_prod_nombre = $_FILES["imagen_prod"]["name"];
        $imagen_prod_tipo = strtolower(pathinfo($imagen_prod_nombre, PATHINFO_EXTENSION));
        $imagen_prod_peso = $_FILES["imagen_prod"]["size"];
        $directorio = "assets/products/";

        if($imagen_prod_tipo == "jpg" or $imagen_prod_tipo == "png" or $imagen_prod_tipo == "jpeg"){

            $nombre_prod = $_POST["nombre_prod"];
            $precio_prod = $_POST["precio_prod"];
            $desc_prod = $_POST["desc_prod"];
            $sql = $conn->query(" insert into productos (nombre_producto, precio_producto, descripcion_producto, imagen_producto) values('$nombre_prod', '$precio_prod', '$desc_prod', '') ");
            $id_prod = $conn->insert_id;

            $ruta = $directorio . "product_" . $id_prod . "." . $imagen_prod_tipo;

            $actualizar_sql = $conn->query(" update productos set imagen_producto = '$ruta' where id = $id_prod ");
            move_uploaded_file($imagen_prod, '../' . $ruta);

            if($actualizar_sql == true){
                header("location: ../index.php");
            } else {
                echo "<div class='alert alert-danger'>Error al crear el prducto.</div>";
            }

        } else {
            echo "<div class='alert alert-warning'>Formato no valido</div>";
        }

    }

?>