<?php

namespace App;

class Permisos
{
	// Roles de administración
	const ADMINISTRADORES = ['Administrador'];
	
	// Roles de clientes
	const CLIENTES = ['cliente'];
	
	// Roles de PROSARC
	const Conductor = ['Conductor'];
	// roles comerciales
	const Comercial = ['Comercial'];
	// roles de logistica
	const Logistica = ['Logistica'];
	// roles de PDA
	const PDA = ['PDA'];
	
	
	// Todos los roles
	const AL = ['Administrador', 'cliente', 'Conductor', 'Comercial', 'Logistica', 'PDA'];
	
	// Método para verificar si el usuario tiene alguno de los roles permitidos
	public static function check($rolesPermitidos)
	{
		if (!auth()->check()) {
			return false;
		}
		
		$userRol = auth()->user()->UsRol;
		$userRol2 = auth()->user()->UsRol2 ?? null;
		
		return in_array($userRol, $rolesPermitidos) || 
			   ($userRol2 !== null && in_array($userRol2, $rolesPermitidos));
	}
}

