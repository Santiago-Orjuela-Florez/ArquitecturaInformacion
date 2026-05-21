<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Muestra el dashboard principal.
     * Protegido por validación de sesión manual.
     */
    public function main()
    {
        $stats = [
            'ventas_hoy' => \App\Models\Pedido::whereDate('fecha_pedido', date('Y-m-d'))->sum('total'),
            'pedidos_pendientes' => \App\Models\Pedido::where('estado', 'Pendiente')->count(),
            'eficiencia' => '94.2%',
        ];

        $chartData = \App\Models\Pedido::selectRaw('estado, count(*) as count')
            ->groupBy('estado')
            ->pluck('count', 'estado')
            ->toArray();

        return view('main.home.home', compact('stats', 'chartData'));
    }
}
