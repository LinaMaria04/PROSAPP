@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Rol</h1>
        <form action="{{ route('roles.update', $role->Id_Rol) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- {{ $role }} --}}
            <div class="form-group">
                <label for="Rol">Rol</label>
                <input type="text" class="form-control" id="Rol" name="Rol" value="{{ $role->Rol }}">
            </div>
            <div class="form-group">
                <label for="Description">Descripción</label>
                <input type="text" class="form-control" id="Description" name="Description" value="{{ $role->Description }}">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
