<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="display-4">Resultados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                @if(isset($resultados[0]['iter']))
                    <th class="h4">Iteración</th>
                    <th class="h4">x</th>
                    <th class="h4">Error</th>
                @else
                    <th class="h4">x</th>
                    <th class="h4">y</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($resultados as $dato)
                <tr>
                    @if(isset($dato['iter']))
                        <td class="h5">{{ $dato['iter'] }}</td>
                        <td class="h5">{{ $dato['x'] }}</td>
                        <td class="h5">{{ $dato['error'] }}</td>
                    @else
                        <td class="h5">{{ $dato['x'] }}</td>
                        <td class="h5">{{ $dato['y'] }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="/" class="btn btn-primary btn-lg">Volver</a>
</body>
</html>
