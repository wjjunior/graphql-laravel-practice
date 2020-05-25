<?php

namespace App\GraphQL\Mutations;

use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use JWTAuth;

class RegisterUser
{
    /**
     * Return a value for the field.
     *
     * @param null $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[] $args The arguments that were passed into the field.
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context Arbitrary data that is shared between all fields of a single query.
     * @param \GraphQL\Type\Definition\ResolveInfo $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $userExist = User::where(["email" => $args["input"]["email"]])->get();
        if (count($userExist)) {
            return new \Exception("User exists");
        }

        $user = new User;
        $user->email = $args["input"]["email"];
        $user->name = "joe";
        $user->password = Hash::make($args["input"]["password"]);
        $user->save();
        $auth_token = JWTAuth::fromUser($user);

        return compact('auth_token', 'user');
    }
}
