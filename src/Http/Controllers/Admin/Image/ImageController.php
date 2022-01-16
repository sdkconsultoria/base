<?php

namespace Sdkconsultoria\Base\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sdkconsultoria\Base\Models\Common\Image\Image;

class ImageController extends Controller
{
    /**
     * Sube una imagen nueva
     * @param  Request $request Peticion
     * @param  string  $class   namespace del objeto al cual se le asignara la imagen.
     * @param  int     $id      id del objeto al que se le asigna la imagen
     * @return void
     */
    public function upload(Request $request, string $class, int $id)
    {
        $object = new $class();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename  = $file->getClientOriginalName();

            $model = new Image();
            $model->created_by = \Auth::user()->id;
            $model->extension =  $file->extension();
            $model->imageable_id =  $id;
            $model->imageable_type =  $class;
            $model->save();
            $file->storeAs('images/' . $object->getTable() . '/' . $id, $model->id . '.' . $file->extension(), 'public');
            $model->convertImage();

            return response()
            ->json([
                'data' => $model->getRow(),
                'table' => $object->getTable() . '_imageable'
            ]);
        }
    }

    /**
     * Sube una imagen nueva
     * @param  Request $request Peticion
     * @param  string  $class   namespace del objeto al cual se le asignara la imagen.
     * @param  int     $id      id del objeto al que se le asigna la imagen
     * @return void
     */
    public function uploadSingle(Request $request, string $class, int $id)
    {
        $object = new $class();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename  = $file->getClientOriginalName();

            $model = Image::where('imageable_id', $id)->where('imageable_type', $class)->first();
            if (!$model) {
                $model = new Image();
                $model->created_by = \Auth::user()->id;
            }

            $model->extension =  $file->extension();
            $model->imageable_id =  $id;
            $model->imageable_type =  $class;
            $model->save();
            $file->storeAs('images/' . $object->getTable() . '/' . $id, $model->id . '.' . $file->extension(), 'public');
            $model->convertImage();

            return $model->url();
        }
    }

    public function change()
    {

    }

    public function destroy($id)
    {
        $model = Image::where('id', $id)->first();
        $model->removeImage();
        $model->forceDelete();

        $object = new $model->imageable_type;

        return response()
        ->json([
            'data' => $object->getTable() . '_row_' . $id
        ]);
    }

    public function generate()
    {

    }

    public function setType(Request $request, $id)
    {
        $model = Image::where('id', $id)->first();
        $model->type = $request->type;
        $model->save();

        return response()
        ->json([
            'data' => $request->type
        ]);
    }
}
