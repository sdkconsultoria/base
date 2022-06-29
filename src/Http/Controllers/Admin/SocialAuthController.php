<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Sdkconsultoria\Base\Models\Auth\UserSocial;

class SocialAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web']);
    }

    protected function save(string $id, string $type)
    {
        $userSocial = new UserSocial();
        $userSocial->social_id = $id;
        $userSocial->social_type = $type;
        $userSocial->created_by = Auth::user()->id;
        $userSocial->save();

        return $userSocial;
    }

    public function login($type)
    {
        $providers = array_keys(config('base.hybridauth'));

        if (in_array($type, $providers)) {
            $class = '\Hybridauth\Provider\\'.ucfirst($type);
            $adapter = new $class(config('base.hybridauth.'.$type));
            $adapter->authenticate();
            $userProfile = $adapter->getUserProfile();

            if ($userProfile) {
                $userSocial = UserSocial::where('social_id', $userProfile->identifier)->where('social_type', $type)->first();

                if (Auth::guest()) {
                    if ($userSocial) {
                        Auth::login($userSocial->createdBy);
                    } else {
                        $user = new User();
                        $user->name = $userProfile->displayName;
                        $user->lastname = $userProfile->firstName;
                        $user->lastname_2 = $userProfile->lastName;
                        $user->email = $userProfile->email;
                        $user->status = User::STATUS_ACTIVE;
                        $user->password = Hash::make(Str::random(15));
                        $user->save();
                        $user->assignRole(['client']);
                        Auth::login($user);
                        $this->save($userProfile->identifier, $type);
                    }
                } else {
                    $user = Auth::user();
                    if (! $userSocial) {
                        $this->save($userProfile->identifier, $type);
                    }
                }

                $adapter->disconnect();

                return redirect()->route('dashboard');
            }
        }

        throw new \Exception('Provider '.$type.' is not supported', 1);
    }
}
