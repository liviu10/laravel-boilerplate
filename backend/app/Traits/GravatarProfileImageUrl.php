<?php

namespace App\Traits;

trait GravatarProfileImageUrl
{
    public function getProfileImageUrl(string $email, string $firstName, string $lastName): string
    {
        $fullName = $firstName . ' ' . $lastName;
        $gravatarProfileImageUrl = vsprintf('https://www.gravatar.com/avatar/%s.jpg?s=200&d=%s', [
            md5(strtolower($email)),
            $fullName ? urlencode('https://ui-avatars.com/api/' . $fullName) : 'mp'
        ]);

        return $gravatarProfileImageUrl;
    }
}
