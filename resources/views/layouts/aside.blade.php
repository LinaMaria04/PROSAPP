<div class="col-sm-3">
    <ul class="list-group">        
        <li class="list-group-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
        <li class="list-group-item"><a href="{{ route('personal.index') }}">Personal</a></li>
        <li class="list-group-item"><a href="{{ route('sedes.index') }}">Sedes</a></li>
        <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action {{ Request::routeIs('profile.show') || Request::routeIs('profile.edit') ? 'active' : '' }}">
            <i class='bx bx-user-circle me-2'></i> Mi Perfil
        </a>
    </ul>
</div>
