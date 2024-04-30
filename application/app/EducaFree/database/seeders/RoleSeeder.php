<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_editor = Role::create(['name' => 'editor']);
        $role_collaborator = Role::create(['name' => 'collaborator']);

        // Asignar permisos a los roles
        $permission_create_role = Permission::create(['name' => 'create roles']);
        $permission_read_role = Permission::create(['name' => 'read roles']);
        $permission_update_role = Permission::create(['name' => 'update roles']);
        $permission_delete_role = Permission::create( [ 'name' => 'delete roles']);

        // Asignar permisos a las lessons
        $permission_create_lesson = Permission::create(['name' => 'create lesson']);
        $permission_read_lesson = Permission::create(['name' => 'read lesson']);
        $permission_update_lesson = Permission::create(['name' => 'update lesson']);
        $permission_delete_lesson = Permission::create( [ 'name' => 'delete lesson']);

        // Asignar permisos a las categories
        $permission_create_course = Permission::create(['name' => 'create course']);
        $permission_read_course  = Permission::create(['name' => 'read course']);
        $permission_update_course  = Permission::create(['name' => 'update course']);
        $permission_delete_course  = Permission::create( [ 'name' => 'delete course']);

        // Permisos admin
        $permission_admin = [$permission_create_role, $permission_read_role, $permission_update_role, $permission_delete_role
                            , $permission_create_lesson, $permission_read_lesson, $permission_update_lesson, $permission_delete_lesson
                            , $permission_create_course, $permission_read_course, $permission_update_course, $permission_delete_course];

        $permission_editor = [$permission_create_lesson, $permission_read_lesson, $permission_update_lesson, $permission_delete_lesson
                            , $permission_create_course, $permission_read_course, $permission_update_course, $permission_delete_course];

        $permission_collaborator = [ $permission_create_lesson, $permission_read_lesson, $permission_update_lesson, $permission_delete_lesson];

        $role_admin->syncPermissions($permission_admin);
        $role_editor->syncPermissions($permission_editor);
        $role_collaborator->syncPermissions($permission_collaborator);
    }
}
