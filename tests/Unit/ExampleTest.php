<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase; // Remove this line
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;
use App\Http\Controllers\EspaceVertController;
use App\Models\EspaceVert;
use Illuminate\Support\Facades\Session;
use Mockery;
use Mockery\MockInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExampleTest extends TestCase
{
    // Remove use RefreshDatabase;

    private EspaceVertController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new EspaceVertController();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_store_creates_espace_vert_successfully(): void
    {
        $data = [
            'nom' => 'Test Park',
            'adresse' => '123 Test St',
            'superficie' => 100.5,
            'type' => 'parc',
            'etat' => 'bon',
            'besoin_specifique' => 'None',
        ];

        $request = Request::create('/store', 'POST', $data);

        $modelMock = Mockery::mock(EspaceVert::class)->makePartial();
        $overloadMock = Mockery::mock('overload:' . EspaceVert::class);
        $overloadMock->shouldReceive('create')->once()->with($data)->andReturn($modelMock);

        Session::shouldReceive('flash')->once()->with('success', 'Espace Vert créé avec succès !');

        $response = $this->controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('espace.create', $response->getTargetUrl()); // Avoid route() if issues
    }

    public function test_store_throws_validation_exception_on_invalid_data(): void
    {
        $invalidData = [
            'nom' => 'Ab', // Too short
            'adresse' => '123', // Too short
            'superficie' => 'invalid',
            'type' => 'invalid',
            'etat' => 'invalid',
        ];

        $request = Request::create('/store', 'POST', $invalidData);

        $this->expectException(ValidationException::class);
        $this->controller->store($request);
    }

    public function test_store_handles_creation_exception(): void
    {
        $data = [
            'nom' => 'Test Park',
            'adresse' => '123 Test St',
            'superficie' => 100.5,
            'type' => 'parc',
            'etat' => 'bon',
        ];

        $request = Request::create('/store', 'POST', $data);

        $overloadMock = Mockery::mock('overload:' . EspaceVert::class);
        $overloadMock->shouldReceive('create')->once()->andThrow(new \Exception('DB Error'));

        Session::shouldReceive('flash')->once()->with('error', Mockery::pattern('/Échec de la création/'));

        $response = $this->controller->store($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('espace.create', $response->getTargetUrl());
    }

    public function test_update_updates_espace_vert_successfully(): void
    {
        $id = 1;
        $data = [
            'nom' => 'Updated Park',
            'adresse' => 'New St',
            'superficie' => 200.0,
            'type' => 'parc',
            'etat' => 'bon',
            'besoin_specifique' => 'New needs',
        ];

        $request = Request::create('/update/' . $id, 'PUT', $data);

        $espaceVertMock = Mockery::mock(EspaceVert::class)->makePartial();
        $espaceVertMock->shouldReceive('update')->once()->with($data)->andReturn(true);

        $overloadMock = Mockery::mock('overload:' . EspaceVert::class);
        $overloadMock->shouldReceive('findOrFail')->once()->with($id)->andReturn($espaceVertMock);

        Session::shouldReceive('flash')->once()->with('success', 'Mise à jour effectuée avec succès !');

        $response = $this->controller->update($request, $id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('espace.index', $response->getTargetUrl());
    }

    public function test_update_throws_model_not_found_exception(): void
    {
        $id = 999;
        $request = Request::create('/update/' . $id, 'PUT', []);

        $overloadMock = Mockery::mock('overload:' . EspaceVert::class);
        $overloadMock->shouldReceive('findOrFail')->once()->with($id)->andThrow(new ModelNotFoundException());

        $this->expectException(ModelNotFoundException::class);
        $this->controller->update($request, $id);
    }

    public function test_update_handles_update_exception(): void
    {
        $id = 1;
        $data = [
            'nom' => 'Updated Park',
            'adresse' => 'New St',
        ];

        $request = Request::create('/update/' . $id, 'PUT', $data);

        $espaceVertMock = Mockery::mock(EspaceVert::class)->makePartial();
        $espaceVertMock->shouldReceive('update')->once()->andThrow(new \Exception('Update Error'));

        $overloadMock = Mockery::mock('overload:' . EspaceVert::class);
        $overloadMock->shouldReceive('findOrFail')->once()->with($id)->andReturn($espaceVertMock);

        Session::shouldReceive('flash')->once()->with('error', Mockery::pattern('/Échec de la mise à jour/'));

        $response = $this->controller->update($request, $id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('espace.index', $response->getTargetUrl());
    }

    public function test_destroy_deletes_espace_vert_successfully(): void
    {
        $id = 1;

        $espaceVertMock = Mockery::mock(EspaceVert::class)->makePartial();
        $espaceVertMock->shouldReceive('delete')->once()->andReturn(true);

        $overloadMock = Mockery::mock('overload:' . EspaceVert::class);
        $overloadMock->shouldReceive('findOrFail')->once()->with($id)->andReturn($espaceVertMock);

        Session::shouldReceive('flash')->once()->with('success', 'Espace Vert supprimé avec succès !');

        $response = $this->controller->destroy($id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('espace.index', $response->getTargetUrl());
    }

    public function test_destroy_throws_model_not_found_exception(): void
    {
        $id = 999;

        $overloadMock = Mockery::mock('overload:' . EspaceVert::class);
        $overloadMock->shouldReceive('findOrFail')->once()->with($id)->andThrow(new ModelNotFoundException());

        $this->expectException(ModelNotFoundException::class);
        $this->controller->destroy($id);
    }

    public function test_destroy_handles_deletion_exception(): void
    {
        $id = 1;

        $espaceVertMock = Mockery::mock(EspaceVert::class)->makePartial();
        $espaceVertMock->shouldReceive('delete')->once()->andThrow(new \Exception('Delete Error'));

        $overloadMock = Mockery::mock('overload:' . EspaceVert::class);
        $overloadMock->shouldReceive('findOrFail')->once()->with($id)->andReturn($espaceVertMock);

        Session::shouldReceive('flash')->once()->with('error', Mockery::pattern('/Échec de la suppression/'));

        $response = $this->controller->destroy($id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('espace.index', $response->getTargetUrl());
    }

    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}