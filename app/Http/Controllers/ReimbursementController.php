<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ReimbursementController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'nama_reimbursement' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_pendukung' => 'nullable|file|max:2048'
        ]);

        if ($request->hasFile('file_pendukung')) {
            $file = $request->file('file_pendukung');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('reimbursement_files', $fileName);
        } else {
            $fileName = null;
        }

        $reimbursement = new Reimbursement();
        $reimbursement->tanggal = $validatedData['tanggal'];
        $reimbursement->nama_reimbursement = $validatedData['nama_reimbursement'];
        $reimbursement->deskripsi = $validatedData['deskripsi'];
        $reimbursement->file_pendukung = $fileName;
        $reimbursement->user_id = auth()->user()->id;
        $reimbursement->save();

        return redirect('/reimbursement')->with('success', 'Reimbursement request submitted successfully.');
    }

    public function approve(Reimbursement $reimbursement)
    {
        $reimbursement->status = 'approved';
        $reimbursement->save();

        return redirect('/reimbursement')->with('success', 'Reimbursement request approved.');
    }

    public function reject(Reimbursement $reimbursement)
    {
        $reimbursement->status = 'rejected';
        $reimbursement->save();

        return redirect('/reimbursement')->with('error', 'Reimbursement request rejected.');
    }

    public function getApprovedReimbursements()
    {
        $approvedReimbursements = Reimbursement::where('status', 'approved')->get();

        return view('reimbursements.approved', compact('approvedReimbursements'));
    }


}
