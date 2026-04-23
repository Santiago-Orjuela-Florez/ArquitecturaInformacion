@extends('main.home.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    @php
        $modo = $modo ?? 'web';
    @endphp

    {{-- 1. Recuadro de errores (Solo visible en la Web) --}}
    @if ($errors->any() && $modo !== 'pdf')
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm shadow-sm">
            <strong class="block mb-1 font-bold">Attention! Check the following fields:</strong>
            <ul class="list-disc list-inside opacity-90">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 2. Apertura del Formulario (Solo en la Web) --}}
    @if($modo !== 'pdf')
        <form method="POST" action="{{ route('formulario.pdf') }}" class="space-y-8">
            @csrf
    @endif

    <div class="bg-white rounded-[40px] shadow-2xl border border-gray-100 overflow-hidden">
        {{-- Encabezado --}}
        <div class="px-10 py-8 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-red-50/50 to-transparent">
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Incoming Inspection Record</h3>
                <p class="text-xs text-red-500 uppercase tracking-[0.2em] font-bold mt-1">Stickered Imported Products</p>
            </div>
            <div class="text-right">
                <span class="px-4 py-1.5 rounded-full bg-red-500 text-white text-[10px] font-black uppercase tracking-wider shadow-md">
                    MODO: {{ strtoupper($modo) }}
                </span>
            </div>
        </div>

        <div class="p-10">
            <div class="hoja-container relative mx-auto overflow-hidden rounded-3xl shadow-xl bg-white border border-gray-200">
                {{-- Imagen de fondo nítida --}}
                @if($modo === 'pdf')
                    <img src="{{ public_path('images/plantilla.png') }}" class="w-full block">
                @else
                    <img src="{{ asset('images/plantilla.png') }}" class="w-full block brightness-[1.02]">
                @endif

                <div class="form-grid-overlay p-10 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    
                    {{-- Bloque 1: Identificación --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Purchase Order No.</label>
                            @if($modo === 'pdf')
                                <div class="Purchase_Order_PDF font-bold text-gray-900">{{ $purchase_order ?? '' }}</div>
                            @else
                                <input type="number" name="purchase_order" class="custom-input w-full shadow-sm"
                                    value="{{ old('purchase_order', $purchase_order ?? '') }}" placeholder="Purchase Order">
                            @endif
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Material Number</label>
                            @if($modo === 'pdf')
                                <div class="Material_Number_PDF font-bold text-gray-900">{{ $material_number ?? '' }}</div>
                            @else
                                <input type="number" name="material_number" class="custom-input w-full shadow-sm"
                                    value="{{ old('material_number', $material_number ?? '') }}" placeholder="Material Number">
                            @endif
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">EAN</label>
                            @if($modo === 'pdf')
                                <div class="EAN_PDF font-bold text-gray-900">{{ $ean ?? '' }}</div>
                            @else
                                <input type="number" name="ean" class="custom-input w-full shadow-sm" 
                                    value="{{ old('ean', $ean ?? '') }}" placeholder="EAN">
                            @endif
                        </div>
                    </div>

                    {{-- Bloque 2: Fechas y Batch --}}
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Delivery Date</label>
                            @if($modo === 'pdf')
                                <div class="Delivery_Date_PDF font-bold text-gray-900">{{ $delivery_date ?? '' }}</div>
                            @else
                                <input type="date" name="delivery_date" class="custom-input w-full shadow-sm"
                                    value="{{ old('delivery_date', $delivery_date ?? '') }}">
                            @endif
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Manufacturing Date</label>
                            @if($modo === 'pdf')
                                <div class="Manufacturing_Date_PDF font-bold text-gray-900">{{ $manufacturing_date ?? '' }}</div>
                            @else
                                <input type="date" name="manufacturing_date" class="custom-input w-full shadow-sm"
                                    value="{{ $manufacturing_date ?? '' }}">
                            @endif
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Best Before Date</label>
                            @if($modo === 'pdf')
                                <div class="Best_Before_Date_PDF font-bold text-gray-900">{{ $best_before_date ?? '' }}</div>
                            @else
                                <input type="date" name="best_before_date" class="custom-input w-full shadow-sm" 
                                    value="{{ $best_before_date ?? '' }}">
                            @endif
                        </div>
                    </div>

                    {{-- Bloque 3: Pallestisation --}}
                    <div class="md:col-span-2 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        <label class="block text-[10px] font-black text-red-500 uppercase mb-3 tracking-widest">Pallestisation</label>
                        @if($modo === 'pdf')
                            <div class="grid grid-cols-4 gap-4 text-center font-bold text-gray-900">
                                <div class="Pallets_PDF">P: {{ $pallets ?? '' }}</div>
                                <div class="Units_PDF">U: {{ $units ?? '' }}</div>
                                <div class="Pallets2_PDF">P2: {{ $pallets2 ?? '' }}</div>
                                <div class="Units2_PDF">U2: {{ $units2 ?? '' }}</div>
                            </div>
                        @else
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <input type="number" name="pallets" class="custom-input" value="{{ old('pallets', $pallets ?? '') }}" placeholder="Pallets">
                                <input type="number" name="units" class="custom-input" value="{{ old('units', $units ?? '') }}" placeholder="Units">
                                <input type="number" name="pallets2" class="custom-input" value="{{ old('pallets2', $pallets2 ?? '') }}" placeholder="Pallets 2">
                                <input type="number" name="units2" class="custom-input" value="{{ old('units2', $units2 ?? '') }}" placeholder="Units 2">
                            </div>
                        @endif
                    </div>

                    {{-- Bloque 4: Firmas --}}
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Sign Warehouse</label>
                        @if($modo === 'pdf')
                            <div class="font-bold text-gray-900">{{ $sign_warehouse ?? '' }}</div>
                        @else
                            <select name="sign_warehouse" class="custom-input w-full shadow-sm">
                                <option value="">Select Name</option>
                                @foreach(['Andres Orjuela', 'Santiago Orjuela', 'Camila Orjuela'] as $name)
                                    <option value="{{ $name }}" {{ old('sign_warehouse') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Sign Inventory</label>
                        @if($modo === 'pdf')
                            <div class="font-bold text-gray-900">{{ $sign_inventory ?? '' }}</div>
                        @else
                            <select name="sign_inventory" class="custom-input w-full shadow-sm">
                                <option value="">Select Name</option>
                                @foreach(['Andres Orjuela', 'Santiago Orjuela', 'Camila Orjuela'] as $name)
                                    <option value="{{ $name }}" {{ old('sign_inventory') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- Bloque 5: Checks y Otros --}}
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-black text-gray-800 uppercase mb-4 tracking-wider border-l-4 border-red-500 pl-3">Technical Inspection Items</label>
                        @if($modo === 'pdf')
                            {{-- Lógica de renderizado PDF original --}}
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach(['01' => 'Correct Sticker?', '02' => 'Sticker Aligned?', '03' => 'Package Integrity', '04' => 'Tape Position', '05' => 'Cleanliness'] as $key => $label)
                                    <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl shadow-sm">
                                        <span class="text-xs font-bold text-gray-700">{{ $label }}</span>
                                        <div class="flex space-x-4">
                                            <div class="flex flex-col items-center">
                                                <span class="text-[8px] font-bold text-green-500">OK</span>
                                                <input type="checkbox" name="inspeccion[]" value="{{ $key }}" class="w-4 h-4 text-green-500 border-gray-300 rounded">
                                            </div>
                                            <div class="flex flex-col items-center">
                                                <span class="text-[8px] font-bold text-red-500">FAIL</span>
                                                <input type="checkbox" name="fallos[]" value="{{ $key }}" class="w-4 h-4 text-red-500 border-gray-300 rounded">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Batch Info</label>
                            @if($modo === 'pdf')
                                <div class="Batch_PDF font-bold text-gray-900">{{ $batch ?? '' }}</div>
                            @else
                                <input type="number" name="batch" class="custom-input w-full" value="{{ old('batch', $batch ?? '') }}" placeholder="Batch">
                            @endif
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Quantity</label>
                            @if($modo === 'pdf')
                                <div class="Quantity_PDF font-bold text-gray-900">{{ $result->total_quantity ?? ($quantity ?? '0') }}</div>
                            @else
                                <input type="number" name="quantity" class="custom-input w-full" value="{{ old('quantity', $quantity ?? '') }}" placeholder="Quantity">
                            @endif
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-800 uppercase mb-1">Product Disposition</label>
                            @if($modo === 'pdf')
                                {{-- Lógica Radio PDF --}}
                            @else
                                <div class="flex space-x-4 mt-2">
                                    @foreach(['yes' => 'Acc', 'no' => 'Rej', 'na' => 'N/A'] as $val => $label)
                                        <label class="flex items-center text-[10px] font-bold text-gray-600 uppercase">
                                            <input type="radio" name="radio_check" value="{{ $val }}" {{ old('radio_check') == $val ? 'checked' : '' }} class="mr-1 text-red-500"> {{ $label }}
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Acciones --}}
        @if($modo !== 'pdf')
            <div class="px-10 py-8 bg-gray-50 border-t border-gray-100 flex flex-wrap gap-4 justify-end">
                <button type="button" id="btn_consultar" data-url="{{ route('datos.buscar') }}" data-token="{{ csrf_token() }}"
                    class="px-8 py-3 rounded-2xl bg-white border-2 border-red-500 text-red-600 font-black text-xs uppercase tracking-widest hover:bg-red-50 transition-all shadow-sm">
                    Consult Data
                </button>
                <button type="submit" class="px-10 py-3 rounded-2xl bg-gradient-to-r from-red-600 to-red-500 text-white font-black text-xs uppercase tracking-widest shadow-xl hover:scale-[1.02] transition-transform">
                    Generate and Download PDF
                </button>
            </div>
        @endif
    </div>

    @if($modo !== 'pdf')
        </form>
    @endif
</div>
@endsection