<div>
    <div class="container">
        {{-- Manejo de mensajes --}}
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

        <div class="mb-3">
            <label for="nombre_empresa">Nombre Empresa *</label>
            <input 
                type="text" 
                class="form-control"
                wire:model='nombre_empresa'
                id="nombre_empresa"
            >
        </div>
        <div class="mb-3">
            <label for="NIT_empresa">Nit Empresa *</label>
            <input 
                type="text" 
                class="form-control" 
                wire:model='NIT_empresa'
                id="NIT_empresa"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
            >
        </div>
        <div class="mb-3">
            <label for="direccion_empresa">Dirección Empresa *</label>
            <input 
                type="text" 
                class="form-control" 
                wire:model='direccion_empresa'
                id="direccion_empresa"
            >
        </div>
        <div class="mb-3">
            <label for="telefono_empresa">Teléfono Empresa *</label>
            <input 
                type="text" 
                class="form-control" 
                wire:model='telefono_empresa'
                id="telefono_empresa"
            >
        </div>
        <div class="mb-3">
            <label for="email_empresa">Email Empresa</label>
            <input 
                type="text" 
                class="form-control" 
                wire:model='email_empresa'
                id="email_empresa"
            >
        </div>
        <div class="mb-3">
            <label for="id_pais">Pais Empresa</label>
            <select 
                wire:model="id_pais" 
                id="id_pais" 
                class="form-control"
            >
                <option value="{{ config('id_pais') }}" selected>{{ config('pais_empresa') }}</option>

                @foreach (config('paises') as $pais)
                    <option value="{{ $pais->id_pais }}">{{ $pais->nombre_pais }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="id_departamento">Departamento Empresa</label>
            <select 
                wire:model="id_departamento" 
                id="id_departamento" 
                class="form-control"
            >
                <option value="{{ config('id_departamento') }}" selected>{{ config('departamento_empresa') }}</option>

                @foreach (config('departamentos') as $departamento)
                    <option value="{{ $departamento->id_departamento }}">{{ $departamento->nombre_departamento }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="id_municipio">Municipio Empresa</label>
            <select 
                wire:model="id_municipio" 
                id="id_municipio" 
                class="form-control"
            >
                <option value="{{ config('id_municipio') }}" selected>{{ config('municipio_empresa') }}</option>

                @foreach (config('municipios') as $municipio)
                    <option value="{{ $municipio->id_municipio }}">{{ $estado->nombre_municipio }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="id_municipio">Estado Empresa</label>
            <select 
                wire:model="id_estado" 
                id="id_estado" 
                class="form-control"
            >
                <option value="{{ config('id_estado') }}" selected>{{ config('estado_empresa') }}</option>

                @foreach (config('estados') as $estado)
                    <option value="{{ $estado->id_estado }}">{{ $estado->nombre_estado }}</option>
                @endforeach
            </select>
        </div>
        <button 
            type="submit" 
            class="btn btn-success"
            wire:click='guardarEmpresa'
        >
            Guardar cambios
        </button>
    </div>
</div>
