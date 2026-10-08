<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_students_but_not_other_admins(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $student = User::factory()->create(['name' => 'Student User', 'is_admin' => false]);
        $otherAdmin = User::factory()->create(['name' => 'Other Admin', 'is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('students.index'));

        $response->assertOk();
        $response->assertSee('Student User');
        $response->assertDontSee('Other Admin');
    }

    public function test_student_cannot_view_the_student_list(): void
    {
        $student = User::factory()->create(['is_admin' => false]);

        $this->actingAs($student)
            ->get(route('students.index'))
            ->assertForbidden();
    }
}