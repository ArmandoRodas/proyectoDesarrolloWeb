<?php

namespace App\Livewire\Usuario;

use App\Models\Caja;
use App\Models\Estado;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $id_usuario;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $id_rol;
    public $id_caja;
    public $id_estado;

    public $search = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:75',
            'email' => 'required|email|max:75|unique:tbl_usuario,email,' . $this->id_usuario . ',id_usuario',
            'id_rol' => 'nullable|integer',
            'id_caja' => 'nullable|integer',
            'id_estado' => 'required|integer',
        ];

        if (!$this->id_usuario) {
            // Si no se esta editando, valida la contraseña
            $rules['password'] = 'required|min:6';
            $rules['password_confirmation'] = 'required|same:password';
        }

        return $rules;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function guardarUsuario()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'id_rol' => $this->id_rol,
                'id_caja' => $this->id_caja,
                'id_estado' => $this->id_estado,
            ];

            // Se va agregar la contraseña si se esta creando un nuevo usuario
            if (!$this->id_usuario) {
                $data['password'] = Hash::make($this->password);
            }

            Usuario::updateOrCreate(
                ['id_usuario' => $this->id_usuario],
                $data
            );

            session()->flash('success', 'Usuario actualizado correctamente.');

            DB::commit();

            // Reiniciar los campos
            $this->resetInput();
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', $th->getMessage());
        }
    }
    
    public function editarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);

        // Pasamos los valores a los inputs
        $this->id_usuario = $usuario->id_usuario;
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->id_rol = $usuario->id_rol;
        $this->id_caja = $usuario->id_caja;
        $this->id_estado = $usuario->id_estado;
    }

    public function resetInput()
    {
        $this->reset([
            'id_usuario',
            'name',
            'email',
            'password',
            'password_confirmation',
            'id_rol',
            'id_caja',
            'id_estado'
        ]);
    }

    public function render()
    {
        $usuarios = Usuario::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })->paginate(10);

        $cajas = Caja::all();
        $roles = Rol::all();
        $estados = Estado::whereIn('id_estado', [1, 2])->get();

        return view('livewire.usuario.index', [
            'usuarios' => $usuarios,
            'cajas' => $cajas,
            'roles' => $roles,
            'estados' => $estados
        ]);
    }
}
