@extends('main.home.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    @php $modo = $modo ?? 'web'; @endphp

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

    @if($modo !== 'pdf')
        <form method="POST" action="{{ route('formulario.pdf') }}" class="space-y-8">
            @csrf
    @endif

    <div class="bg-white rounded-[40px] shadow-2xl border border-gray-100 overflow-hidden">
        {{-- Header corporativo --}}
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
                {{-- Fondo con nitidez forzada --}}
                @if($modo === 'pdf')
                    <img src="{{ public_path('images/plantilla.png') }}" class="w-full block">
                @else
                    <img src="{{ asset('images/plantilla.png') }}" class="w-full block img-nitida">
                @endif

                <div class="form-grid-overlay p-10 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    
                    {{-- Bloque 1: Identificación --}}
                    <div class="space-y-4">
                        <div>
                            <label class="label-form">Purchase Order No.</label>
                            @if($modo === 'pdf')
                                <div class="Purchase_Order_PDF text-pdf">{{ $purchase_order ?? '' }}</div>
                            @else
                                <input type="number" name="purchase_order" class="custom-input w-full shadow-sm"
                                    value="{{ old('purchase_order', $purchase_order ?? '') }}" placeholder="P.O. Number">
                            @endif
                        </div>

                        <div>
                            <label class="label-form">Material Number</label>
                            @if($modo === 'pdf')
                                <div class="Material_Number_PDF text-pdf">{{ $material_number ?? '' }}</div>
                            @else
                                <input type="number" name="material_number" class="custom-input w-full shadow-sm"
                                    value="{{ old('material_number', $material_number ?? '') }}" placeholder="Material Code">
                            @endif
                        </div>

                        <div>
                            <label class="label-form">EAN</label>
                            @if($modo === 'pdf')
                                <div class="EAN_PDF text-pdf">{{ $ean ?? '' }}</div>
                            @else
                                <input type="number" name="ean" class="custom-input w-full shadow-sm" 
                                    value="{{ old('ean', $ean ?? '') }}" placeholder="Barcode EAN">
                            @endif
                        </div>
                    </div>

                    {{-- Bloque 2: Fechas --}}
                    <div class="space-y-4">
                        <div>
                            <label class="label-form">Delivery Date</label>
                            @if($modo === 'pdf')
                                <div class="Delivery_Date_PDF text-pdf">{{ $delivery_date ?? '' }}</div>
                            @else
                                <input type="date" name="delivery_date" class="custom-input w-full shadow-sm"
                                    value="{{ old('delivery_date', $delivery_date ?? '') }}">
                            @endif
                        </div>

                        <div>
                            <label class="label-form">Manufacturing Date</label>
                            @if($modo === 'pdf')
                                <div class="Manufacturing_Date_PDF text-pdf">{{ $manufacturing_date ?? '' }}</div>
                            @else
                                <input type="date" name="manufacturing_date" class="custom-input w-full shadow-sm"
                                    value="{{ $manufacturing_date ?? '' }}">
                            @endif
                        </div>

                        <div>
                            <label class="label-form">Best Before Date</label>
                            @if($modo === 'pdf')
                                <div class="Best_Before_Date_PDF text-pdf">{{ $best_before_date ?? '' }}</div>
                            @else
                                <input type="date" name="best_before_date" class="custom-input w-full shadow-sm" 
                                    value="{{ $best_before_date ?? '' }}">
                            @endif
                        </div>
                    </div>

                    {{-- Pallestisation --}}
                    <div class="md:col-span-2 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        <label class="block text-[10px] font-black text-red-500 uppercase mb-3 tracking-widest">Pallestisation Details</label>
                        @if($modo === 'pdf')
                            <div class="grid grid-cols-4 gap-4 text-center font-bold text-gray-900">
                                <div>P: {{ $pallets ?? '' }}</div>
                                <div>U: {{ $units ?? '' }}</div>
                                <div>P2: {{ $pallets2 ?? '' }}</div>
                                <div>U2: {{ $units2 ?? '' }}</div>
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

                    {{-- Firmas --}}
                    <div class="space-y-4">
                        <label class="label-form">Sign Warehouse</label>
                        @if($modo === 'pdf')
                            <div class="text-pdf">{{ $sign_warehouse ?? '' }}</div>
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
                        <label class="label-form">Sign Inventory</label>
                        @if($modo === 'pdf')
                            <div class="text-pdf">{{ $sign_inventory ?? '' }}</div>
                        @else
                            <select name="sign_inventory" class="custom-input w-full shadow-sm">
                                <option value="">Select Name</option>
                                @foreach(['Andres Orjuela', 'Santiago Orjuela', 'Camila Orjuela'] as $name)
                                    <option value="{{ $name }}" {{ old('sign_inventory') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    {{-- Inspección --}}
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-black text-gray-800 uppercase mb-4 tracking-wider border-l-4 border-red-500 pl-3">Technical Inspection Items</label>
                        @if($modo !== 'pdf')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach(['01' => 'Correct Sticker?', '02' => 'Sticker Aligned?', '03' => 'Package Integrity', '04' => 'Tape Position', '05' => 'Cleanliness'] as $key => $label)
                                    <div class="item-check group hover:border-red-200 transition-colors">
                                        <span class="text-xs font-bold text-gray-700 group-hover:text-red-600">{{ $label }}</span>
                                        <div class="flex space-x-4">
                                            <div class="flex flex-col items-center">
                                                <span class="text-[8px] font-black text-green-600">OK</span>
                                                <input type="checkbox" name="inspeccion[]" value="{{ $key }}" class="w-4 h-4 text-green-500 border-gray-300 rounded focus:ring-green-400">
                                            </div>
                                            <div class="flex flex-col items-center">
                                                <span class="text-[8px] font-black text-red-600">FAIL</span>
                                                <input type="checkbox" name="fallos[]" value="{{ $key }}" class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-400">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Acciones --}}
        @if($modo !== 'pdf')
            <div class="px-10 py-8 bg-gray-50 border-t border-gray-100 flex flex-wrap gap-4 justify-end">
                <button type="button" id="btn_consultar" data-url="{{ route('datos.buscar') }}" data-token="{{ csrf_token() }}"
                    class="btn-secondary">
                    Consult SAP Data
                </button>
                <button type="submit" class="btn-primary">
                    Generate & Download PDF
                </button>
            </div>
        @endif
    </div>

    @if($modo !== 'pdf')
        </form>
    @endif
</div>
@endsection