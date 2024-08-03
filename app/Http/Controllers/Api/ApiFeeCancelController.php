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
            $feeCancels = $this->database->getReference('fee_cancels')->getValue();

            return response()->json([
                'success' => true,
                'message' => 'Data retrieved successfully!',
                'data' => $feeCancels ?? [],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'fee' => 'required|numeric',
                'user_id' => 'required|string',
                'user_name' => 'required|string',
            ]);

            $data = $request->all();
            $newReference = $this->database->getReference('fee_cancels')->push();
            $newReference->set($data);

            return response()->json([
                'success' => true,
                'message' => 'Data added successfully',
                'data' => $newReference->getValue(),
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
                'message' => 'Failed to add data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $reference = $this->database->getReference('fee_cancels/' . $id);
            $feeCancel = $reference->getValue();

            if (!$feeCancel) {
                return response()->json(['message' => 'Data not found'], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data retrieved successfully',
                'data' => array_merge(['id' => $id], $feeCancel),
            ], 200);
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
                'fee' => 'required|numeric',
                'user_id' => 'required|string',
                'user_name' => 'required|string',
            ]);

            $data = $request->only(['fee', 'user_id', 'user_name']);
            $reference = $this->database->getReference('fee_cancels/' . $id);
            $reference->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data updated successfully',
                'data' => $reference->getValue(),
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
            $reference = $this->database->getReference('fee_cancels/' . $id);
            if ($reference->getValue()) {
                $reference->remove();
                return response()->json([
                    'success' => true,
                    'message' => 'Data deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
