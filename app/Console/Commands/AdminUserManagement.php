<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserManagement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:usermanage 
                            {operation : The CRUD operation (create, read, update, delete)} 
                            {--id= : The ID of the user (required for read, update, delete)} 
                            {--name= : The name of the user (required for create, update)} 
                            {--email= : The email of the user (required for create, update)} 
                            {--password= : The password of the user (required for create, update)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin can perform CRUD operations on users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $operation = $this->argument('operation');
        $id = $this->option('id');
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');

        switch ($operation) {
            case 'create':
                $this->createUser($name, $email, $password);
                break;
            case 'read':
                $this->readUser($id);
                break;
            case 'update':
                $this->updateUser($id, $name, $email, $password);
                break;
            case 'delete':
                $this->deleteUser($id);
                break;
            default:
                $this->error('Invalid operation. Please use create, read, update, or delete.');
                return 1;
        }

        return 0;
    }

    protected function createUser($name, $email, $password)
    {
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        if ($user) {
            $this->info('User created successfully.');
        } else {
            $this->error('Failed to create user.');
            return 1;
        }
    }

    protected function readUser($id)
    {
        if (!$id) {
            $this->error('User ID is required for reading a user.');
            return 1;
        }

        $user = User::find($id);

        if ($user) {
            $this->info("User ID: $user->id");
            $this->info("Name: $user->name");
            $this->info("Email: $user->email");
        } else {
            $this->error('User not found.');
            return 1;
        }
    }

    protected function updateUser($id, $name, $email, $password)
    {
        if (!$id) {
            $this->error('User ID is required for updating a user.');
            return 1;
        }

        $user = User::find($id);

        if (!$user) {
            $this->error('User not found.');
            return 1;
        }

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $user->update([
            'name' => $name ?? $user->name,
            'email' => $email ?? $user->email,
            'password' => $password ? Hash::make($password) : $user->password,
        ]);

        $this->info('User updated successfully.');
    }

    protected function deleteUser($id)
    {
        if (!$id) {
            $this->error('User ID is required for deleting a user.');
            return 1;
        }

        $user = User::find($id);

        if ($user) {
            $user->delete();
            $this->info('User deleted successfully.');
        } else {
            $this->error('User not found.');
            return 1;
        }
    }
}
