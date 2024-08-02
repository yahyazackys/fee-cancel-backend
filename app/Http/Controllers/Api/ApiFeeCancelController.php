<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Contract\Database;
use Illuminate\Validation\ValidationException;

class ApiFeeCancelController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function index()
    {
        try {
            $feeCancels = $this->database->getReference('feeCancels')->getValue();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diload',
                'data' => $feeCancels,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'fee' => 'required',
                'nama_lengkap' => 'required'
            ]);

            $data = $request->all();
            $newPostKey = $this->database->getReference('feeCancels')->push()->getKey();
            $this->database->getReference('feeCancels/' . $newPostKey)->set($data);

            $feeCancel = $this->database->getReference('feeCancels/' . $newPostKey)->getValue();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $feeCancel,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $feeCancel = $this->database->getReference('feeCancels/' . $id)->getValue();

            if ($feeCancel === null) {
                return response()->json(['message' => 'Fee cancel not found'], 404);
            }

            return response()->json([
                'id' => $id,
                'fee' => $feeCancel['fee'] ?? '',
                'nama_lengkap' => $feeCancel['nama_lengkap'] ?? '',
                'user_id' => $feeCancel['user_id'] ?? '',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer',
                'fee' => 'required|numeric',
                'nama_lengkap' => 'required|string',
            ]);

            $data = $request->only(['user_id', 'fee', 'nama_lengkap']);
            $reference = $this->database->getReference('feeCancels/' . $id);
            $reference->update($data);

            $feeCancel = $reference->getValue();

            return response()->json([
                'message' => 'Data berhasil diperbarui',
                'data' => $feeCancel,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $reference = $this->database->getReference('feeCancels/' . $id);
            $feeCancel = $reference->getValue();

            if ($feeCancel) {
                $reference->remove();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Fee Cancel berhasil dihapus',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Fee Cancel tidak ditemukan',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Fee Cancel: ' . $e->getMessage(),
            ], 500);
        }
    }
}
