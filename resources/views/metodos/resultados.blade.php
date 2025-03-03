<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Resultados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                @if(isset($resultados[0]['iter']))
                    <th>Iteración</th>
                    <th>x</th>
                    <th>Error</th>
                @else
                    <th>x</th>
                    <th>y</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($resultados as $dato)
                <tr>
                    @if(isset($dato['iter']))
                        <td>{{ $dato['iter'] }}</td>
                        <td>{{ $dato['x'] }}</td>
                        <td>{{ $dato['error'] }}</td>
                    @else
                        <td>{{ $dato['x'] }}</td>
                        <td>{{ $dato['y'] }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="/" class="btn btn-primary">Volver</a>
</body>
</html>
