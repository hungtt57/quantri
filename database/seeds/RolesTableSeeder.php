<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission_Role;
use App\Permission;
use App\Role_User;
use App\User;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Default'
        ]);

        DB::table('roles')->insert([
            'name' => 'Admin'
        ]);
       
        $permission = new Permission;
        $permission->name = 'RoleController';
        $permission->label= 'Quản lý quyền';
        $permission->save();

        $new = new Permission;
        $new->name = 'RoleController.index';
        $new->label = 'Danh sách';
        $new->parent_id = $permission->id;
        $new->save();

        $new1 = new Permission;
        $new1->name = 'RoleController.synchronous';
        $new1->label = 'Đồng bộ quyền';
        $new1->parent_id = $permission->id;
        $new1->save();

        $permission_role = new Permission_Role;
        $permission_role->role_id = Role::where('name','=','Admin')->first()->id;
        $permission_role->permission_id = Permission::where('name','=','RoleController.index')->first()->id;
        $permission_role->save();

        $user_role = new Role_User;
        $user_role->role_id = Role::where('name','=','Admin')->first()->id;
        $user_role->user_id = User::where('name','=','Admin')->first()->id;
        $user_role->save();

        $permission_role = new Permission_Role;
        $permission_role->role_id = Role::where('name','=','Admin')->first()->id;
        $permission_role->permission_id = Permission::where('name','=','RoleController.synchronous')->first()->id;
        $permission_role->save();
    }
}
