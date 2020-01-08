<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<h2>Hola {{$user->name}}</h2>
<br>
<p>Bienvenido al sistema de compra y venta de funkopops en el tesoem, para verificar tu cuenta</p>
<p>accede al siguiente link  y goza de todos los feneficios.</p>
<br>
{{Route('verify', $user->verification_token)}}
<br>
<p>Un gran abrazo y un saludo de todo el equpo de "sistema tesoem"</p>
</body>
</html>