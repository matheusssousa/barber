<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilEPermissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Redefinir funções e permissões em cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // CRIANDO CARGOS DE ADMINISTRADOR E USUÁRIO
        $administrador = DB::table('roles')->insertGetid([
            'name' => 'Administrador',
            'guard_name' => 'admins',
            'description' => 'Acesso completo ao sistema',
        ]);
        $user = DB::table('roles')->insertGetId([
            'name' => 'Usuário',
            'guard_name' => 'api',
            'description' => 'Acesso de usuário comum ao sistema',
        ]);

        
        // TODAS AS PERMISSÕES PARA O SISTEMA
        $permissoes = collect([
            // CORTE
            ['guard_name' => 'admins', 'name' => 'Listar corte', 'category' => 'corte', 'description' => 'Permite visualizar os cortes.'],
            ['guard_name' => 'admins', 'name' => 'Cadastrar corte', 'category' => 'corte', 'description' => 'Permite cadastrar novos cortes.'],
            ['guard_name' => 'admins', 'name' => 'Visualizar corte', 'category' => 'corte', 'description' => 'Permite visualizar um corte.'],
            ['guard_name' => 'admins', 'name' => 'Editar corte', 'category' => 'corte', 'description' => 'Permite editar um corte.'],
            ['guard_name' => 'admins', 'name' => 'Desativar corte', 'category' => 'corte', 'description' => 'Permite desativar um corte.'],
            ['guard_name' => 'admins', 'name' => 'Restaurar corte', 'category' => 'corte', 'description' => 'Permite restaurar um corte desativado.'],
            ['guard_name' => 'admins', 'name' => 'Excluir corte', 'category' => 'corte', 'description' => 'Permite excluir permanentemente um corte.'],

            // SERVICO
            ['guard_name' => 'admins', 'name' => 'Listar servico', 'category' => 'servico', 'description' => 'Permite visualizar os servicos.'],
            ['guard_name' => 'admins', 'name' => 'Cadastrar servico', 'category' => 'servico', 'description' => 'Permite cadastrar novos servicos.'],
            ['guard_name' => 'admins', 'name' => 'Visualizar servico', 'category' => 'servico', 'description' => 'Permite visualizar um servico.'],
            ['guard_name' => 'admins', 'name' => 'Editar servico', 'category' => 'servico', 'description' => 'Permite editar um servico.'],
            ['guard_name' => 'admins', 'name' => 'Desativar servico', 'category' => 'servico', 'description' => 'Permite desativar um servico.'],
            ['guard_name' => 'admins', 'name' => 'Restaurar servico', 'category' => 'servico', 'description' => 'Permite restaurar um servico desativado.'],
            ['guard_name' => 'admins', 'name' => 'Excluir servico', 'category' => 'servico', 'description' => 'Permite excluir permanentemente um servico.'],

            // PACOTE
            ['guard_name' => 'admins', 'name' => 'Listar pacote', 'category' => 'pacote', 'description' => 'Permite visualizar os pacotes.'],
            ['guard_name' => 'admins', 'name' => 'Cadastrar pacote', 'category' => 'pacote', 'description' => 'Permite cadastrar novos pacotes.'],
            ['guard_name' => 'admins', 'name' => 'Visualizar pacote', 'category' => 'pacote', 'description' => 'Permite visualizar um pacote.'],
            ['guard_name' => 'admins', 'name' => 'Editar pacote', 'category' => 'pacote', 'description' => 'Permite editar um pacote.'],
            ['guard_name' => 'admins', 'name' => 'Desativar pacote', 'category' => 'pacote', 'description' => 'Permite desativar um pacote.'],
            ['guard_name' => 'admins', 'name' => 'Restaurar pacote', 'category' => 'pacote', 'description' => 'Permite restaurar um pacote desativado.'],
            ['guard_name' => 'admins', 'name' => 'Excluir pacote', 'category' => 'pacote', 'description' => 'Permite excluir permanentemente um pacote.'],
        ]);
        $permissoes_usuarios = collect([
            // CORTE
            ['guard_name' => 'api', 'name' => 'Listar corte', 'category' => 'corte', 'description' => 'Permite visualizar os cortes.'],

            // SERVICO
            ['guard_name' => 'api', 'name' => 'Listar servico', 'category' => 'servico', 'description' => 'Permite visualizar os servicos.'],

            // PACOTE
            ['guard_name' => 'api', 'name' => 'Listar pacote', 'category' => 'pacote', 'description' => 'Permite visualizar os pacotes.'],
        ]);


        // HABILITANDO AS PERMISSOES PARA O ADMINISTRADOR
        $permissoes->each(function ($item) {
            DB::table('permissions')->insert($item);
        });

        $permissions = DB::table('permissions')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $administrador,
                'permission_id' => $permission->id,
            ]);
        }

        //HABILITANDO AS PERMISSOES PARA OS USUÁRIOS COMUNS
        $permissoes_usuarios->each(function ($item) {
            DB::table('permissions')->insert($item);
        });

        $permissions = DB::table('permissions')->get();

        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $user,
                'permission_id' => $permission->id,
            ]);
        }

    }
}
