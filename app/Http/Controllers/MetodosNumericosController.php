<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetodosNumericosController extends Controller
{
    public function index()
    {
        return view('metodos.index');
    }

    public function eulerMejorado(Request $request)
    {
        $f = function($x, $y) use ($request) { // Se agrega "use ($request)"
            return eval("return " . str_replace(["x", "y"], ["$x", "$y"], $request->funcion) . ";");
        };
        
        $x0 = $request->x0;
        $y0 = $request->y0;
        $h = $request->h;
        $xf = $request->xf;
        
        $x = $x0;
        $y = $y0;
        $resultados = [];
        
        while ($x < $xf) {
            $k1 = $h * $f($x, $y);
            $k2 = $h * $f($x + $h, $y + $k1);
            $y += ($k1 + $k2) / 2;
            $x += $h;
            $resultados[] = ['x' => $x, 'y' => $y];
        }
        
        return view('metodos.resultados', compact('resultados'));
    }
    
    public function rungeKutta(Request $request)
    {
        $f = function($x, $y) use ($request) {
            return eval("return " . str_replace(["x", "y"], ["$x", "$y"], $request->funcion) . ";");
        };
        
        $x0 = $request->x0;
        $y0 = $request->y0;
        $h = $request->h;
        $xf = $request->xf;
        
        $x = $x0;
        $y = $y0;
        $resultados = [];
        
        while ($x < $xf) {
            $k1 = $h * $f($x, $y);
            $k2 = $h * $f($x + $h / 2, $y + $k1 / 2);
            $k3 = $h * $f($x + $h / 2, $y + $k2 / 2);
            $k4 = $h * $f($x + $h, $y + $k3);
            
            $y += ($k1 + 2 * $k2 + 2 * $k3 + $k4) / 6;
            $x += $h;
            $resultados[] = ['x' => $x, 'y' => $y];
        }
        
        return view('metodos.resultados', compact('resultados'));
    }

    public function newtonRaphson(Request $request)
    {
        $f = function($x) use ($request) {
            return eval("return " . str_replace("x", "$x", $request->funcion) . ";");
        };
    
        $df = function($x) use ($request) {
            return eval("return " . str_replace("x", "$x", $request->derivada) . ";");
        };
        
        $x0 = $request->x0;
        $tol = $request->tol;
        $iter = $request->iter;
        
        $x = $x0;
        $resultados = [];
        
        for ($i = 0; $i < $iter; $i++) {
            $fx = $f($x);
            $dfx = $df($x);
            
            if ($dfx == 0) {
                break;
            }
            
            $x_new = $x - ($fx / $dfx);
            $resultados[] = ['iter' => $i + 1, 'x' => $x_new, 'error' => abs($x_new - $x)];
            
            if (abs($x_new - $x) < $tol) {
                break;
            }
            
            $x = $x_new;
        }
        
        return view('metodos.resultados', compact('resultados'));
    }
}
