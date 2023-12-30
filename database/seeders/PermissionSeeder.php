<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $modulePermissions = array(

            'system-configuration' => array(),
            'system-configuration-permissions' => array(
                array(
                    'label' => 'Create Role',
                    'route' => 'api/settings/permissions/createRole'
                ),
                array(
                    'label' => 'Update Role',
                    'route' => 'api/settings/permissions/updateRole/{roleId}'
                ),
                array(
                    'label' => 'Save Role Resources',
                    'route' => 'api/settings/permissions/saveRoleResources'
                ),
            ),

            'system-configuration-user-management' => array(
                array(
                    'label' => 'Create User',
                    'route' => 'api/users/create-user'
                ),
                array(
                    'label' => 'Update User',
                    'route' => 'api/users/update/{id}'
                ),
                array(
                    'label' => 'View User',
                    'route' => 'api/users/view/{id}'
                ),
            ), 

            //pending till after role access is done
            'system-configuration-settings' => array(),

            'system-configuration-settings-document-type' => array(
                array(
                    'label' => 'Create Document Type',
                    'route' => 'api/settings/document-type/create'
                ),
                array(
                    'label' => 'Update Document Type',
                    'route' => 'api/settings/document-type/update/{id}'
                ),
                array(
                    'label' => 'Delete Document Type',
                    'route' => 'api/settings/document-type/delete/{id}'
                )
            ),

            'system-configuration-settings-ranks' => array(
                array(
                    'label' => 'Create ranks',
                    'route' => 'api/settings/ranks/create'
                ),
                array(
                    'label' => 'Update ranks',
                    'route' => 'api/settings/ranks/update/{id}'
                ),
                array(
                    'label' => 'Delete ranks',
                    'route' => 'api/settings/ranks/delete/{id}'
                ),
            ),

            'system-configuration-settings-document-class' => array(
                array(
                    'label' => 'Create Document Class',
                    'route' => 'api/settings/document-class/create'
                ),
                array(
                    'label' => 'Update Document Class',
                    'route' => 'api/settings/document-class/update/{id}'
                ),
                array(
                    'label' => 'Delete Document Class',
                    'route' => 'api/settings/document/delete/{id}'
                ),
            ),


            'system-configuration-settings-document-type' => array(
                array(
                    'label' => 'Create Document Type',
                    'route' => 'api/settings/document-type/create'
                ),
                array(
                    'label' => 'Update Document Type',
                    'route' => 'api/settings/document-type/update/{id}'
                ),
                array(
                    'label' => 'Delete Document Type',
                    'route' => 'api/settings/document-type/delete/{id}'
                ),
            ),

            'system-configuration-settings-branch' => array(
                array(
                    'label' => 'Create Branch',
                    'route' => 'api/settings/branch/create'
                ),
                array(
                    'label' => 'Update Branch',
                    'route' => 'api/settings/branch/update/{id}'
                ),
                array(
                    'label' => 'Delete Branch',
                    'route' => 'api/settings/branch/delete/{id}'
                )
            ),


            'Task Management' => array(),
            'task-management' => array(
                array(
                    'label' => 'View All Tasks',
                    'route' => 'api/tasks/viewAll'
                ),
                array(
                    'label' => 'View Task',
                    'route' => 'api/tasks/view/{id}'
                ),
                array(
                    'label' => 'Create Task',
                    'route' => 'api/tasks/create/'
                ),
                array(
                    'label' => 'Search Tasks',
                    'route' => 'api/tasks/search'
                ),
                array(
                    'label' => 'Update Task',
                    'route' => 'api/tasks/update/{user:username}'
                ),
                array(
                    'label' => 'Delete Task',
                    'route' => 'api/tasks/delete/{user:username}'
                )
            ),

            'Document Management' => array(),
            'document-management' => array(
                array(
                    'label' => 'View All Documents',
                    'route' => 'api/documents/viewAll'
                ),
                array(
                    'label' => 'View Document',
                    'route' => 'api/documents/view/{id}'
                ),
                array(
                    'label' => 'Create Document',
                    'route' => 'api/documents/create/'
                ),
                array(
                    'label' => 'Search Documents',
                    'route' => 'api/documents/search'
                ),
                array(
                    'label' => 'Update Document',
                    'route' => 'api/documents/update/{user:username}'
                ),
                array(
                    'label' => 'Delete Document',
                    'route' => 'api/documents/delete/{user:username}'
                )
            ),






        );
    }
}
