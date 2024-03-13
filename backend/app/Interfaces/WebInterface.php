<?php

namespace App\Interfaces;

use Illuminate\View\View;
use Illuminate\Http\Request;

/**
 * Interface WebInterface
 *
 * @package App\Interfaces
 */
interface WebInterface
{
    /**
     * Handle the index operation.
     *
     * @param array $search An array containing search parameters.
     * @param string|null $type Optional type parameter.
     * @return View
     */
    public function handleIndex(array $search = [], string|null $type = null): View;

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function handleCreate(): View;

    /**
     * Handle the store operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing request data.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleStore(Request $request);

    /**
     * Display the specified resource.
     *
     * @param string $id The identifier for the resource.
     * @param string|null $type Optional type parameter.
     * @return View
     */
    public function handleShow(string $id, string|null $type = null): View;

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id The identifier for the resource.
     * @return View
     */
    public function handleEdit(string $id): View;

    /**
     * Handle the update operation.
     *
     * @param Request $request An instance of Illuminate\Http\Request containing update data.
     * @param string $id The identifier for the resource.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleUpdate(Request $request, string $id);

    /**
     * Handle the destroy operation.
     *
     * @param string $id The identifier for the resource to be destroyed.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleDestroy(string $id);
}
