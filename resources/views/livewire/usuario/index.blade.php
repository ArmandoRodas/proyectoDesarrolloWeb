<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
        Usuarios
    </button>

    @if (session('error'))
        <div class="alert alert-danger mt-3" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Modal -->
    <div 
        class="modal fade" 
        id="staticBackdrop" 
        data-backdrop="static" 
        data-keyboard="false" 
        tabindex="-1" 
        aria-labelledby="staticBackdropLabel" 
        aria-hidden="true" 
        wire:ignore.self
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ $id_usuario ? 'Editar Usuario' : 'Crear Usuario' }}
                    </h5>
                    <button 
                        type="button" 
                        class="close" 
                        data-dismiss="modal" 
                        aria-label="Close"
                        wire:click='resetInput'
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="name">Nombre de usuario *</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            wire:model='name'
                            id="name"
                        >
                    </div>
                    <div>
                        <label for="email">Email *</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            wire:model='email'
                            id="email"
                        >
                    </div>
                    @if (!$id_usuario )
                        <div>
                            <label for="password">Contraseña *</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                wire:model='password'
                                id="password"
                            >
                        </div>
                        <div>
                            <label for="password_confirmation">Repetir Contraseña *</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                wire:model='password_confirmation'
                                id="password_confirmation"
                            >
                        </div>
                    @endif
                    <div>
                        <label for="id_rol">Rol</label>
                        <select 
                            class="form-control"
                            wire:model="id_rol" 
                            id="id_rol"
                        >
                            <option value="">--Seleccione--</option>
                            @foreach ($roles as $rol)
                                <option 
                                    value="{{ $rol->id_rol }}"
                                >
                                    {{ $rol->nombre_rol}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="id_caja">Caja  default</label>
                        <select 
                            class="form-control"
                            wire:model="id_caja" 
                            id="id_caja"
                        >
                            <option value="">--Seleccione--</option>
                            @foreach ($cajas as $caja)
                                <option 
                                    value="{{ $caja->id_caja }}"
                                >
                                    {{ $caja->nombre_caja}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="id_estado">Estado *</label>
                        <select 
                            class="form-control"
                            wire:model="id_estado" 
                            id="id_estado"
                        >
                            <option value="">--Seleccione--</option>
                            @foreach ($estados as $estado)
                                <option 
                                    value="{{ $estado->id_estado }}"
                                >
                                    {{ $estado->nombre_estado   }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button 
                            type="button" 
                            class="btn btn-danger" 
                            data-dismiss="modal"
                            wire:click='resetInput'
                        >
                            Cerrar
                        </button>
                        <button 
                            type="submit" 
                            class="btn btn-success" 
                            data-dismiss="modal"
                            wire:click='guardarUsuario'
                        >
                            {{ $id_usuario ? 'Actualizar Usuario' : 'Crear Usuario' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <input class="form-control mb-3" wire:model.live="search" placeholder="Buscar aperturas de cajas">
        
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td>Nombre usuarios</td>
                    <td>Email</td>
                    <td>Rol</td>
                    <td>Caja default</td>
                    <td>Estado</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->rol->nombre_rol ?? null }}</td>
                        <td>{{ $usuario->caja->nombre_caja ?? null }}</td>
                        <td>{{ $usuario->estado->nombre_estado ?? null }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" wire:click.prevent="editarUsuario({{ $usuario->id_usuario }})" data-toggle="modal" data-target="#staticBackdrop">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Sin resultados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>