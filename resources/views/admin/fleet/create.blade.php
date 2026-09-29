@extends('layouts.app')

@section('title', 'Registrar Vehículo en Flota')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Registrar Nuevo Taxi en Flota</h2>
            <a href="{{ route('admin.fleet.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>

        <form action="{{ route('admin.fleet.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="license_plate" class="form-label">Placa del Taxi * (Ej: UBA123)</label>
                    <input type="text" id="license_plate" name="license_plate" class="form-control" value="{{ old('license_plate') }}" placeholder="UBA123" maxlength="7">
                    @error('license_plate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="year" class="form-label">Año del Modelo * (Número 2000-2030)</label>
                    <input type="text" id="year" name="year" class="form-control" value="{{ old('year') }}" placeholder="2023">
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="brand" class="form-label">Marca del Vehículo *</label>
                    <input type="text" id="brand" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="Hyundai">
                    @error('brand')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="model" class="form-label">Línea / Modelo *</label>
                    <input type="text" id="model" name="model" class="form-control" value="{{ old('model') }}" placeholder="Accent">
                    @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="color" class="form-label">Color *</label>
                    <input type="text" id="color" name="color" class="form-control" value="{{ old('color', 'Amarillo') }}" placeholder="Amarillo">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Estado Operativo *</label>
                    <select id="status" name="status" class="form-control">
                        <option value="operativo" {{ old('status') == 'operativo' ? 'selected' : '' }}>Operativo</option>
                        <option value="mantenimiento" {{ old('status') == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                        <option value="inactivo" {{ old('status') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="driver_id" class="form-label">Conductor Asignado</label>
                <select id="driver_id" name="driver_id" class="form-control">
                    <option value="">-- Sin conductor asignado --</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }} ({{ $driver->email }})
                        </option>
                    @endforeach
                </select>
                @error('driver_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('admin.fleet.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Vehículo</button>
            </div>
        </form>
    </div>
</div>
@endsection
