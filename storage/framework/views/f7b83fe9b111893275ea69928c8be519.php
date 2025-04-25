<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - ProsarApp</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1565C0, #64B5F6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .register-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(21, 101, 192, 0.25);
            border-color: #1565C0;
        }
        .btn-primary {
            padding: 0.75rem;
            background-color: #1565C0;
            border-color: #1565C0;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #0D47A1;
            border-color: #0D47A1;
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
        }
        #step2Form {
            display: none;
        }
        .description-tooltip {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h2 class="mb-3">ProsarApp</h2>
            <p class="text-muted" id="stepTitle">Paso 1: Datos de la empresa</p>
        </div>

        <!-- Paso 1: Formulario de datos de cliente -->
        <form id="step1Form">
            <div class="mb-3">
                <label for="ClientDocType" class="form-label">Tipo de Documento</label>
                <select class="form-control" id="ClientDocType" name="ClientDocType" required>
                    <option value="">Seleccione...</option>
                </select>
                <div class="invalid-feedback" id="ClientDocType-error"></div>
            </div>

            <div class="mb-3">
                <label for="ClientDocumento" class="form-label">Número de Documento</label>
                <input type="text" class="form-control" id="ClientDocumento" name="ClientDocumento" required>
                <div class="invalid-feedback" id="ClientDocumento-error"></div>
            </div>

            <div class="mb-3">
                <label for="razon_social" class="form-label">Razón Social</label>
                <input type="text" class="form-control" id="razon_social" name="razon_social" required>
                <div class="invalid-feedback" id="razon_social-error"></div>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
                <div class="invalid-feedback" id="direccion-error"></div>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
                <div class="invalid-feedback" id="telefono-error"></div>
            </div>

            <div class="mb-3">
                <label for="FK_TipoComercio" class="form-label">Tipo de Comercio</label>
                <select class="form-control" id="FK_TipoComercio" name="FK_TipoComercio" required>
                    <option value="">Seleccione...</option>
                </select>
                <div class="description-tooltip" id="comercio-description"></div>
                <div class="invalid-feedback" id="FK_TipoComercio-error"></div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Siguiente</button>
        </form>

        <!-- Paso 2: Formulario de datos de acceso -->
        <form id="step2Form">
            <div class="mb-3">
                <label for="Email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
                <div class="invalid-feedback" id="Email-error"></div>
            </div>

            <div class="mb-3">
                <label for="Contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="Contraseña" name="Contraseña" required>
                <div class="invalid-feedback" id="Contraseña-error"></div>
            </div>

            <div class="mb-3">
                <label for="Contraseña_confirmation" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" id="Contraseña_confirmation" name="Contraseña_confirmation" required>
                <div class="invalid-feedback" id="Contraseña_confirmation-error"></div>
            </div>

            <button type="button" class="btn btn-secondary w-100 mb-2" onclick="showStep1()">Anterior</button>
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>

            <div class="text-center mt-3">
                <a href="<?php echo e(route('login')); ?>" class="text-decoration-none" style="color: #1565C0;">
                    ¿Ya tienes una cuenta? Inicia sesión
                </a>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Configurar CSRF token para las peticiones AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Cargar datos iniciales
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // Cargar tipos de documento
                const tiposDocResponse = await fetch('/api/auth/register/tipos-documento');
                const tiposDocResult = await tiposDocResponse.json();
                if (tiposDocResult.success) {
                    const docTypeSelect = document.getElementById('ClientDocType');
                    Object.entries(tiposDocResult.data).forEach(([value, label]) => {
                        const option = new Option(label, value);
                        docTypeSelect.add(option);
                    });
                }

                // Cargar tipos de comercio
                const tiposComResponse = await fetch('/api/auth/register/tipos-comercio');
                const tiposComResult = await tiposComResponse.json();
                if (tiposComResult.success) {
                    const tipoComSelect = document.getElementById('FK_TipoComercio');
                    tiposComResult.data.forEach(tipo => {
                        const option = new Option(tipo.label, tipo.value);
                        tipoComSelect.add(option);
                    });

                    // Agregar evento para mostrar descripción
                    tipoComSelect.addEventListener('change', () => {
                        const selectedTipo = tiposComResult.data.find(t => t.value == tipoComSelect.value);
                        const descriptionElement = document.getElementById('comercio-description');
                        descriptionElement.textContent = selectedTipo ? selectedTipo.description : '';
                    });
                }
            } catch (error) {
                console.error('Error cargando datos:', error);
                showErrors({'general': ['Error al cargar los datos. Por favor, recarga la página.']});
            }
        });

        // Manejar envío del paso 1
        document.getElementById('step1Form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            try {
                const response = await fetch('/api/auth/register/step1', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                // Verificar si la respuesta es JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('La respuesta del servidor no es JSON');
                }

                const result = await response.json();
                if (result.success) {
                    // Verificar que los datos se guardaron correctamente
                    if (result.session_data) {
                        console.log('Datos del paso 1 guardados:', result.session_data);
                        showStep2();
                    } else {
                        showErrors({'general': ['Error al guardar los datos del paso 1']});
                    }
                } else {
                    showErrors(result.errors || {'general': ['Error en el servidor']});
                }
            } catch (error) {
                console.error('Error:', error);
                showErrors({'general': ['Error de comunicación con el servidor. Por favor, intente nuevamente.']});
            }
        });

        // Manejar envío del paso 2
        document.getElementById('step2Form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            
            // Validar que las contraseñas coincidan en el frontend
            const password = formData.get('Contraseña');
            const confirmation = formData.get('Contraseña_confirmation');
            
            if (password !== confirmation) {
                showErrors({
                    'Contraseña': ['Las contraseñas no coinciden'],
                    'Contraseña_confirmation': ['Las contraseñas no coinciden']
                });
                return;
            }

            try {
                const response = await fetch('/api/auth/register/step2', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                });

                // Verificar si la respuesta es JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('La respuesta del servidor no es JSON');
                }

                const result = await response.json();
                if (result.success) {
                    window.location.href = '/dashboard';
                } else {
                    console.error('Error del servidor:', result);
                    
                    // Manejar diferentes tipos de errores
                    if (result.errors) {
                        if (typeof result.errors === 'object') {
                            if (result.errors.general && result.errors.general.includes('Debe completar el paso 1 primero')) {
                                showStep1();
                                showErrors({'general': ['Se perdieron los datos del paso 1. Por favor, complete el formulario nuevamente.']});
                            } else {
                                showErrors(result.errors);
                            }
                        } else {
                            showErrors({'general': ['Error en el servidor']});
                        }
                    } else {
                        showErrors({'general': ['Error desconocido en el servidor']});
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                if (error.message === 'La respuesta del servidor no es JSON') {
                    showErrors({'general': ['Error en el servidor. Por favor, intente nuevamente más tarde.']});
                } else {
                    showErrors({'general': ['Error de comunicación con el servidor. Por favor, intente nuevamente.']});
                }
            }
        });

        function showStep2() {
            document.getElementById('step1Form').style.display = 'none';
            document.getElementById('step2Form').style.display = 'block';
            document.getElementById('stepTitle').textContent = 'Paso 2: Datos de acceso';
        }

        function showStep1() {
            document.getElementById('step2Form').style.display = 'none';
            document.getElementById('step1Form').style.display = 'block';
            document.getElementById('stepTitle').textContent = 'Paso 1: Datos de la empresa';
        }

        function showErrors(errors) {
            // Limpiar errores anteriores
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));

            // Mostrar nuevos errores
            if (errors && typeof errors === 'object') {
                Object.entries(errors).forEach(([field, messages]) => {
                    const element = document.getElementById(field);
                    const feedback = document.getElementById(`${field}-error`);
                    if (element && feedback) {
                        element.classList.add('is-invalid');
                        feedback.textContent = Array.isArray(messages) ? messages[0] : messages;
                    } else if (field === 'general') {
                        // Mostrar error general
                        alert(Array.isArray(messages) ? messages[0] : messages);
                    }
                });
            } else {
                // Si errors no es un objeto, mostrar un error general
                alert('Error desconocido en el servidor');
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\prosarapp\resources\views/auth/register.blade.php ENDPATH**/ ?>