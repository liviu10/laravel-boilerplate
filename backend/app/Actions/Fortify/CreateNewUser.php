<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use NameValidationRules, EmailValidationRules, PasswordValidationRules;

    protected User $modelName;

    public function __construct()
    {
        $this->modelName = new User();
    }

    /**
     * Create a newly registered user.
     *
     * @param array<string, string> $input
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'first_name' => $this->nameRules(),
            'last_name' => $this->nameRules(),
            'email' => $this->emailRules(),
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap($this->modelName->createRecord([
                'full_name' => $this->getFullName($input),
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'nickname' => null,
                'email' => $input['email'],
                'phone' => null,
                'password' => Hash::make($input['password']),
                'profile_image' => $this->getProfileImageUrl($input),
            ]), function (User $user) {
                $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => "Team" . ' ' . $user->full_name,
            'personal_team' => true,
        ]));
    }

    /**
     * Handle the full name based on request
     *
     * @param array $input
     * @return string
     */
    protected function getFullName(array $input): string
    {
        return $input['first_name'] . ' ' . $input['last_name'];
    }

    /**
     * Handle the gravatar profile image based on request
     *
     * @param array $input
     * @return string
     */
    protected function getProfileImageUrl(array $input): string
    {
        $fullName = $input['first_name'] . ' ' . $input['last_name'];
        return vsprintf('https://www.gravatar.com/avatar/%s.jpg?s=200&d=%s', [
            md5(strtolower($input['email'])),
            $fullName ? urlencode('https://ui-avatars.com/api/' . $fullName) : 'mp'
        ]);
    }
}
