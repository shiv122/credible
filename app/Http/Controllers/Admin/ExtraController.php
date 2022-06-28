<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FaqDataTable;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    public function faqTable(FaqDataTable $table)
    {
        $pageConfigs = ['has_table' => true,];
        return $table->render('content.tables.faq', compact('pageConfigs'));
    }

    public function faqStore(Request $request)
    {

        $request->validate([
            'question' => 'required|string|max:2000',
            'answer' => 'required|string|max:4000',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return response(['status' => 'success', 'header' => 'Created', 'message' => 'Faq created successfully.', 'table' => 'faq-table']);
    }

    public function faqStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:faqs,id',
            'status' => 'required|in:active,inactive',
        ]);

        Faq::where('id', $request->id)->update([
            'status' => $request->status,
        ]);

        return response(['status' => 'success', 'header' => 'Updated', 'message' => 'Faq status updated successfully.']);
    }
}
