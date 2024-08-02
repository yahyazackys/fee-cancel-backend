<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Contract\Database;

class ApiFeeCancelController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function index()
    {
        $feeCancels = $this->database->getReference('feeCancels')->getValue();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $feeCancels,
            ],
            200
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'fee' => 'required',
            'nama_lengkap' => 'required'
        ]);

        $data = $request->all();
        $newPostKey = $this->database->getReference('feeCancels')->push()->getKey();
        $this->database->getReference('feeCancels/' . $newPostKey)->set($data);

        $feeCancel = $this->database->getReference('feeCancels/' . $newPostKey)->getValue();
        return response()->json(
            [
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $feeCancel,
            ],
            200
        );
    }


    public function show($id)
    {
        // Ambil data dari Firebase
        $feeCancel = $this->database->getReference('feeCancels/' . $id)->getValue();

        // Jika data tidak ditemukan, kembalikan response dengan error
        if ($feeCancel === null) {
            return response()->json(['message' => 'Fee cancel not found'], 404);
        }

        // Format data untuk dikembalikan
        return response()->json([
            'id' => $id,
            'fee' => $feeCancel['fee'] ?? '',
            'nama_lengkap' => $feeCancel['nama_lengkap'] ?? '',
            'user_id' => $feeCancel['user_id'] ?? '',
        ]);
    }


    public function update(Request $request, $id)
    {
        // Validasi input request
        $request->validate([
            'user_id' => 'required|integer',
            'fee' => 'required|numeric',
            'nama_lengkap' => 'required|string', // Menambahkan validasi untuk nama_lengkap
        ]);

        try {
            // Ambil data dari request
            $data = $request->only(['user_id', 'fee', 'nama_lengkap']);

            // Update data di database
            $reference = $this->database->getReference('feeCancels/' . $id);
            $reference->update($data);

            // Ambil data yang diperbarui untuk konfirmasi
            $feeCancel = $reference->getValue();

            // Kirim response sukses
            return response()->json([
                'message' => 'Success Update',
                'data' => $feeCancel
            ], 200);
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return response()->json([
                'message' => 'Update Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            // Cek apakah referensi dengan ID yang diberikan ada
            $reference = $this->database->getReference('feeCancels/' . $id);
            $feeCancel = $reference->getValue();

            if ($feeCancel) {
                // Hapus data dari database
                $reference->remove();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Fee Cancel deleted successfully.'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Fee Cancel not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan yang mungkin terjadi
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Fee Cancel: ' . $e->getMessage()
            ], 500);
        }
    }
}
