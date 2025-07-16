<?php

namespace App\Http\Controllers\admin\general;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('general.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        try {
            Faq::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'FAQ berhasil ditambahkan',
                    'redirect' => route('faq.index')
                ]);
            }

            return redirect()->route('faq.index')
                ->with('success', 'FAQ berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan FAQ: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Gagal menambahkan FAQ: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $faq = Faq::findOrFail($id);

            $validated = $request->validate([
                'question' => 'required|string|max:255',
                'answer' => 'required|string',
                'order' => 'required|integer|min:1',
                'is_active' => 'boolean'
            ]);

            $faq->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'FAQ berhasil diperbarui'
                ]);
            }

            return redirect()->route('faq.index')
                ->with('success', 'FAQ berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui FAQ: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Gagal memperbarui FAQ: ' . $e->getMessage());
        }
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $faq = Faq::findOrFail($id);
            $faq->delete();

            return response()->json([
                'success' => true,
                'message' => 'FAQ berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus FAQ: ' . $e->getMessage()
            ], 500);
        }
    }
}
