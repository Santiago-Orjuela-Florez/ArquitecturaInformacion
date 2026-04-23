<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\PdfDocument;
use App\Models\Registro;

class PdfController extends Controller
{
    /**
     * Consulta técnica para el microservicio de búsqueda SAP.
     */
    public function buscar(Request $request)
    {
        try {
            $request->validate([
                'purchase_order' => 'required',
                'material_number' => 'required',
            ]);

            // Mapeo: material = Material Number, material_document = Purchase Order
            $registro = Registro::where('material', $request->material_number)
                ->where('material_document', $request->purchase_order)
                ->first();

            if ($registro) {
                $totalQuantity = $registro->batches()->sum('quantity');
                $batches = $registro->batches()->pluck('batch')->unique()->values()->toArray();
                $fecha = $registro->batches()->whereNotNull('date')->value('date');

                return response()->json([
                    'total_quantity' => (int) $totalQuantity,
                    'primary_batch' => $batches[0] ?? '',
                    'extra_batches_list' => count($batches) > 1 ? implode(', ', array_slice($batches, 1)) : '',
                    'delivery_date' => $fecha,
                    'material_description' => $registro->material_description
                ]);
            }

            return response()->json(['error' => 'No se encontraron registros en SAP.'], 404);

        } catch (\Exception $e) {
            \Log::error('Error en búsqueda SAP: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Genera, guarda y descarga el formulario de inspección.
     */
    public function descargarPdf(Request $request)
    {
        $data = $request->validate([
            'purchase_order' => 'required',
            'material_number' => 'required',
            'ean' => 'required',
            'delivery_date' => 'required',
            'batch' => 'required',
            'quantity' => 'required',
            'sign_warehouse' => 'required',
            'sign_inventory' => 'required',
            'batches' => 'nullable|string',
            'pallets' => 'nullable',
            'units' => 'nullable',
            'pallets2' => 'nullable',
            'units2' => 'nullable',
            'manufacturing_date' => 'nullable',
            'best_before_date' => 'nullable',
            'inspeccion' => 'nullable|array',
            'fallos' => 'nullable|array',
            'radio_check' => 'nullable',
        ]);

        // Consulta de validación final para el PDF
        $result = DB::table('registros')
            ->join('batches', 'registros.id', '=', 'batches.registro_id')
            ->select(
                'registros.id',
                'registros.material',
                'registros.material_description',
                'registros.material_document',
                'batches.batch',
                'batches.date',
                DB::raw('SUM(batches.quantity) as total_quantity')
            )
            ->where('registros.material', $request->material_number)
            ->where('registros.material_document', $request->purchase_order)
            ->where('batches.batch', $request->batch)
            ->groupBy('registros.id', 'registros.material', 'registros.material_description', 'registros.material_document', 'batches.batch', 'batches.date')
            ->first();

        // Configuración de vista PDF
        $pdf = Pdf::loadView('productos.plantilla', array_merge($data, [
            'modo' => 'pdf',
            'result' => $result
        ]))
        ->setPaper('legal', 'portrait')
        ->setOption('dpi', 72)
        ->setOption('defaultFont', 'DejaVu Sans');

        // Persistencia
        $filename = 'formulario_' . $request->purchase_order . '_' . time() . '.pdf';
        $path = 'pdfs/' . $filename;
        
        // Guardado físico en storage/app/public/pdfs
        Storage::disk('public')->put($path, $pdf->output());

        // Registro en historial (DB Secundaria)
        PdfDocument::create([
            'registro_id' => $result ? $result->id : 0, 
            'filename' => $filename,
            'path' => $path,
        ]);

        return $pdf->download($filename);
    }
}