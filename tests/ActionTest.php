<?php

namespace Tests;

use Action\Action;
use Tests\Model\Role;
use Tests\Model\User;
use Tests\Model\Permission;
use Tests\Model\AnotherUser;
use PHPUnit\Framework\TestCase;
use Tests\Actions\GetUserAction;
use Tests\Actions\GetUserProfilesAction;
use Tests\Actions\CreateFamilyImageAction;
use Tests\Actions\SyncAssociationMemberAction;

class ActionTest extends TestCase
{
    /** @test */
    public function can_perform_helper_invoking_action()
    {
        $perform = perform(new GetUserAction(new User));
        $this->assertEmpty([], $perform);
    }

    /** @test */
    public function can_invoking_action()
    {
        $perform = perform(new Action(new User));
        $this->assertEmpty([], $perform);
    }

    /** @test */
    public function spit_a_pascal_case()
    {

        $action1 = (new GetUserProfilesAction(new User));
        $action2 = (new SyncAssociationMemberAction(new User));
        $action3 = (new CreateFamilyImageAction(new User));
        $case1   = $action1->guessModelName();
        $case2   = $action2->guessModelName();
        $case3   = $action3->guessModelName();
        $this->assertEquals("Tests\Model\UserProfiles", $case1);
        $this->assertEquals("Tests\Model\AssociationMember", $case2);
        $this->assertEquals("Tests\Model\FamilyImage", $case3);
    }

    /** @test */
    public function peform_string_class_action()
    {
        $users = perform((new GetUserAction(User::class))->additional(
            [
                "role"       => Role::class,
                "permission" => new Permission,
            ]
        ));

        $this->assertInstanceOf(User::class, $users->action);
        $this->assertArrayHasKey('role', $users->additional);
        $this->assertArrayHasKey('permission', $users->additional);

        $userTest = perform(GetUserAction::class, AnotherUser::class, [
            "role"       => Role::class,
            "permission" => new Permission,
        ]);

        $this->assertInstanceOf(AnotherUser::class, $userTest->action);
        $this->assertArrayHasKey('role', $userTest->additional);
        $this->assertArrayHasKey('permission', $userTest->additional);
    }
}
