<?php

use App\Portal\Helpers\Acl;
use App\Portal\Helpers\Faker;
use App\Portal\Models\Role;
use App\Portal\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userList = [
            "Adriana C. Ocampo Uria",
            "Albert Einstein",
            "Anna K. Behrensmeyer",
            "Blaise Pascal",
            "Caroline Herschel",
            "Cecilia Payne-Gaposchkin",
            "Chien-Shiung Wu",
            "Dorothy Hodgkin",
            "Edmond Halley",
            "Edwin Powell Hubble",
            "Elizabeth Blackburn",
            "Enrico Fermi",
            "Erwin Schroedinger",
            "Flossie Wong-Staal",
            "Frieda Robscheit-Robbins",
            "Geraldine Seydoux",
            "Gertrude B. Elion",
            "Ingrid Daubechies",
            "Jacqueline K. Barton",
            "Jane Goodall",
            "Jocelyn Bell Burnell",
            "Johannes Kepler",
            "Lene Vestergaard Hau",
            "Lise Meitner",
            "Lord Kelvin",
            "Maria Mitchell",
            "Marie Curie",
            "Max Born",
            "Max Planck",
            "Melissa Franklin",
            "Michael Faraday",
            "Mildred S. Dresselhaus",
            "Nicolaus Copernicus",
            "Niels Bohr",
            "Patricia S. Goldman-Rakic",
            "Patty Jo Watson",
            "Polly Matzinger",
            "Richard Phillips Feynman",
            "Rita Levi-Montalcini",
            "Rosalind Franklin",
            "Ruzena Bajcsy",
            "Sarah Boysen",
            "Shannon W. Lucid",
            "Shirley Ann Jackson",
            "Sir Ernest Rutherford",
            "Sir Isaac Newton",
            "Stephen Hawking",
            "Werner Karl Heisenberg",
            "Wilhelm Conrad Roentgen",
            "Wolfgang Ernst Pauli",
        ];

        foreach ($userList as $fullName) {
            $name = str_replace(' ', '.', $fullName);
            $roleName = Faker::randomInArray([
                Acl::ROLE_ADMIN,
                Acl::ROLE_MANAGER,
                Acl::ROLE_MASTER,
            ]);
            $user = User::create([
                'first_name' => explode(' ', $fullName)[0],
                'last_name' => explode(' ', $fullName)[1],
                'date_of_birth' => Faker::randomInArray([
                    '1985-07-05',
                    '1973-02-03',
                    '1990-09-30',
                ]),
                'about' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio doloremque dolorum eligendi quod
                  suscipit. Ab accusamus asperiores autem hic iusto magni nihil non pariatur perspiciatis possimus
                  praesentium qui, suscipit, velit!',
                'email' => strtolower($name) . '@gmail.com',
                'password' => Hash::make('123456'),
            ]);

            $role = Role::findByName($roleName);
            $user->syncRoles($role);
        }
    }
}
