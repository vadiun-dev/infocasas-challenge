<?php

function obtenerPrecio($id) {

    // Definir los posibles valores variables
    $valores_variables = array(
        "venta-apartamento-3-dormitorios-escritorio-3-baos-serv-gje",
        "apartamento-en-venta-en-carrasco-sur",
        "reservado-apartamento-moderno-premium-piscina-carrasco-sur"
    );

    // Iterar sobre cada valor variable y probar obtener el precio del inmueble
    foreach ($valores_variables as $valor_variable) {
        // Construir la URL del inmueble usando el valor variable y el ID proporcionado
        $url = "https://www.infocasas.com.uy/$valor_variable/$id";

        // Inicializar cURL
        $curl = curl_init();

        // Configurar las opciones de cURL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        // Ejecutar la solicitud HTTP
        $response = curl_exec($curl);

        // Verificar si hubo errores
        if ($response === false) {
            echo "Error al obtener la página del inmueble.";
            continue; // Pasar al siguiente valor variable
        }

        // Cerrar la sesión cURL
        curl_close($curl);

        // Buscar el precio en el JSON de la página usando una expresión regular
        if (preg_match('/"price_amount_usd":(\d+)/', $response, $matches)) {
            // Obtener el precio del inmueble
            $precio = $matches[1];
            
            // Devolver el precio en formato "U$S precio"
            return "U\$S $precio";
        }
    }

    // Si no se encuentra el precio en ninguno de los valores variables, mostrar un mensaje de error
    return "price not found for id $id.";
}

// Obtener el ID del inmueble desde los argumentos de la línea de comandos
if (isset($argv[1])) {
    $id_inmueble = $argv[1];
    $precio = obtenerPrecio($id_inmueble);
    echo "$precio\n";
} else {
    echo "Por favor, proporcione el ID del inmueble como argumento.\n";
}

?>
