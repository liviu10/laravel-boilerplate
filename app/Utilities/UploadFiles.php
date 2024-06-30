<?php

namespace App\Utilities;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class UploadFiles
{
    protected $internalPath;

    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->internalPath = '';
    }

    /**
     * Handle internal upload.
     *
     * @return string
     */
    public function handleInternalUpload(Request $request, Collection $mediaType): string
    {
        if ($request->hasFile('internal_path')) {
            $file = $request->file('internal_path');
            $hashFilename = $file->hashName();

            if ($mediaType instanceof Collection && $mediaType->isNotEmpty()) {
                $file->storeAs($mediaType->toArray()[0]['value'], $hashFilename, 'public');
                $this->internalPath = 'storage/' . $mediaType->toArray()[0]['value'] . '/' . $hashFilename;
            } else {
                $file->storeAs('others', $hashFilename, 'public');
                $this->internalPath = 'storage/others/' . $hashFilename;
            }
        }

        return $this->internalPath;
    }

    /**
     * Handle external upload.
     *
     * @return null
     */
    public function handleExternalUpload(): null
    {
        return null;
    }

    /**
     * Handle title.
     *
     * @return null
     */
    public function handleTitle(): null
    {
        return null;
    }

    /**
     * Handle caption.
     *
     * @return null
     */
    public function handleCaption(): null
    {
        return null;
    }

    /**
     * Handle alternative text.
     *
     * @return null
     */
    public function handleAltText(): null
    {
        return null;
    }

    /**
     * Handle description.
     *
     * @return null
     */
    public function handleDescription(): null
    {
        return null;
    }
}
