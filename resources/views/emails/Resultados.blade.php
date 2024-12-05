<x-mail::message>
# ¡Hola, {{ $name }}! 👋
<br>

Gracias por elegir el **CENTRO MEDICO SAMA**.
Le informamos que sus resultados médicos ya están listos y puede verlos haciendo clic en el botón de abajo.

<x-mail::button :url="$ruta">
Ver resultados
</x-mail::button>

Si tiene alguna duda o necesita más información, no dude en responder a este mensaje.

Estamos aquí para ayudarle.

<br>

Gracias,<br>
**{{ config('app.name') }}**

<x-mail::subcopy>
Si tiene problemas con el botón **Ver resultados**, copie y pegue la siguiente URL en su navegador web: {{ $ruta }}
</x-mail::subcopy>

</x-mail::message>