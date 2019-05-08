<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\User;
use App\Category;
use App\Match;
use App\Teams;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'arbitro']);
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'informador']);

        $user = User::create([
            'arb_cod' => '001',
            'name' => 'arbitro',
            'surname' => 'arbitro',
            'email' => 'arb@arb.com',
            'password' => Hash::make('123'),
        ]);

        $user->assignRole('arbitro');
        

        $user1 = User::create([
            'arb_cod' => '002',
            'name' => 'informador',
            'surname' => 'informador',
            'email' => 'info@info.com',
            'password' => Hash::make('123'),
        ]);

        $user1->assignRole('informador');

        $user2 = User::create([
            'arb_cod' => '003',
            'name' => 'director',
            'surname' => 'director',
            'email' => 'dire@dire.com',
            'password' => Hash::make('123'),
        ]);

        $user2->assignRole('admin');

        $category = Category::create([ 'category' => 'prebenjamin' ]);
        $category = Category::create([ 'category' => 'benjamin' ]);
        $category = Category::create([ 'category' => 'premini' ]);
        $category = Category::create([ 'category' => 'mini' ]);
        $category = Category::create([ 'category' => 'preinfantil' ]);
        $category = Category::create([ 'category' => 'infantil' ]);
        $category = Category::create([ 'category' => 'precadete' ]);
        $category = Category::create([ 'category' => 'cadete' ]);
        $category = Category::create([ 'category' => 'junior' ]);
        $category = Category::create([ 'category' => 'sub-22' ]);
        $category = Category::create([ 'category' => 'senior' ]);

        $team = Teams::create(['name' => 'Spar Gran Canaria']);
        $category = Category::where('category','benjamin')->first();
        $team->categories()->attach($category->id);
        $category = Category::where('category','mini')->first();
        $team->categories()->attach($category->id);

        $team = Teams::create(['name' => 'Telde Basket Tara']);
        $category = Category::where('category','cadete')->first();
        $team->categories()->attach($category->id);
        $category = Category::where('category','mini')->first();
        $team->categories()->attach($category->id);

        $team = Teams::create(['name' => 'Gran Canaria Claret']);
        $category = Category::where('category','cadete')->first();
        $team->categories()->attach($category->id);
        $category = Category::where('category','benjamin')->first();
        $team->categories()->attach($category->id);

        $team = Teams::create(['name' => 'Santa Lucía Basket']);
        $team = Teams::create(['name' => 'Canterbury Academy']);
        $team = Teams::create(['name' => 'Tirma BSB']);
        $team = Teams::create(['name' => 'CB Valsequillo']);
        $team = Teams::create(['name' => 'Evecan']);
        $team = Teams::create(['name' => 'Baloncesto Loyola']);
        $team = Teams::create(['name' => 'CB Las Palmas 02']);
        
    }
}
