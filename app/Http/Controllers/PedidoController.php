<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::orderBy('fecha_pedido', 'desc')->get();
        return view('main.pedidos.index', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'fecha_pedido' => 'required|date',
        ]);

        Pedido::create($request->all());

        return back()->with('success', 'Pedido guardado exitosamente.');
    }

    public function destroy($id)
    {
        Pedido::findOrFail($id)->delete();
        return back()->with('success', 'Pedido eliminado correctamente.');
    }

    public function exportPdf()
    {
        $pedidos = Pedido::all();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('main.pedidos.pdf', compact('pedidos'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('reporte_pedidos_'.date('Y_m_d').'.pdf');
    }
}
