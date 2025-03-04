<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métodos Numéricos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 1.25rem; /* Aumenta el tamaño de la fuente */
        }
    </style>
</head>
<body class="container mt-4">
    <h2>Métodos Numéricos</h2>

    <!-- Pestañas para seleccionar el formulario -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="euler-tab" data-bs-toggle="tab" href="#euler" role="tab" aria-controls="euler" aria-selected="true">Euler Mejorado</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="runge-tab" data-bs-toggle="tab" href="#runge" role="tab" aria-controls="runge" aria-selected="false">Runge-Kutta</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="newton-tab" data-bs-toggle="tab" href="#newton" role="tab" aria-controls="newton" aria-selected="false">Newton-Raphson</a>
        </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <!-- Formulario Euler Mejorado -->
        <div class="tab-pane fade show active" id="euler" role="tabpanel" aria-labelledby="euler-tab">
            <form action="/euler-mejorado" method="POST">
                @csrf
                <h4>Euler Mejorado</h4>
                <label>Función (en términos de x y y):</label>
                <input type="text" name="funcion" class="form-control" required placeholder="Ej: y-x^2+1">
                <label>x0:</label>
                <input type="number" step="any" name="x0" class="form-control" required placeholder="Ej: 0">
                <label>y0:</label>
                <input type="number" step="any" name="y0" class="form-control" required placeholder="Ej: 0.5">
                <label>h (paso):</label>
                <input type="number" step="any" name="h" class="form-control" required placeholder="Ej: 0.2">
                <label>xf:</label>
                <input type="number" step="any" name="xf" class="form-control" required placeholder="Ej: 2">
                <button type="submit" class="btn btn-primary mt-2">Calcular</button>
            </form>
        </div>

        <!-- Formulario Runge-Kutta -->
        <div class="tab-pane fade" id="runge" role="tabpanel" aria-labelledby="runge-tab">
            <form action="/runge-kutta" method="POST" class="mt-4">
                @csrf
                <h4>Runge-Kutta (4to orden)</h4>
                <label>Función (en términos de x y y):</label>
                <input type="text" name="funcion" class="form-control" required placeholder="Ej: y-x^2+1">
                <label>x0:</label>
                <input type="number" step="any" name="x0" class="form-control" required placeholder="Ej: 0">
                <label>y0:</label>
                <input type="number" step="any" name="y0" class="form-control" required placeholder="Ej: 0.5">
                <label>h (paso):</label>
                <input type="number" step="any" name="h" class="form-control" required placeholder="Ej: 0.2">
                <label>xf:</label>
                <input type="number" step="any" name="xf" class="form-control" required placeholder="Ej: 2">
                <button type="submit" class="btn btn-primary mt-2">Calcular</button>
            </form>
        </div>

        <!-- Formulario Newton-Raphson -->
        <div class="tab-pane fade" id="newton" role="tabpanel" aria-labelledby="newton-tab">
            <form action="/newton-raphson" method="POST" class="mt-4">
                @csrf
                <h4>Newton-Raphson</h4>
                <label>Función (en términos de x):</label>
                <input type="text" name="funcion" class="form-control" required placeholder="Ej:x^3-x-2">
                <label>Derivada de la función:</label>
                <input type="text" name="derivada" class="form-control" required placeholder="Ej: 3*x^2-1">
                <label>x0:</label>
                <input type="number" step="any" name="x0" class="form-control" required placeholder="Ej: 1">
                <label>Tolerancia:</label>
                <input type="number" step="any" name="tol" class="form-control" required placeholder="Ej: 0.0001">
                <label>Iteraciones máximas:</label>
                <input type="number" name="iter" class="form-control" required placeholder="Ej: 100">
                <button type="submit" class="btn btn-primary mt-2">Calcular</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <footer class="mt-4">
        <p>Realizado por Jorge Adrian Lira Lopez, 8C</p>
    </footer>
</body>
</html>