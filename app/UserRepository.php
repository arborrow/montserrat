<?php

namespace App;

class UserRepository
{
    public function findByUserNameOrCreate($userData)
    {
        if (isset($userData->user['hd'])) {
            if (! $userData->user['hd'] == 'montserratretreat.org') {
                redirect('/restricted');
            }
        } else {
            redirect('/restricted');
        }
        $user = User::where('provider_id', '=', $userData->id)->first();
        if (! $user) {
            $user = User::create([
                'provider' => 'google',
                'provider_id' => $userData->id,
                'name' => $userData->name,
                'username' => $userData->nickname,
                'email' => $userData->email,
                'avatar' => $userData->avatar,
                'active' => 1,
            ]);
        }

        $this->checkIfUserNeedsUpdating($userData, $user);

        return $user;
    }

    public function checkIfUserNeedsUpdating($userData, $user)
    {
        $socialData = [
            'avatar' => $userData->avatar,
            'email' => $userData->email,
            'name' => $userData->name,
            'username' => $userData->nickname,
        ];
        $dbData = [
            'avatar' => $user->avatar,
            'email' => $user->email,
            'name' => $user->name,
            'username' => $user->username,
        ];

        if (! empty(array_diff($socialData, $dbData))) {
            $user->avatar = $userData->avatar;
            $user->email = $userData->email;
            $user->name = $userData->name;
            $user->username = $userData->nickname;
            $user->save();
        }
    }
}
