@extends('layouts.app')

@section('title', 'Editar Vehículo')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Editar Vehículo: {{ $vehicle->license_plate }}</h2>
            <a href="{{ route('admin.fleet.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>

        <form action="{{ route('admin.fleet.update', $vehicle) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="license_plate" class="form-label">Placa del Taxi *</label>
                    <input type="text" id="license_plate" name="license_plate" class="form-control" value="{{ old('license_plate', $vehicle->license_plate) }}" maxlength="7">
                    @error('license_plate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="year" class="form-label">Año del Modelo *</label>
                    <input type="text" id="year" name="year" class="form-control" value="{{ old('year', $vehicle->year) }}">
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="brand" class="form-label">Marca *</label>
                    <input type="text" id="brand" name="brand" class="form-control" value="{{ old('brand', $vehicle->brand) }}">
                    @error('brand')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="model" class="form-label">Modelo *</label>
                    <input type="text" id="model" name="model" class="form-control" value="{{ old('model', $vehicle->model) }}">
                    @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="color" class="form-label">Color *</label>
                    <input type="text" id="color" name="color" class="form-control" value="{{ old('color', $vehicle->color) }}">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Estado *</label>
                    <select id="status" name="status" class="form-control">
                        <option value="operativo" {{ old('status', $vehicle->status) == 'operativo' ? 'selected' : '' }}>Operativo</option>
                        <option value="mantenimiento" {{ old('status', $vehicle->status) == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                        <option value="inactivo" {{ old('status', $vehicle->status) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
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
                        <option value="{{ $driver->id }}" {{ old('driver_id', $vehicle->driver_id) == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }} ({{ $driver->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('admin.fleet.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
