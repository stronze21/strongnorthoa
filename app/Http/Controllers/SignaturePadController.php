<?php

namespace App\Http\Controllers;

use App\Models\OrderAgreement;
use Illuminate\Http\Request;

class SignaturePadController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
        return view('signaturePad', [
            'oa_id' => $request['oa_id'],
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function upload(Request $request)
    {
        $folderPath = public_path('upload/');

        $image_parts = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $file_name = uniqid() . '.'.$image_type;
        $file = $folderPath . $file_name;

        file_put_contents($file, $image_base64);

        $order = OrderAgreement::find($request->oa_id);
        $order->host_signature = $file_name;
        $order->save();

        return redirect(route('oa.view', $request->oa_id));
    }
}
